<?php 
require_once('includes/header.php');

$preview = new Preview($conn, $userLogin);
echo $preview->createTVShowPreviewVideo();

$preview = new CategoryContainers($conn, $userLogin);
echo $preview->showMoviesCategories();

?>

