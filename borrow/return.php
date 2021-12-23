<?php include "../includes/header.php"; ?>

<?php
require_once("../libs/connection.php");
require_once("../libs/checkPermission.php");
if (checkPermission($conn, $_SESSION['role_id'], 8)) {

    // Lấy tham số URL
    $id = htmlspecialchars($_GET['id']);
    
    // Quy trình xóa bản ghi sau khi đã xác nhận
    if (isset($_POST["btn_submit"])) {
        $bookid = htmlspecialchars($_POST['bookid']);
        
        // Chuẩn bị câu lệnh delete
        $query = "DELETE FROM borrow_book WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $sql = "UPDATE books SET quantily = quantily+1 WHERE id = '$bookid'";
            if(mysqli_query($conn, $sql)){
                header("location: /udweb/borrow");
                exit();
            } else {
                echo "lỗi cmnr"; 
            }
        } else {
            echo "Vui lòng thử lại.";
        }
    } else {
        if (isset($id)) {
            // Chuẩn bị câu lệnh select
            $sql = "SELECT * FROM borrow_book WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                //trả về tên sách
                $book_id = $row['book_id'];
                $sql_book = "SELECT * FROM books WHERE id = '$book_id'";
                $result_book = mysqli_query($conn, $sql_book);
                if ($data_book = mysqli_fetch_array($result_book)){
                    $bookname = $data_book['name'];
                    $bookid = $data_book['id'];
                };
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
                    <h2>Trả sách</h2>
                </div>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="alert alert-primary fade in">
                        <p>Bạn có chắc chắn muốn trả quyền sách này không?</p><br>
                        <p>
                            <label>Tên sách</label>
                            <input type="text" class="form-control w-25" name="bookname" value="<?php echo $bookname; ?>" disabled>
                            <br>
                            <input type="text" class="form-control w-25" name="bookid" value="<?php echo $bookid; ?>" hidden>
                            <input type="submit" value="Đồng ý" class="btn btn-primary" name="btn_submit">
                            <a href="index.php" class="btn btn-default">Hủy bỏ</a>
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