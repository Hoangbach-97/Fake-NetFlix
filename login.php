
<?php 
require_once('includes/classes/SanitizerForm.php');
require_once('includes/config.php');
require_once('includes/classes/Account.php');
$account = new Account($conn);
if(isset($_POST["submit"])){
    $username =SanitizerForm::sanitizeUsername($_POST["username"]);
    $password =SanitizerForm::sanitizePassword($_POST["password"]);
    $success =  $account->login($username, $password);
  if($success===true){
      //store session data
      $_SESSION["userLogin"] = $username;
      header("Location: index.php");
  }
}

 function rememberValue($name){
    if(isset($_POST[$name])){
        echo $_POST[$name];
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
            <h3>Sign In</h3>
            <span>to continue VietFlix</span>
        </div>
            <form action="" method="post">
                <?= $account->getError(Constants::$loginFailed); ?>
                <input type="text" name="username" placeholder="Username" value="<?= rememberValue("username")?>">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" name="submit" value="Submit">
              
            </form>
            <a href="login.php" class="loginMessage">Already has an account? Sign in here!</a>
        </div>
    </div>
</body>
</html>