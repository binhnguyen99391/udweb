<?php include "includes/header.php" ?>
<?php
include("auth_session.php");
require_once("libs/connection.php");
?>

<?php

if (isset($_POST['btn_submit'])) {
    $username = $_SESSION['username'];
    $password = mysqli_fetch_array(mysqli_query($conn, "SELECT password FROM users WHERE username = '$username'"));

    $oldpass = sha1($_POST["oldPassword"]);
    $newpass = sha1($_POST["newPassword"]);

    if ($oldpass == $password[0]) {

        $query    = "UPDATE users SET password = '$newpass' WHERE username= '$username'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<div class='container'>
              <h3>Đổi mật khẩu thành công.</h3><br/>
              </div>";
        } else {
            echo "<div class='container'>
              <h3>Có lỗi xảy ra. Vui lòng thử lại</h3><br/>
              </div>";
        }
    } else {
        echo "<div class='container'>
              <h3>Mật khẩu không khớp.</h3><br/>
              </div>";
    }
} else {

?>

    <div class="container">
        <form action="" method="post">
            <div class="form-group">
                <label>Old Password</label>
                <input type="password" class="form-control" name="oldPassword" placeholder="Enter Password" required autocomplete="new-password">
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Enter Password" 
                pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" required autocomplete="new-password">
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" class="form-control" id="ConfirmPassword" placeholder="Confirm Password" required>
            </div>

            <button type="submit" class="btn btn-primary" name="btn_submit">Submit</button>
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