<?php
    include("../../connection/connection.php");

    // header("Content-Type: application/json");
    date_default_timezone_set('Asia/Manila');
    session_start();

    try {
        // Example: get the logged-in RHU name from session
        $currentRHU = $_SESSION['user']['hospital_code'] ?? null;

        $sql = "
        SELECT 
            r.reference_num,
            r.referral_id,
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
            r.reception_time,
            r.sensitive_case,
            r.referred_by_code,

            -- Optional: compute processing time if timestamps exist
            CASE 
                WHEN r.reception_time IS NOT NULL AND r.date_time IS NOT NULL 
                THEN TIMESTAMPDIFF(MINUTE, r.date_time, r.reception_time)
                ELSE NULL
            END AS processing_time,

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
            ON r.referred_by_code = sh.hospital_code
        WHERE r.referred_by_code = :current_rhu AND r.status IN ('Pending', 'On-Process')
            ORDER BY r.date_time DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([":current_rhu" => $currentRHU]);
        $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ✅ Add numbering to reference_num
        $refCounts = [];
        foreach ($referrals as &$row) {
            $refKey = $row['reference_num'];

            if (!isset($refCounts[$refKey])) {
                $refCounts[$refKey] = 1;
            } else {
                $refCounts[$refKey]++;
            }

            $row['reference_num'] = $refKey . ' - ' . $refCounts[$refKey];
        }

        echo json_encode(["data" => $referrals], JSON_PRETTY_PRINT);

    } 
    catch (PDOException $e) {
        echo json_encode([
            "error" => true,
            "message" => $e->getMessage()
        ]);
    }
?>
