<?php
    define('HOST', '127.0.0.1');
    define('USER', 'root');
    define('PASS', '');
    define('DB', 'lab08');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require './vendor/autoload.php';


    function openDatabase() {
        $conn = new mysqli(HOST, USER, PASS, DB);
        if($conn -> connect_error ){
            die ('Connect error:' . $conn -> connection_error);
        }
        return $conn;
    }

    function login($user, $pass) {
        $sql = "SELECT * FROM account WHERE username = ?";
        $conn = openDatabase();

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

        $hashed_pass = $data['password'];
        if(!password_verify($pass, $hashed_pass)) {
            return array('code' => 1, 'message' => "Invalid account or password");
        }

        else if ($data['activated'] == 0) {
            return array('code' => 2, 'message' => "This account is not activated");
        }

        else return array('code' => 0, 'message' => '', 'data' => $data);
    }

    function is_email_exist($email) {
        $sql = "SELECT * FROM account WHERE email = ?";
        $conn = openDatabase();

        $stm = $conn->prepare($sql);
        $stm->bind_param("s" , $email);
        if(!$stm->execute()) {
            return false;
        }
        
        $result = $stm -> get_result();
        if($result-> num_rows >0) {
            return true;
        }
        return false;
    }

    //chinh lai
    function change_password($email, $pass) {
        if(!is_email_exist($email)) {
            return array('code' => 2, 'message' => "Email not found");
        }

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "UPDATE account set password = ? where email = ? ";
        $conn = openDatabase();

        $stm = $conn->prepare($sql);
        $stm->bind_param("ss" ,$hash, $email);

        if(!$stm->execute()) {
            return array('code' => 1, 'message' => "Failed to execute");
        }
        return array('code' => 0, 'message' => "Successful");
    }
?>