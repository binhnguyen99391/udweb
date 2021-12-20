<?php include "includes/header.php";?>

<?php include("auth_session.php");?>

<?php require_once("libs/connection.php"); 
echo "role_id" .$_SESSION['role_id'];
echo "user_id" .$_SESSION['user_id'];
?>

<main class="container">
  <img src="/udweb/asset/welcome.gif" alt="welcome" class="rounded mx-auto d-block">
  <?php echo "<h1 class='text-center text-uppercase'>" . $_SESSION['username'] . "</h1>";?>
</main>

<?php include "includes/footer.php" ?>
