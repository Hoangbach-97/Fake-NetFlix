<?php 
require_once('includes/header.php');
if(!isset($_GET['id'])){
    ErrorMessage::show("NO MOVIES");
}

$user  =new User($conn, $userLogin);
if(!$user->getIsSubcribed()){
    ErrorMessage::show("You must to be subscribed");
}

$video = new Video($conn, $_GET['id']);
$video->incrementViews();

$upNextVideo = VideoProvider::getUpNext($conn, $video);

?>

<div class="watchContainer">
    <div class="videoControls watchNav">
        <button onclick='goBack()'>Back</button>
        <h1><?=$video->getTitle();?></h1>
    </div>
    <div class="videoControls upNext " style="display: none">
        <button onclick="restartVideo();"><i class="fas fa-redo"></i></button>
        <div class="upNextContainer">
            <h2>Up next:</h2>
            <h3><?=$upNextVideo->getTitle();?></h3>
            <h3><?=$upNextVideo->getSeasonAndEpisode();?></h3>
            <button class="playNext" onclick="watchVideo(<?=$upNextVideo->getId()?>);">
            <i class="fas fa-play"></i>Play
            </button>

        </div>
    </div>
    <video controls autoplay onended="showUpNext();">
    <source src='<?php echo $video->getFilePath();?>' type='video/mp4'>
    </video>
</div>

<script type='text/javascript'>initVideo("<?=$video->getId()?>", "<?=$userLogin;?>");</script>