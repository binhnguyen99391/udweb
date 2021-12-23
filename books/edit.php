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
        $author = trim($_POST["author"]);
        $quantily = trim($_POST["quantily"]);
        $category = trim($_POST["category"]);

        // Chuẩn bị câu lệnh Update
        $sql = "UPDATE books SET name='$name', author='$author', 
                category_id='$category', quantily='$quantily' WHERE id='$id'";

        // Cố gắng thực thi câu lệnh đã chuẩn bị
        if (mysqli_query($conn, $sql)) {
            // Update thành công. Chuyển hướng đến trang đích
            header("location: /udweb/books");
            exit();
        } else {
            echo "Vui lòng thử lại.";
        }
    } else {
        // Kiểm tra sự tồn tại của tham số id trước khi xử lý thêm
        if (isset($id)) {
            // Chuẩn bị câu lệnh select
            $sql = "SELECT * FROM books WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 1) {
                /* Lấy hàng kết quả dưới dạng một mảng kết hợp. Vì tập kết quả chỉ chứa một hàng, chúng ta không cần sử dụng vòng lặp while */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Lấy giá trị trường riêng lẻ
                $name = $row["name"];
                $author = $row["author"];
                $quantily = $row["quantily"];
                $category = $row["category_id"];
                // }
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
                    <h2>Cập nhật thông tin sách</h2>
                </div>
                <p>Chỉnh sửa giá trị đầu vào và nhấn Xác nhận để cập nhật thông tin.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                        <label>Tên sách</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label>Tác giả</label>
                        <input type="text" name="author" class="form-control" value="<?php echo $author; ?>" required>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="Category">Thể loại *</label>
                        <select name="category" class="form-control w-50">
                            <?php
                            $sql = "SELECT * FROM categories";
                            if ($result = mysqli_query($conn, $sql)) {
                                while ($row = mysqli_fetch_array($result)) {
                                    if ($row['id'] == $category) { ?>
                                        <option selected value="<?php echo $row['id']; ?>">
                                            <?php echo $row['name']; ?>
                                        <?php } else { ?>
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['name']; ?>
                                        <?php } ?>
                                        </option>
                                <?php
                                }
                            }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="text" name="quantily" class="form-control" value="<?php echo $quantily; ?>">
                        <span class="help-block"></span>
                    </div>
                    <input type="submit" name="btn_submit" class="btn btn-primary" value="Xác nhận">
                    <a href="index.php" class="btn btn-default">Hủy</a>
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