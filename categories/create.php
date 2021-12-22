<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php"); ?>

<?php
require_once("../checkPermission.php");
if (checkPermission($conn, $_SESSION['role_id'], 5)) {

    // Nếu không phải là sự kiện đăng ký thì không xử lý
    if (isset($_POST['btn_submit'])) {
        $name = trim($_POST['name']);

        //Kiểm tra tên sách này đã có chưa
        if (mysqli_num_rows(mysqli_query($conn, "SELECT name FROM categories WHERE name='$name'"))) {
            echo "<div class='container'>
                <h3>Tên thể loại đã có. Vui lòng chọn tên khác.</h3><br/>
                <a href='javascript: history.go(-1)'>Trở lại</a>
                </div>";
            exit;
        }

        $query    = "INSERT into categories (name) VALUES ('$name')";
        $result   = mysqli_query($conn, $query);

        if ($result) {
            echo "<div class='container'>
                <h3>Tạo thể loại thành công</h3><br/>
                <p class='link'>Nhấn <a href='/udweb/categories'>đây</a> để quay lại</p>
                </div>";
        } else {
            echo "<div class='container'>
                <h3>Có lỗi xảy ra.</h3><br/>
                <p class='link'>Vui lòng <a href='javascript: history.go(-1)'>tạo lại thể loại</a></p>
                </div>";
        }
    } else {
?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Thêm thể loại mới</h2>
                    </div>
                    <p>Nhập các giá trị để tạo mới 1 thể loại sách.</p>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="Name">Tên thể loại*</label>
                            <input type="text" class="form-control" name="name" id="Name" placeholder="Nhập tên sách" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="btn_submit">Xác nhận</button>
                        <a href="index.php" class="btn btn-default">Hủy bỏ</a>
                    </form>
                </div>
            </div>
        </div>
<?php
    }
} else {
    header('Location: ../403.php');
}
?>
<?php include "../includes/footer.php" ?>