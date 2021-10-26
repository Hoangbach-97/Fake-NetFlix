<?php 

require_once("../includes/config.php");
require_once("../includes/classes/SearchResultProvider.php");
require_once("../includes/classes/EntityProviders.php");
require_once("../includes/classes/Entity.php");
require_once("../includes/classes/PreviewProvider.php");

if(isset($_POST["term"]) && isset($_POST["username"])){
// $query = $conn->prepare("SELECT progress FROM videoprogress  WHERE username=:username AND videoId=:videoId ");
// $query->bindParam(":username", $_POST["username"]);
// $query->bindParam("videoId", $_POST["videoId"]);
// $query->execute();

// echo $query->fetchColumn();
$srp = new SearchResultProvider($conn, $_POST["username"]);
echo $srp->getResult($_POST["term"]);

}
else{
    echo "No term or username  passed into file";
}

?>