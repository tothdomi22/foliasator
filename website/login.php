<?php
require_once 'vendor/autoload.php';

use Cookies\TokenManager;
use Configurat\ConfigurationLoader;

ConfigurationLoader::loadConfiguration();
$configuration = $_SESSION['configuration'];

// Access the configuration variables like this:
$servername = $configuration['servername'];
$dbname = $configuration['dbname'];
$username = $configuration['username'];
$password = $configuration['password'];
$url = $configuration['URL'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_log = $_POST['password_log'] ?? null;
    $user = $_POST['username_log'] ?? null;
}
$login = 0;
$storedPasswordHash = "";
$user_id = 0;

$conn = new mysqli($servername, $username, $password, $dbname); // Connect to the database.

$sql = "SELECT password_hash, user_id FROM users WHERE username = '$user'"; //select password hash and
//user id from the users where username is $user.
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $storedPasswordHash = $row["password_hash"];
        $user_id = $row["user_id"];
    }
} else {
    // The login is not successful, because there is no user with this username.
    $error_messagelog = "Hibás felhasználónév vagy jelszó!";
    header("Location: index.php?error_messagelog=" . urlencode($error_messagelog));
    exit;
}

if (password_verify($password_log, $storedPasswordHash)) {
    // The login is successful.
    $login = 1;
    $_SESSION['username'] = $user;
} else {
    // // The login is not successful, because the password is not match.
    $error_messagelog = "Hibás felhasználónév vagy jelszó!";
    header("Location: index.php?error_messagelog=" . urlencode($error_messagelog));
    exit;
}


$conn->close();

if ($login == 1) { // If the login is successful set cookies
    TokenManager::setCookies($user_id);
} else {
    header("Location:$url/index.php"); // if login is not successful change the page to $URL/index.php
}
