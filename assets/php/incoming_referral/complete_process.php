<?php
include("../../connection/connection.php");

header("Content-Type: application/json");
date_default_timezone_set('Asia/Manila');
session_start();

require "../../../vendor/autoload.php";  // Ensure Composer's autoload is included
use WebSocket\Client;

try {
    $referral_id = $_POST['referral_id'] ?? null;
    $result = $_POST['result'] ?? null;
    $pat_class = $_POST['pat_class'] ?? null;
    $details = $_POST['approval_details'] ?? null; // can be approval_details OR deferred_details
    
    $hpercode = $_POST['referral_hpercode'] ?? null;

    if (!$referral_id || !$result) {
        echo json_encode(["success" => false, "message" => "Missing required data"]);
        exit;
    }

    // 🕒 Get reception_time from DB
    $stmt = $pdo->prepare("SELECT reception_time FROM incoming_referrals WHERE referral_id = :referral_id");
    $stmt->execute([":referral_id" => $referral_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(["success" => false, "message" => "Referral not found"]);
        exit;
    }

    $reception_time = new DateTime($row['reception_time']);
    $now = new DateTime(); // current time

    // ⏱️ Calculate difference
    $interval = $reception_time->diff($now);
    $final_progressed_timer = sprintf(
        "%02d:%02d:%02d",
        ($interval->days * 24) + $interval->h, // total hours
        $interval->i,
        $interval->s
    );

    if ($result === "Approved") {
        // ✅ Approval path
        $sql = "UPDATE incoming_referrals 
                SET status = :status,
                    pat_class = :pat_class,
                    approval_details = :approval_details,
                    final_progressed_timer = :final_progressed_timer,
                    approved_time = :approved_time,
                    processed_by = 'Juan Dela Cruz'
                WHERE referral_id = :referral_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":status" => $result,
            ":pat_class" => $pat_class,
            ":approval_details" => $details,
            ":final_progressed_timer" => $final_progressed_timer,
            ":approved_time" => $now->format("Y-m-d H:i:s"),
            ":referral_id" => $referral_id
        ]);

        $sql = "UPDATE hperson 
                SET status = 'Approved'
                WHERE hpercode = :hpercode";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":hpercode" => $hpercode]);

        echo json_encode([
            "success" => true,
            "message" => "Referral approved successfully",
            "final_progressed_timer" => $final_progressed_timer,
            "approved_time" => $now->format("Y-m-d H:i:s")
        ]);
    } elseif ($result === "Deferred") {
        // ❌ Deferral path
        $sql = "UPDATE incoming_referrals 
                SET status = :status,
                    pat_class = :pat_class,
                    deferred_details = :deferred_details,
                    final_progressed_timer = :final_progressed_timer,
                    deferred_time = :deferred_time,
                    processed_by = 'Juan Dela Cruz'
                WHERE referral_id = :referral_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":status" => $result,
            ":pat_class" => $pat_class,
            ":deferred_details" => $details,
            ":final_progressed_timer" => $final_progressed_timer,
            ":deferred_time" => $now->format("Y-m-d H:i:s"),
            ":referral_id" => $referral_id
        ]);

        $sql = "UPDATE hperson 
            SET status = 'Deferred'
            WHERE hpercode = :hpercode";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":hpercode" => $hpercode]);

        echo json_encode([
            "success" => true,
            "message" => "Referral deferred successfully",
            "final_progressed_timer" => $final_progressed_timer,
            "deferred_time" => $now->format("Y-m-d H:i:s")
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid result type"]);
    }

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

try {
    // $client = new Client("ws://10.10.90.14:8081/chat");
    // $client->send(json_encode(["action" => "completeProcess"]));

    $client = new Client("ws://10.10.90.14:8082");
    $client->send(json_encode(["action" => "completeProcess"]));
} catch (Exception $e) {
    echo "WebSocket error: " . $e->getMessage();
}

?>
