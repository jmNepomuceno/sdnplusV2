<?php
include("../../connection/connection.php");

header("Content-Type: application/json");

try {
    $stmt = $pdo->query("SELECT hospital_code, hospital_name FROM sdn_hospital WHERE hospital_autKey is not null ORDER BY hospital_name ASC");
    $hospitals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($hospitals);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
