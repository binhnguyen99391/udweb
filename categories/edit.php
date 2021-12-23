<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php");

require_once("../libs/checkPermission.php");
if (checkPermission($conn, $_SESSION['role_id'], 6)) {

    // Lấy tham số URL
    $id = trim($_GET["id"]);
    
    // Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
    if (isset($_POST["btn_submit"])) {
        // Lấy dữ liệu đầu vào
        $name = trim($_POST["name"]);

        // Chuẩn bị câu lệnh Update
        $sql = "UPDATE categories SET name='$name' WHERE id='$id'";

        // Cố gắng thực thi câu lệnh đã chuẩn bị
        if (mysqli_query($conn, $sql)) {
            // Update thành công. Chuyển hướng đến trang đích
            header("location: /udweb/categories");
            exit();
        } else {
            echo "Vui lòng thử lại.";
        }
    } else {
        // Kiểm tra sự tồn tại của tham số id trước khi xử lý thêm
        if (isset($id)) {
            // Chuẩn bị câu lệnh select
            $sql = "SELECT * FROM categories WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Lấy giá trị trường riêng lẻ
                $name = $row["name"];
            } else {
                echo "Vui lòng thử lại.";
            }
        } else {
            // URL không chứa tham số id.
            header("location: ../errors/error.php");
            exit();
        }
    }
?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Cập nhật thông tin thể loại sách</h2>
                </div>
                <p>Chỉnh sửa giá trị đầu vào và nhấn Xác nhận để cập nhật thông tin.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                        <label>Tên thể loại</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
                        <span class="help-block"></span>
                    </div>
                    <input type="submit" name="btn_submit" class="btn btn-primary" value="Xác nhận">
                    <a href="index.php" class="btn btn-default">Hủy bỏ</a>
                </form>
            </div>
        </div>
    </div>
<?php
} else {
    header('Location: ../errors/403.php');
}
?>
<?php include "../includes/footer.php" ?>