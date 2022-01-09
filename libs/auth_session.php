<?php
    if(!isset($_SESSION["username"])) {
        header("Location: http://localhost/udweb/auth/login.php");
        exit();
    }
