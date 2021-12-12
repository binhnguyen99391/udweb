<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php"); ?>
<?php

// When form submitted, check and create user session.
if (isset($_POST['username'])) {
    $username = stripslashes($_REQUEST['username']);    // removes backslashes
    $username = mysqli_real_escape_string($conn, $username);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn, $password);
    // Check user is exist in the database
    $query    = "SELECT * FROM `users` WHERE username='$username'
                     AND password='" . md5($password) . "'";
    $result = mysqli_query($conn, $query) or die();
    $rows = mysqli_num_rows($result);
    if ($rows == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
        // Redirect to user dashboard page
        header("Location: /udweb");
    } else {
        echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
    }
} else {
?>

    <div class="container">
        <form action="" method="post">
            <div class="form-group">
                <label for="InputUsername">Username</label>
                <input type="text" class="form-control" id="InputUsername" name="username" placeholder="Enter Username" required>
            </div>
            <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" class="form-control" id="Password" name="password" placeholder="Enter Password" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<?php
}
?>
<?php include "../includes/footer.php" ?>