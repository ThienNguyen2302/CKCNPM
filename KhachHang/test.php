<?php
    session_start();
    require_once("db.php");
    $result = get_user("nguyenngocthien749@gmail.com");
    print_r($result);
?>