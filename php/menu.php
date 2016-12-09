<?php
session_start();
require_once("php/autoload.php");

$info = false;

if(isset($_SESSION['id']))
{
    $user = new User;
    $info = $user->getData($_SESSION['id']);

    if(!$info)
    {
      header("Location: logout.php");
      die("Not logged in");
    }
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Secure User System</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css" rel="stylesheet" integrity="sha384-h21C2fcDk/eFsW9sC9h0dhokq5pDinLNklTKoxIZRUn3+hvmgQSffLLQ4G4l2eEr" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="static/validator.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Secure Login System</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <?php if(!$info) { ?>
      <ul class="nav navbar-nav">
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
      </ul>
      <?php } else { ?>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Logout</a>
      </ul>
      <?php } ?>

    </div>
  </div>
</nav>