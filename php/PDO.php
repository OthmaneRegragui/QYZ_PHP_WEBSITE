<?php
include('config.php');
try {
    $conn = new PDO("mysql:host=$Server;dbname=$DbName", $DbUserName, $DbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>


