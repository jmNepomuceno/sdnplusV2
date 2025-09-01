<?php
    include("../../connection/connection.php");

    header("Content-Type: application/json");

    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect POST data (sanitize/validate as needed)
            $hpercode   = $_POST['hpercode'] ?? null;
            $type       = $_POST['type'] ?? null; // classification
            $referred_by     = $_POST['referred_by'] ?? null;
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
                $stmt->execute([$referred_by]);
                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $landline_no = $row['hospital_landline'];
                    $mobile_no   = $row['hospital_mobile'];
                }
            }

            $sql = "INSERT INTO incoming_referrals (
                hpercode, patlast, patfirst, patmiddle, patsuffix,
                type, referred_by, referred_by_no, refer_to,
                landline_no, mobile_no, icd_diagnosis, sensitive_case, parent_guardian,
                phic_member, transport, referring_doctor,
                chief_complaint_history, reason, diagnosis, remarks,
                bp, hr, rr, temp, weight, pertinent_findings,
                status, date_time
            ) VALUES (
                :hpercode, :patlast, :patfirst, :patmiddle, :patsuffix,
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

            echo json_encode([
                "success" => true,
                "message" => "Referral successfully added!"
            ]);
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
