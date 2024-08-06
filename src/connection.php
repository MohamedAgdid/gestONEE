<?php


try {
  $pdo = new PDO("mysql:host=localhost;dbname=gest", "root", "");

} catch(PDOException $e){ 
  echo "Database connection failed: " . $e->getMessage();
  error_log($e->getMessage()); 
  exit();
}





?>
