<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php"); ?>

<?php
if (isset($_POST['btn_submit'])) {
    $inputEmail = htmlspecialchars($_POST["inputEmail"]);
    $captcha = $_POST['g-recaptcha-response'];
    
    if (!$captcha) {
        echo 'Xin mời xác nhận Captcha!!!';
        exit;
    }
    $secretKey = "6LdjCZMcAAAAAOInAGk20QYv63YK4l3twrAul-De";

    // Gửi request đến server
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);
    
    //sẽ trả về JSON với success == true
    if ($responseKeys["success"]) {
        $email = mysqli_fetch_array(mysqli_query($conn, "SELECT email FROM users WHERE email='$inputEmail'"));

        if ($inputEmail == $email[0]) {
            $new_pass = bin2hex(random_bytes(8));

            $to_email = "$inputEmail";
            $subject = "New Password";
            $body = "Xin chào, mật khẩu mới của bạn ở website http://localhost/udweb là: $new_pass";
            $headers = "From: binhnguyen9939@gmail.com" . "\r\n";
            if (mail($to_email, $subject, $body, $headers)) {

                $query = "UPDATE users set password = '" . sha1($new_pass) . "' WHERE email= '$inputEmail'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    echo "<div class='container'>
                    Email gửi thành công tới $to_email...</div>";
                } else {
                    echo "<div class='container'>
                    Vui lòng thử lại</div>";
                }
            } else {
                echo "<div class='container'>
                Đường truyền bị lỗi...</div>";
            }
        } else {
            echo "<div class='container'>
                  <h3>Email không tồn tại</h3><br/>
                  </div>";
        }
    } else {
        echo 'You are spammer ! Get the @$%K out';
    }
} else {
?>
    <div class="m-5 w-25 mx-auto">
        <form action="" method="post">
            <div class="form-group">
                <label>Email *</label>
                <input type="email" class="form-control" name="inputEmail" placeholder="Nhập email" required>
            </div>
            <div class="g-recaptcha" data-sitekey="6LdjCZMcAAAAAOQuieGQABscVALfqts9PHOVrlqV"></div>

            <button type="submit" class="btn btn-primary" name="btn_submit">Gửi</button>
        </form>
    </div>
<?php
}
?>
<script>
    window.onload = function() {
        var $recaptcha = document.querySelector('#g-recaptcha-response');

        if ($recaptcha) {
            $recaptcha.setAttribute("required", "required");
        }
    };
</script>
<?php include "../includes/footer.php" ?>