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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,
    initial-scale=1.0">
    <title> finals </title>
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>
<body>
    <h1 style="text-align:center"> Senior Citizens' Information </h1>
    <div class="container">
        <table class="table table-striped my-5">
        <thead>
        <tr>
        <th scope="col">id</th>
        <th scope="col">First Name</th>
        <th scope="col">Middle Name</th>
        <th scope="col">Surname</th>
        <th scope="col">Suffix</th>
        <th scope="col">Address</th>
        <th scope="col">Barangay</th>
        <th scope="col">Date of Birth</th>
        <th scope="col">Age</th>
        <th scope="col">Sex</th>
        <th scope="col">Date of ID Issue</th>
        </tr>
        </thead>
<tbody>
<?php
$sql = "SELECT * FROM senior WHERE barangay = 'Tangos'";;
$result=mysqli_query($db, $sql);

if($result){
    while($row=mysqli_fetch_assoc($result)){
    $idNumber=$row['idNumber'];
    $firstName=$row['firstName'];
    $middleName=$row['middleName'];
    $surname=$row['surname'];
    $suffix=$row['suffix'];
    $address=$row['address'];
    $barangay=$row['barangay'];
    $dob=$row['dob'];
    $age=$row['age'];
    $sex=$row['sex'];
    $dateIdissue=$row['dateIdissue'];
echo ' <tr>
<th scope="row">' . $idNumber . '</th>
<td>' . $firstName . '</td>
<td>' . $middleName . '</td>
<td>' . $surname . '</td>
<td>' . $suffix . '</td>
<td>' . $address . '</td>
<td>' . $barangay . '</td>
<td>' . $dob . '</td>
<td>' . $age . '</td>
<td>' . $sex . '</td>
<td>' . $dateIdissue . '</td>
</tr> ';
}
}
?>
</tbody>
</div>
</body>
</html>
