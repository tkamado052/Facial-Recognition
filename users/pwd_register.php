<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Portal Account Creation</title>
    <link rel="stylesheet" href="../style/regStyles.css">
    <script src="../js/script.js" defer></script>
</head>
<body>
    <div class="container">
        <h2>PWD Account Registration</h2>
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
                        <input type="text" id="sex" name="sex" required>
                    </div>
                    <div class="column">
                        <label for="dateIssue">*Date ID Issue</label>
                        <input type="date" id="dateIssue" name="dateIssue" required>
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
