<?php 
    session_start();
    $_SESSION['hospital_code'] = 101010;
    $_SESSION['hospital_name'] = 'Test RHU';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include('./views/sidebar.php') ?>
    
</body>
</html>