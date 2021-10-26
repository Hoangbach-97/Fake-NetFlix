<?php 

require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["username"])){
$query = $conn->prepare("UPDATE videoprogress SET finished=1, progress=0, dateModified=NOW()  WHERE username=:username AND videoId=:videoId ");
$query->bindParam(":username", $_POST["username"]);
$query->bindParam("videoId", $_POST["videoId"]);
$query->execute();


}
else{
    echo "No video or username  passed into file";
}

?>