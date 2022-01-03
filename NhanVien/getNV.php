<?php
    session_start();
    $host = '127.0.0.1'; // tên mysql server
    $user = 'root';
    $pass = '';
    $db = 'lab08'; // tên databse

    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8");

    $user = $_SESSION["user"];
    $manv = $user["MANV"];

    if ($conn->connect_error) {
        die('Không thể kết nối database: ');
    }

    $sql = "SELECT * FROM nhanvien WHERE MANV != ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("s",$manv);

    if(!$stm->execute()) {
        print_r( array('code' => 1, 'message' => "Failed to execute"));
    }
    
    $result = $stm->get_result();

    $data = array();
    while ($row = $result -> fetch_assoc()) {
        $data [] = $row;
    }

    
    print_r( array('code' => 0, 'message' => $data));


?>