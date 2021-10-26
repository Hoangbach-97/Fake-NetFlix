<?php 
class CategoryContainers{
    private $conn, $username;
    public function __construct($conn, $username){
    $this->conn = $conn;
    $this->username = $username;
    }


    public function showAllCategories(){
        $query = $this->conn->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>";
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $html .=$this->getCategoryHtml($row, null, true, false);
        }
        return $html ."</div>";
    }


    public function showTVShowCategories(){
        $query = $this->conn->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>
                    <h1>TV Shows</h1>";
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $html .=$this->getCategoryHtml($row, null, true, true);
        }
        return $html ."</div>";
    }

    public function showMoviesCategories(){
        $query = $this->conn->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>
                    <h1>Movies</h1>";
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $html .=$this->getCategoryHtml($row, null, false, true);
        }
        return $html ."</div>";
    }


    public function showCategory($categoryId, $title=null){
        $query = $this->conn->prepare("SELECT * FROM categories WHERE id=:id");
        $query->bindParam(':id', $categoryId);
        $query->execute();

        $html = "<div class='previewCategories noScroll'>";
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $html .=$this->getCategoryHtml($row, $title, true, true);
        }
        return $html ."</div>";
    }

    private function getCategoryHtml($sqlData, $title, $tvShows, $movies){
        $categoryId = $sqlData['id'];
        $title = $title == null ? $sqlData['name']:$title;

        if($tvShows && $movies){
            $entities = EntityProvider::getEntities($this->conn, $categoryId, 30);
        }
        elseif($tvShows){
            // TODO: Get tv show entities
            $entities = EntityProvider::getTVShowEntities($this->conn, $categoryId, 30);

        }
        else{
            // TODO: Get movies entities
            $entities = EntityProvider::getMoviesEntities($this->conn, $categoryId, 30);

            
        }

        if(sizeof($entities)==0){
            return;
        }
        $entityHtml = "";
        $previewProvider = new Preview($this->conn, $this->username);
        foreach($entities as $entity){
            $entityHtml .= $previewProvider->createEntityPreviewSquare($entity);
        }

        return "<div class='category'>
                    <a href='category.php?id=$categoryId'>
                    <h3>$title</h3>
                    </a>
                    <div class='entities'>
                    $entityHtml
                    </div>
                </div>";
    }

}
    ?>