<?php
include("../../../connection/connection.php");

date_default_timezone_set('Asia/Manila');
session_start();
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = $_POST['id'] ?? null;
    $hospitalId = $_POST['hospital_id'] ?? null;
    $firstname  = $_POST['firstname'] ?? '';
    $lastname   = $_POST['lastname'] ?? '';
    $middlename = $_POST['middlename'] ?? '';
    $username   = $_POST['username'] ?? '';
    $password   = $_POST['password'] ?? '';

    if (!$id || !$hospitalId) {
        echo json_encode(['success' => false, 'message' => 'Missing required IDs']);
        exit;
    }

    try {
        // First, get the hospital_code for the given hospital_ID
        $stmt = $pdo->prepare("SELECT hospital_code FROM sdn_hospital WHERE hospital_ID = :hospitalId");
        $stmt->execute([':hospitalId' => $hospitalId]);
        $hospital = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$hospital) {
            echo json_encode(['success' => false, 'message' => 'Hospital not found']);
            exit;
        }

        $hospitalCode = $hospital['hospital_code'];

        // Update user based on user_ID and hospital_code
        $sql = "UPDATE sdn_users
                SET user_firstname = :firstname,
                    user_lastname  = :lastname,
                    user_middlename= :middlename,
                    username       = :username,
                    password       = :password
                WHERE user_ID = :id AND hospital_code = :hospitalCode";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':firstname'    => $firstname,
            ':lastname'     => $lastname,
            ':middlename'   => $middlename,
            ':username'     => $username,
            ':password'     => $password, // plain text for now
            ':id'           => $id,
            ':hospitalCode' => $hospitalCode
        ]);

        echo json_encode(['success' => true, 'message' => 'User updated successfully']);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
