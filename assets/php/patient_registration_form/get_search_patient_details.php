<?php
include("../../connection/connection.php");

header('Content-Type: application/json');

if (isset($_GET['hpercode'])) {
    $hpercode = $_GET['hpercode'];

    try {
        $sql = "SELECT h.*,
                       -- Province
                       p1.province_description AS pat_province,
                       p2.province_description AS pat_curr_province,
                       p3.province_description AS pat_work_province,

                       -- Municipality
                       m1.municipality_description AS pat_municipality,
                       m2.municipality_description AS pat_curr_municipality,
                       m3.municipality_description AS pat_work_municipality,

                       -- Barangay
                       b1.barangay_description AS pat_barangay,
                       b2.barangay_description AS pat_curr_barangay,
                       b3.barangay_description AS pat_work_barangay

                FROM hperson h

                -- province joins
                LEFT JOIN provinces p1 ON p1.province_code = h.pat_province
                LEFT JOIN provinces p2 ON p2.province_code = h.pat_curr_province
                LEFT JOIN provinces p3 ON p3.province_code = h.pat_work_province

                -- municipality joins
                LEFT JOIN city m1 ON m1.municipality_code = h.pat_municipality
                LEFT JOIN city m2 ON m2.municipality_code = h.pat_curr_municipality
                LEFT JOIN city m3 ON m3.municipality_code = h.pat_work_municipality

                -- barangay joins
                LEFT JOIN barangay b1 ON b1.barangay_code = h.pat_barangay
                LEFT JOIN barangay b2 ON b2.barangay_code = h.pat_curr_barangay
                LEFT JOIN barangay b3 ON b3.barangay_code = h.pat_work_barangay

                WHERE h.hpercode = :hpercode
                LIMIT 1";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":hpercode", $hpercode, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            echo json_encode([
                "success" => true,
                "data" => $data
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "No patient found."
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "message" => "Error: " . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request."
    ]);
}
