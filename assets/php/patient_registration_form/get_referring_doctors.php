<?php
include("../../connection/connection.php");

header("Content-Type: application/json");

try {
    // hospital_code comes from logged-in user session
    // $hospital_code = $_SESSION['hospital_code'] ?? null;
    $hospital_code = 1111;

    if (!$hospital_code) {
        echo json_encode([]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, last_name, first_name, middle_name , mobile_number
                        FROM doctors_list 
                        WHERE hospital_code = :hospital_code 
                        ORDER BY last_name ASC");
    $stmt->execute([':hospital_code' => $hospital_code]);

    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($doctors);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
