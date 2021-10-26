<?php 
require_once('includes/header.php');

if(!isset($_GET['id'])){
    ErrorMessage::show("No ID is passed to page");
}
$preview = new Preview($conn, $userLogin);
echo $preview->createCategoryPreviewVideo($_GET['id']);

$preview = new CategoryContainers($conn, $userLogin);
echo $preview->showMoviesCategories();

?>

