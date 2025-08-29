<?php
include("../../connection/connection.php");

header("Content-Type: application/json");

try {
    $q = $_GET['q'] ?? '';
    $type = $_GET['type'] ?? 'title';

    // if(strlen($q) < 2) {
    // echo json_encode([]);
    // exit;
    // }

    if($type === 'code') {
    $stmt = $pdo->prepare("SELECT icd10_code AS code, icd10_title AS title 
                            FROM icd_code_mapping 
                            WHERE icd10_code LIKE ? LIMIT 10");
    $stmt->execute(["%$q%"]);
    } else {
    $stmt = $pdo->prepare("SELECT icd10_code AS code, icd10_title AS title 
                            FROM icd_code_mapping 
                            WHERE icd10_title LIKE ? LIMIT 10");
    $stmt->execute(["%$q%"]);
    }

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
