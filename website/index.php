<?php

session_start();

include('get_config_json.php');
$configuration = $_SESSION['configuration'];

// Access the configuration variables like this:
$URL = $configuration['URL'];
$domain = $configuration['domain'];
$access_secret = $configuration['access_secret'];
$refresh_secret = $configuration['refresh_secret'];

$token_is_valid = 0;

include('token_valid.php');

if (isset($_COOKIE['access_token']) && is_string($_COOKIE['access_token'])) {
    $token_is_valid = verifyToken($_COOKIE['access_token'], $access_secret);
}
if (isset($_COOKIE['access_token']) && is_string($_COOKIE['access_token'])) {
    $token_is_valid = verifyToken($_COOKIE['refresh_token'], $refresh_secret);
}

if ($token_is_valid==1) { // if the jwt token is valid this change the page to $URL/index2.php
    header("Location:$URL/index2.php"); // This
    exit(); // if not exit the php
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Regisztráció</title>
</head>
<body>
<h2>Regisztráció</h2>
<form action="register.php" method="POST">
    <label for="username">Felhasználónév:</label>
    <input type="text" id="username_reg" name="username_reg" required><br><br>

    <label for="email">E-mail cím:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Jelszó:</label>
    <input type="password" id="password_reg" name="password_reg" required><br><br>
    <span class='error'>
        <?php
        if (isset($_GET["error_messagereg"])) {
            $error_messagereg = urldecode($_GET["error_messagereg"]);
            echo $error_messagereg;
        } ?></span><br><br>
    <input type="submit" value="Regisztráció">
</form>
<h2>Bejelentkezés</h2>
<form action="login.php" method="post">
    <label for="username">Felhasználónév:</label>
    <label for="username"></label><input type="text" id="username_log" name="username_log" required><br><br>

    <label for="password">Jelszó:</label>
    <label for="password"></label><input type="password" id="password_log" name="password_log" required><br><br>
    <span class='error'>
        <?php
        if (isset($_GET["error_messagelog"])) {
            $error_messagelog = urldecode($_GET["error_messagelog"]);
            echo $error_messagelog;
        } ?></span><br><br>
    <input type="submit" value="Bejelentkezés">
</form>
<a href="<?php echo "$URL/forgot_password.php";?>">Elfelejtetted a jelszavad?</a>
</body>
</html>
