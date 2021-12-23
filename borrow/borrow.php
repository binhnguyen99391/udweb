<?php include "../includes/header.php"; ?>

<?php
require_once("../libs/connection.php");
require_once("../libs/checkPermission.php");
if (checkPermission($conn, $_SESSION['role_id'], 8)) {

    // Lấy tham số URL
    $book_id = htmlspecialchars($_GET['id']);

    // Quy trình xóa bản ghi sau khi đã xác nhận
    if (isset($_POST["btn_submit"])) {
        $user_id = $_SESSION['user_id'];
        
        // Chuẩn bị câu lệnh delete
        $query = "INSERT INTO borrow_book (user_id, book_id) VALUES ('$user_id', '$book_id')";

        $result = mysqli_query($conn, $query);
        if ($result) {
            header("location: /udweb/books");
            exit();
        } else {
            echo "Vui lòng thử lại.";
        }
    } else {
        // Kiểm tra sự tồn tại của tham số id
        if (empty($book_id)) {
            // URL không chứa tham số id. Chuyển hướng đén trang error
            header("location: ../errors/error.php");
            exit();
        }
    }
?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Yêu cầu mượn sách</h2>
                </div>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="alert alert-primary fade in">
                        <p>Bạn có chắc chắn muốn mượn quyển sách <b>
                            <?php
                            $id = $_GET['id'];
                            $sql = "SELECT * FROM books WHERE id = $id";
                            $result1 = mysqli_query($conn, $sql);
                            $data = mysqli_fetch_array($result1);
                            echo $data['name'];
                            ?>
                            </b>không?</p><br>
                        <p>
                            <input type="submit" value="Đồng ý" class="btn btn-primary" name="btn_submit">
                            <a href="../books" class="btn btn-default">Hủy bỏ</a>
                        </p>
                    </div>
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