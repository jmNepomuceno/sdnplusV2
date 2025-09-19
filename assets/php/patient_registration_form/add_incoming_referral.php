<?php
    include("../../connection/connection.php");

    header("Content-Type: application/json");
    date_default_timezone_set('Asia/Manila');

    require "../../../vendor/autoload.php";  // Ensure Composer's autoload is included
    use WebSocket\Client;

    
    session_start();

    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // referral_id
            
            $sql = "SELECT referral_id FROM incoming_referrals ORDER BY referral_id DESC LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $data_referral_id = $stmt->fetch(PDO::FETCH_ASSOC);

            $referral_id = ""; 
            if($data_referral_id == "" || $data_referral_id == null ){
                $referral_id = "REF000001";
            }else{
                $last_number = substr($data_referral_id['referral_id'], 3);

                $referral_idPrefix = "REF"; // Set the prefix
                $new_number = $last_number + 1; // Increment the last number

                $zeros = "0";

                if($new_number <= 9){
                    $zeros = "00000";
                }else if($new_number <= 99){
                    $zeros = "0000";
                }else if($new_number <= 999){
                    $zeros = "000";
                }else if($new_number <= 9999){
                    $zeros = "00";
                }else if($new_number <= 99999){
                    $zeros = "0";
                }else if($new_number <= 999999){
                    $zeros = "";
                }

                $referral_id = $referral_idPrefix . $zeros . $new_number;
            }

            // reference_num
            $current_date = new DateTime();
            $year = $current_date->format("Y");
            $month = $current_date->format("m");
            $day = $current_date->format("d");
            $inputString = $_POST['refer_to'];

            // FOR NAMING OF THE REFERENCE NUMBER DEPENDS ON WHAT HOSPITAL, BGH WILL REFER TO
            $referTo = filter_input(INPUT_POST, 'refer_to');
            $sql_temp = "SELECT hospital_municipality_code FROM sdn_hospital WHERE hospital_name = :refer_to";
            $stmt_temp = $pdo->prepare($sql_temp);
            $stmt_temp->bindParam(':refer_to', $referTo, PDO::PARAM_STR);
            $stmt_temp->execute();
            $data_municipality_code = $stmt_temp->fetch(PDO::FETCH_ASSOC);

            // reference now the municipality code to get the municipality name from city table
            $sql_temp = "SELECT municipality_description FROM city WHERE municipality_code=:id ";
            $stmt_temp = $pdo->prepare($sql_temp); 
            $stmt_temp->bindParam(':id', $data_municipality_code['hospital_municipality_code'], PDO::PARAM_STR);
            $stmt_temp->execute();
            $data_municipality_desc = $stmt_temp->fetch(PDO::FETCH_ASSOC);


            $words = explode(' ', $inputString);
            $firstLetters = array_map(function ($word) {
                return ucfirst(substr($word, 0, 1));
            }, $words);
            $abbreviation = implode('', $firstLetters);

            if($data_municipality_desc['municipality_description'] === "CITY OF BALANGA (Capital)"){
                $data_municipality_desc['municipality_description'] = "BALANGA";
                $abbreviation = "BGHMC";
            }

            $reference_num = 'R3-BTN-'. $data_municipality_desc['municipality_description'] . '-' . $abbreviation . '-' . $year . '-' . $month . '-' . $day;

            // Collect POST data (sanitize/validate as needed)
            $hpercode   = $_POST['hpercode'] ?? null;
            $type       = $_POST['type'] ?? null; // classification
            $referred_by     = $_SESSION['user']['hospital_name'];
            $referred_by_no  = $_POST['referred_by_no'] ?? null;
            $refer_to        = $_POST['refer_to'] ?? null;

            $icd_diagnosis   = $_POST['icd_diagnosis'] ?? null;
            $sensitive_case  = $_POST['sensitive_case'] ?? null;
            $parent_guardian = $_POST['parent_guardian'] ?? null;
            $phic_member     = $_POST['phic_member'] ?? null;
            $transport       = $_POST['transport'] ?? null;
            $referring_doctor= $_POST['referring_doctor'] ?? null;
            $chief_complaint_history = $_POST['chief_complaint_history'] ?? null;
            $reason          = $_POST['reason'] ?? null;
            $diagnosis       = $_POST['diagnosis'] ?? null;
            $remarks         = $_POST['remarks'] ?? null;
            $bp              = $_POST['bp'] ?? null;
            $hr              = $_POST['hr'] ?? null;
            $rr              = $_POST['rr'] ?? null;
            $temp            = $_POST['temp'] ?? null;
            $weight          = $_POST['weight'] ?? null;
            $pertinent_findings = $_POST['pertinent_findings'] ?? null;

            // Default values
            $status   = "Pending";
            $dateTime = date("Y-m-d H:i:s");

            // 🔹 Fetch patient details (patlast, patfirst, patmiddle, patsuffix)
            $patlast = $patfirst = $patmiddle = $patsuffix = null;
            if ($hpercode) {
                $stmt = $pdo->prepare("SELECT patlast, patfirst, patmiddle, patsuffix FROM hperson WHERE hpercode = ?");
                $stmt->execute([$hpercode]);
                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $patlast   = $row['patlast'];
                    $patfirst  = $row['patfirst'];
                    $patmiddle = $row['patmiddle'];
                    $patsuffix = $row['patsuffix'];
                }
            }

            // 🔹 Fetch hospital details (landline_no, mobile_no)
            $landline_no = $mobile_no = null;
            if ($referred_by) {
                $stmt = $pdo->prepare("SELECT hospital_landline, hospital_mobile FROM sdn_hospital WHERE hospital_code = ?");
                $stmt->execute([$_SESSION['user']['hospital_code']]);
                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $landline_no = $row['hospital_landline'];
                    $mobile_no   = $row['hospital_mobile'];
                }
            }

            $sql = "INSERT INTO incoming_referrals (
                hpercode, referral_id, reference_num, patlast, patfirst, patmiddle, patsuffix,
                type, referred_by, referred_by_no, refer_to,
                landline_no, mobile_no, icd_diagnosis, sensitive_case, parent_guardian,
                phic_member, transport, referring_doctor,
                chief_complaint_history, reason, diagnosis, remarks,
                bp, hr, rr, temp, weight, pertinent_findings,
                status, date_time
            ) VALUES (
                :hpercode, :referral_id, :reference_num, :patlast, :patfirst, :patmiddle, :patsuffix,
                :type, :referred_by, :referred_by_no, :refer_to,
                :landline_no, :mobile_no, :icd_diagnosis, :sensitive_case, :parent_guardian,
                :phic_member, :transport, :referring_doctor,
                :chief_complaint_history, :reason, :diagnosis, :remarks,
                :bp, :hr, :rr, :temp, :weight, :pertinent_findings,
                :status, :date_time
            )";

            $stmt = $pdo->prepare($sql);
            $success = $stmt->execute([
                ':hpercode' => $hpercode,
                ':referral_id' => $referral_id,
                ':reference_num' => $reference_num,
                ':patlast' => $patlast,
                ':patfirst' => $patfirst,
                ':patmiddle' => $patmiddle,
                ':patsuffix' => $patsuffix,
                ':type' => $type,
                ':referred_by' => $referred_by,
                ':referred_by_no' => $referred_by_no,
                ':refer_to' => $refer_to,
                ':landline_no' => $landline_no,
                ':mobile_no' => $mobile_no,
                ':icd_diagnosis' => $icd_diagnosis,
                ':sensitive_case' => $sensitive_case,
                ':parent_guardian' => $parent_guardian,
                ':phic_member' => $phic_member,
                ':transport' => $transport,
                ':referring_doctor' => $referring_doctor,
                ':chief_complaint_history' => $chief_complaint_history,
                ':reason' => $reason,
                ':diagnosis' => $diagnosis,
                ':remarks' => $remarks,
                ':bp' => $bp,
                ':hr' => $hr,
                ':rr' => $rr,
                ':temp' => $temp,
                ':weight' => $weight,
                ':pertinent_findings' => $pertinent_findings,
                ':status' => $status,
                ':date_time' => $dateTime
            ]);

            // update the status of the patient for the hperson
            $stmt = $pdo->prepare("UPDATE hperson SET status = 'Pending', type=:type WHERE hpercode = :hpercode");
            $stmt->execute([':hpercode' => $hpercode, ':type' => $type]);

            // update the referral_id for the hperson, but as a JSON
            // initialize first
            $stmt = $pdo->prepare("UPDATE hperson SET referral_id = IFNULL(referral_id, JSON_ARRAY()) WHERE hpercode=:hpercode");
            $stmt->execute([':hpercode' => $hpercode]);

            $stmt = $pdo->prepare("UPDATE hperson SET referral_id = JSON_ARRAY_APPEND(referral_id, '$', :referral_id) WHERE hpercode=:hpercode");
            $stmt->execute([':hpercode' => $hpercode, ':referral_id' => $referral_id]);

            echo json_encode([
                "success" => true,
                "message" => "Referral successfully added!"
            ]);

            try {
                $client = new Client("ws://10.10.90.14:8082");
                $client->send(json_encode(["action" => "sentIncomingReferral"]));
            } catch (Exception $e) {
                echo "WebSocket error: " . $e->getMessage();
            }
             
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Invalid request method."
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "message" => "Database error: " . $e->getMessage()
        ]);
    }


?>
