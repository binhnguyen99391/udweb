<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.88.1">
  <title>XDUDWEB</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/blog/">



  <!-- Bootstrap core CSS -->
  <link href="http://localhost:5/udweb/asset/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="http://localhost:5/udweb/asset/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container">
    <header class="blog-header py-3">
      <div class="row flex-nowrap justify-content-between align-items-center">
        <div class="col-4 pt-1">
          <a class="link-secondary" href="#">Nguyễn Trường Bình</a>
        </div>
        <div class="col-4 text-center">
          <a class="blog-header-logo text-dark" href="/udweb">Xây Dựng Ứng Dụng Web</a>
        </div>
        <div class="col-4 d-flex justify-content-end align-items-center">
          <a class="link-secondary" href="#">AT140803</a>
        </div>
      </div>
    </header>
    <div class="nav-scroller py-1 mb-2">
      <nav class="nav d-flex justify-content-between">
        <?php
        session_start();

        if (isset($_SESSION["loggedin"]) == false) { ?>
          <a class="p-2 link-primary" href="registration.php">Registration</a>
          <a class="p-2 link-primary" href="login.php">Login</a>
          <a class="p-2 link-primary" href="forgotPass.php">Forgot Password</a>
        <?php
        } else { ?>
          <a class="p-2 link-primary" href="users">User</a>
          <a class="p-2 link-primary" href="changePass.php">Change Password</a>
          <a class="p-2 link-primary" href="logout.php">Logout</a>
        <?php } ?>
      </nav>
    </div>
  </div>