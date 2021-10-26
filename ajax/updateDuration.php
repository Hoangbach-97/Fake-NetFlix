<?php 

require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["username"]) && isset($_POST["progress"])){
$query = $conn->prepare("UPDATE videoprogress SET progress=:progress, dateModified=NOW()  WHERE username=:username AND videoId=:videoId ");
$query->bindParam(":username", $_POST["username"]);
$query->bindParam("videoId", $_POST["videoId"]);
$query->bindParam("progress", $_POST["progress"]);
$query->execute();


}
else{
    echo "No video or username  passed into file";
}

?>