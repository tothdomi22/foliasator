<?php
require_once 'vendor/autoload.php';

session_start();

$token_is_valid = 0;
use Configurat\ConfigurationLoader;

ConfigurationLoader::loadConfiguration();
$configuration = $_SESSION['configuration'];

//Access the configuration variables like this:
$reset_password_secret = $configuration['reset_password_secret'];
$url = $configuration['URL'];
$reset_password_token = "";
$reset_password_token_is_valid = 0;

use Token\TokenVerifier;

if (isset($_GET['token'])) {
    $reset_password_token = $_GET['token'];
    $reset_password_token_is_valid = TokenVerifier::verifyToken($reset_password_token, $reset_password_secret);
}
if ($reset_password_token_is_valid == 1) { // if the jwt token is valid this change the page to $URL/index2.php
    $_SESSION['reset_password_token'] = $reset_password_token;
} else {
    echo "A jelszó változtatás nem lehetséges kérjen egy másik jelszóváltoztató emailt.";
}
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <title>Jelszó Visszaállítás</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .reset-password-body {
            text-align: center;
            margin: 20px auto;
            max-width: 400px;
        }

        .reset-password-body label {
            display: block;
            margin-bottom: 10px;
        }

        .reset-password-body input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .reset-password-body input[type="submit"] {
            background-color: #0074cc;
            /* Kék színű gomb */
            color: white;
            padding: 10px 20px;
            border: none;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="reset-password-body">
        <form action="process_reset_password.php" method="POST">
            <h1>Új jelszó megadása</h1><br>
            <label for="new_password">Új jelszó</label>
            <input type="password" name="new_password" id="new_password" required><br><br>
            <span class='error'>
                <?php
                if (isset($_GET["error_message_new_user_password"])) {
                    $error_message = urldecode($_GET["error_message_new_user_password"]);
                    echo $error_message;
                } ?>
            </span><br><br>
            <label for="confirm_password">Új jelszó újra</label>
            <input type="password" name="confirm_password" id="confirm_password" required><br><br>
            <span class='error'>
                <?php
                if (isset($_GET["error_message_new_user_password_again"])) {
                    $error_message = urldecode($_GET["error_message_new_user_password_again"]);
                    echo $error_message;
                } ?>
            </span><br><br>
            <input type="submit" value="Mentés">
        </form>
    </div>
</body>

</html>