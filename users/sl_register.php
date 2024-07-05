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
$key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';

function encryptthis($data, $key) {
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

$message = "";


if (isset($_POST['submit'])) {

    $idNumber = $_POST['idNumber'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $surname = $_POST['surname'];
    $suffix = $_POST['suffix'];
    $address = $_POST['address'];
    $barangay = $_POST['barangay'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $dateIssue = $_POST['dateIssue'];
    $CfirstName = $_POST['CfirstName'];
    $CmiddleName = $_POST['CmiddleName'];
    $Csurname = $_POST['Csurname'];
    $Csuffix = $_POST['Csuffix'];
    $Cdob = $_POST['Cdob'];
    $Cage = $_POST['Cage'];
    $Csex = $_POST['Csex'];
    $password = $_POST['password'];


$idNumberEncrypted = encryptthis($idNumber, $key);
$firstNameEncrypted = encryptthis($firstName, $key);
$middleNameEncrypted = encryptthis($middleName, $key);
$surnameEncrypted = encryptthis($surname, $key);
$suffixEncrypted = encryptthis($suffix, $key);
$addressEncrypted = encryptthis($address, $key);
$barangayEncrypted = encryptthis($barangay, $key);
$dobEncrypted = encryptthis($dob, $key);
$ageEncrypted = encryptthis($age, $key);
$sexEncrypted = encryptthis($sex, $key);
$dateIDIssueEncrypted = encryptthis($dateIssue, $key);
$childfirstNameEncrypted = encryptthis($CfirstName, $key);
$childmiddleNameEncrypted = encryptthis($CmiddleName, $key);
$childsurnameEncrypted = encryptthis($Csurname, $key);
$childdobEncrypted = encryptthis($Cdob, $key);
$childageEncrypted = encryptthis($Cage, $key);
$childsexEncrypted = encryptthis($Csex, $key);
$passwordEncrypted = password_hash($password, PASSWORD_DEFAULT);


$target_dir = "uploads/";
$picture = $target_dir . basename($_FILES["picture"]["name"]);
$idPicture = $target_dir . basename($_FILES["idPicture"]["name"]);
$signature = $target_dir . basename($_FILES["signature"]["name"]);

if (move_uploaded_file($_FILES["picture"]["tmp_name"], $picture) &&
    move_uploaded_file($_FILES["idPicture"]["tmp_name"], $idPicture) &&
    move_uploaded_file($_FILES["signature"]["tmp_name"], $signature)) {


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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Portal Account Creation</title>
    <link rel="stylesheet" href="../style/seniorreg.css">
    <script src="../js/script.js" defer></script>
</head>
<body>
<div class="container">
        <h2>Solo Parents Account Registration</h2>
        <p>Fields with * are required.</p>
        <form id="registrationForm" action="register.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <fieldset>
                <legend>Basic Information</legend>
                <!-- Basic Information Fields -->
                <div class="row">
                    <div class="column">
                        <label for="idNumber">*ID Number</label>
                        <input type="text" id="idNumber" name="idNumber" required>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="firstName">*First Name</label>
                        <input type="text" id="firstName" name="firstName" required>
                    </div>
                    <div class="column">
                        <label for="middleName">*Middle Name</label>
                        <input type="text" id="middleName" name="middleName" required>
                    </div>
                    <div class="column">
                        <label for="surname">*Surname</label>
                        <input type="text" id="surname" name="surname" required>
                    </div>
                    <div class="column">
                        <label for="suffix">Suffix</label>
                        <input type="text" id="suffix" name="suffix">
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="address">*Address</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                    <div class="column">
                        <label for="barangay">*Barangay</label>
                        <select id="barangay" name="barangay" required>
                            <option value="blank"> </option>
                            <option value="tanzaUno"> Tanza Uno </option>
                            <option value="tanzaDos"> Tanza Dos </option>
                            <option value="tangos"> Tangos</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="dob">*Date of Birth</label>
                        <input type="date" id="dob" name="dob" required>
                    </div>
                    <div class="column">
                        <label for="age">*Age</label>
                        <input type="number" id="age" name="age" required>
                    </div>
                    <div class="column">
                        <label for="sex">*Sex</label>
                        <select name="sex" id="sex">
                        <option value="blank"> </option>
                            <option value="male">male</option>
                            <option value="female">female</option>
                            <option value="others">others</option>
                        </select>
                    </div>
                    <div class="column">
                        <label for="dateIssue">*Date ID Issue</label>
                        <input type="date" id="dateIssue" name="dateIssue" required>
                    </div>
                </div>
                <legend>Child Information</legend>
                <div class="row">
                    <div class="column">
                        <label for="CfirstName">*First Name</label>
                        <input type="text" id="CfirstName" name="CfirstName" required>
                    </div>
                    <div class="column">
                        <label for="CmiddleName">*Middle Name</label>
                        <input type="text" id="CmiddleName" name="CmiddleName" required>
                    </div>
                    <div class="column">
                        <label for="Csurname">*Surname</label>
                        <input type="text" id="Csurname" name="Csurname" required>
                    </div>
                    <div class="column">
                        <label for="Csuffix">Suffix</label>
                        <input type="text" id="Csuffix" name="Csuffix">
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="Cdob">*Date of Birth</label>
                        <input type="date" id="Cdob" name="Cdob" required>
                    </div>
                    <div class="column">
                        <label for="Cage">*Age</label>
                        <input type="number" id="Cage" name="Cage" required>
                    </div>
                    <div class="column">
                        <label for="Csex">*Sex</label>
                        <input type="text" id="Csex" name="Csex" required>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="picture">*Upload Picture</label>
                        <input type="file" id="picture" name="picture" required>
                    </div>
                    <div class="column">
                        <label for="idPicture">*Upload ID Picture</label>
                        <input type="file" id="idPicture" name="idPicture" required>
                    </div>
                    <div class="column">
                        <label for="signature">*Upload Signature</label>
                        <input type="file" id="signature" name="signature" required>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Login Information</legend>
                <div class="password-requirements">
                    <p>Password must meet the following requirements:</p>
                    <ul>
                        <li id="length" class="invalid">Minimum of 8 characters</li>
                        <li id="maxLength" class="invalid">Maximum of 32 characters</li>
                        <li id="digit" class="invalid">Must contain at least one digit (0-9)</li>
                        <li id="uppercase" class="invalid">Must contain at least one uppercase letter (A-Z)</li>
                        <li id="lowercase" class="invalid">Must contain at least one lowercase letter (a-z)</li>
                        <li id="special" class="invalid">Must contain at least one special character (~`!@#$%^&*()_-+={}[]|:;"'<>,.?/)</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="password">*Password</label>
                        <input type="password" id="password" name="password" onkeyup="checkPassword()" required>
                    </div>
                    <div class="column">
                        <label for="confirmPassword">*Confirm Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" onkeyup="checkPassword()" required>
                        <span id="matchMessage" class="match-message"></span>
                    </div>
                </div>
            </fieldset>
        
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>