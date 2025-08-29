<?php
include("../../connection/connection.php");

header('Content-Type: application/json');

try {
    $sql = "SELECT class_code, classifications FROM classifications ORDER BY classifications ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $rows
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}

?>