<?php
require_once("../connection.php");
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_type = $_POST['form_type'];

    if ($form_type == 'form1') {
    $access = $_POST['access'];
    $id = $_POST['id'];
    $stmt = $pdo->prepare("UPDATE employee SET acces = ? WHERE id = ?");
    $stmt->execute([$access, $id]);
    header("Location: employee.php");
    exit();

    }
    elseif($form_type == 'Suppreme_empl'){
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM employee WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: employee.php");
        exit();
    }
    elseif($form_type=="id_empl"){
        if (isset($_POST['id_empl'])) {
            $id = filter_input(INPUT_POST, 'id_empl', FILTER_SANITIZE_NUMBER_INT);
            if ($id) {
                header("Location: employee.php?id=$id");
                exit();}}
    }
    elseif($_POST['form_type'] == 'modifier'){
    $id = htmlspecialchars($_POST['idM']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $type = htmlspecialchars($_POST['type']);
    $typeservice = htmlspecialchars($_POST['typeservice']);

    $selec=$pdo->prepare("UPDATE employee SET name=?, email=?, address=?, type=?, typeservice=? WHERE id=?");
    $selec->execute([$name, $email, $address, $type, $typeservice, $id]);
    header("Location: employee.php"); exit();


    }
    elseif($form_type == 'AddEmpl'){
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $genre = htmlspecialchars($_POST['gender']);
    $typeservice = htmlspecialchars($_POST['typeservice']);

    $selec=$pdo->prepare("insert into employee (name,email,address,gender,typeservice) values (?,?,?,?,?)");
    $selec->execute([$name, $email, $address, $genre, $typeservice]);
    header("Location: employee.php"); exit();

    }
    elseif($_POST['form_type'] == 'profile_edit') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $idservice = $_POST['idservice'];
    
        $file_name=$_FILES['picture']['name'];
        $tempname = $_FILES['picture']['tmp_name'];
        $folder="images/".$file_name;
    
    
        if (move_uploaded_file($tempname, $folder)) {
            $picturePath = htmlspecialchars($folder);
        
        }
        else {
            $picturePath = null;
        }
        
            $sql = "UPDATE admin SET name = ?, email = ?, address = ?, idservice = ?";
            if ($picturePath) {
                $sql .= ", picture = ?";
            }
            $sql .= " WHERE id = ?";
    
            $stmt = $pdo->prepare($sql);
    
            if ($picturePath) {
                $stmt->execute([$name, $email, $address, $idservice, $picturePath, $id]);
            } else {
                $stmt->execute([$name, $email, $address, $idservice, $id]);
            }
            header("Location: profile.php");
            exit();
       
    
    }

}
?>