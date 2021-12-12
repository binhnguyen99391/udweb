<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php"); ?>

<?php
if (isset($_POST['inputEmail'])) {
    $inputEmail = $_POST["inputEmail"];
    $email = mysqli_fetch_array(mysqli_query($conn, "SELECT `email` FROM `users` WHERE email='$inputEmail'"));


    if ($inputEmail == $email[0]) {
        $new_pass = bin2hex(random_bytes(8));

        $to_email = "$inputEmail";
        $subject = "New Password";
        $body = "Hello, Your new password in XDUDWEB: $new_pass";
        $headers = "From: binhnguyen9939@gmail.com" . "\r\n"; 
        if (mail($to_email, $subject, $body, $headers)) {

            $query    = "UPDATE `users` set `password` = '".md5($new_pass)."' WHERE email= '$inputEmail'";
            $result = mysqli_query($conn, $query);
            if($result){
                echo "<div class='container'>
                Email successfully sent to $to_email...</div>";
            } else {
                echo "<div class='container'>
                Something error. Please try again</div>";
            }
            
        } else {
            echo "<div class='container'>
            Email sending failed...</div>";
        }

    } else {
        echo "<div class='container'>
              <h3>Invalid Email</h3><br/>
              </div>";
    }
    
} else {
?>
    <div class="container">

        <form action="" method="post">
            <div class="form-group">
                <label for="InputUsername">Email *</label>
                <input type="email" class="form-control" id="Email" name="inputEmail" placeholder="Enter Email" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<?php
}
?>

<?php include "../includes/footer.php" ?>