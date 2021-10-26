<?php 
require_once('includes/header.php');

$preview = new Preview($conn, $userLogin);
echo $preview->createPreviewVideo(null);

$preview = new CategoryContainers($conn, $userLogin);
echo $preview->showAllCategories();

?>

