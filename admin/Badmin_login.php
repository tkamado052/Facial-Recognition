<?php
date_default_timezone_set('America/New_York');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "facial-recognition";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Admin Log In Portal</title>
    <link rel="stylesheet" href="../style/regStyles.css">
    <script src="../js/script.js" defer></script>
   
</head>
<body>
    <div class="container">
        <h2>Barangay Admin Log in</h2>
        <div class="row">
             <div class="column">
                <label for="bUserName">Username</label>
                <input type="text" id="bUserName" name="bUserName" required>
            </div>
        </div>
        <div class="row">
             <div class="column">
                <label for="bPassword">Password</label>
                <input type="text" id="bPassword" name="bPassword" required>
            </div>
        </div>
    </div>  
</body>
</html>