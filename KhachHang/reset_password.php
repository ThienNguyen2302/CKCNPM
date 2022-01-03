
<DOCTYPE html>
<html lang="en">
<head>
    <title>Reset user password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php
    require_once("db.php");
    $errorurl = "";
    $error = '';
    $email = '';
    $pass = '';
    $pass_confirm = '';

    $display_email = filter_input(INPUT_GET,'email', FILTER_SANITIZE_EMAIL);

    if(isset($_GET['email']) && isset($_GET['token'])) {
        $email = $_GET['email'];
        $token = $_GET['token']; 
        //echo filter_var($email, FILTER_VALIDATE_EMAIL);

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
          $errorurl = "Invalid email address";
        }

        else if(strlen($token) != 32) {
          $errorurl = "Invalid token format";
        }
        else {
            // check password
            if (isset($_POST['email']) && isset($_POST['pass']) &&
                isset($_POST['pass-confirm'])) {

                $email = $_POST['email'];
                $pass = $_POST['pass'];
                $pass_confirm = $_POST['pass-confirm'];

                if (empty($email)) {
                    $error = 'Please enter your email';
                }
                else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                    $error = 'This is not a valid email address';
                }
                else if (empty($pass)) {
                    $error = 'Please enter your password';
                }
                else if (strlen($pass) < 6) {
                    $error = 'Password must have at least 6 characters';
                }
                else if ($pass != $pass_confirm) {
                    $error = 'Password does not match';
                }
                else {
                    //truyen len database
                    $result = change_password($email,$pass);
                    if($result['code'] != 0) {
                        $error = $result['message'];
                    }
                    else {
                        header('Location: login.php');
                        exit();
                    }
                }
            }
        }
    }
    else{
        $errorurl = "Invalid URL";
    }

    echo $error;
    echo $errorurl;
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">Reset Password</h3>
            <?php
            if(empty($errorurl)) {
                ?>
                <form novalidate method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input readonly value="<?=$display_email?>" name="email" id="email" type="text" class="form-control" placeholder="Email address">
                    </div>
                    <div class="form-group">
                        <label for="pass">Password</label>
                        <input  value="<?= $pass?>" name="pass" required class="form-control" type="password" placeholder="Password" id="pass">
                        <div class="invalid-feedback">Password is not valid.</div>
                    </div>
                    <div class="form-group">
                        <label for="pass2">Confirm Password</label>
                        <input value="<?= $pass_confirm?>" name="pass-confirm" required class="form-control" type="password" placeholder="Confirm Password" id="pass2">
                        <div class="invalid-feedback">Please enter your email</div>
                    </div>
                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                        <button class="btn btn-success px-5">Change password</button>
                    </div>
                </form>
                <?php
            }
            else {
                echo "<div class='alert alert-danger'>$errorurl</div>";
            }
            ?>

        </div>
    </div>
</div>

</body>
</html>
