<?php
require_once("../connection.php");
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_type = $_POST['form_type'];

    if ($form_type == 'form1') {
    $note = $_POST['note'];
    
    $insert = $pdo->prepare("update responsable set note = ? where id = ?");

    if ($insert->execute([$note,$_SESSION['idR']])) {
        $_SESSION['succes']='succes';
        header("Location: home.php");
        exit();
    } else {
        echo "Error adding note.";
    }
}
elseif ($form_type == 'form2') {
        $name = htmlspecialchars($_POST['name']);
        $lieu = htmlspecialchars($_POST['lieu']);
        $date = htmlspecialchars($_POST['date']);
        $description = htmlspecialchars($_POST['materiaux']);
        $selectedEmployees = isset($_POST['services']) ? $_POST['services'] : [];
        $quantities = isset($_POST['quantities']) ? (int)$_POST['quantities'] : 0;
       
       $insert = $pdo->prepare("INSERT INTO missions (name, date, address, description, idr, ide, status, nbr_vehicule) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
       $insert->execute([$name, $date, $lieu, $description,$_SESSION['idR'], $selectedEmployees[0], 'En attente', $quantities]);
       $missionId = $pdo->lastInsertId();

       #employee update
       foreach ($selectedEmployees as $employeeId) {
        $updateEmployee = $pdo->prepare("UPDATE employee SET idM = ? WHERE id = ?");
        $updateEmployee->execute([$missionId, $employeeId]);
        }

        $_SESSION['succes']='succes';
    header("Location: missions.php");
    exit();
}
elseif($form_type === 'reply'){
    $id = htmlspecialchars($_POST['id']);
    $reply = htmlspecialchars($_POST['replay-mess']);
    $idSender = $_POST['idSender'];
    $idDist = $_POST['idDist'];
    $date = date('Y-m-d H:i:s');
    
    $insert=$pdo->prepare("INSERT INTO courier (idsender, idDistinateur, message, date, seen) 
                VALUES (?, ?, ?, ?, ?)");
    $insert->execute([$idDist,$idSender,$reply,$date,0]);
    $stmt = $pdo->prepare('UPDATE courier SET seen=? WHERE id = ?');
    $stmt->execute([1, $id]);
    $_SESSION['succes']='succes';
    header("Location: courier.php");
    exit();

}
elseif($form_type ==='send_email'){
    $idSender = $_POST['idSender'];
    $idDist = $_POST['idDist'];
    $message = $_POST['mess'];
    $date = date('Y-m-d H:i:s');
    $insert=$pdo->prepare("INSERT INTO courier (idsender, idDistinateur, message, date, seen) 
                VALUES (?, ?, ?, ?, ?)");
    $insert->execute([$idSender,$idDist,$message,$date,0]);
    $_SESSION['succes']='succes';
    header("Location: courier.php");
    exit();
    
}

elseif($form_type=='answer_congee'){
    $answer = $_POST['answer'];
    $idDemande = $_POST['idDemande'];
    $idEmp = $_POST['idEmp'];
    $datefin=$_POST['datefin'];
    $datdebut=$_POST['datdebut'];
    $nbr_rest=$_POST['nbr_rest'];

    $stmt = $pdo->prepare("UPDATE congees SET statut = ? WHERE id = ?");
    $success = $stmt->execute([$answer, $idDemande]);
    if($answer== 'Approuvé'){
    $SD = new DateTime($datdebut);
    $ED = new DateTime($datefin);
    $nbrrest = $nbr_rest - ( $ED -> diff($SD)->d);
    if($nbrrest == 0){
      $stmt = $pdo->prepare("UPDATE congees SET effectue = ?,nbr_rest = 0 WHERE ide = ? ");
      $success = $stmt->execute(['oui', $idEmp]);
      if ($success) {
        $_SESSION['succes']='succes';
        header("Location: congee.php");
        exit();
    } else {
        header("Location: congee.php?prblem");
    exit();
    }
    }
    }
    else{ 
        
        $update=$pdo->prepare("UPDATE congees SET 
        nbr_rest = nbr_rest + days_select, 
        days_select = 0 WHERE id = ?;");
        $update->execute([$idDemande]);
        $_SESSION['succes']='succes';
        header("Location: congee.php");
        exit();

    }
    


}

elseif($form_type =='edit'){
    $idM=$_POST['idM'];
    header("Location: missions.php?id=$idM");
    exit();

}
elseif($_POST['form_type'] == "delete"){
    $idM=$_POST['idM'];
    $delete = $pdo->prepare("UPDATE missions SET `show` = 'non' WHERE id = ?");
    $delete->execute([$idM]);
    $_SESSION['succes']='succes';
    header("Location: missions.php");
    exit();
}
elseif($form_type== 'deletemess'){
    $idDelete=$_POST['idDelete'];
    $delete=$pdo->prepare("delete from courier where id =?");
    $delete->execute([$idDelete]);
    $_SESSION['succes']='succes';
    header("Location: courier.php");
    exit();

}

elseif($_POST['form_type'] == 'profile_edit') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $typeservice = $_POST['typeservice'];

    $file_name=$_FILES['picture']['name'];
    $tempname = $_FILES['picture']['tmp_name'];
    $folder="images/".$file_name;


    if (move_uploaded_file($tempname, $folder)) {
        $picturePath = htmlspecialchars($folder);
       // header("Location: profile.php");
    }
    else {
        $picturePath = null;
    }
    
        $sql = "UPDATE responsable SET name = ?, email = ?, address = ?, typeservice = ?";
        if ($picturePath) {
            $sql .= ", picture = ?";
        }
        $sql .= " WHERE id = ?";

        $stmt = $pdo->prepare($sql);

        if ($picturePath) {
            $stmt->execute([$name, $email, $address, $typeservice, $picturePath, $id]);
        } else {
            $stmt->execute([$name, $email, $address, $typeservice, $id]);
        }
        $_SESSION['succes']='succes';
        header("Location: profile.php");
        exit();
   

}

elseif($form_type =='modifier'){
    $id = $_POST['idM'];
    $name = $_POST['name'];
    $nbrvehicule = $_POST['quantities'];
    $description = $_POST['materiaux'];
    $address = $_POST['lieu'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    $selectedVehicles = $_POST['vehicules'];
    $matricules = implode(',', array_map('intval', $selectedVehicles));
    $name = trim($name);
    $nbrvehicule = intval($nbrvehicule);
    $description = trim($description);
    $address = trim($address);
    $date = trim($date);
    $status = trim($status);
    if ($status === "Terminée" || $status === "Annulée") {
        $matricules = null;
        $update = $pdo->prepare("UPDATE missions SET name=?, description=?, date=?, address=?, status=?, nbr_vehicule=?,matricules=? WHERE id=?");
        $success = $update->execute([$name, $description, $date, $address, $status, $nbrvehicule,$matricules, $id]);
        $stmt = $pdo->prepare("UPDATE vehicule SET Disponibilite = 'oui' WHERE id = ?");
        foreach ($selectedVehicles as $vehicleId) {
        $vehicleId = htmlspecialchars($vehicleId);
        $stmt->execute([$vehicleId]);
    }

    }
    else if ($status === "Acceptée"){

        $update = $pdo->prepare("UPDATE missions SET name=?, description=?, date=?, address=?, status=?, nbr_vehicule=?,matricules=? WHERE id=?");
        $success = $update->execute([$name, $description, $date, $address, $status, $nbrvehicule,$matricules, $id]);
        $stmt = $pdo->prepare("UPDATE vehicule SET Disponibilite = 'non' WHERE id = ?");
        foreach ($selectedVehicles as $vehicleId) {
            $vehicleId = htmlspecialchars($vehicleId);
            $stmt->execute([$vehicleId]);
    }

    }

    else{
        
        $update = $pdo->prepare("UPDATE missions SET name=?, description=?, date=?, address=?, status=?, nbr_vehicule=?,matricules=? WHERE id=?");
        $success = $update->execute([$name, $description, $date, $address, $status, $nbrvehicule,$matricules, $id]);
       
    }
    if ($success) {
        $_SESSION['succes']='succes';
        header("Location: missions.php");
        exit();
    }
    else {
        echo "<p>Failed to update mission.</p>";
    }



}

}



?>