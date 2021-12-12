<?php
    session_start();
    if (session_destroy()) {
      unset($_SESSION["username"]);
      $_SESSION['loggedin'] = false;
      header("Location: auth/login.php");
    }
