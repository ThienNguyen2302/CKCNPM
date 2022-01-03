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

    function is_account_exist($user) {
        $sql = "SELECT * FROM account WHERE username = ?";
        $conn = openDatabase();

        $stm = $conn->prepare($sql);
        $stm->bind_param("s" , $user);
        
        if(!$stm->execute()) {
            return null;
        }
        
        $result = $stm -> get_result();
        if($result-> num_rows >0) {
            return true;
        }
        return false;
    }

    function register($user, $pass, $fist, $last,$email, $address, $sdt) {
        if(is_account_exist($user))
        return array('code' => 1, 'message' => "Account is already exist");

        if(is_email_exist($email))
        return array('code' => 1, 'message' => "Email is already exist");

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $rand = random_int(0,1000);
        $token = md5($user. '+'. $rand);

        $sql = "INSERT into account (username, firstname, lastname, address,
        email, SDT, password, activate_token) values(?,?,?,?,?,?,?,?)";
        $conn = openDatabase();

        $stm = $conn->prepare($sql);
        $stm->bind_param("ssssssss" , $user, $fist, $last, $email, $address, $sdt, $hash, $token);
        
        if(!$stm->execute()) {
            return array('code' => 2, 'message' => "Failed to execute");
        }

        sendActivation($email,$token);
        return array('code' => 0, 'message' => "Successful");
    }

    function sendActivation ($email, $token) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->CharSet       = 'UTF-8';   
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'tieuthien951@gmail.com';                     //SMTP username
            $mail->Password   = 'orsmeuzlwbkeilhg';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('tieuthien951@gmail.com', 'Admin');
            $mail->addAddress($email, 'Thiện');     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Xác Minh tài khoản';
            $mail->Body    = "Click <a href='http://localhost/lab08/activate.php?email=$email&token=$token'>vào đây</a> để xác minh tài khoản";
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function activateAccount($email, $token) {
        $sql = "SELECT username from  account where email = ? and activate_token = ? and activated = 0";
        $conn = openDatabase();

        $stm = $conn->prepare($sql);
        $stm->bind_param("ss" ,  $email, $token);
        if(!$stm->execute()) {
            return array('code' => 1, 'message' => "Failed to execute");
        }

        $result = $stm -> get_result();
        if($result-> num_rows ==0) {
            return array('code' => 2, 'message' => "Email or token not found");
        }

        $sql = "UPDATE account set activated = 1, activate_token = '' where email = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('s' ,  $email);

        if(!$stm->execute()) {
            return array('code' => 1, 'message' => "Failed to execute");
        }
        return array('code' => 0, 'message' => "Acount Activated");
    }

    function reset_password ($email) {
        if(!is_email_exist($email)) {
            return array('code' => 2, 'message' => "Email not found");
        }
        $token = md5($email."".random_int(100,1000));
        $exp = time() + 3600*24;

        $sql = "UPDATE reset_token set token = ?, expire_on = ? where email = ?";
        $conn = openDatabase();

        $stm = $conn->prepare($sql);
        $stm->bind_param("sis" ,  $token,$exp, $email);

        if(!$stm->execute()) {
            return array('code' => 1, 'message' => "Failed to execute");
        }

        if($stm-> affected_rows ==0) {
            $sql = "INSERT into reset_token values(?,?,?)";
            $stm = $conn->prepare($sql);
            $stm->bind_param("ssi" ,  $email,$token,$exp );

            if(!$stm->execute()) {
                return array('code' => 1, 'message' => "Failed to execute");
            }
        }

        $success = send_reset_password($email, $token);
        return array('code' => 1, 'message' => $success);

    }

    function send_reset_password ($email, $token) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->CharSet       = 'UTF-8';   
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'tieuthien951@gmail.com';                     //SMTP username
            $mail->Password   = 'orsmeuzlwbkeilhg';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('tieuthien951@gmail.com', 'Admin');
            $mail->addAddress($email, 'Thiện');     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Khôi phục tài khoản của bạn';
            $mail->Body    = "Click <a href='http://localhost/lab08/reset_password.php?email=$email&token=$token'>vào đây</a> để khôi phục tài khoản của bạn";
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

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

    function change_profile($first_name,$last_name, $add,$sdt, $email) {
        $sql = "UPDATE account set firstname = ?, lastname = ?, address = ?,SDT = ? where email = ?";
        $conn = openDatabase();

        $stm = $conn->prepare($sql);
        $stm->bind_param("sssss" ,  $first_name,$last_name, $add,$sdt, $email);

        if(!$stm->execute()) {
            return array('code' => 1, 'message' => "Failed to execute");
        }

        return array('code' => 0, 'message' => "success");
    }

    function get_user($email) {
        $sql = "SELECT * FROM account WHERE email = ?";
        $conn = openDatabase();

        $stm = $conn->prepare($sql);
        $stm->bind_param("s" , $email);
        if(!$stm->execute()) {
            return array('code' => 2, 'message' => "Failed to execute");
        }
        
        $result = $stm -> get_result();
        if($result-> num_rows  == 0) {
            return array('code' => 1, 'message' => "Invalid account or password");
        }

        $data = $result -> fetch_assoc();
        return array('code' => 0, 'message' => '', 'data' => $data);
    }
?>