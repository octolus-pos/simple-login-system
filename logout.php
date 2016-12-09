<?php
header("Location: login.php");
session_start();
$_SESSION['id'] = NULL;
session_destroy();
unset($_SESSION['id']);
?>
