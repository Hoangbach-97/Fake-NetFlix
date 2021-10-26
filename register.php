<?php 
require_once('includes/classes/SanitizerForm.php');
require_once('includes/config.php');
require_once('includes/classes/Account.php');

// $conn variable from includes/config.php
$account = new Account($conn);
if(isset($_POST["submit"])){
    $firstName =SanitizerForm::sanitizeFormString($_POST["firstName"]);
    $lastName =SanitizerForm::sanitizeFormString($_POST["lastName"]);
    $username =SanitizerForm::sanitizeUsername($_POST["username"]);
    $email =SanitizerForm::sanitizeFormEmail($_POST["email"]);
    $confirmEmail =SanitizerForm::sanitizeFormEmail($_POST["confirmEmail"]);
    $password =SanitizerForm::sanitizePassword($_POST["password"]);
    $confirmPassword =SanitizerForm::sanitizePassword($_POST["confirmPassword"]);

  $success =  $account->register($firstName, $lastName,$username, $email, $confirmEmail, $password, $confirmPassword);
  if($success===true){
      //store session data
      header("Location: index.php");
  }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style/style.css">
    <title>Document</title>
</head>
<body>
    <div class="SignUpPage">
       
        <div class="column">
        <div class="header">
            <img src="assets/images/logo.png" title="vietflix" alt="vietflix">
            <h3>Sign Up</h3>
            <span>to continue VietFlix</span>
        </div>
            <form action="" method="post">
                <?= $account->getError(Constants::$firstNameCharacters); ?>
                <input type="text" name="firstName" placeholder="First Name">
                <?= $account->getError(Constants::$lastNameCharacters); ?>
                <input type="text" name="lastName" placeholder="Last Name">
                <?= $account->getError(Constants::$usernameCharacters); ?>
                <?= $account->getError(Constants::$checkUserExists); ?>
                <input type="text" name="username" placeholder="Username">

                <?= $account->getError(Constants::$emailNotMatch); ?>
                <?= $account->getError(Constants::$invalidEmail); ?>
                <?= $account->getError(Constants::$checkEmailExists); ?>
                <input type="email" name="email" placeholder="Email">
                <input type="email" name="confirmEmail" placeholder="confirmEmail">

                
                <?= $account->getError(Constants::$passwordNotMatch); ?>
                <?= $account->getError(Constants::$invalidPassword); ?>
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="confirmPassword" placeholder="confirmPassword">
                <input type="submit" name="submit" value="Submit">
              
            </form>
            <a href="login.php" class="loginMessage">Need an account? Sign up here!</a>
        </div>
    </div>
</body>
</html>