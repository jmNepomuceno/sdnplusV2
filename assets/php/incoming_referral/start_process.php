<?php
    include("../../connection/connection.php");

    header("Content-Type: application/json");
    date_default_timezone_set('Asia/Manila');
    session_start();

    require "../../../vendor/autoload.php";  // Ensure Composer's autoload is included
    use WebSocket\Client;
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

    try {
        $client = new Client("ws://10.10.90.14:8081/chat");
        $client->send(json_encode(["action" => "startProcess"]));
    } catch (Exception $e) {
        echo "WebSocket error: " . $e->getMessage();
    }
?>
