<?php
    include("../../../connection/connection.php");
    header("Content-Type: application/json");

    try {
        if (!isset($_POST['classification']) || !isset($_POST['class_code']) || !isset($_POST['color'])) {
            echo json_encode(["success" => false, "message" => "Missing required fields."]);
            exit;
        }

        $classification = trim($_POST['classification']);
        $class_code = trim($_POST['class_code']);
        $color = trim($_POST['color']);

        $sql = "INSERT INTO classifications (classifications, class_code, color) 
                VALUES (:classification, :class_code, :color)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':classification', $classification);
        $stmt->bindParam(':class_code', $class_code);
        $stmt->bindParam(':color', $color);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Classification added successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to add classification."]);
        }

    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

?>