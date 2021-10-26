<?php 
require_once('Constants.php');
class Account{
    private $conn;
    private $errorArray = array();
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function updateDetails($firstName, $lastName, $email,$username){
        $this->validateFirstName($firstName);
        $this->validatelastName($lastName);
        $this->validateNewEmail($email, $username);

        if(empty($this->errorArray)){
            // TODO
            
            $query = $this->conn->prepare("UPDATE users SET firstName=:firstName, lastName=:lastName, email=:email WHERE username=:username");
            $query->bindValue(':firstName',$firstName);
            $query->bindValue(':lastName',$lastName);
            $query->bindValue(':email',$email);
            $query->bindValue(':username',$username);
            $query->execute();
        }
            return false;
    }

    public function register($firstName, $lastName,$username, $email, $confirmEmail, $password, $confirmPassword){
        $this->validateFirstName($firstName);
        $this->validatelastName($lastName);
        $this->validateUsername($username);
        $this->validateEmail($email, $confirmEmail);
        $this->validatePassword($password, $confirmPassword);
        if(empty($this->errorArray)){
            return $this->insertUserDetail($firstName, $lastName,$username,$email, $password);
        }
        return false;
    }

    public function login($username,$password){
        $password = hash('sha256', $password);
        $query =$this->conn->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
        $query->bindParam(':username', $username);
        $query->bindParam(':password', $password);
        $query->execute();

        if($query->rowCount()===1){
            return true;
        }
        array_push($this->errorArray,Constants::$loginFailed);
        return false;
    }

    private function insertUserDetail($firstName, $lastName,$username,$email, $password){
        $password = hash('sha256', $password);
        $query =$this->conn->prepare("INSERT INTO users(firstName, lastName, username, email, password) VALUES (:firstName, :lastName, :username, :email, :password)");
        $query->bindParam(':firstName', $firstName);
        $query->bindParam(':lastName', $lastName);
        $query->bindParam(':username', $username);
        $query->bindParam(':email', $email);
        $query->bindParam(':password', $password);

        return $query->execute();
    }
    private function validateFirstName($firstName){
        if(strlen($firstName)<2||strlen($firstName)>25){
            array_push($this->errorArray,Constants::$firstNameCharacters);
        }
    }
    private function validateLastName($lastName){
        if(strlen($lastName)<2||strlen($lastName)>25){
            array_push($this->errorArray,Constants::$lastNameCharacters);
        }
    }  
    private function validateUsername($username){
        if(strlen($username)<2||strlen($username)>25){
            array_push($this->errorArray,Constants::$usernameCharacters);
            return;
        }
        $query = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindParam(':username', $username);
        
        $query->execute();
        if($query->rowCount()!==0){
            array_push($this->errorArray,Constants::$checkUserExists);
        }
      
    }
    private function validateEmail($email, $confirmEmail){
      if($email !== $confirmEmail){
        array_push($this->errorArray,Constants::$emailNotMatch);
        return;

      }
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($this->errorArray,Constants::$invalidEmail);
        return;
    }
    $query = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $query->bindParam(':email', $email);
        
        $query->execute();
        if($query->rowCount()!==0){
            array_push($this->errorArray,Constants::$checkEmailExists);
        }

    } 

    private function validateNewEmail($email, $username){
      
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
          array_push($this->errorArray,Constants::$invalidEmail);
          return;
      }
      $query = $this->conn->prepare("SELECT * FROM users WHERE email = :email AND username !=:username");
          $query->bindParam(':email', $email);
          $query->bindParam(':username', $username);
          
          $query->execute();
          if($query->rowCount()!==0){
              array_push($this->errorArray,Constants::$checkEmailExists);
          }
  
      } 

    private function validatePassword($password, $confirmPassword){
        if($password !== $confirmPassword){
          array_push($this->errorArray,Constants::$passwordNotMatch);
          return;
        }
        if(strlen($password)<2||strlen($password)>25){
            array_push($this->errorArray,Constants::$invalidPassword);
        }
    }

    public function getError($error){
        if(in_array($error,$this->errorArray)){
            return "<span class='errorMessage'>$error</span>";
        }
    }


    public function getFirstError(){
        if(!empty($this->errorArray)){
            return $this->errorArray[0];
        }
    }

public function updatePassword($oldPassword,$newPassword, $confirmPassword, $username){
$this->validateOldPassword($oldPassword,$username);
$this->validatePassword($newPassword,$confirmPassword);
if(empty($this->errorArray)){
    // TODO
    
    $query = $this->conn->prepare("UPDATE users SET password=:password WHERE username=:username");
    $password = hash('sha256', $password);
    $query->bindParam(':username', $username);
    $query->bindParam(':password', $password);
    $query->execute();
}
    return false;
}

public function validateOldPassword($oldPassword,$newPassword){
    $password = hash('sha256', $oldPassword);
    $query =$this->conn->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
    $query->bindParam(':username', $username);
    $query->bindParam(':password', $password);
    $query->execute();

if($query->rowCount()===0){
array_push($this->errorArray,Constants::$passwordIncorrect);
}

}

}


?>