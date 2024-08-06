<?php
require_once("../connection.php");
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_type = $_POST['form_type'];

    if ($form_type == 'form1') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    if ($status === "Terminée" || $status === "Annulée") {
        $select=$pdo->prepare("select matricules from missions where id=?");
        $select->execute([$id]);
        $data=$select->fetch();
        if ($data && !empty($data['matricules'])) {
            $selectedVehicles = explode(',', $data['matricules']);
            $stmt = $pdo->prepare("UPDATE vehicule SET Disponibilite = 'oui' WHERE id = ?");
        foreach ($selectedVehicles as $vehicleId) {
        $vehicleId = htmlspecialchars($vehicleId);
        $stmt->execute([$vehicleId]);
        }
        }

        $matricules = null;
        $update = $pdo->prepare("UPDATE missions SET status=? , matricules=? WHERE id=?");
        $success = $update->execute([$status,$matricules, $id]);


    } 
    else{
        $update = $pdo->prepare("UPDATE missions SET status=? WHERE id=?");
        $success = $update->execute([$status, $id]);
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
    
    }
    else {
        $picturePath = null;
    }
    
        $sql = "UPDATE employee SET name = ?, email = ?, address = ?, typeservice = ?";
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
    header("Location: courier.php");
    exit();

}
elseif($form_type ==='send_email'){
    $idSender = $_POST['idSender'];
    $idDist = $_POST['idDist'];
    $message = $_POST['mess'];
    $date = date('Y-m-d H:i:s');
    $_SESSION['succes']='oui';
    $insert=$pdo->prepare("INSERT INTO courier (idsender, idDistinateur, message, date, seen) 
                VALUES (?, ?, ?, ?, ?)");
    $insert->execute([$idSender,$idDist,$message,$date,0]);
    header("Location: courier.php");
    exit();



}
elseif ($form_type == 'form-note') {
    $note = $_POST['note'];
    
    $insert = $pdo->prepare("update employee set note = ? where id = ?");

    if ($insert->execute([$note,$_SESSION['idE']])) {
        header("Location: home.php");
        exit();
    } else {
        echo "Error adding note.";
    }
}

    elseif($form_type == 'raport'){
        $id = $_POST['idRM'];
        $raport=$_POST['raport'];
        $update = $pdo->prepare("UPDATE missions SET raport=? WHERE id=?");
        $success = $update->execute([$raport,$id]);
        if ($success) {
            $_SESSION['succes']='succes';
            header("Location: missions.php");
            exit();
        }


        



    }
    elseif($form_type== 'deletemess'){
        $idDelete=$_POST['idDelete'];
        $delete=$pdo->prepare("delete from courier where id =?");
        $delete->execute([$idDelete]);
        $_SESSION['succes']='succes';
        header("Location: courier.php");
        exit();

    }
    elseif($form_type =='congee_demande'){
    $idC = $_SESSION['idE'];
    $rest_day=$_POST['restday'];
    $idService = $_SESSION['IDService'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];
    $select = $pdo->prepare("SELECT id FROM responsable WHERE idservice = ?");
    $select->execute([$idService]);
    $data = $select->fetch();
    
    $SD = new DateTime($start_date);
    $ED = new DateTime($end_date);
    
    $day_select=$ED -> diff($SD)->d;
    $nbr_rest = $rest_day - $day_select;
    
    $update = $pdo->prepare("INSERT INTO congees (ide, demande, motif, datedebut, datefin,nbr_rest,days_select, idr) VALUES (?, 'oui', ?, ?,?,?, ?,?)");
    $success = $update->execute([$idC, $reason, $start_date, $end_date,$nbr_rest,$day_select, $data['id']]);
    $_SESSION['succes']='succes';
    if ($success) {
        header("Location: congee.php");
        exit();
    }



    }
    elseif($form_type=='downloadrecu'){
        $id = $_POST['idD'];
            $select = $pdo->prepare("SELECT datedebut,datefin,motif,ide FROM congees WHERE id = ?");
            $select->execute([$id]);
            $data = $select->fetch();
            $Datedebut=$data['datedebut'];
            $Datefin=$data['datefin'];
            $motif=$data['motif'];
            $ID=$id;
        
    
            $select = $pdo->prepare("SELECT name, typeservice FROM employee WHERE id = ?");
            $select->execute([$data['ide']]);
            $data2 = $select->fetch();
        
            $Employee_Name = $data2['name'];
            $Service_Name = $data2['typeservice'];
            $Employee_ID = $data['ide'];
        ?>
           <!DOCTYPE html>
<html>
<head>
    <script src="https://unpkg.com/jspdf-invoice-template@1.4.0/dist/index.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var props = {
                outputType: jsPDFInvoiceTemplate.OutputType.Save,
                returnJsPDFDocObject: true,
                fileName: 'Congee_Recu',
                orientationLandscape: true,
                compress: true,
                logo: {
                    src: '../../img/oneelog.png',
                    type: 'PNG',
                    width: 19.66,
                    height: 19.66,
                    margin: {
                        top: 0,
                        left: 0
                    }
                },
                business: {
                    name: 'ONEE ERRACHIDIA',
                    address: 'ONEE_BO_ BP 519 ERRACHIDIA',
                    phone: '+212 654385224',
                    email: 'Onee-errachidia@onee.com',
                },
                employee: {
                    name: '<?php echo addslashes($Employee_Name); ?>',
                    service: '<?php echo addslashes($Service_Name); ?>',
                    employeeID: '<?php echo addslashes($Employee_ID); ?>'
                },
                invoice: {
                    label: 'Congée pour',
                    num: 'ID: <?php echo addslashes($ID); ?>',
                    invDate: 'Date début : <?php echo addslashes($Datedebut); ?>    Date fin : <?php echo addslashes($Datefin); ?>',
                    headerBorder: false,
                    tableBodyBorder: false,
                    invDescLabel: 'Employee nom : <?php echo addslashes($Employee_Name); ?>',
                    invDesc: 'Service name: <?php echo addslashes($Service_Name); ?>  ID : <?php echo addslashes($Employee_ID); ?>',
                    labelStyle: {
                        fontSize: 14,
                        fontStyle: 'bold',
                        textAlign: 'center'
                    },
                    numStyle: {
                        fontSize: 12,
                        textAlign: 'center'
                    },
                    invDateStyle: {
                        fontSize: 12,
                        textAlign: 'center'
                    },
                    invDescLabelStyle: {
                        fontSize: 12,
                        fontStyle: 'italic',
                        textAlign: 'center'
                    },
                    invDescStyle: {
                        fontSize: 12,
                        textAlign: 'center'
                    },
                },
                pageEnable: true,
                pageLabel: 'Page ',
                format: 'a5'
            };

            var pdfObject = jsPDFInvoiceTemplate.default(props);
            console.log('PDF created: ', pdfObject);
        });
    </script>
</head>
<body>
    <p>pdf telecharger</p>
</body>
</html>

        <?php
    
        
    
    }
    elseif ($form_type == 'form2') {
        $name = htmlspecialchars($_POST['name']);
        $lieu = htmlspecialchars($_POST['lieu']);
        $date = htmlspecialchars($_POST['date']);
        $description = htmlspecialchars($_POST['materiaux']);
        $selectedEmployees = isset($_POST['services']) ? $_POST['services'] : [];
        $quantities = isset($_POST['quantities']) ? (int)$_POST['quantities'] : 0;
       
       $insert = $pdo->prepare("INSERT INTO missions (name, date, address, description, idr, ide, status, nbr_vehicule) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
       $insert->execute([$name, $date, $lieu, $description, $_SESSION['idE'], 1, 'En attente', $quantities]);
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

    elseif ($form_type == 'download') {
        $id = $_POST['idD'];
$select = $pdo->prepare("SELECT name, date, description, address, nbr_vehicule, matricules, ide FROM missions WHERE id = ?");
$select->execute([$id]);
$data = $select->fetch();

$matriculesConcatenated = $data['matricules'] ?? '';
$Name_Mission = $data['name'];
$date_Mission = $data['date'];
$ID = $id;
$Description_Mission = $data['description'];
$address = $data['address'];
$N_Vehicule = $data['nbr_vehicule'];

$select = $pdo->prepare("SELECT name, typeservice FROM employee WHERE id = ?");
$select->execute([$data['ide']]);
$data2 = $select->fetch();

$Employee_Name = $data2['name'];
$Service_Name = $data2['typeservice'];
$Employee_ID = $data['ide'];

$matriculesArray = explode(',', $matriculesConcatenated);


if (count($matriculesArray) > 1) {
    $placeholders = str_repeat('?,', count($matriculesArray) - 1) . '?';
    $sel = $pdo->prepare("SELECT matricule FROM vehicule WHERE id IN ($placeholders)");
    $sel->execute($matriculesArray);
} else {
    $sel = $pdo->prepare("SELECT matricule FROM vehicule WHERE id = ?");
    $sel->execute($matriculesArray);
}

$res = $sel->fetchAll();

if ($res) {
    $matricules = [];
    foreach ($res as $row) {
        $matricules[] = $row['matricule'];
    }
    $matriculesConcatenated = implode(',', $matricules);
} else {
    $matriculesConcatenated = '';
}

    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <script src="https://unpkg.com/jspdf-invoice-template@1.4.0/dist/index.js"></script>
            <script>
                let pdfGenerated = false;
                document.addEventListener("DOMContentLoaded", function() {
                    if (!pdfGenerated) {
        pdfGenerated = true;

        var props = {
            outputType: jsPDFInvoiceTemplate.OutputType.Save,
            returnJsPDFDocObject: true,
            fileName: 'Mission_Report',
            orientationLandscape: true,
            compress: true,
            logo: {
                src: '../../img/oneelog.png',
                type: 'PNG',
                width: 19.66,
                height: 19.66,
                margin: {
                    top: 0,
                    left: 0
                }
            },
            business: {
                name: 'ONEE ERRACHIDIA',
                address: 'ONEE_BO_ BP 519 ERRACHIDIA',
                phone: '+212 654385224',
                email: 'Onee-errachidia@onee.com',
            },
            employee: {
                name: '<?php echo addslashes($Employee_Name); ?>',
                service: '<?php echo addslashes($Service_Name); ?>',
                employeeID: '<?php echo addslashes($Employee_ID); ?>'
            },
            invoice: {
                label: '<?php echo addslashes($Name_Mission); ?>',
                num: 'ID: <?php echo addslashes($ID); ?>',
                invDate: '<?php echo addslashes($date_Mission); ?>',
                headerBorder: false,
                tableBodyBorder: false,
                header: [
                    { title: 'ID', style: { width: 10 } },
                    { title: 'Title', style: { width: 30 } },
                    { title: 'Address', style: { width: 30 } },
                    { title: 'Nombre de Vehicule' },
                    { title: 'Matricules' },
                    { title: 'Description', style: { width: 80 } },
                ],
                table: [
                    [
                        '<?php echo addslashes($ID); ?>',
                        '<?php echo addslashes($Name_Mission); ?>',
                        '<?php echo addslashes($address); ?>',
                        '<?php echo addslashes($N_Vehicule); ?>',
                        '<?php echo addslashes($matriculesConcatenated);    ?>',
                        '<?php echo addslashes($Description_Mission); ?>',
                    ]
                ],
                invDescLabel: 'Employee nome : <?php echo addslashes($Employee_Name); ?>',
                invDesc: 'Service name: <?php echo addslashes($Service_Name); ?>  ID :<?php echo addslashes($Employee_ID); ?>',
            },
            pageEnable: true,
            pageLabel: 'Page ',
            format: 'a5'
        };
        
    var pdfObject = jsPDFInvoiceTemplate.default(props);
    console.log('PDF created: ', pdfObject);
                }
});
            </script>
        </head>
        <body>
            <p>pdf telecharger</p>
        </body>
        </html>
    <?php

    }

    
    



}

?>


