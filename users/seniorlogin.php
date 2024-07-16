<?php
require '../includes/dbconfig.php';  // Adjust the path as per your file structure
require '../includes/encryption_functions.php';  // Adjust the path as per your file structure

session_start();

// Define your encryption key here or fetch it from a secure source
$key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';

if (isset($_POST['login'])) {
    $idNumber = $_POST['UserID']; // Assuming UserID input corresponds to idNumber in the database
    $password = $_POST['Password'];

    
    
    // Debug output to check submitted UserID
    echo "UserID submitted: $idNumber <br>";

    // Query to fetch user based on idNumber (assuming it's not encrypted)
    $query = "SELECT * FROM seniordb WHERE idNumber = '$idNumber'";
    $result = mysqli_query($conn, $query);

    // Check if query executed successfully
    if ($result) {
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Decrypt stored idNumber to use for comparison
            $decryptedIDNumber = decryptthis($row["idNumber"], $key);
            
            // Debug output to check decrypted IDNumber
            echo "Decrypted IDNumber: $decryptedIDNumber <br>";

            // Verify hashed password
            if (password_verify($password, $row['password'])) {
                $_SESSION["UserID"] = $decryptedIDNumber;  // Store decrypted idNumber in session
                header("Location: welcomepage.php");
                exit();
            } else {
                echo '<script>alert("Invalid Password");</script>';
            }
        } else {
            echo '<script>alert("Invalid UserID");</script>';
        }
    } else {
        // Display SQL error for debugging
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="../style/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="" method="post">
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

    <script src="../js/showpass.js"></script>
</body>
</html>
