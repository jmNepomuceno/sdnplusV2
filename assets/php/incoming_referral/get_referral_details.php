<?php
    include("../../connection/connection.php");

    // header("Content-Type: application/json");
    date_default_timezone_set('Asia/Manila');
    session_start();

    if (!isset($_POST['referral_id'])) {
        echo json_encode(["success" => false, "message" => "Missing referral_id"]);
        exit;
    }

    $referralId = $_POST['referral_id'];

    try {
        // 🔹 Step 1: Get referral details from incoming_referrals
        $stmt = $pdo->prepare("
            SELECT ir.*, hp.hpercode, hp.patlast, hp.patfirst, hp.patmiddle, hp.patsuffix,
                hp.pat_age, hp.patsex, hp.patcstat, hp.relcode, hp.pat_mobile_no, hp.pat_mobile_no
            FROM incoming_referrals ir
            JOIN hperson hp ON ir.hpercode = hp.hpercode
            WHERE ir.referral_id = :referral_id
        ");
        $stmt->execute([":referral_id" => $referralId]);
        $referral = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$referral) {
            echo json_encode(["success" => false, "message" => "Referral not found"]);
            exit;
        }

        // 🔹 Step 2: Structure JSON
        $response = [
            "success" => true,
            "patient" => [
                "hpercode"    => $referral["hpercode"],
                "referral_status" => $referral["status"] ?? "N/A",
                "pat_mobile_no"     => $referral["pat_mobile_no"] ?? "N/A",
                "patlast"     => $referral["patlast"],
                "patfirst"    => $referral["patfirst"],
                "patmiddle"   => $referral["patmiddle"],
                "patsuffix"=> $referral["patsuffix"],
                "pat_age"           => $referral["pat_age"],
                "patsex"        => $referral["patsex"],
                "patcstat"  => $referral["patcstat"],
                "relcode"      => $referral["relcode"],
                "pat_mobile_no"    => $referral["pat_mobile_no"]
            ],
            "referral" => [
                "referral_id"   => $referral["referral_id"],
                "status"=> $referral["status"],
                "reception_time" => $referral["reception_time"],
                "processed_by"  => $referral["processed_by"],
                "bp"            => $referral["bp"],
                "hr"            => $referral["hr"],
                "rr"            => $referral["rr"],
                "temp"          => $referral["temp"],
                "weight"        => $referral["weight"],
                "icd_diagnosis"         => $referral["icd_diagnosis"],
                "chief_complaint_history"    => $referral["chief_complaint_history"],
                "pertinent_findings"     => $referral["pertinent_findings"],
                "diagnosis"          => $referral["diagnosis"],
                "plan" => $referral["reason"],
                "remarks"       => $referral["remarks"],
                "referred_by"   => $referral["referred_by"],
                "referring_doctor" => $referral["referring_doctor"],
                "referring_doctor_mobile" => $referral['referred_by_no'],
                "type" => $referral['type'],
            ]
        ];

        echo json_encode($response);

    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
?>
