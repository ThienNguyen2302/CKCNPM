<?php
    #  https://www.w3schools.com/php/php_mysql_select.asp

    $host = '127.0.0.1'; // tên mysql server
    $user = 'root';
    $pass = '';
    $db = 'lab08'; // tên databse

    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8");
    if ($conn->connect_error) {
        die('Không thể kết nối database: ' . $conn->connect_error);
    }

    function isNV($manv, $conn) {
        $sql = "SELECT * FROM nhanvien WHERE MANV = ?";

        $stm = $conn->prepare($sql);
        $stm->bind_param("s" , $manv);
        if(!$stm->execute()) {
            return false;
        }
        
        $result = $stm -> get_result();
        if($result-> num_rows >0) {
            return true;
        }
        return false;
    }

    function activate_account($pass, $conn, $manv){
        $sql = "update nhanvien set ACTIVATED = 1, PASS = ?  where MANV = ?";
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        if(!isNV($manv, $conn)) {
            die ("Bạn không phải là nhân viên của công ti");
        }

        $stm = $conn->prepare($sql);
        $stm->bind_param("ss",$hash,$manv);


        if(!$stm->execute()) {
            return array('code' => 1, 'message' => "Failed to execute");
        }

        return array('code' => 0, 'message' => "Successful");
    }

?>