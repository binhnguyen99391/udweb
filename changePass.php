<?php include "includes/header.php" ?>
<?php 
include("auth_session.php");
require_once("libs/connection.php"); 
?>

<?php

if (isset($_POST['oldPassword'])) {
    $username = $_SESSION['username'];
    $password = mysqli_fetch_array(mysqli_query($conn, "SELECT `password` FROM `users` WHERE username='$username'"));

    $oldpass = sha1($_POST["oldPassword"]);
    $newpass = sha1($_POST["newPassword"]);

    if ($oldpass == $password[0]) {

        $query    = "UPDATE `users` set `password` = '$newpass' WHERE username= '$username'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<div class='container'>
              <h3>Password changed sucessfully.</h3><br/>
              </div>";
        }
    } else {
        echo "<div class='container'>
              <h3>Password is not correct.</h3><br/>
              </div>";
    }
} else {

?>

    <div class="container">

        <form action="" method="post">
            <div class="form-group">
                <label for="Password">Old Password</label>
                <input type="password" class="form-control" name="oldPassword" id="oldPassword" placeholder="Enter Password" required autocomplete="new-password">
            </div>
            <div class="form-group">
                <label for="Password">New Password</label>
                <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Enter Password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" required autocomplete="new-password">
            </div>
            <div class="form-group">
                <label for="ConfirmPassword">Confirm New Password</label>
                <input type="password" class="form-control" id="ConfirmPassword" placeholder="Confirm Password" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script>
        var new_password = document.getElementById("newPassword"),
            confirm_password = document.getElementById("ConfirmPassword");

        function validatePassword() {
            if (new_password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
                confirm_password.setCustomValidity('');
            }
        }
        new_password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>
<?php
}
?>
<?php include "includes/footer.php" ?>