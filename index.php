<?php include "includes/header.php"; ?>
<?php
include("auth_session.php");
require_once("libs/connection.php");
?>

<main class="container">
  <img src="/udweb/asset/welcome.gif" alt="welcome" class="rounded mx-auto d-block">
  <?php echo "<h1 class='text-center text-uppercase'>" . $_SESSION['username'] . "</h1>"; ?>
</main>

<?php include "includes/footer.php" ?>