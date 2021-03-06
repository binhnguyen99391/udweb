<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php"); ?>
<?php
// When form submitted, check and create user session.
if (isset($_POST['btn_submit'])) {
    $username = htmlspecialchars($_POST['username']);    // removes backslashes
    $password = htmlspecialchars($_POST['password']);

    $query    = "SELECT * FROM users WHERE username='$username'
                     AND password='" . sha1($password) . "'";
    $result = mysqli_query($conn, $query) or die();
    $rows = mysqli_num_rows($result);
    if ($rows == 1) {
        $data = mysqli_fetch_array($result);
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['role_id'] = $data['role_id'];
        $_SESSION['loggedin'] = true;
        
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
                <label>Tên đăng nhập</label>
                <input type="text" class="form-control" name="username" 
                placeholder="Nhập tên đăng nhập" required autocomplete="username">
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" class="form-control" name="password" 
                placeholder="Nhập mật khẩu" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-primary" name="btn_submit">Đăng nhập</button>
        </form>
    </div>
<?php
}
?>
<?php include "../includes/footer.php" ?>