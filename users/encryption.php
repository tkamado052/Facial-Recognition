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
$encryption_key = base64_decode($key);
$iv_length = openssl_cipher_iv_length('aes-256-cbc');

// Encrypt function
function encryptthis($data, $key) {
    global $iv_length;
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes($iv_length);
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

// Decrypt function
function decryptthis($data, $key) {
    global $iv_length;
    $encryption_key = base64_decode($key);
    list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2), 2, null);
    if (strlen($iv) !== $iv_length) {
        return false; // Return false if IV length is not correct
    }
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

// Password verify function
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}
?>
