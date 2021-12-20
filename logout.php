<?php
    session_start();
    if (session_destroy()) {
      unset($_SESSION["username"]);
      unset($_SESSION["user_id"]);
      unset($_SESSION["role_id"]);
      $_SESSION['loggedin'] = false;
      header("Location: auth/login.php");
    }
