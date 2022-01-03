<?php
    session_start();
	  // require_once("./admin/loadpage.php");
    if (!isset($_SESSION['name'])) {
        header('Location: login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<title>Home Page</title>
</head>

<body>

	<?php
		$data = $_SESSION['user'];
		if($data["MANV"] == "admin") {
			?>
			<!-- Navigation -->
    <nav class="navbar navbar-expand-md bg-dark navbar-dark px-5">
        <!-- Brand -->
        <a class="navbar-brand" href="#">Nhà Thuốc</a>
      
        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Trang Chủ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">Nhân Viên</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">Sản Phẩm</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Nghỉ Phép</a>
            </li>
            
          </ul>

          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">Xin chào <?=$_SESSION['name']?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Đăng Xuất</a>
            </li>
          </ul>
        </div>
    </nav>
			<?php
		}
		
		else { ?>
			<!-- Navigation -->
			<nav class="navbar navbar-expand-md bg-dark navbar-dark px-5">
        <!-- Brand -->
        <a class="navbar-brand" href="#">Nhà Thuốc</a>
      
        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Trang Chủ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Đơn Hàng</a>
            </li>
          </ul>

          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">Xin chào <?=$_SESSION['name']?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Đăng Xuất</a>
            </li>
          </ul>
        </div>
    </nav>
		<?php
		}
		
	?>
    