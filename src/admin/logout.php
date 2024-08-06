<?php
session_start();

unset($_SESSION['admin']);
unset($_SESSION['id']);

session_destroy();


header("Location: ../login.html");
exit();
?>