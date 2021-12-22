<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php"); ?>
<?php
// When form submitted, check and create user session.
if (isset($_POST['btn_submit'])) {
    $username = stripslashes($_POST['username']);    // removes backslashes
    $username = mysqli_real_escape_string($conn, $username);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($conn, $password);
    // Check user is exist in the database
    $query    = "SELECT * FROM `users` WHERE username='$username'
                     AND password='" . sha1($password) . "'";
    $result = mysqli_query($conn, $query) or die();
    $rows = mysqli_num_rows($result);
    if ($rows == 1) {
        $data = mysqli_fetch_array($result);
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['role_id'] = $data['role_id'];
        $_SESSION['loggedin'] = true;
        // Redirect to user dashboard page
        header("Location: /udweb");
    } else {
        echo "<div class='container'>
                <h3>Kiểm tra lại thông tin</h3><br/>
                <p class='link'>Nhấn <a href='login.php'>đây</a> để quay lại.</p>
              </div>";
    }
} else {
?>
    <div class="m-5 w-25 mx-auto">
        <form action="" method="post">
            <div class="form-group">
                <label for="InputUsername">Tên đăng nhập</label>
                <input type="text" class="form-control" id="InputUsername" name="username" placeholder="Nhập tên đăng nhập" required autocomplete="username">
            </div>
            <div class="form-group">
                <label for="Password">Mật khẩu</label>
                <input type="password" class="form-control" id="Password" name="password" placeholder="Nhập mật khẩu" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary" name="btn_submit">Đăng nhập</button>
        </form>
    </div>
<?php
}
?>
<?php include "../includes/footer.php" ?>