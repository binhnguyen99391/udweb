<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php");

require_once("../checkPermission.php");
if (checkPermission($conn, $_SESSION['role_id'], 2)) {
    echo $_GET['id'];

    // Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
    if (isset($_POST["btn_submit"])) {
        // Lấy dữ liệu đầu vào
        $id = $_GET["id"];
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $address = trim($_POST["address"]);
        $phone = trim($_POST["phone"]);
        $role_id = trim($_POST['role']);

        // Chuẩn bị câu lệnh Update
        $sql = "UPDATE users SET username=?, email=?, address=?, phone=?, role_id=? WHERE id=?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Liên kết các biến với câu lệnh đã chuẩn bị
            mysqli_stmt_bind_param($stmt, "ssssii", $param_username, $param_email, $param_address, $param_phone, $param_role, $param_id);

            // Thiết lập tham số
            $param_username = $username;
            $param_email = $email;
            $param_address = $address;
            $param_phone = $phone;
            $param_role = $role_id;
            $param_id = $id;

            // Cố gắng thực thi câu lệnh đã chuẩn bị
            if (mysqli_stmt_execute($stmt)) {
                //nếu là người dùng hiện tại thì thay đổi luôn Session
                if ($id == $_SESSION['user_id']) {
                    $_SESSION['role_id'] = $role_id;
                }
                // Update thành công. Chuyển hướng đến trang đích
                header("location: /udweb/users");
                exit();
            } else {
                echo "Oh, no. Có gì đó sai sai. Vui lòng thử lại.";
            }
        }
        // Đóng két nối
        mysqli_close($conn);
    } else {
        // Kiểm tra sự tồn tại của tham số id trước khi xử lý thêm
        if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            // Lấy tham số URL
            $id =  trim($_GET["id"]);

            // Chuẩn bị câu lệnh select
            $sql = "SELECT * FROM users WHERE id = ?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Liên kết các biến với câu lệnh đã chuẩn bị
                mysqli_stmt_bind_param($stmt, "i", $param_id);

                // Thiết lập tham số
                $param_id = $id;

                // Cố gắng thực thi câu lệnh đã chuẩn bị
                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($result) == 1) {
                        /* Lấy hàng kết quả dưới dạng một mảng kết hợp. Vì tập kết quả chỉ chứa một hàng, chúng ta không cần sử dụng vòng lặp while */
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                        // Lấy giá trị trường riêng lẻ
                        $username = $row["username"];
                        $email = $row["email"];
                        $address = $row["address"];
                        $phone = $row["phone"];
                        $role = $row['role_id'];
                    }
                } else {
                    echo "Oh, no. Có gì đó sai sai. Vui lòng thử lại.";
                }
            }
            // Đóng kết nối
            mysqli_close($conn);
        } else {
            // URL không chứa tham số id.
            exit();
        }
    }
?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Cập nhật thông tin</h2>
                </div>
                <p>Chỉnh sửa giá trị đầu vào và nhấn Xác nhận để cập nhật thông tin.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                        <label>Tên đăng nhập</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" 
                        pattern="^[A-Za-z][A-Za-z0-9-]{2,25}$" required>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>"
                        pattern="^(09|03|07|08|05)+([0-9]{8})$">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                        <span class="help-block"></span>
                    </div>
                    <label>Vai trò</label><br>
                    <select name="role" class="form-control w-25">
                        <option <?php if ($role == 1) echo "selected=\"selected\"";  ?> value="1">Quản trị viên</option>
                        <option <?php if ($role == 2) echo "selected=\"selected\"";  ?> value="2">Thủ thư</option>
                        <option <?php if ($role == 3) echo "selected=\"selected\"";  ?> value="3">Người dùng</option>
                    </select><br>
                    <input type="submit" name="btn_submit" class="btn btn-primary" value="Xác nhận">
                    <a href="index.php" class="btn btn-default">Hủy bỏ</a>
                </form>
            </div>
        </div>
    </div>
<?php
} else {
    header('Location: ../403.php');
}
?>
<?php include "../includes/footer.php" ?>