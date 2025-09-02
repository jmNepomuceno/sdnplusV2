<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Delivery Network Plus (SDN+)</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php
            if (isset($_SESSION['user_id'])) {
                include "views/dashboard.php";  // logged-in user
            } else {
                include "views/login.php"; // guest
            }
        ?>
    </div>
</body>
</html>