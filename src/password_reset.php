<?php

if (isset($_POST['name']) && isset($_POST['email'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    require_once("./connection.php");
    
    $select = $pdo->prepare("SELECT password FROM responsable WHERE name=? AND email=?");
    $select->execute([$name, $email]);
    $row = $select->fetch();
    if ($row) {
        $password = $row['password'];
        $response = json_encode(['success' => true, 'password' => $password, 'name' => $name, 'email' => $email]);
    } else {
        $response = json_encode(['success' => false, 'error' => 'User not found']);
    }
    
    echo $response;
}
?>



