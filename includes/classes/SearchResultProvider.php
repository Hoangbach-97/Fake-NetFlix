<?php 

class SearchResultProvider{
    private $conn, $username;

    public function __construct($conn, $username){
        $this->conn = $conn;
        $this->username = $username;
    }

    public function getResult($inputText){
        $entities = EntityProvider::getSearchEntities($this->conn,$inputText);
        $html = "<div class='previewCategories noScroll'>";
        $html .= $this->getResultHtml($entities);
        return $html."</div>";
    }


    private function getResultHtml($entities){
        if(sizeof($entities)==0){
            return;
        }
        $entityHtml = "";
        $previewProvider = new Preview($this->conn, $this->username);
        foreach($entities as $entity){
            $entityHtml .= $previewProvider->createEntityPreviewSquare($entity);
        }

        return "<div class='category'>
                    <div class='entities'>
                    $entityHtml
                    </div>
                </div>";
    }
}

?>