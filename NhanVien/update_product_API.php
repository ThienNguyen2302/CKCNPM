<?php
    $host = '127.0.0.1'; // tên mysql server
    $user = 'root';
    $pass = '';
    $db = 'lab08'; // tên databse

    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8");
    
    $sql = "UPDATE product set name = ?, price = ?, description = ?, image = ? where id = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("sissi" , $name, $price, $desc, $img, $id);

    if(!$stm->execute()) {
        return array('code' => 2, 'message' => "Failed to execute");
    }
    
    return array('code' => 0, 'message' => "Product has been update");
?>