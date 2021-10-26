<?php 
require_once('includes/header.php');

if(!isset($_GET['id'])){
    ErrorMessage::show("NO MOVIES");
}
$entityId = $_GET['id'];
$entity = new Entity($conn, $entityId);

$preview = new Preview($conn, $userLogin);
echo $preview->createPreviewVideo($entity);

$seasonProvider = new SeasonProvider($conn, $userLogin);
echo $seasonProvider->create($entity);

$categoryContainers = new CategoryContainers($conn, $userLogin);
echo $categoryContainers->showCategory($entity->getCategoryId(), "You might also like");


?>

