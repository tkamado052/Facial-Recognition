<?php
require '../includes/encryption_functions.php';
require '../includes/dbconfig.php';

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
    $barangay = $_POST['barangay'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $dateIssue = $_POST['dateIdissue'];
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

    // Handle file uploads
    $target_dir = "uploads/";
    $idPicture = $target_dir . basename($_FILES["idPicture"]["name"]);
    $signature = $target_dir . basename($_FILES["signature"]["name"]);

    if (move_uploaded_file($_FILES["idPicture"]["tmp_name"], $idPicture) &&
        move_uploaded_file($_FILES["signature"]["tmp_name"], $signature)) {

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO seniordb (idNumber, firstName, middleName, surname, suffix, address, barangay, dob, age, sex, dateIdissue, idPicture, signature, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssss", $idNumberEncrypted, $firstNameEncrypted, $middleNameEncrypted, $surnameEncrypted, $suffixEncrypted, $addressEncrypted, $barangay, $dobEncrypted, $ageEncrypted, $sexEncrypted, $dateIDIssueEncrypted, $idPicture, $signature, $passwordEncrypted);

        if ($stmt->execute()) {
            $id = $conn->insert_id;
            $message = "Registration complete!";
            $username = $firstName;

            // Redirect to capture.php
            header("Location: capture.php?id=$id&username=$username");
            exit();
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
        <h2>Senior Citizens Account Registration</h2>
        <p>Fields with * are required.</p>
        <form id="registrationForm" action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <fieldset>
                <legend>Basic Information</legend>
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
                        <label for="dateIdissue">*Date ID Issue</label>
                        <input type="date" id="dateIdissue" name="dateIdissue" required>
                    </div>
                </div>
                <div class="row">
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

            <button type="submit" name="submit">Register</button>
        </form>
        <div id="popup" class="popup">
            <h3><?php echo $message; ?></h3>
            <button onclick="closePopup()">OK</button>
        </div>
    </div>

    <script>
        // Show the popup if message is set
        window.onload = function() {
            const message = "<?php echo $message; ?>";
            if (message) {
                const popup = document.getElementById('popup');
                popup.classList.add('show');
            }
        };

        // Close the popup
        function closePopup() {
            const popup = document.getElementById('popup');
            popup.classList.remove('show');
        }
    </script>
</body>
</html>
