<?php
    include("../../../connection/connection.php");
    header("Content-Type: application/json");

    try {
        $sql = "SELECT id, classifications, class_code, color FROM classifications ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($data, JSON_PRETTY_PRINT);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
?>
