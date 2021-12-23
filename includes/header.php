<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>XDUDWEB</title>

  <!-- Bootstrap core CSS -->
  <link href="http://localhost:5/udweb/asset/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <!-- Custom styles for this template -->
  <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
  <link href="http://localhost:5/udweb/asset/css/style.css" rel="stylesheet">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js' async defer></script>
</head>

<body>
  <div class="container">
    <header class="blog-header">
      <div class=" flex-nowrap justify-content-between align-items-center pt-1">
        <div class="text-center">
          <a class="blog-header-logo text-dark" href="/udweb">Xây Dựng Ứng Dụng Web</a>
          <img src="../asset/NTB.png" alt="Nguyễn Trường Bình" hidden>
        </div>
      </div>
    </header>
    <div class="nav-scroller py-1 mb-2">
      <nav class="nav d-flex justify-content-between pt-2">
        <?php
        session_start();
        // Khai báo utf-8 để hiển thị được tiếng việt
        header('Content-Type: text/html; charset=UTF-8');

        if (isset($_SESSION["loggedin"]) == false) { ?>
          <a class="p-2 link-primary" href="registration.php">Đăng ký</a>
          <a class="p-2 link-primary" href="login.php">Đăng nhập</a>
          <a class="p-2 link-primary" href="forgotPass.php">Quên mật khẩu</a>
        <?php
        } else { ?>
          <a class="p-2 link-primary" href="http://localhost:5/udweb/users">Quản lý người dùng</a>
          <a class="p-2 link-primary" href="http://localhost:5/udweb/books">Quản lý sách</a>
          <a class="p-2 link-primary" href="http://localhost:5/udweb/categories">Quản lý thể loại</a>
          <a class="p-2 link-primary" href="http://localhost:5/udweb/borrow">Quản lý phiếu mượn</a>
          <a class="p-2 link-primary" href="http://localhost:5/udweb/auth/changePass.php">Đổi mật khẩu</a>
          <a class="p-2 link-primary" href="http://localhost:5/udweb/auth/logout.php">Đăng xuất</a>
        <?php } ?>
      </nav>
    </div>
  </div>