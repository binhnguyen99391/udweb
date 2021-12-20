<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php");

// Xác định các biến và khởi tạo với các giá trị trống
$username = $email = $phone = $address = "";
$username_err = $email_err = $phone_err = $address_err = "";

// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Lấy dữ liệu đầu vào
    $id = $_POST["id"];

    // Xác thực tên
    $input_username = trim($_POST["username"]);
    if (empty($input_username)) {
        $username_err = "Please enter a name.";
    } elseif (!filter_var($input_username, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $username_err = "Please enter a valid name.";
    } else {
        $username = $input_username;
    }

    // Xác thực địa chỉ email
    $input_email = trim($_POST["email"]);
    if (empty($input_email)) {
        $email_err = "Please enter an email.";
    } else {
        $email = $input_email;
    }

    // Xác thực địa chỉ
    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Please enter an address.";
    } else {
        $address = $input_address;
    }

    // Xác thực số đt
    $input_phone = trim($_POST["phone"]);
    if (empty($input_phone)) {
        $phone_err = "Please enter the phone number.";
    } else {
        $phone = $input_phone;
    }

    $role_id = trim($_POST['role']); 

    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if (empty($username_err) && empty($email_err) && empty($address_err) && empty($phone_err)) {
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
                if ($id == $_SESSION['user_id']){
                    $_SESSION['role_id'] = $role_id;
                }
                // Update thành công. Chuyển hướng đến trang đích
                header("location: /udweb/users");
                exit();
            } else {
                echo "Oh, no. Có gì đó sai sai. Vui lòng thử lại.";
            }
        }

        // Đóng câu lệnh
        mysqli_stmt_close($stmt);
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
                } else {
                    // URL không có id hợp lệ. Chuyển hướng đến trang error
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oh, no. Có gì đó sai sai. Vui lòng thử lại.";
            }
        }

        // Đóng câu lệnh
        // mysqli_stmt_close($stmt);

        // Đóng kết nối
        mysqli_close($conn);
    } else {
        // URL không chứa tham số id. Chuyển hướng đến trang error
        header("location: error.php");
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
            <p>Chỉnh sửa giá trị đầu vào và nhấn Gửi để cập nhật thông tin.</p>
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                    <span class="help-block"><?php echo $phone_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                    <label>Địa chỉ</label>
                    <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                    <span class="help-block"><?php echo $address_err; ?></span>
                </div>
                <label>Vai trò</label><br/>
                    <select name="role">
                        <option <?php if ($role == 1) echo "selected=\"selected\"";  ?> value="1">Quản trị viên</option>
                        <option <?php if ($role == 2) echo "selected=\"selected\"";  ?> value="2">Thủ thư</option>
                        <option <?php if ($role == 3) echo "selected=\"selected\"";  ?> value="3">Người dùng</option>
                    </select><br/><br/>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="submit" class="btn btn-primary" value="Gửi">
                <a href="index.php" class="btn btn-default">Hủy</a>
            </form>
        </div>
    </div>
</div>

<?php include "../includes/footer.php" ?>