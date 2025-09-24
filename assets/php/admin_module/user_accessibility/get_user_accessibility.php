<?php
include("../../../connection/connection.php");

date_default_timezone_set('Asia/Manila');
session_start();

header("Content-Type: application/json");

try {
    // Example query: adjust to your actual table + columns
    $sql = "SELECT user_ID, user_lastname, user_firstname, user_middlename, username, password, role, permission 
            FROM sdn_users WHERE role !='rhu_account' ORDER BY user_ID DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Decode permissions JSON if stored as string
    foreach ($users as &$user) {
        if (!empty($user['permission'])) {
            $user['permission'] = json_decode($user['permission'], true);
        } else {
            $user['permission'] = [];
        }
    }

    echo json_encode($users, JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
