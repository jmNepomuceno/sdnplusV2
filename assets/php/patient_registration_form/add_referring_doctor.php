<?php 
include("../../connection/connection.php");
date_default_timezone_set('Asia/Manila');
header('Content-Type: application/json; charset=utf-8');

try {
    $last_name      = $_POST['last_name'];
    $first_name     = $_POST['first_name'];
    $middle_name    = $_POST['middle_name'];
    $license_no     = $_POST['license_no'];
    $specialization = $_POST['specialization'];
    $mobile_no      = $_POST['mobile_no'];

    $sql = "INSERT INTO doctors_list 
            (last_name, first_name, middle_name, license_no, specialization, mobile_number, status, hospital_code) 
            VALUES (:last_name, :first_name, :middle_name, :license_no, :specialization, :mobile_no, 'Active', :hospital_code)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':last_name'     => $last_name,
        ':first_name'    => $first_name,
        ':middle_name'   => $middle_name,
        ':license_no'    => $license_no,
        ':specialization'=> $specialization,
        ':mobile_no'     => $mobile_no,
        ':hospital_code' => '1111'
    ]);

    $doctor_id = $pdo->lastInsertId();
    $full_name = $first_name . " " . $middle_name . " " . $last_name;

    echo json_encode([
        "status" => "success",
        "data" => [
            "id"            => $doctor_id,
            "full_name"     => $full_name,
            "license_no"    => $license_no,
            "specialization"=> $specialization,
            "mobile_no"     => $mobile_no
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => $e->getMessage()
    ]);
}
?>
