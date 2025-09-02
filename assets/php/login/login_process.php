<?php 
    include("../../connection/connection.php");

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

        if($user){
            // ⚠ If you’re storing plain text password (not recommended), compare directly
            if($password === $user['password']){

                // build fullname
                $fullname = $user['user_firstname'] . " " . 
                            ($user['user_middlename'] ? substr($user['user_middlename'], 0, 1) . ". " : "") . 
                            $user['user_lastname'] . " " . 
                            $user['user_extname'];

                // save to session
                $_SESSION['user'] = [
                    "hospital_code" => $user['hospital_code'],
                    "fullname"      => trim($fullname),
                    "role"          => $user['role'],
                    "permission"    => json_decode($user['permission'], true)
                ];

                echo json_encode([
                    "success"  => true,
                    "message"  => "Login successful",
                    "fullname" => trim($fullname)
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
