<?php
    $host = '127.0.0.1'; // tên mysql server
    $user = 'root';
    $pass = '';
    $db = 'lab08'; // tên databse

    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8");

    $sql = "INSERT into product (name, price, description, image) values (?,?,?,?)";
    $stm = $conn->prepare($sql);

    $stm = $conn->prepare($sql);
    $stm->bind_param("ssss" , $name, $price, $desc, $img);
    if(!$stm->execute()) {
        return array('code' => 2, 'message' => "Failed to execute");
    }
    
    

?>

        if(is_account_exist($user))
        return array('code' => 1, 'message' => "Account is already exist");

        if(is_email_exist($email))
        return array('code' => 1, 'message' => "Email is already exist");

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $rand = random_int(0,1000);
        $token = md5($user. '+'. $rand);

        $sql = "INSERT into account (username, firstname, lastname, 
        email, password, activate_token) values(?,?,?,?,?,?)";
        $conn = openDatabase();

        $stm = $conn->prepare($sql);
        $stm->bind_param("ssssss" , $user, $fist, $last, $email, $hash, $token);
        if(!$stm->execute()) {
            return array('code' => 2, 'message' => "Failed to execute");
        }

        sendActivation($email,$token);
        return array('code' => 0, 'message' => "Successful");