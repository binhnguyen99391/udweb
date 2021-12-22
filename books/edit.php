<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php");

require_once("../checkPermission.php");
if (checkPermission($conn, $_SESSION['role_id'], 6)) {
    echo $_GET['id'];

    // Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
    if ( isset($_POST["btn_submit"]) ) {
        // Lấy dữ liệu đầu vào
        $id = $_GET["id"];

        $name = trim($_POST["name"]);
        $author = trim($_POST["author"]);
        $quantily = trim($_POST["quantily"]);
        $category = trim($_POST["category"]);

        // Chuẩn bị câu lệnh Update
        $sql = "UPDATE books SET name=?, author=?, category_id=?, quantily=? WHERE id=?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Liên kết các biến với câu lệnh đã chuẩn bị
            mysqli_stmt_bind_param($stmt, "ssiii", $param_name, $param_author, $param_category_id, $param_quantily, $param_id);

            // Thiết lập tham số
            $param_name = $name;
            $param_author = $author;
            $param_quantily = $quantily;
            $param_category_id =$category;
            $param_id = $id;

            // Cố gắng thực thi câu lệnh đã chuẩn bị
            if (mysqli_stmt_execute($stmt)) {
                // Update thành công. Chuyển hướng đến trang đích
                header("location: /udweb/books");
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
            $sql = "SELECT * FROM books WHERE id = ?";
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
                        $name = $row["name"];
                        $author = $row["author"];
                        $quantily = $row["quantily"];
                        $category = $row["category_id"];
                    }
                } else {
                    echo "Oh, no. Có gì đó sai sai. Vui lòng thử lại.";
                }
            }
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
                    <h2>Cập nhật thông tin sách</h2>
                </div>
                <p>Chỉnh sửa giá trị đầu vào và nhấn Xác nhận để cập nhật thông tin.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>Tên sách</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <label>Tác giả</label>
                        <input type="text" name="author" class="form-control" value="<?php echo $author; ?>" required>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="Category">Thể loại *</label>
                        <select name="category" class="form-control w-50"> 
                        <?php 
                        $sql = "SELECT * FROM categories";
                        if ($result = mysqli_query($conn, $sql)){
                            while ($row = mysqli_fetch_array($result)){ 
                                if($row['id'] == $category){ ?>
                                    <option selected value="<?php echo $row['id']; ?>">
                                    <?php echo $row['name']; ?>
                                <?php } else {?>
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
                    <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
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
    header('Location: ../403.php');
}
?>
<?php include "../includes/footer.php" ?>