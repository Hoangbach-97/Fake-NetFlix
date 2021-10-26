<?php 
class EntityProvider{
    public static function getEntities($conn, $categoryId, $limit){
        $sql = "SELECT * FROM entities ";
        if ($categoryId != null) {
            # code...
            $sql .= "WHERE categoryId=:categoryId ";
        }
        $sql .= " ORDER BY RAND() LIMIT :limit";

            $query =$conn->prepare($sql);

            if($categoryId != null){
                $query->bindParam(':categoryId',$categoryId);
            }
            $query->bindParam(':limit',$limit, PDO::PARAM_INT);
            $query->execute();

            $result = array();

            while ($row =$query->fetch(PDO::FETCH_ASSOC)){
                $result[] = new Entity($conn, $row);
            }

            return $result;


    }



    public static function getTVShowEntities($conn, $categoryId, $limit){
        $sql = "SELECT DISTINCT(entities.id) FROM `entities`
                INNER JOIN videos ON entities.id = videos.entityId
                WHERE videos.isMovie =0";
        if ($categoryId != null) {
            # code...
            $sql .= " AND  categoryId=:categoryId ";
        }
        $sql .= " ORDER BY RAND() LIMIT :limit";

            $query =$conn->prepare($sql);

            if($categoryId != null){
                $query->bindParam(':categoryId',$categoryId);
            }
            $query->bindParam(':limit',$limit, PDO::PARAM_INT);
            $query->execute();

            $result = array();

            while ($row =$query->fetch(PDO::FETCH_ASSOC)){
                $result[] = new Entity($conn, $row['id']);
            }

            return $result;


    }

    public static function getMoviesEntities($conn, $categoryId, $limit){
        $sql = "SELECT DISTINCT(entities.id) FROM `entities`
                INNER JOIN videos ON entities.id = videos.entityId
                WHERE videos.isMovie =1";
        if ($categoryId != null) {
            # code...
            $sql .= " AND  categoryId=:categoryId ";
        }
        $sql .= " ORDER BY RAND() LIMIT :limit";

            $query =$conn->prepare($sql);

            if($categoryId != null){
                $query->bindParam(':categoryId',$categoryId);
            }
            $query->bindParam(':limit',$limit, PDO::PARAM_INT);
            $query->execute();

            $result = array();

            while ($row =$query->fetch(PDO::FETCH_ASSOC)){
                $result[] = new Entity($conn, $row['id']);
            }

            return $result;


    }




    public static function getSearchEntities($conn, $term){
        $sql = "SELECT * FROM entities WHERE `name` LIKE CONCAT('%',:term,'%') LIMIT 30";
            $query =$conn->prepare($sql);
            $query->bindParam(':term',$term);
            $query->execute();

            $result = array();

            while ($row =$query->fetch(PDO::FETCH_ASSOC)){
                $result[] = new Entity($conn, $row);
            }

            return $result;


    }
}


?>