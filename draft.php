<?php
    include("./assets/connection/connection.php");

    $sql = "SELECT *
            FROM hperson
            WHERE hpercode = 'PAT000001'
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<pre>"; print_r($data); echo "</pre>";
?>
