<?php
    include("../../connection/connection.php");

    // header("Content-Type: application/json");
    date_default_timezone_set('Asia/Manila');
    session_start();

    try {
        
        // Fetch classification with its assigned color
        $sql = "SELECT classifications, color FROM classifications";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data_classifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Create dynamic mapping
        $dynamic_classification = [];
        foreach ($data_classifications as $row) {
            $dynamic_classification[$row['classifications']] = $row['color'];
        }

        echo json_encode($dynamic_classification, JSON_PRETTY_PRINT);

    } catch (PDOException $e) {
        echo json_encode([
            "error" => true,
            "message" => $e->getMessage()
        ]);
    }
?>
