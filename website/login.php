<?php

require 'vendor/autoload.php'; // Include the JWT library

use Firebase\JWT\JWT;

include('get_config_json.php');

$servername = "localhost:3307";

$dbname = "id21264970_projektmunka";
$username = "id21264970_esp_board";
$password = "Admin123!";
$password1 = $_POST['password1'];
$user = $_POST['username1'];
$login = 0;
$storedPasswordHash = "";

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT password_hash, user_id FROM users WHERE username = '$user'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $storedPasswordHash = $row["password_hash"];
        $user_id = $row["user_id"];
    }
} else {
    // Sikertelen bejelentkezés
    #echo "Hibás jelszó vagy felhasználónév!";
    $error_messagelog = "Hibás felhasználónév vagy jelszó!";
    //echo $error_message;
    header("Location: index.php?error_messagelog=" . urlencode($error_messagelog));
    exit;
}

if (password_verify($password1 , $storedPasswordHash)) {
    // Sikeres bejelentkezés
    echo "Sikeres bejelentkezés!";
    $login = 1;
} else {
    // Sikertelen bejelentkezés
    $error_messagelog = "Hibás felhasználónév vagy jelszó!";
    //header("Location: index.php");
    header("Location: index.php?error_messagelog=" . urlencode($error_messagelog));
    exit;
}


$conn->close();
if ($login == 1) {
    $refresh_token_expiry = time() + 30 * 24 * 60 * 60;
    $access_token_expiry = time() + 3600;

    // Generate a new access token
    $access_token = JWT::encode(['user_id' => $user_id], $access_secret, 'HS256', $access_token_expiry);

// Generate a refresh token
    $refresh_token = JWT::encode(['user_id' => $user_id], $refresh_secret, 'HS256', $refresh_token_expiry);

    setcookie('access_token', $access_token, $access_token_expiry, "/", "", true, true);// Secure and HttpOnly
    setcookie("refresh_token", $refresh_token, $refresh_token_expiry, "/", "", true, true);
    header("Location: index2.php");
}
else{
    header("Location: index.php");
}
exit;
