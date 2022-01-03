<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Danh sách sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    
            <!-- Navigation -->
    <nav class="navbar navbar-expand-md bg-dark navbar-dark px-5">
        <!-- Brand -->
        <a class="navbar-brand" href="index.php">Nhà thuốc</a>
      
        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <!-- Navbar links -->
        <?php
        if (isset($_SESSION['user'])) {
            $name = $_SESSION['name'];
            ?>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                <a class="nav-link" href="index.php">Đơn hàng</a>
                </li>
            </ul>
        </div>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link" href="profile.php"> Xin chào <?= $name?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="logout.php">Đăng Xuất</a>
                </li>
            </ul>
        </div>
        
    </nav>
            <?php
        }
        else {
            ?>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link" href="login.php"> Đăng Nhập</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="register.php">Đăng Ký</a>
                </li>
            </ul>
        </div>
        </nav>
            <?php
        }
    ?>

