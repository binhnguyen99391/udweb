<?php include "../includes/header.php"; ?>

<?php include("../auth_session.php"); ?>

<?php
require_once("../libs/connection.php");
require_once("../checkPermission.php");
if (checkPermission($conn, $_SESSION['role_id'], 1)) {
?>

  <main class="container">
    <a href="create.php" class="btn btn-success pull-right">Thêm vai trò</a>
    <?php
    // Cố gắng thực thi truy vấn
    $sql = "SELECT * FROM roles ORDER BY role_id";
    if ($result = mysqli_query($conn, $sql)) {
      if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Tên vai trò</th>";
        echo "<th>Tên quyền</th>";
        echo "<th>Hành động</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $i=1;
        while ($row = mysqli_fetch_array($result)) {
          echo "<tr>";
          echo "<td>" . $i++ . "</td>";
          echo "<td>" . $row['role_name'] . "</td>";
          $role_id = $row['role_id'];
          $query = "SELECT * FROM `permissions`         
          LEFT JOIN roles_permissions ON roles_permissions.perm_id = permissions.perm_id
          WHERE roles_permissions.role_id = '$role_id'";
          $data = mysqli_fetch_array(mysqli_query($conn, $query));
          $result1 = mysqli_query($conn, $query);
          echo "<td>";
          while ($data = mysqli_fetch_array($result1)){
            echo $data['perm_desc']."<br>";
          };
          echo "</td>";
          echo "<td>";
          echo "<a href='edit.php?id=" . $row['role_id'] . "' class='btn btn-secondary'><span class='glyphicon glyphicon-edit'></span></a>";
          echo "<a href='delete.php?id=" . $row['role_id'] . "' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span></a>";
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