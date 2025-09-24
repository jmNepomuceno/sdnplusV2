<?php
include("../../../connection/connection.php");

date_default_timezone_set('Asia/Manila');
session_start();

header("Content-Type: application/json");

try {
    // Collect POST data
    $firstName  = $_POST['first_name'] ?? '';
    $middleName = $_POST['middle_name'] ?? '';
    $lastName   = $_POST['last_name'] ?? '';
    $username   = $_POST['username'] ?? '';
    $password   = $_POST['password'] ?? '';
    $roles      = $_POST['roles'] ?? [];

    if (empty($firstName) || empty($lastName) || empty($username) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit;
    }

    // 🔹 Convert roles to string (comma-separated)
    $roleString = is_array($roles) ? implode(',', $roles) : $roles;

    // 🔹 Default permission object (set census to false + other defaults)
    $defaultPermission = [
        "setting"            => false,
        "history_log"        => false,
        "admin_function"     => false,
        "bucas_referral"     => false,
        "incoming_referral"  => false,
        "outgoing_referral"  => false,
        "patient_registration" => false,
        "census"             => false
    ];

    // 🔹 Hash password (same style if you’re storing plain text, but best to hash)
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $hashedPassword = $password; // ⚠️ Change to hash if you want security

    $sql = "INSERT INTO sdn_users 
            (hospital_code, user_firstname, user_middlename, user_lastname, username, password, role, permission) 
            VALUES 
            (:hcode, :fname, :mname, :lname, :uname, :pass, :role, :perm)";
    $stmt = $pdo->prepare($sql);

    $ok = $stmt->execute([
        ":hcode" => 1111,
        ":fname" => $firstName,
        ":mname" => $middleName,
        ":lname" => $lastName,
        ":uname" => $username,
        ":pass"  => $password,
        ":role"  => $roleString,
        ":perm"  => json_encode($defaultPermission, JSON_UNESCAPED_SLASHES)
    ]);

    if ($ok) {
        echo json_encode(["success" => true, "message" => "User added successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add user"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
