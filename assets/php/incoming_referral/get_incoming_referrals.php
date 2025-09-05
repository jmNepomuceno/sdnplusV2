<?php
    include("../../connection/connection.php");

    // header("Content-Type: application/json");
    date_default_timezone_set('Asia/Manila');
    session_start();

    try {
        $sql = "
            SELECT 
                r.reference_num,
                CONCAT(hp.patlast, ', ', hp.patfirst, ' ', COALESCE(hp.patmiddle, '')) AS patient_name,
                
                CONCAT(
                    COALESCE(b.barangay_description, ''), ', ',
                    COALESCE(c.municipality_description, ''), ', ',
                    COALESCE(p.province_description, '')
                ) AS full_address,
                
                TIMESTAMPDIFF(YEAR, hp.patbdate, CURDATE()) AS age,
                
                r.type,
                r.referred_by,
                r.landline_no,
                r.mobile_no,
                r.date_time,
                r.status,

            sh.hospital_director,
            sh.hospital_director_mobile,
            sh.hospital_point_person,
            sh.hospital_point_person_mobile

            FROM bghmc.incoming_referrals r
            INNER JOIN bghmc.hperson hp 
                ON r.hpercode = hp.hpercode
            LEFT JOIN bghmc.barangay b 
                ON hp.pat_barangay = b.barangay_code
            LEFT JOIN bghmc.city c 
                ON hp.pat_municipality = c.municipality_code
            LEFT JOIN bghmc.provinces p 
                ON hp.pat_province = p.province_code
            LEFT JOIN bghmc.sdn_hospital sh 
                ON r.referred_by = sh.hospital_name

            WHERE r.status = 'Pending'
            ORDER BY r.date_time DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["data" => $referrals], JSON_PRETTY_PRINT);
        // echo "here";

    } catch (PDOException $e) {
        echo json_encode([
            "error" => true,
            "message" => $e->getMessage()
        ]);
    }
?>
