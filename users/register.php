<?php
date_default_timezone_set('America/New_York');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "facial-recognition";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//THE KEY FOR ENCRYPTION AND DECRYPTION
$key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';
//ENCRYPT FUNCTION
function encryptthis($data, $key) {
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

// Check if form is submitted
if(isset($_POST['submit'])){

    //GET POST VARIABLES
    $idNumber = $_POST['idNumber'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];

    //THE ENCRYPTION PROCESS
    $idNumberEncrypted = encryptthis($idNumber, $key);
    $firstNameEncrypted = encryptthis($firstName, $key);
    $middleNameEncrypted = encryptthis($middleName, $key);
    //INSERT INTO DATABASE
    $stmt = $conn->prepare("INSERT INTO encryp (idNumber, firstName, middleName) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $idNumberEncrypted, $firstNameEncrypted, $middleNameEncrypted);
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Form not submitted.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Insert Data Form</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
</head>
<body>
<div class="jumbotron"><h1>Insert Data Form</h1></div>
<div class="container">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="well">
                <h2>Our Form</h2>
                <!-- FORM FOR OUR EXAMPLE -->
                <form action="" method="post">
                    <div class="form-group">
                        <label for="idNumber">ID Number</label>
                        <input type="text" class="form-control" name="idNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="fistName">Fist Name</label>
                        <input type="text" class="form-control" name="firstName" required>
                    </div>
                    <div class="form-group">
                        <label for="middleName">Middle Name</label>
                        <input type="text" class="form-control" name="middleName" required>
                    </div>
                    <input type="submit" name="submit" class="btn btn-success btn-lg" value="submit">
                </form>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>
</body>
</html>