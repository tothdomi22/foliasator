<?php

session_start();

include('get_config_json.php');
$configuration = $_SESSION['configuration'];

// Access the configuration variables like this:
$URL = $configuration['URL'];
$domain = $configuration['domain'];

$token_is_valid = 0;
include('token_valid.php');
if ($token_is_valid==1) { // if the jwt token is valid this change the page to $URL/index2.php
    header("Location:$URL/index2.php"); // This
    exit(); // if not exit the php
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Regisztráció</title>
    <style>
        body
        {
            margin: 0;
            padding: 0;
            font font-family: 'Poppins', sans-serif;
            color: white;
            background-color: #37474f;
        }
        h2 {
            color: #ffffff;
            width: 250px;
            height: 93px;
            background-color: #2C87BF;
            border-radius: 15px;
            text-align: center;
            line-height: 99px;
            font-size: 35px;
        }
        label {
            color: #ffffff;
            font-size: 25px;
           }
           input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            }
            .error {
            color: red;     
        }
    </style>
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
</body>
</html>
