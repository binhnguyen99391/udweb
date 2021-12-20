<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php"); ?>

<?php

// Nếu không phải là sự kiện đăng ký thì không xử lý
if (isset($_POST['txtUsername'])) {

    // Khai báo utf-8 để hiển thị được tiếng việt
    
    header('Content-Type: text/html; charset=UTF-8');

    //Lấy dữ liệu từ file dangky.php
    $name = [
        "administrator", 
        "support", 
        "root", 
        "postmaster",
        "abuse", 
        "webmaster",
        "security"
    ];

    $username = stripslashes($_REQUEST['txtUsername']);
    $username = mysqli_real_escape_string($conn, $username);
    $password = stripslashes($_REQUEST['txtPassword']);
    $password = mysqli_real_escape_string($conn, $password);
    $email = stripslashes($_REQUEST['txtEmail']);
    $email = mysqli_real_escape_string($conn, $email);

    $phone   = addslashes($_POST['txtPhone']);
    $address   = stripslashes($_POST['txtAddress']);

    //
    if (in_array($username, $name)){
        echo "<div class='container'>
            Tên đăng nhập này bị cấm, mời chọn tên khác!!!
            </div>";
        exit;
    }

    //Kiểm tra tên đăng nhập này đã có người dùng chưa
    if (mysqli_num_rows(mysqli_query($conn, "SELECT username FROM users WHERE username='$username'"))) {
        echo "Tên đăng nhập này đã có người dùng. Vui lòng chọn tên đăng nhập khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

    //Kiểm tra email đã có người dùng chưa
    if (mysqli_num_rows(mysqli_query($conn, "SELECT email FROM users WHERE email='$email'"))) {
        echo "Email này đã có người dùng. Vui lòng chọn Email khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

    $query    = "INSERT into users (username, password, email, phone, address)
                     VALUES ('$username', '" . sha1($password) . "', '$email', '$phone', '$address')";
    $result   = mysqli_query($conn, $query);

    if ($result) {
        echo "<div class='container'>
              <h3>Bạn đã đăng ký thành công</h3><br/>
              <p class='link'>Nhấn đây để <a href='login.php'>Đăng nhập</a></p>
              </div>";
    } else {
        echo "<div class='container'>
                <h3>Có lỗi gì đó xảy ra</h3><br/>
                <p class='link'>Nhấn đây để <a href='registration.php'>Đăng ký</a> lại.</p>
                </div>";
    }
} else {
?>

    <div class="row m-5 w-25 mx-auto">
        <form action="" method="post">
            <div class="form-group">
                <label for="InputUsername">Tên đăng nhập *</label>
                <input type="text" class="form-control" name="txtUsername" id="InputUsername" placeholder="Nhập tên đăng nhập" 
                pattern="^[A-Za-z][A-Za-z0-9-]{2,25}$" required>
            </div>
            <div class="form-group">
                <label for="Password">Mật khẩu *</label>
                <input type="password" class="form-control" name="txtPassword" id="Password" placeholder="Tối thiểu 8 ký tự bao gồm chữ hoa, thường, số và ký tự" 
                pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" required autocomplete="new-password">
            </div>
            <div class="form-group">
                <label for="ConfirmPassword">Xác nhận mật khẩu *</label>
                <input type="password" class="form-control" id="ConfirmPassword" placeholder="Nhập lại mật khẩu" required>
            </div>
            <div class="form-group">
                <label for="Email">Email *</label>
                <input type="email" class="form-control" name="txtEmail" id="Email" placeholder="Nhập email" required>
            </div>
            <div class="form-group">
                <label for="PhoneNumber">Số điện thoại</label>
                <input type="tel" class="form-control" name="txtPhone" id="PhoneNumber" placeholder="Nhập số điện thoại" pattern="^(09|03|07|08|05)+([0-9]{8})$">
            </div>
            <div class="form-group">
                <label for="Address">Địa chỉ</label>
                <input type="text" class="form-control" name="txtAddress" id="Address" placeholder="Nhập địa chỉ">
            </div>

            <button type="submit" class="btn btn-primary">Đăng ký</button>
        </form>
    </div>

    <script>
        var password = document.getElementById("Password"),
            confirm_password = document.getElementById("ConfirmPassword");

        function validatePassword() {
            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
                confirm_password.setCustomValidity('');
            }
        }
        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>
<?php
}
?>
<?php include "../includes/footer.php" ?>