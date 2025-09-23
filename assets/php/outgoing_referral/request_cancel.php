<?php
    include("../../connection/connection.php");

    // header("Content-Type: application/json");
    date_default_timezone_set('Asia/Manila');
    session_start();
    $now = new DateTime(); // current time

    require "../../../vendor/autoload.php";  // Ensure Composer's autoload is included
    use WebSocket\Client;

    if (!empty($_POST['referral_id'])) {
        $referralId = $_POST['referral_id'];

        try {
            $sql = "UPDATE bghmc.incoming_referrals 
                    SET cancelled_request = 1, 
                    cancelled_requestor = :cancelled_requestor,
                    cancellation_request_time = :cancellation_request_time,
                    cancellation_reason = :cancellation_reason
                    WHERE referral_id = :referral_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":referral_id" => $referralId,
                ":cancelled_requestor" => $_SESSION['user']['fullname'], // Assuming user_id is stored in session
                ":cancellation_request_time" => $now->format('Y-m-d H:i:s'),
                ":cancellation_reason" => $_POST['reason'] ?? null
            ]);

            echo json_encode(["success" => true, "message" => "Cancellation request sent."]);
            try {
                // $client = new Client("ws://10.10.90.14:8081/chat");
                // $client->send(json_encode(["action" => "completeProcess"]));

                $client = new Client("ws://10.10.90.14:8082");
                $client->send(json_encode(["action" => "cancelReferralRequest"]));
            } catch (Exception $e) {
                echo "WebSocket error: " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request."]);
    }
?>
