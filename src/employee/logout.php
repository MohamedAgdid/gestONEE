<?php
session_start();

unset($_SESSION['Empl']);
unset($_SESSION['IDService']);
unset($_SESSION['idE']);

session_destroy();


header("Location: ../login.php");
exit();
?>