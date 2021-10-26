<?php
require_once("includes/header.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/SanitizerForm.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/BillingDetails.php");
require_once("includes/paypalConfig.php");
$user = new User($conn, $userLogin);

$detailsMessage = "";
$passwordMessage = "";
$subscriptionMessage="";
if(isset($_POST['saveDetailButon'])){
    $account = new Account($conn);
    $firstName = SanitizerForm::sanitizeFormString($_POST['firstName']);
    $lastName = SanitizerForm::sanitizeFormString($_POST['lastName']);
    $email = SanitizerForm::sanitizeFormEmail($_POST['email']);

    if($account->updateDetails($firstName, $lastName, $email, $userLogin)){
            // TODO
            $detailsMessage = "<div class='alertSuccess'>
                                <h1>Successfully updated</h1>
                                </div>";
    }
    else{
      $errorMessage = $account->getFirstError();
      $detailsMessage = "<div class='alertError'>
      $errorMessage
      </div>";
    }

}


if(isset($_POST['savePassword'])){
    $account = new Account($conn);
    $oldPassword = SanitizerForm::sanitizePassword($_POST['oldPassword']);
    $newPassword = SanitizerForm::sanitizePassword($_POST['newPassword']);
    $confirmPassword = SanitizerForm::sanitizePassword($_POST['confirmPassword']);
 

    if($account->updatePassword($oldPassword, $newPassword, $confirmPassword, $userLogin)){
            // TODO
            $passwordMessage = "<div class='alertSuccess'>
                                <h1>Successfully updated</h1>
                                </div>";
    }
    else{
      $errorMessage = $account->getFirstError();
      $passwordMessage = "<div class='alertError'>
      $errorMessage
      </div>";
    }

}

if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $token = $_GET['token'];
    $agreement = new \PayPal\Api\Agreement();

    $subscriptionMessage = "<div class='alertError'>
                                    <h1>Something went wrong</h1>
                                    </div>";
  
    try {
      // Execute agreement
      $agreement->execute($token, $apiContext);

      $result = BillingDetails::insertDetails($conn, $agreement, $token, $userLogin);
        $result  = $result && $user->setIsSubcribed(1);

        if($result){
            $subscriptionMessage = "<div class='alertError'>
                                    <h1>You are all signed up</h1>
                                    </div>";
        }
    //   Update user's account satus
    } catch (PayPal\Exception\PayPalConnectionException $ex) {
      echo $ex->getCode();
      echo $ex->getData();
      die($ex);
    } catch (Exception $ex) {
      die($ex);
    }
  } else if (isset($_GET['success']) && $_GET['success'] == 'false') {
    $subscriptionMessage = "<div class='alertError'>
    <h1>User cancelled or something wrong</h1>
    </div>";
  }

?>


<div class="settingContainer column">
    <div class="formSection">
        <form action="" method="post">
            <h2>User details</h2>

        <!--START PHP -->
            <?php 
            $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : $user->getFirstName();
            $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : $user->getLastName();
            $email = isset($_POST['email']) ? $_POST['email'] : $user->getEmail();
           
           ?>

        <!--ENDDED PHP -->

            <input type="text" name="firstName" placeholder="First Name" value="<?php echo $firstName?>">
            <input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName?>">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email?>">

            <div class="message" style="color: #fff">
                <?= $detailsMessage;?>
            </div>
            <input type="submit" name="saveDetailButon" value="Submit">
        </form>
    </div>

    <div class="formSection">
        <form action="" method="post">
            <h2>Update Password</h2>
            <input type="password" name="oldPassword" placeholder="Old Password">
            <input type="password" name="newPassword" placeholder="New Password">
            <input type="password" name="confirmPassword" placeholder="Confirm Password">
            <div class="message" style="color: #fff">
                <?= $passwordMessage;?>
            </div>
            <input type="submit" name="savePassword" value="Submit">
        </form>
    </div>



    <div class="formSection">
         <h2>Subcription</h2>
            <div><?=$subscriptionMessage;?></div>
         <?php 
         if($user->getIsSubcribed()){
             echo "<h3>You are subscribed to Paypal</h3>";
         }
         else{
             echo "<a href='billing.php'>Subcribe to VietFlix</a>";
         }
         
         ?>
    </div>
</div>