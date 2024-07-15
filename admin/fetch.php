<?php

require '../includes/encryption_functions.php';
require '../includes/dbconfig.php';


$sql = "SELECT * FROM seniordb";
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
    <div class="jumbotron">
        <h1>Display Encrypted Data</h1>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id Number</th>
                <th>firstname</th>
                <th>middle name</th>
                <th>surname</th>
                <th>suffix</th>
                <th>address</th>
                <th>date of birth</th>
                <th>age</th>
                <th>sex</th>
                <th>date id issued</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $decryptedName = decryptthis($row['idNumber'], $key);
                    $decryptedEmail = decryptthis($row['firstName'], $key);
                    $decryptedmiddleName = decryptthis($row['middleName'], $key);
                    $decryptedsurname = decryptthis($row['surname'], $key);
                    $decryptedsuffix = decryptthis($row['suffix'], $key);
                    $decryptedaddress= decryptthis($row['address'], $key);
                    $decrypteddob = decryptthis($row['dob'], $key);
                    $decryptedage = decryptthis($row['age'], $key);
                    $decryptedsex = decryptthis($row['sex'], $key);
                    $decrypteddateIdissue = decryptthis($row['dateIdissue'], $key);
                    echo "<tr>
                            <td>" . htmlspecialchars($decryptedName) . "</td>
                            <td>" . htmlspecialchars($decryptedEmail) . "</td>
                            <td>" . htmlspecialchars($decryptedmiddleName) . "</td>
                            <td>" . htmlspecialchars($decryptedsurname) . "</td>
                            <td>" . htmlspecialchars($decryptedsuffix) . "</td>
                            <td>" . htmlspecialchars($decryptedaddress) . "</td>
                            <td>" . htmlspecialchars($decrypteddob) . "</td>
                            <td>" . htmlspecialchars($decryptedage) . "</td>
                            <td>" . htmlspecialchars($decryptedsex) . "</td>
                            <td>" . htmlspecialchars($decrypteddateIdissue) . "</td>
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
</body>
</html>
