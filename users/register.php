<?php
require '../admin/encryption_functions.php'; // Include the encryption functions

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

// Prepare and bind
 
$stmt = $conn->prepare("INSERT INTO senior (idNumber, firstName, middleName, surname, suffix, address, dob, age, sex, dateIssue, picture, idPicture, signature, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssissssss", $idNumber, $firstName, $middleName, $surname, $suffix, $address, $dob, $age, $sex, $dateIssue, $picture, $idPicture, $signature, $password);

// Set parameters and execute
$idNumber = encryptthis($_POST['idNumber'], $key);
$firstName = encryptthis($_POST['firstName'], $key);
$middleName = encryptthis($_POST['middleName'], $key);
$surname = encryptthis($_POST['surname'], $key);
$suffix = encryptthis($_POST['suffix'], $key);
$address = encryptthis($_POST['address'], $key);
$dob = encryptthis($_POST['dob'], $key);
$age = encryptthis($_POST['age'], $key);
$sex = encryptthis($_POST['sex'], $key);
$dateIssue = encryptthis($_POST['dateIssue'], $key);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

// Handle file uploads
$target_dir = "uploads/";
$picture = $target_dir . basename($_FILES["picture"]["name"]);
$idPicture = $target_dir . basename($_FILES["idPicture"]["name"]);
$signature = $target_dir . basename($_FILES["signature"]["name"]);

// Check if files were uploaded successfully
if (move_uploaded_file($_FILES["picture"]["tmp_name"], $picture) &&
    move_uploaded_file($_FILES["idPicture"]["tmp_name"], $idPicture) &&
    move_uploaded_file($_FILES["signature"]["tmp_name"], $signature)) {

    // Execute statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Sorry, there was an error uploading your files.";
}

$stmt->close();
$conn->close();
?>
