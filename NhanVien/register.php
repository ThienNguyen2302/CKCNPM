<?php
    session_start();
    require_once("change_pass_API.php");
    
    $user = $_SESSION["user"];
    $manv = $user["MANV"];
    $pass = '';
    $pass_confirm = '';
    $error ="";

    if (isset($_POST['password']) && isset($_POST['password_confirm']))
    {
        $pass = $_POST['password'];
        $pass_confirm = $_POST['password_confirm'];

        if (empty($pass)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pass) < 6) {
            $error = 'Password must have at least 6 characters';
        }
        else if ($pass != $pass_confirm) {
            $error = 'Password does not match';
        }
        
        else {
            $result = activate_account($pass, $conn, $manv);
            if ($result['code'] != 0) {
                $error = $result['message'];
            }
            else {
                $_SESSION["name"] = $user["TENNV"];
                header('Location: index.php');
                exit();
            }
    
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">Change Password</h3>
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input name="password" id="password" type="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="password_confirm">Confirm Password</label>
                    <input name="password_confirm" id="password_confirm" type="password" class="form-control" placeholder="Confirm Password">
                </div>
                <div class="form-group">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button class="btn btn-success px-5">Change</button>
                    <a class="btn btn-success px-5" href = "logout.php">Log out</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>