<?php include('includes/header.php'); ?>

<?php

require '../includes/encryption_functions.php';
require '../includes/dbconfig.php';

$sql = "SELECT idNumber, surname, firstName, middleName, suffix FROM seniordb";
$result = $conn->query($sql);
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
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id Number</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $decryptedIdNumber = decryptthis($row['idNumber'], $key);
                    $decryptedSurname = decryptthis($row['surname'], $key);
                    $decryptedFirstName = decryptthis($row['firstName'], $key);
                    $decryptedMiddleName = decryptthis($row['middleName'], $key);
                    $decryptedSuffix = decryptthis($row['suffix'], $key);

                    $fullName = $decryptedFirstName . " " . $decryptedMiddleName . " " . $decryptedSurname . " " . $decryptedSuffix;

                    echo "<tr>
                            <td>" . htmlspecialchars($decryptedIdNumber) . "</td>
                            <td>" . htmlspecialchars($fullName) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No results found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
