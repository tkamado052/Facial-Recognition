<html?php
require '../includes/dbconfig.php';
require '../includes/encryption_functions.php';

?>
<!DOCTYPE html>
<html lang="en"></html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="../style/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

    <div class="wrapper">
        <form action="loginpage.php" method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="UserID" class="field" placeholder="User ID" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="Password" class="field" id="password" placeholder="Password" required>
                <button type="button" id="togglePassword">Show</button>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox"> Remember Me</label>
                <a href="#">Forgot Password</a>
            </div>
            <button type="submit" name="login" class="btn">Login</button>
            <div class="register-link">
                <p> Don't have an account? <a href="../index.html">Register</a></p>
            </div>
        </form>
    </div>
    <?php
    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'facial-recognition') or die('Unable to connect');
    if (isset($_POST['login'])) {
    $username = $_POST['UserID'];
    $password = $_POST['Password'];

    $query = "SELECT * FROM seniordb WHERE UserID= '$username' AND Password = '$password'";
    $select = mysqli_query($conn, $query);
    

    if (is_array($row)) {
        $_SESSION["UserID"] = $row["UserID"];
        $_SESSION["Password"] = $row["Password"];
        header("Location: welcomepage.php");
        
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Invalid UserID or Password");';
        echo 'window.location.href = "loginpage.php";';
        echo '</script>';
    }
}

    ?>
    

    <script src="../js/showpass.js"></script>
</body>
</html>
