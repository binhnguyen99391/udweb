<?php
    if(!isset($_SESSION["username"])) {
        header("Location: http://localhost:5/udweb/auth/login.php");
        exit();
    }
