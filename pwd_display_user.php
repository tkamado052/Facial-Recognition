<?php
require 'includes/encryption_functions.php';
require 'includes/dbconfig.php';

$id = $_GET['id'];
$key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';

$sql = "SELECT * FROM pwddb WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $decryptedIdNumber = decryptthis($row['idNumber'], $key);
    $decryptedFirstName = decryptthis($row['firstName'], $key);
    $decryptedMiddleName = decryptthis($row['middleName'], $key);
    $decryptedSurname = decryptthis($row['surname'], $key);
    $decryptedSuffix = decryptthis($row['suffix'], $key);
    $decryptedAddress = decryptthis($row['address'], $key);
    $decryptedDOB = decryptthis($row['dob'], $key);
    $decryptedAge = decryptthis($row['age'], $key);
    $decryptedSex = decryptthis($row['sex'], $key);
    $decryptedDateIdIssue = decryptthis($row['dateIdissue'], $key);
} else {
    echo "No user found.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Encrypted Data</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h1>Display Encrypted Data</h1>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Number</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Surname</th>
                <th>Suffix</th>
                <th>Address</th>
                <th>Date of Birth</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Date ID Issued</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= htmlspecialchars($decryptedIdNumber) ?></td>
                <td><?= htmlspecialchars($decryptedFirstName) ?></td>
                <td><?= htmlspecialchars($decryptedMiddleName) ?></td>
                <td><?= htmlspecialchars($decryptedSurname) ?></td>
                <td><?= htmlspecialchars($decryptedSuffix) ?></td>
                <td><?= htmlspecialchars($decryptedAddress) ?></td>
                <td><?= htmlspecialchars($decryptedDOB) ?></td>
                <td><?= htmlspecialchars($decryptedAge) ?></td>
                <td><?= htmlspecialchars($decryptedSex) ?></td>
                <td><?= htmlspecialchars($decryptedDateIdIssue) ?></td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>
