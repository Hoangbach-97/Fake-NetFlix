<?php 
class User{
    private $conn, $sqlData;
    public function __construct($conn, $username){
$this->conn = $conn;

$query =$conn->prepare( "SELECT * FROM users WHERE username=:username");
$query->bindValue(':username', $username);
$query->execute();

$this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }



    public function getFirstName() {
        return $this->sqlData['firstName'];
    }

    public function getLastName() {
        return $this->sqlData['lastName'];
    }
    public function getEmail() {
        return $this->sqlData['email'];
    }
    public function getIsSubcribed() {
        return $this->sqlData['isSubcribed'];
    }

    public function getUsername() {
        return $this->sqlData['username'];
    }

    public function setIsSubcribed($value) {
        $query = $this->conn->prepare("UPDATE  users  SET isSubcribed =:isSubscribed WHERE username=:username");
        $query->bindValue(':username', $this->getUsername());
        $query->bindValue(':isSubscribed', $value);

        if($query->execute()){
            $this->sqlData["isSubcribed"] = $value;
            return true;
        }
        return false;
    }
}


?>