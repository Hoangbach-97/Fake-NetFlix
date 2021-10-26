<?php
require_once('includes/config.php');
require_once('includes/classes/PreviewProvider.php');
require_once('includes/classes/Entity.php');
require_once('includes/classes/CategoryContainers.php');
require_once('includes/classes/EntityProviders.php');
require_once('includes/classes/ErrorMessage.php');
require_once('includes/classes/SeasonProvider.php');
require_once('includes/classes/Seasons.php');
require_once('includes/classes/Videos.php');
require_once('includes/classes/VideoProvider.php');
require_once('includes/classes/User.php');
require_once('includes/classes/Account.php');


if(!isset($_SESSION['userLogin'])){
    header('Location: register.php');
}

$userLogin = $_SESSION['userLogin'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/bc67e88606.js" crossorigin="anonymous"></script>
    <script src="assets/js/script.js" crossorigin="anonymous"></script>

    <title>Document</title>
</head>
<body>

<div class="wrapper">

<div class="topBar">
    <div class="logoContainer">
        <a href="index.php">
            <img src="assets/images/logo.png" alt="vietflix">
        </a>
    </div>
    <ul class="navLinks">
        <li><a href="index.php">Home</a></li>
        <li><a href="show.php">TV Shows</a></li>
        <li><a href="movies.php">Movies</a></li>
    </ul>
    <div class="rightItems">
        <a href="search.php">
            <i class="fa fa-search"></i>
        </a>
        <a href="profile.php">
            <i class="fa fa-user"></i>
        </a>
        <a href="logout.php">
            <i class="fa fa-sign-out-alt"></i>
        </a>
    </div>
</div>