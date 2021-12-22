<?php include "../includes/header.php"; ?>

<?php
require_once("../libs/connection.php");
require_once("../checkPermission.php");
if (checkPermission($conn, $_SESSION['role_id'], 7)) {

    // Quy trình xóa bản ghi sau khi đã xác nhận
    if (isset($_POST["btn_submit"])) {
        $id = trim($_GET['id']);
        
        // Chuẩn bị câu lệnh delete
        $query = "DELETE FROM books WHERE id = $id";

        $result   = mysqli_query($conn, $query);
        if ($result) {
            header("location: /udweb/books");
            exit();
        } else {
            echo "Oh, no. Có gì đó sai sai. Vui lòng thử lại.";
        }
    } else {
        // Kiểm tra sự tồn tại của tham số id
        if (empty(trim($_GET["id"]))) {
            // URL không chứa tham số id. Chuyển hướng đén trang error
            header("location: ../error.php");
            exit();
        }
    }
?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Xóa sách</h2>
                </div>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="alert alert-danger fade in">
                        <p>Bạn có chắc chắn muốn xóa sách này không?</p><br>
                        <p>
                            <input type="submit" value="Đồng ý" class="btn btn-danger" name="btn_submit">
                            <a href="index.php" class="btn btn-default">Hủy bỏ</a>
                        </p>
                    </div>
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