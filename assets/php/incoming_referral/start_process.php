<?php
    include("../../connection/connection.php");

    header("Content-Type: application/json");
    date_default_timezone_set('Asia/Manila');
    session_start();

    try {
        $referral_id = $_POST['referral_id'] ?? null;
        if (!$referral_id) {
            echo json_encode(["success" => false, "message" => "Missing referral_id"]);
            exit;
        }

        $sql = "UPDATE incoming_referrals 
                SET reception_time = NOW(), status = 'On-Process' 
                WHERE referral_id = :referral_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":referral_id" => $referral_id]);

        echo json_encode([
            "success" => true,
            "reception_time" => date("Y-m-d H:i:s")
        ]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
?>
