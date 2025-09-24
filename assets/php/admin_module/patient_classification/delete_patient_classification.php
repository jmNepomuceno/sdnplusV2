<?php
include("../../../connection/connection.php");
header("Content-Type: application/json");

try {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        echo json_encode(["success" => false, "message" => "Invalid request."]);
        exit;
    }

    $id = intval($_POST['id']);

    $sql = "DELETE FROM classifications WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Classification deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete classification."]);
    }

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>