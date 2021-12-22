<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php"); ?>

<?php
require_once("../checkPermission.php");
if (checkPermission($conn, $_SESSION['role_id'], 5)) {

    // Nếu không phải là sự kiện đăng ký thì không xử lý
    if (isset($_POST['btn_submit'])) {
        $name = stripslashes($_POST['name']);

        $author = stripslashes($_POST['author']);

        $category = stripslashes($_POST['category']);

        $quantily = stripslashes($_POST['quantily']);

        //Kiểm tra tên sách này đã có chưa
        if (mysqli_num_rows(mysqli_query($conn, "SELECT name FROM books WHERE name='$name'"))) {
            echo "<div class='container'>
                <h3>Tên sách đã có. Vui lòng chọn tên khác.</h3><br/>
                <a href='javascript: history.go(-1)'>Trở lại</a>
                </div>";
            exit;
        }

        $query    = "INSERT into books (name, author, category_id, quantily)
                        VALUES ('$name', '$author', '$category', '$quantily')";
        $result   = mysqli_query($conn, $query);

        if ($result) {
            echo "<div class='container'>
                <h3>Tạo sách thành công</h3><br/>
                <p class='link'>Nhấn <a href='/udweb/books'>đây</a> để quay lại</p>
                </div>";
        } else {
            echo "<div class='container'>
                <h3>Có lỗi xảy ra.</h3><br/>
                <p class='link'>Vui lòng <a href='javascript: history.go(-1)'>tạo lại sách</a> lại.</p>
                </div>";
        }
    } else {
?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Thêm sách mới</h2>
                    </div>
                    <p>Nhập các giá trị để tạo mới 1 quyển sách.</p>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="Name">Tên sách*</label>
                            <input type="text" class="form-control" name="name" id="Name" placeholder="Nhập tên sách" required>
                        </div>
                        <div class="form-group">
                            <label for="Author">Tác giả *</label>
                            <input type="text" class="form-control" name="author" id="Author" placeholder="Nhập tên tác giả" required>
                        </div>
                        <div class="form-group">
                            <label for="Category">Thể loại *</label>
                            <select name="category" class="form-control w-50">
                                <?php
                                $sql = "SELECT * FROM categories";
                                if ($result = mysqli_query($conn, $sql)) {
                                    while ($row = mysqli_fetch_array($result)) { ?>
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['name']; ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Quantily">Số lượng *</label>
                            <input type="text" class="form-control" name="quantily" id="Quantily" placeholder="Nhập Email" required>
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