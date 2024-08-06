<?php
session_start();

try {
  $pdo = new PDO("mysql:host=localhost;dbname=gest", "root", "");

} catch(PDOException $e){ 
  echo "Database connection failed: " . $e->getMessage();
  error_log($e->getMessage()); 
  exit();
}

$email = $_POST['email'];
$password = $_POST['pwd'];
if (empty($email) || empty($password) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (empty($email) || empty($password)) {
        $_SESSION['error_title'] = 'Champs manquants !';
        $_SESSION['error'] = "Tous les champs doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_title'] = 'Adresse e-mail invalide !';
        $_SESSION['error'] = "L'adresse e-mail fournie est invalide.";
    }
    header("Location: login.php");
    exit();
}


function fetch_user_data($pdo, $email, $table) {
    $select = $pdo->prepare("SELECT id,email, password, name, type, idservice, acces FROM $table WHERE email = ?");
    $select->execute(array($email));
    return $select->fetch();
}


$data = null;

$tables = ['responsable', 'employee', 'admin'];

foreach ($tables as $table) {
    $data = fetch_user_data($pdo, $email, $table);
    if ($data) {
        break;
    }
}


if ($data) {
    
    if ($password === $data['password']) {
        if ($data['type'] === 'R') {
            if($data['acces']==='Oui'){
            $_SESSION['Direct'] = $data['name'];
            $_SESSION['IDService'] = $data['idservice'];
            $_SESSION['idR']=$data['id'];

            header("Location: responsable/home.php");
            exit();
            }
            else{
                $_SESSION['error_title']='Accès Refusé !';
                $_SESSION['error']="Vous n'avez pas l'accès nécessaire pour effectuer cette opération.";
                header("Location: login.php");
                exit();
            }
        } elseif ($data['type'] === 'E') {
            if($data['acces']==='Oui'){
            $_SESSION['Empl'] = $data['name'];
            $_SESSION['IDService'] = $data['idservice'];
            $_SESSION['idE']=$data['id'];
            header("Location: employee/home.php");
            exit();}
            else{
                $_SESSION['error_title']='Accès Refusé !';
                $_SESSION['error']="Vous n'avez pas l'accès nécessaire pour effectuer cette opération.";
                header("Location: login.php");
                exit();
            }

        }
        elseif($data['type'] === 'A'){
            
            $_SESSION['admin'] = $data['name'];
            $_SESSION['id']=$data['id'];
            header("Location: admin/home.php");
            exit();
        }
    } else {
        $_SESSION['error_title']='mot de passe incorrect!';
        $_SESSION['error']="Le mot de passe que vous avez saisi est incorrect.";
        header("Location: login.php");
        exit();
    }

    $data=[];
} else {
    $_SESSION['error_title'] = 'Compte non trouvé!';
    $_SESSION['error'] = "Le compte que vous avez saisi n'existe pas.";
    header("Location: login.php");
    exit();
}
?>
