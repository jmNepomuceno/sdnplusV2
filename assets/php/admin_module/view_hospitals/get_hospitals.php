<?php
include("../../../connection/connection.php");

date_default_timezone_set('Asia/Manila');
session_start();
header("Content-Type: application/json");

try {
    // Join with users table to count number of users per hospital
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
                h.hospital_isVerified,
                COUNT(u.user_ID) AS user_count
            FROM sdn_hospital h
            LEFT JOIN sdn_users u ON u.hospital_code = h.hospital_code
            GROUP BY h.hospital_ID
            ORDER BY h.hospital_name ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $hospitals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($hospitals, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
