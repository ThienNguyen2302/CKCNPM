<?php
    // require_once("connection.php");
    $host = '127.0.0.1'; // tên mysql server
    $user = 'root';
    $pass = '';
    $db = 'lab08'; // tên databse

    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8");
    if ($conn->connect_error) {
        die('Không thể kết nối database: ' . $conn->connect_error);
    }
    function login($user, $pass, $conn) {
        $sql = "SELECT * FROM nhanvien WHERE MANV = ?";
        // $conn = openDatabase();

        $stm = $conn->prepare($sql);
        $stm->bind_param("s" , $user);
        if(!$stm->execute()) {
            return array('code' => 2, 'message' => "Failed to execute");
        }
        
        $result = $stm -> get_result();
        if($result-> num_rows  == 0) {
            return array('code' => 1, 'message' => "Invalid account or password");
        }

        $data = $result -> fetch_assoc();

        $hashed_pass = $data['PASS'];
        if(!password_verify($pass, $hashed_pass)) {
            return array('code' => 1, 'message' => "Invalid account or password");
        }


        else if ($data['ACTIVATED'] == 0) {
            return array('code' => 3, 'message' => "This account is not activated", 'data' => $data);
        }

        else return array('code' => 0, 'message' => '', 'data' => $data);
        
    }

?>