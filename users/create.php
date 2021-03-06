<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php"); ?>

<?php
require_once("../libs/checkPermission.php");
if (checkPermission($conn, $_SESSION['role_id'], 1)) {
    $name = [
        "administrator",
        "support",
        "root",
        "postmaster",
        "abuse",
        "webmaster",
        "security"
    ];
    // Nếu không phải là sự kiện đăng ký thì không xử lý
    if (isset($_POST['btn_submit'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $email = htmlspecialchars($_POST['email']);
        $role_id = htmlspecialchars($_POST['role']);
        $phone = htmlspecialchars($_POST['phone']);
        $address = htmlspecialchars($_POST['address']);

        // Kiểm tra tên người dùng bị cấm
        if (in_array($username, $name)) {
            echo "<div class='container'>
                Tên đăng nhập này bị cấm, mời chọn tên khác!!!
                <a href='javascript: history.go(-1)'>Trở lại</a>
                </div>";
            exit;
        }

        //Kiểm tra tên đăng nhập này đã có người dùng chưa
        if (mysqli_num_rows(mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'"))) {
            echo "<div class='container'>
                <h3>Tên đăng nhập này đã có người dùng. Vui lòng chọn tên đăng nhập khác.</h3><br/>
                <a href='javascript: history.go(-1)'>Trở lại</a>
                </div>";
            exit;
        }

        //Kiểm tra email đã có người dùng chưa
        if (mysqli_num_rows(mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'"))) {
            echo "<div class='container'>
                <h3>Email này đã có người dùng. Vui lòng chọn Email khác.</h3><br/>
                <a href='javascript: history.go(-1)'>Trở lại</a>
                </div>";
            exit;
        }

        $query    = "INSERT into users (role_id, username, password, email, phone, address)
                        VALUES ('$role_id', '$username', '" . sha1($password) . "', '$email', '$phone', '$address')";
        $result   = mysqli_query($conn, $query);

        if ($result) {
            echo "<div class='container'>
                <h3>Tạo user thành công</h3><br/>
                <p class='link'>Nhấn <a href='/udweb/users'>đây</a> để quay lại</p>
                </div>";
        } else {
            echo "<div class='container'>
                <h3>Có lỗi xảy ra.</h3><br/>
                <p class='link'>Vui lòng <a href='users/create.php'>tạo người dùng</a> lại.</p>
                </div>";
        }
    } else {
?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Thêm người dùng</h2>
                    </div>
                    <p>Nhập các giá trị để tạo mới người dùng.</p>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Tên đăng nhập *</label>
                            <input type="text" class="form-control" name="username" placeholder="Nhập tên đăng nhập" pattern="^[A-Za-z][A-Za-z0-9-]{2,25}$" required>
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu *</label>
                            <input type="password" class="form-control" name="password" id="Password" placeholder="Nhập mật khẩu" placeholder="Tối thiểu 8 ký tự bao gồm chữ hoa, thường, số và ký tự" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label>Xác nhận mật khẩu *</label>
                            <input type="password" class="form-control" id="ConfirmPassword" placeholder="Nhập lại mật khẩu" required>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" class="form-control" name="email" placeholder="Nhập Email" required>
                        </div>
                        <label>Vai trò</label><br>
                        <select name="role" class="form-control w-25">
                            <option value="1">Quản trị viên</option>
                            <option value="2">Thủ thư</option>
                            <option value="3">Người dùng</option>
                        </select><br>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="tel" class="form-control" name="phone" placeholder="Nhập số điện thoại" 
                            pattern="^(09|03|07|08|05)+([0-9]{8})$">
                        </div>
                        <div class="form-group">
                            <label for="Address">Địa chỉ</label>
                            <input type="text" class="form-control" name="address" placeholder="Nhập địa chỉ">
                        </div>

                        <button type="submit" class="btn btn-primary" name="btn_submit">Xác nhận</button>
                        <a href="/udweb/users" class="btn btn-default">Hủy bỏ</a>
                    </form>
                </div>
            </div>
        </div>
        <script>
            var password = document.getElementById("Password"),
                confirm_password = document.getElementById("ConfirmPassword");

            function validatePassword() {
                if (password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("Mật khẩu không trùng");
                } else {
                    confirm_password.setCustomValidity('');
                }
            }
            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;
        </script>
<?php
    }
} else {
    header('Location: ../errors/403.php');
}
?>
<?php include "../includes/footer.php" ?>