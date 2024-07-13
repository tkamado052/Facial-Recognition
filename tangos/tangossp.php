<?php
require '../includes/encryption_functions.php';
require '../includes/dbconfig.php';
$sql = "SELECT * FROM seniordb WHERE barangay = 'Tangos'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Tangos</title>
    <link rel="stylesheet" href="../style/bgyStyle.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="https://kit.fontawesome.com/0c1d2e938f.js" crossorigin="anonymous"></script></script>
</head>
<body>
    <input type="checkbox" id="check">
    <label for="check">
        <i class="fas fa-bars" id="btn"></i>
        <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
        <header>Barangay Tangos</header>
        <ul>
            <li><a href="#">Graphs</a></li>
            <li><a href="../tangos/tangospwd.php">PWDs</a></li>
            <li><a href="../tangos/tangossenior.php">Senior Citizens</a></li>
            <li><a href="../tangos/tangossp.php">Solo Parents</a></li>
        </ul>
        <ul>
            <li><a href="#">Log Out</a></li>
        </ul>
    </div>
    <div class="container">
    <div class="jumbotron">
        <h1>Solo Parents' Information</h1>
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
                <th>child's first name</th>
                <th>child's middle name</th>
                <th>child's surname</th>
                <th>child's suffix</th>
                <th>child's date of birth</th>
                <th>child's age</th>
                <th>child's sex</th>
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
                    $decryptedCfirstName = decryptthis($row['CfirstName'], $key);
                    $decryptedCmiddleName = decryptthis($row['CmiddleName'], $key);
                    $decryptedCsurname = decryptthis($row['Csurname'], $key);
                    $decryptedCsuffix = decryptthis($row['Csuffix'], $key);
                    $decryptedCdob = decryptthis($row['Cdob'], $key);
                    $decryptedCage = decryptthis($row['Cage'], $key);
                    $decryptedCsex = decryptthis($row['Csex'], $key);
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
                            <td>" . htmlspecialchars($decryptedCfirstName) . "</td>
                            <td>" . htmlspecialchars($decryptedCmiddleName) . "</td>
                            <td>" . htmlspecialchars($decryptedCsurname) . "</td>
                            <td>" . htmlspecialchars($decryptedCsuffix) . "</td>
                            <td>" . htmlspecialchars($decryptedCdob) . "</td>
                            <td>" . htmlspecialchars($decryptedCage) . "</td>
                            <td>" . htmlspecialchars($decryptedCsex) . "</td>
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