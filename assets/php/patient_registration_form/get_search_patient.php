<?php
include("../../connection/connection.php");

header("Content-Type: application/json");

try {
    // Get POST data
    $lastName   = isset($_POST['lastName']) ? trim($_POST['lastName']) : "";
    $firstName  = isset($_POST['firstName']) ? trim($_POST['firstName']) : "";
    $middleName = isset($_POST['middleName']) ? trim($_POST['middleName']) : "";

    // Base query
    $sql = "SELECT hpercode, patlast, patfirst, patmiddle, patbdate, hospital_code, status
            FROM hperson
            WHERE 1=1";

    $params = [];

    if (!empty($lastName)) {
        $sql .= " AND patlast LIKE :patlast";
        $params[':patlast'] = "%" . $lastName . "%";
    }
    if (!empty($firstName)) {
        $sql .= " AND patfirst LIKE :patfirst";
        $params[':patfirst'] = "%" . $firstName . "%";
    }
    if (!empty($middleName)) {
        $sql .= " AND patmiddle LIKE :patmiddle";
        $params[':patmiddle'] = "%" . $middleName . "%";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $patients = [];

    foreach ($rows as $row) {
        $fullName = $row['patlast'] . ", " . $row['patfirst'];
        if (!empty($row['patmiddle'])) {
            $fullName .= " " . $row['patmiddle'];
        }

        $patients[] = [
            "hpercode"    => $row['hpercode'],
            "fullName"     => $fullName,
            "birthday"     => $row['patbdate'],
            "registeredAt" => $row['hospital_code'],
            "status"       => $row['status']
        ];
    }

    echo json_encode($patients);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
