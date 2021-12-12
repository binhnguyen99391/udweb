<?php include "../includes/header.php" ?>
<?php require_once("../libs/connection.php"); ?>

<?php

// Nếu không phải là sự kiện đăng ký thì không xử lý
if (isset($_POST['txtUsername'])) {

    // Khai báo utf-8 để hiển thị được tiếng việt
    header('Content-Type: text/html; charset=UTF-8');

    //Lấy dữ liệu từ file dangky.php

    $username = stripslashes($_REQUEST['txtUsername']);
    $username = mysqli_real_escape_string($conn, $username);
    $password = stripslashes($_REQUEST['txtPassword']);
    $password = mysqli_real_escape_string($conn, $password);
    $email = stripslashes($_REQUEST['txtEmail']);
    $email = mysqli_real_escape_string($conn, $email);

    $phone   = addslashes($_POST['txtPhone']);
    $address   = stripslashes($_POST['txtAddress']);

    //Kiểm tra người dùng đã nhập liệu đầy đủ chưa
    if (!$username || !$password || !$email || !$phone || !$address) {
        echo "Vui lòng nhập đầy đủ thông tin. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

    //Kiểm tra tên đăng nhập này đã có người dùng chưa
    if (mysqli_num_rows(mysqli_query($conn, "SELECT username FROM users WHERE username='$username'"))) {
        echo "Tên đăng nhập này đã có người dùng. Vui lòng chọn tên đăng nhập khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }


    //Kiểm tra email đã có người dùng chưa
    if (mysqli_num_rows(mysqli_query($conn, "SELECT email FROM users WHERE email='$email'"))) {
        echo "Email này đã có người dùng. Vui lòng chọn Email khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

    $query    = "INSERT into users (username, password, email, phone, address)
                     VALUES ('$username', '" . md5($password) . "', '$email', '$phone', '$address')";
    $result   = mysqli_query($conn, $query);

    if ($result) {
        echo "<div class='container'>
              <h3>You are registered successfully.</h3><br/>
              <p class='link'>Click here to <a href='login.php'>Login</a></p>
              </div>";
    } else {
        echo "<div class='form'>
                <h3>Required fields are missing.</h3><br/>
                <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                </div>";
    }
} else {
?>


    <div class="container">
        <form action="" method="post">
            <div class="form-group">
                <label for="InputUsername">Username *</label>
                <input type="text" class="form-control" name="txtUsername" id="InputUsername" placeholder="Enter Username" required>
            </div>
            <div class="form-group">
                <label for="Password">Password *</label>
                <input type="password" class="form-control" name="txtPassword" id="Password" placeholder="Enter Password" 
                pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" required autocomplete="new-password">
            </div>
            <div class="form-group">
                <label for="ConfirmPassword">Confirm Password *</label>
                <input type="password" class="form-control" id="ConfirmPassword" placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
                <label for="Email">Email *</label>
                <input type="email" class="form-control" name="txtEmail" id="Email" placeholder="Enter Email" required>
            </div>
            <div class="form-group">
                <label for="PhoneNumber">Phone Number</label>
                <input type="tel" class="form-control" name="txtPhone" id="PhoneNumber" placeholder="Enter Phone Number" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
            </div>
            <div class="form-group">
                <label for="Address">Address</label>
                <input type="text" class="form-control" name="txtAddress" id="Address" placeholder="Enter Address">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        var password = document.getElementById("Password"),
            confirm_password = document.getElementById("ConfirmPassword");

        function validatePassword() {
            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
                confirm_password.setCustomValidity('');
            }
        }
        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>
<?php
}
?>
<?php include "../includes/footer.php" ?>