<?php
include("../../../connection/connection.php");

date_default_timezone_set('Asia/Manila');
session_start();
header("Content-Type: application/json");

try {
    // First: fetch hospitals
    $sql = "SELECT 
                h.hospital_ID,
                h.hospital_code,
                h.hospital_name,
                h.hospital_email,
                h.hospital_landline,
                h.hospital_mobile,
                h.hospital_director,
                h.hospital_director_mobile,
                h.hospital_point_person,
                h.hospital_point_person_mobile,
                h.hospital_isVerified
            FROM sdn_hospital h
            ORDER BY h.hospital_name ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $hospitals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Second: fetch users grouped by hospital_code
    $sqlUsers = "SELECT 
                    u.user_ID,
                    u.user_firstname,
                    u.user_lastname,
                    u.user_middlename,
                    u.username,
                    u.password,
                    u.hospital_code
                FROM sdn_users u";
    $stmtUsers = $pdo->prepare($sqlUsers);
    $stmtUsers->execute();
    $users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

    // Group users by hospital_code
    $usersByHospital = [];
    foreach ($users as $user) {
        $usersByHospital[$user['hospital_code']][] = $user;
    }

    // Attach users to hospitals
    foreach ($hospitals as &$hospital) {
        $code = $hospital['hospital_code'];
        $hospital['users'] = $usersByHospital[$code] ?? [];
        $hospital['user_count'] = count($hospital['users']);
    }

    echo json_encode($hospitals, JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
