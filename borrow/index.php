<?php include "../includes/header.php"; ?>

<?php include("../libs/auth_session.php"); ?>

<?php
require_once("../libs/connection.php");
require_once("../libs/checkPermission.php");
if (checkPermission($conn, $_SESSION['role_id'], 8)) {
?>

  <main class="container">
    <?php
    // Cố gắng thực thi truy vấn
    if ($_SESSION['role_id'] == 2) {
      $sql = "SELECT * FROM borrow_book";
    } else {
      $user_id = $_SESSION['user_id'];
      $sql = "SELECT * FROM borrow_book WHERE user_id = '$user_id'";
    }
    if ($result = mysqli_query($conn, $sql)) {
      if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Tên người mượn</th>";
        echo "<th>Tên sách</th>";
        echo "<th>Trạng thái</th>";
        echo "<th>Hành động</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $i=1;
        while ($row = mysqli_fetch_array($result)) {
          echo "<tr>";
          echo "<td>" . $i++ . "</td>";
          //trả về tên người dùng
          $user_id = $row['user_id'];
          $sql_user = "SELECT * FROM users WHERE id = '$user_id'";
          $result_user = mysqli_query($conn, $sql_user);
          if ($data_user = mysqli_fetch_array($result_user)){
            echo "<td>". $data_user['username'] ."</td>";
          };
          //trả về tên sách
          $book_id = $row['book_id'];
          $sql_book = "SELECT * FROM books WHERE id = '$book_id'";
          $result_book = mysqli_query($conn, $sql_book);
          if ($data_book = mysqli_fetch_array($result_book)){
            echo "<td>". $data_book['name'] ."</td>";
          };
          $status = $row['status'];
          if ($status == 0) {
            echo "<td> Chưa duyệt </td>";
          } else {
            echo "<td> Đã duyệt </td>";
          }
          echo "<td>";
          if ($status != 0 && $user_id == $_SESSION['user_id']){
            echo "<a href='return.php?id=" . $row['id'] . "' class='btn btn-primary'><span class='glyphicon glyphicon-repeat'></span></a>";
          } elseif ($status == 0 && $_SESSION['role_id'] == 2) {
            echo "<a href='yes.php?id=" . $row['id'] . "' class='btn btn-success'><span class='glyphicon glyphicon-ok'></span></a>";
            echo "<a href='no.php?id=" . $row['id'] . "' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span></a>";
          }
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
  header('Location: ../errors/403.php');
}
?>
<?php include "../includes/footer.php" ?>