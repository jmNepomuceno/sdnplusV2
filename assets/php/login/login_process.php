<?php 
    include("../../connection/connection.php");
    session_start();
    // Get input safely
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if(empty($username) || empty($password)){
        echo json_encode(["success" => false, "message" => "Username and password are required."]);
        exit;
    }

    try {
        $sql = "SELECT hospital_code, user_lastname, user_firstname, user_middlename, user_extname, username, password, role, permission 
                FROM sdn_users WHERE username = :username LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // ⚠ If plain text password (not recommended), compare directly
            if ($password === $user['password']) {

                // Build fullname
                $fullname = $user['user_firstname'] . " " . 
                            ($user['user_middlename'] ? substr($user['user_middlename'], 0, 1) . ". " : "") . 
                            $user['user_lastname'] . " " . 
                            $user['user_extname'];

                // ✅ Fetch hospital_name from sdn_hospital
                $sqlHospital = "SELECT hospital_name FROM sdn_hospital WHERE hospital_code = :hospital_code LIMIT 1";
                $stmtHospital = $pdo->prepare($sqlHospital);
                $stmtHospital->bindParam(":hospital_code", $user['hospital_code'], PDO::PARAM_INT);
                $stmtHospital->execute();
                $hospital = $stmtHospital->fetch(PDO::FETCH_ASSOC);

                $hospitalName = $hospital ? $hospital['hospital_name'] : "Unknown Hospital";

                // Save to session
                $_SESSION['user'] = [
                    "hospital_code" => $user['hospital_code'],
                    "hospital_name" => $hospitalName,
                    "fullname"      => trim($fullname),
                    "role"          => $user['role'],
                    "permission"    => json_decode($user['permission'], true)
                ];

                echo json_encode([
                    "success"       => true,
                    "message"       => "Login successful",
                    "fullname"      => trim($fullname),
                    "hospital_name" => $hospitalName
                ]);
            } else {
                echo json_encode(["success" => false, "message" => "Invalid password."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "User not found."]);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }


?>
