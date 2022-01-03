<?php
    $host = '127.0.0.1'; // tên mysql server
    $user = 'root';
    $pass = '';
    $db = 'lab08'; // tên databse

    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8");

    if (!isset($_GET['id']) ) {
        die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
    }
    
    $id = $_GET['id'];
    
    $sql = 'DELETE FROM product where id = ?';
    
    echo "id: " . $id;
    
    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($id));
    
        $count = $stmt->rowCount();
    
        if ($count == 1) {
            echo json_encode(array('status' => true, 'data' => 'Xóa sản phẩm thành công'));
        }else {
            die(json_encode(array('status' => false, 'data' => 'Mã sản phẩm không hợp lệ')));
        }
    
    
    }
    catch(PDOException $ex){
        die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
    }
?>