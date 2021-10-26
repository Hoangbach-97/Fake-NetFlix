<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Ho_Chi_Minh");

try{
    $conn = new PDO("mysql:dbname=vietflix; host=localhost", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

}
catch(PDOException $e) {
   exit("Error ".$e->getMessage()); 
}

?>