<?php

session_start();

require_once 'vendor/autoload.php'; // Include the JWT library

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Cookies\TokenManager;

use Configurat\ConfigurationLoader;

ConfigurationLoader::loadConfiguration();
$configuration = $_SESSION['configuration'];

// Access the configuration variables like this:
$servername = $configuration['servername'];
$dbname = $configuration['dbname'];
$username = $configuration['username'];
$password = $configuration['password'];
$reset_password_secret = $configuration['reset_password_secret'];

$new_user_password = $_POST['new_password'];
$new_user_password_again = $_POST['confirm_password'];




// Check if the password meets the criteria.
if (strlen($new_user_password) < 8) {
    $error_message_new_user_password = "A jelszónak legalább 8 karakter hosszúnak kell lennie.";
} elseif (!preg_match('/[A-Z]/', $new_user_password)) {
    $error_message_new_user_password = "A jelszónak tartalmaznia kell legalább egy nagybetűt.";
} elseif (!preg_match('/\d/', $new_user_password)) {
    $error_message_new_user_password = "A jelszónak tartalmaznia kell legalább egy számot.";
} elseif (!preg_match('/[!@#$%^&*()_+=\-{}[\]:;"\'<>,.?]/', $new_user_password)) {
    $error_message_new_user_password = "A jelszónak tartalmaznia kell legalább egy speciális karaktert.";
}

if ($new_user_password != $new_user_password_again) {
    $error_message_new_user_password_again = "A megadott jelszavak nem egyeznek";
}
// If the password does not meet the criteria, we return to the registration page with an error message.
if (isset($error_message_new_user_password)) {
    header("Location: reset_password.php?error_message_new_user_password="
        . urlencode($error_message_new_user_password));
    exit;
} elseif (isset($error_message_new_user_password_again)) {
    header("Location: reset_password.php?error_message_new_user_password_again="
        . urlencode($error_message_new_user_password_again));
    exit;
}


$passwordHash = password_hash($new_user_password, PASSWORD_DEFAULT); // Generate password hash.

$conn = new mysqli($servername, $username, $password, $dbname); // Connect to sql.

if (isset($_SESSION['reset_password_token'])) {
    $reset_password_token = $_SESSION['reset_password_token'];

    // Token deckoding
    $decoded_token = JWT::decode($reset_password_token, new Key($reset_password_secret, 'HS256'));

    if (isset($decoded_token->user_id)) {
        $user_id = $decoded_token->user_id;
        // Update the password in the database
        $sql = "UPDATE users SET password_hash = '$passwordHash' WHERE user_id = '$user_id'";
        $result = $conn->query($sql);

        if ($result === false) {
            // if the password update is unsuccessful
            echo "A jelszó frissítése sikertelen.";
        } elseif ($conn->affected_rows == 0) {
            // if the the password is the same as the old one
            echo "Nincs változtatni való.";
        }

        // set the cookies
        TokenManager::setCookies($user_id);
    } else {
        echo "A JWT token hibás vagy hiányos.";
    }
} else {
    echo "Nincs érvényes reset_password_token a session-ben.";
}


