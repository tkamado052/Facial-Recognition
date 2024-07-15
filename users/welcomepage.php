<?php
session_start();
?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            text-align: center;
        }
    </style>
</head>
  
    <body>
        <h2>Welcome @<?php echo $_SESSION['idNumber']; ?></h2>
        <a href = "logout.php">Logout</a>
</body>
</html>
