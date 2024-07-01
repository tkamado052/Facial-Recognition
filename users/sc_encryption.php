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

// Encryption key
$key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';

// Encrypt function
function encryptthis($data, $key) {
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decryptthis($data, $key) {
    $encryption_key = base64_decode($key);
    list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2), 2, null);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}


$message = "";

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get POST variables
    $idNumber = $_POST['idNumber'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $surname = $_POST['surname'];
    $suffix = $_POST['suffix'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $dateIssue = $_POST['dateIssue'];
    $password = $_POST['password'];

    // Encryption process
    $idNumberEncrypted = encryptthis($idNumber, $key);
    $firstNameEncrypted = encryptthis($firstName, $key);
    $middleNameEncrypted = encryptthis($middleName, $key);
    $surnameEncrypted = encryptthis($surname, $key);
    $suffixEncrypted = encryptthis($suffix, $key);
    $addressEncrypted = encryptthis($address, $key);
    $dobEncrypted = encryptthis($dob, $key);
    $ageEncrypted = encryptthis($age, $key);
    $sexEncrypted = encryptthis($sex, $key);
    $dateIDIssueEncrypted = encryptthis($dateIssue, $key);
    $passwordEncrypted = password_hash($password, PASSWORD_DEFAULT);

    // Decrypt process
    $idNumberdecrypted = decryptthis($idNumberEncrypted, $key);
    $firstNamedecrypted = decryptthis($firstNameEncrypted, $key);
    $middleNamedecrypted = decryptthis($middleNameEncrypted, $key);
    $surnamedecrypted = decryptthis($surnameEncrypted, $key);
    $suffixdecrypted = decryptthis($suffixEncrypted, $key);
    $addressdecrypted = decryptthis($addressEncrypted, $key);
    $dobdecrypted = decryptthis($dobEncrypted, $key);
    $agedecrypted = decryptthis($ageEncrypted, $key);
    $sexdecrypted = decryptthis($sexEncrypted, $key);
    $dateIDIssuedecrypted = decryptthis($dateIDIssueEncrypted, $key);
 



    // Handle file uploads
    $target_dir = "uploads/";
    $picture = $target_dir . basename($_FILES["picture"]["name"]);
    $idPicture = $target_dir . basename($_FILES["idPicture"]["name"]);
    $signature = $target_dir . basename($_FILES["signature"]["name"]);

    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $picture) &&
        move_uploaded_file($_FILES["idPicture"]["tmp_name"], $idPicture) &&
        move_uploaded_file($_FILES["signature"]["tmp_name"], $signature)) {

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO senior (idNumber, firstName, middleName, surname, suffix, address, dob, age, sex, dateIssue, picture, idPicture, signature, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssss", $idNumberEncrypted, $firstNameEncrypted, $middleNameEncrypted, $surnameEncrypted, $suffixEncrypted, $addressEncrypted, $dobEncrypted, $ageEncrypted, $sexEncrypted, $dateIDIssueEncrypted, $picture, $idPicture, $signature, $passwordEncrypted);

        if ($stmt->execute()) {
            $message = "Registration complete!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Sorry, there was an error uploading your files.";
    }
}

$conn->close();
?>
