<?php
    include("../../connection/connection.php");

    header("Content-Type: application/json");
    date_default_timezone_set('Asia/Manila');
    session_start();

    try {
    // Collect filters
    $ref_no      = $_POST['ref_no']      ?? null;
    $last_name   = $_POST['last_name']   ?? null;
    $first_name  = $_POST['first_name']  ?? null;
    $middle_name = $_POST['middle_name'] ?? null;
    $type        = $_POST['case_type']   ?? null;
    $agency      = (int)$_POST['agency']      ?? null;
    $start_date  = $_POST['start_date']  ?? null;
    $end_date    = $_POST['end_date']    ?? null;
    $turnaround  = $_POST['turnaround']  ?? null;
    $sensitive   = $_POST['sensitive']   ?? null;
    $status      = $_POST['status']      ?? null;

    // Base query (same structure as your second PHP)
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
            r.approved_time,
            r.deferred_time,
            r.sensitive_case,
            r.final_progressed_timer,

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
        WHERE 1=1
    ";

    $params = [];

    // Dynamic filters
    if (!empty($ref_no)) {
        $sql .= " AND r.reference_num LIKE :ref_no";
        $params[":ref_no"] = "%$ref_no%";
    }
    if (!empty($last_name)) {
        $sql .= " AND hp.patlast LIKE :last_name";
        $params[":last_name"] = "%$last_name%";
    }
    if (!empty($first_name)) {
        $sql .= " AND hp.patfirst LIKE :first_name";
        $params[":first_name"] = "%$first_name%";
    }
    if (!empty($middle_name)) {
        $sql .= " AND hp.patmiddle LIKE :middle_name";
        $params[":middle_name"] = "%$middle_name%";
    }
    if (!empty($type)) {
        $sql .= " AND r.type = :type";
        $params[":type"] = $type;
    }
    if (!empty($agency)) {
        $sql .= " AND r.hospital_code = :agency";
        $params[":agency"] = $agency;
    }
    if (!empty($start_date)) {
        $sql .= " AND DATE(r.date_time) >= :start_date";
        $params[":start_date"] = $start_date;
        }
        if (!empty($end_date)) {
            $sql .= " AND DATE(r.date_time) <= :end_date";
            $params[":end_date"] = $end_date;
        }
        if (!empty($status)) {
            $sql .= " AND r.status = :status";
            $params[":status"] = $status;
        }
        if (!empty($sensitive)) {
            $sql .= " AND r.sensitive_case = :sensitive";
            $params[":sensitive"] = $sensitive;
        }
        if (!empty($turnaround)) {
            $sql .= " AND r.final_progressed_timer <= :turnaround";
            $params[":turnaround"] = $turnaround;
        }

        $sql .= " ORDER BY r.date_time DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "data" => $referrals]);

    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
?>