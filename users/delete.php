<?php
include "../includes/header.php";
require_once("../libs/connection.php");
?>

<?php
// Quy trình xóa bản ghi sau khi đã xác nhận
if (isset($_POST["id"]) && !empty($_POST["id"])) {

    // Chuẩn bị câu lệnh delete
    $sql = "DELETE FROM users WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Liên kết các biến với câu lệnh đã chuẩn bị
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Thiết lập tham số
        $param_id = trim($_POST["id"]);

        // Cố gắng thực thi câu lệnh đã chuẩn bị
        if (mysqli_stmt_execute($stmt)) {
            // Xóa bản ghi thành công. Chuyển hướng đến trang đích
            header("location: /udweb");
            exit();
        } else {
            echo "Oh, no. Có gì đó sai sai. Vui lòng thử lại.";
        }
    }

    // Đóng câu lệnh
    mysqli_stmt_close($stmt);

    // Đóng kết nối
    mysqli_close($conn);
} else {
    // Kiểm tra sự tồn tại của tham số id
    if (empty(trim($_GET["id"]))) {
        // URL không chứa tham số id. Chuyển hướng đén trang error
        header("location: error.php");
        exit();
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Xóa người dùng</h1>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="alert alert-danger fade in">
                    <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
                    <p>Bạn có chắc chắn muốn xóa người dùng này không?</p><br>
                    <p>
                        <input type="submit" value="Đồng ý" class="btn btn-danger">
                        <a href="/udweb/users" class="btn btn-default">Hủy</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "../includes/footer.php" ?>