<?php
  $dbHost = "localhost";
  $dbUser = "root";
  $dbPassword = "password";
  $dbName = "bghmc";

  try {
    $dsn = "mysql:host=" . $dbHost . ";dbname=" . $dbName;
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
  } catch(PDOException $e) {
    echo "DB Connection Failed: " . $e->getMessage();
  }
?>