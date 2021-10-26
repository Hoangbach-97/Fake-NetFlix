<?php 
class Preview{
    private $conn, $username;
    public function __construct($conn, $username){
    $this->conn = $conn;
    $this->username = $username;
    }

    public function createCategoryPreviewVideo($categoryId){
        $entitiesArray = EntityProvider::getTVShowEntities($this->conn, $categoryId,1);
        if(sizeof($entitiesArray)==0){
             ErrorMessage::show("No TV shows display");
        }
        return $this->createPreviewVideo($entitiesArray[0]);
    }


    public function createTVShowPreviewVideo(){
        $entitiesArray = EntityProvider::getTVShowEntities($this->conn, null,1);
        if(sizeof($entitiesArray)==0){
             ErrorMessage::show("No TV shows display");
        }
        return $this->createPreviewVideo($entitiesArray[0]);
    }

    public function createMoviesPreviewVideo(){
        $entitiesArray = EntityProvider::getMoviesEntities($this->conn, null,1);
        if(sizeof($entitiesArray)==0){
             ErrorMessage::show("No TV movies display");
        }
        return $this->createPreviewVideo($entitiesArray[0]);
    }


    public function createPreviewVideo($entity){
        if($entity==null){
            $entity= $this->getRandomEntity();
        }

        $id = $entity->getId();
        $name = $entity->getName();
        $preview = $entity->getPreview();
        $thumbnail = $entity->getThumbnail();

        // TODO: ADD SUBTITLE
        $videoId = VideoProvider::getEntityVideoForUser($this->conn, $id, $this->username);
        $video = new Video($this->conn, $videoId);
        $inProgress = $video->isInProgress($this->username);
        $playButtonText = $inProgress ? "Continue" : "Play";

        $seasonEpisode = $video->getSeasonAndEpisode();
        $subHeading = $video->isMovie() ? "":"<h4>$seasonEpisode</h4>";

        return "<div class='previewContainer'>
            <img src='$thumbnail' class='previewImage' hidden>
            <video  autoplay muted class='previewVideo' onended='toggleEnded()'>
            <source src='$preview' type='video/mp4'> 
            </video>
            <div class='previewOverlay'>
           <div class='mainDetail'>
            <h3>$name</h3>
            $subHeading
            <div class='buttons'>
            <button onclick='watchVideo($videoId);'><i class='fas fa-play'></i> $playButtonText</button>
            <button onclick='volumeToggle(this)'> <i class='fas fa-volume-mute'></i></button>
            </div>
           </div>
            </div>
         </div>";

    }

public function createEntityPreviewSquare($entity){

    $id = $entity->getId();
    $thumbnail = $entity->getThumbnail();
    $name = $entity->getName();
    return "<a href='entity.php?id=$id'>
            <div class='previewContainer small'>
            <img src='$thumbnail' title='$name'>
            </div>
    
    
            </a>";

}


    private function getRandomEntity(){
        // $query = $this->conn->prepare("SELECT * FROM entities ORDER BY RAND() LIMIT 1");
        // $query->execute();

        // $row = $query->fetch(PDO::FETCH_ASSOC);
        // return new Entity($this->conn, $row);

        $entity = EntityProvider::getEntities($this->conn, null, 1);
        return $entity[0];
    }
    
}


?>