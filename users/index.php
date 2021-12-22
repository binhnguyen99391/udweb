<?php include "../includes/header.php"; ?>

<?php include("../auth_session.php"); ?>

<?php
require_once("../libs/connection.php");
require_once("../checkPermission.php");
if (checkPermission($conn, $_SESSION['role_id'], 4)) {
?>

  <main class="container">
    <a href="create.php" class="btn btn-success pull-right">Thêm người dùng</a>
    <?php
    // Cố gắng thực thi truy vấn
    $sql = "SELECT * FROM users";
    if ($result = mysqli_query($conn, $sql)) {
      if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Tên đăng nhập</th>";
        echo "<th>Email</th>";
        echo "<th>Vai trò</th>";
        echo "<th>Số điện thoại</th>";
        echo "<th>Địa chỉ</th>";
        echo "<th>Hành động</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_array($result)) {
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['username'] . "</td>";
          echo "<td>" . $row['email'] . "</td>";
          if ($row['role_id'] == 1) {
            echo "<td> Quản trị viên </td>";
          } elseif ($row['role_id'] == 2) {
            echo "<td> Thủ thư </td>";
          } else {
            echo "<td> Người dùng </td>";
          }
          echo "<td>" . $row['phone'] . "</td>";
          echo "<td>" . $row['address'] . "</td>";
          echo "<td>";
          echo "<a href='edit.php?id=" . $row['id'] . "' class='btn btn-secondary'><span class='glyphicon glyphicon-edit'></span></a>";
          echo "<a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span></a>";
          echo "</td>";
          echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        // Giải phóng bộ nhớ
        mysqli_free_result($result);
      } else {
        echo "<p class='lead'><em>Không tìm thấy bản ghi.</em></p>";
      }
    } else {
      echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
    }
    ?>

  </main>
<?php
} else {
  header('Location: ../403.php');
}
?>
<?php include "../includes/footer.php" ?>