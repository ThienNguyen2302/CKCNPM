<?php
    require_once('db.php');

    function get_product() {
        $sql = "SELECT * FROM product";
        $conn = openDatabase();

        $stm = $conn->prepare($sql);

        if(!$stm->execute()) {
            return array('status' => false, 'data' => "Cant get data");
        }
        
        $result = $stm -> get_result();
        $data = array();
        while ($row = $result -> fetch_assoc()) {
            $data [] = $row;
        }
        return array('status' => true, 'data' => $data) ;
    }
?>