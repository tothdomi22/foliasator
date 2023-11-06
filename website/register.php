<?php

include('get_config_json.php');
$configuration = $_SESSION['configuration'];

// Access the configuration variables like this:
$servername = $configuration['servername'];
$dbname = $configuration['dbname'];
$username = $configuration['username'];
$password = $configuration['password'];
$URL = $configuration['URL'];

$user_password = $_POST['password'];
$user = $_POST['username'];
$email = $_POST['email'];
$login = 0;

$stored_password_hash="";

// Check if the password meets the criteria.
if (strlen($user_password) < 8) {
    $error_messagereg = "A jelszónak legalább 8 karakter hosszúnak kell lennie.";
} elseif (!preg_match('/[A-Z]/', $user_password)) {
    $error_messagereg = "A jelszónak tartalmaznia kell legalább egy nagybetűt.";
} elseif (!preg_match('/\d/', $user_password)) {
    $error_messagereg = "A jelszónak tartalmaznia kell legalább egy számot.";
} elseif (!preg_match('/[!@#$%^&*()_+=\-{}[\]:;"\'<>,.?]/', $user_password)) {
    $error_messagereg = "A jelszónak tartalmaznia kell legalább egy speciális karaktert.";
    }
// If the password does not meet the criteria, we return to the registration page with an error message.
    if (isset($error_messagereg)) {
        header("Location: index.php?error_messagereg=" . urlencode($error_messagereg));
        exit;
    }


$passwordHash = password_hash($user_password, PASSWORD_DEFAULT); // Generate password hash.

$conn = new mysqli($servername, $username, $password, $dbname); // Connect to sql.

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username FROM users WHERE username = '$user'"; // Select username from users where username is $user.
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // The username already exists in the database
    $error_messagereg = "A felhasználónév már létezik.";
    header("Location: index.php?error_messagereg=" . urlencode($error_messagereg));
    exit;
} else {
    //The username does not yet exist, so it can be added to the database.
    $sql = "INSERT INTO users (username, email, password_hash)
            VALUES ('$user', '$email', '$passwordHash')";// Insert the data in the database.
    include('login.php'); //Login if the user is not exist
    if ($conn->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

