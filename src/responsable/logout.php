<?php
session_start();

unset($_SESSION['Direct']);
unset($_SESSION['IDService']);
unset($_SESSION['idR']);

session_destroy();


header("Location: ../login.php");
exit();
?>