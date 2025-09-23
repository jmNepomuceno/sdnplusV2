<?php
    include("../../connection/connection.php");

    // header("Content-Type: application/json");
    date_default_timezone_set('Asia/Manila');
    session_start();

    require "../../../vendor/autoload.php";  // Ensure Composer's autoload is included
    use WebSocket\Client;

    if (!empty($_POST['referral_id'])) {
        $referralId = $_POST['referral_id'];

        try {
            $sql = " SELECT cancelled_requestor, cancellation_request_time, cancellation_reason FROM bghmc.incoming_referrals WHERE referral_id = :referral_id";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([":referral_id" => $referralId]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            echo json_encode(["data" => $data], JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request."]);
    }
?>
