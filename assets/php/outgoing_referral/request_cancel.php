<?php
    include("../../connection/connection.php");

    // header("Content-Type: application/json");
    date_default_timezone_set('Asia/Manila');
    session_start();

    
    if (!empty($_POST['referral_id'])) {
        $referralId = $_POST['referral_id'];

        try {
            $sql = "UPDATE bghmc.incoming_referrals 
                    SET cancelled_request = 1 
                    WHERE referral_id = :referral_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":referral_id" => $referralId]);

            echo json_encode(["success" => true, "message" => "Cancellation request sent."]);
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request."]);
    }
?>
