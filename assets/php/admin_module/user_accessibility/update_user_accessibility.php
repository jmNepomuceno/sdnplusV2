<?php
include("../../../connection/connection.php");

date_default_timezone_set('Asia/Manila');
session_start();

header("Content-Type: application/json");

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode(["success" => false, "message" => "Invalid request method"]);
        exit;
    }

    // Collect posted data
    $userID      = $_POST['user_ID'] ?? null;
    $firstname   = $_POST['user_firstname'] ?? '';
    $lastname    = $_POST['user_lastname'] ?? '';
    $middlename  = $_POST['user_middlename'] ?? '';
    $username    = $_POST['username'] ?? '';
    $password    = $_POST['password'] ?? '';
    $role        = $_POST['role'] ?? '';

    // Permissions (should come as JSON string from frontend)
    $permissions = $_POST['permissions'] ?? '{}';

    if (!$userID) {
        echo json_encode(["success" => false, "message" => "Missing user ID"]);
        exit;
    }

    $sql = "UPDATE sdn_users 
            SET user_firstname = :firstname, 
                user_lastname = :lastname, 
                user_middlename = :middlename,
                username = :username, 
                password = :password, 
                role = :role, 
                permission = :permission 
            WHERE user_ID = :userID";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":firstname"   => $firstname,
        ":lastname"    => $lastname,
        ":middlename"  => $middlename,
        ":username"    => $username,
        ":password"    => $password, // ⚠️ plaintext (can hash later if needed)
        ":role"        => $role,
        ":permission"  => $permissions, // already JSON string
        ":userID"      => $userID
    ]);

    echo json_encode(["success" => true, "message" => "User updated successfully"]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
