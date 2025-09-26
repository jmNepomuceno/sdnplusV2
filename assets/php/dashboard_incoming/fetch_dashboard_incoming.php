<?php
include("../../connection/connection.php");

date_default_timezone_set('Asia/Manila');
session_start();
header("Content-Type: application/json");

try {
    // Grab filters (with defaults)
    $startDate  = isset($_GET['start_date']) ? $_GET['start_date'] . " 00:00:00" : date("Y-m-01 00:00:00");
    $endDate    = isset($_GET['end_date']) ? $_GET['end_date'] . " 23:59:59" : date("Y-m-t 23:59:59");
    
    // $startDate = isset($_GET['startDate']) 
    // ? $_GET['startDate'] . " 00:00:00" 
    // : date("Y-m-d 00:00:00");   // today only

    // $endDate = isset($_GET['endDate']) 
    // ? $_GET['endDate'] . " 23:59:59" 
    // : date("Y-m-d 23:59:59");   // today only
    
    $caseType   = isset($_GET['case_type']) && $_GET['case_type'] !== "" ? $_GET['case_type'] : null;
    $rhu        = isset($_GET['rhu']) && $_GET['rhu'] !== "" ? $_GET['rhu'] : null;

    // Base SQL
    $sqlIncoming = "SELECT 
                    i.id,
                    i.referral_id,
                    i.reference_num,
                    i.patlast,
                    i.patfirst,
                    i.patmiddle,
                    i.type,
                    i.date_time,
                    i.reception_time,
                    i.status,
                    i.approved_time,
                    i.final_progressed_timer,
                    i.referred_by,
                    i.refer_to,
                    i.pat_class,
                    i.icd_diagnosis,
                    i.referred_by_code,
                    m.icd10_title AS icd_diagnosis_title
                FROM incoming_referrals i
                LEFT JOIN icd_code_mapping m 
                    ON i.icd_diagnosis = m.icd10_code
                WHERE 1=1"; // start with always-true

    $params = [];

    // Only add if dates exist
    if (!empty($startDate) && !empty($endDate)) {
        $sqlIncoming .= " AND i.date_time BETWEEN :startDate AND :endDate";
        $params[':startDate'] = $startDate;
        $params[':endDate']   = $endDate;
    }

    if (!empty($caseType)) {
        $sqlIncoming .= " AND i.type = :caseType";
        $params[':caseType'] = $caseType;
    }

    if (!empty($rhu)) {
        // $sqlIncoming .= " AND i.referred_by_code = :rhu";
        $sqlIncoming .= " AND i.referred_by = :rhu";
        $params[':rhu'] = $rhu;
    }

    $sqlIncoming .= " ORDER BY i.date_time DESC";

    $stmtIncoming = $pdo->prepare($sqlIncoming);
    $stmtIncoming->execute($params);
    $incoming = $stmtIncoming->fetchAll(PDO::FETCH_ASSOC);



    // Group incoming by hospital
    $groupedByHospital = [];
    foreach ($incoming as $row) {
        $hospitalCode = $row['refer_to'];
        $groupedByHospital[$hospitalCode][] = $row;
    }

    // Attach grouped incoming to hospitals
    $result = [];
    foreach ($groupedByHospital as $hospitalCode => $referrals) {
        $result[] = [
            "hospital_code" => $hospitalCode,
            "referrals"     => $referrals,
            "referral_count"=> count($referrals)
        ];
    }

    echo json_encode($result, JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
