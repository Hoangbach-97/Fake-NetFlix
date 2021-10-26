<?php 

require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["username"])){
$query = $conn->prepare("SELECT progress FROM videoprogress  WHERE username=:username AND videoId=:videoId ");
$query->bindParam(":username", $_POST["username"]);
$query->bindParam("videoId", $_POST["videoId"]);
$query->execute();

echo $query->fetchColumn();

}
else{
    echo "No video or username  passed into file";
}

?>