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

// THE KEY FOR ENCRYPTION AND DECRYPTION
$key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';

// DECRYPT FUNCTION
function decryptthis($data, $key) {
    $encryption_key = base64_decode($key);
    list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2), 2, null);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

$sql = "SELECT * FROM encryp";
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
                <th>Name</th>
                <th>Email</th>
                <th>middle name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $decryptedName = decryptthis($row['idNumber'], $key);
                    $decryptedEmail = decryptthis($row['firstName'], $key);
                    $decryptedmiddleName = decryptthis($row['middleName'], $key);
                    echo "<tr>
                            <td>" . htmlspecialchars($decryptedName) . "</td>
                            <td>" . htmlspecialchars($decryptedEmail) . "</td>
                            <td>" . htmlspecialchars($decryptedmiddleName) . "</td>
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
