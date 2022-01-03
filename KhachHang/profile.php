<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }

    require_once('db.php');
    $user = $_SESSION['user'];
    $error = '';
    $first_name = $user['firstname'];
    $last_name = $user['lastname'];
    $email = $user['email'];
    $sdt = $user['SDT'];
    $address = $user['address'];

    if (isset($_POST['first']) && isset($_POST['last'])
    && isset($_POST['sdt']) && isset($_POST['add']))
    {
        $first_name = $_POST['first'];
        $last_name = $_POST['last'];
        $address = $_POST['add'];
        $sdt = $_POST['sdt'];

        if (empty($first_name)) {
            $error = 'Please enter your first name';
        }
        else if (empty($last_name)) {
            $error = 'Please enter your last name';
        }
        else {
            // change profile a new account
            $result = change_profile($first_name,$last_name, $address,$sdt,$email);
            if(!$result['code'] == 0) {
                $error = $result['message'];
            }

            else {
                // cập nhật user
                $update = get_user($email);
                if(!$update['code'] == 0) {
                    $error = $update['message'];
                }
                $data = $update["data"];
                $_SESSION["user"] = $data;
                $_SESSION['name'] = $data ['firstname'] . ' ' . $data ['lastname'];
                header('Location: index.php');
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register an account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        .bg {
            background: #eceb7b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Your Profile</h3>
                <form method="post" action="" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">First name</label>
                            <input value="<?= $first_name?>" name="first" required class="form-control" type="text" placeholder="First name" id="firstname">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Last name</label>
                            <input value="<?= $last_name?>" name="last" required class="form-control" type="text" placeholder="Last name" id="lastname">
                            <div class="invalid-tooltip">Last name is required</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input value="<?= $email?>" name="email" required class="form-control" type="email" placeholder="Email" id="email">
                    </div>

                    <div class="form-group">
                        <label for="sdt">SDT</label>
                        <input value="<?= $sdt?>" name="sdt" required class="form-control" type="text" placeholder="SDT" id="sdt">
                        <div class="invalid-feedback">Please enter your username</div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input value="<?= $address?>" name="add" required class="form-control" type="text" placeholder="Username" id="address">
                        <div class="invalid-feedback">Please enter your username</div>
                    </div>

                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                        <button type="submit" class="btn btn-success px-5 mt-3 mr-2">Change</button>
                        <button type="reset" class="btn btn-outline-success px-5 mt-3">Reset</button>
                    </div>
                    <div class="form-group">
                        <p>Về lại trang chủ <a href="index.php">Home</a></p>
                    </div>
                </form>

            </div>
        </div>

    </div>
</body>
</html>