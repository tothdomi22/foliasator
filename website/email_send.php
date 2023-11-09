<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

include('get_config_json.php');
$configuration = $_SESSION['configuration'];

// Access the configuration variables like this:
$email_password = $configuration['email_password'];
$servername = $configuration['servername'];
$dbname = $configuration['dbname'];
$username = $configuration['username'];
$password = $configuration['password'];
$reset_password_secret = $configuration['reset_password_secret'];
$URL = $configuration['URL'];

$email="";
$user_id="";
$username_login="";

if (isset($_POST['email'])) {
    $email = $_POST['email'];
}

$reset_password_token_expiry= time() + 3600;


$conn = new mysqli($servername, $username, $password, $dbname); // Connect to sql.

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql= "SELECT email,username,user_id FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    session_destroy();
    while ($row = $result->fetch_assoc()) {
        $username_login = $row["username"];
        $user_id = $row["user_id"];
    }
    $reset_password_token_data = array(
        'user_id' => $user_id, // Példa adat: felhasználói azonosító
        'exp' => $reset_password_token_expiry, // A lejárati idő beállítása 1 óra múlva
    );
    $reset_password_token = JWT::encode($reset_password_token_data, $reset_password_secret, 'HS256', $reset_password_token_expiry);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.hostinger.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'foliasator@foliasatorprojektmunka.com';                     //SMTP username
        $mail->Password = "$email_password";                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;

        //Recipients
        $mail->setFrom('foliasator@foliasatorprojektmunka.com', 'Foliasator');
        $mail->addAddress("$email", "$username_login");     //Add a recipient
        $mail->addReplyTo('foliasator@foliasatorprojektmunka.com', 'Foliasator');

        //Content
        $mail->isHTML(true);//Set email format to HTML
        //$mail->CharSet = 'UTF-8';
        //$mail->Subject = '=?UTF-8?B?' . base64_encode('Jelszó-visszaállítási e-mail') . '?=';
        $mail->Subject = 'Jelszo visszaallitasa';
        $mail->Body = "
        <div style='text-align: center;'>
            <h3>Jelszó emlékeztető</h3>
            <p>Kattints az alábbi gombra a jelszavad visszaállításához:</p>
            <p><a href='$URL/reset_password.php?token=$reset_password_token'>
                <button style='background-color: #007BFF; color: white; border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 5px;'>Jelszó visszaállítása</button>
            </a></p>
            <p>Ha nem kérted a jelszó visszaállítását, akkor hagyd figyelmen kívül ezt az e-mailt.</p>
            <p><small style='color: #808080; font-size: 14px;'>Vagy kattints erre a hivatkozásra: <a href='$URL/reset_password.php?token=$reset_password_token'>$URL/reset_password.php?token=$reset_password_token</a></small></p>
            </div>
        ";

        $mail->AltBody = "$URL/reset_password.php?token=$reset_password_token";

        $mail->send();
    } catch (Exception $e) {
        $error_message = "Az email küldése sikertelen kérjük probálja meg újra.";
        header("Location: forgot_password.php?error_message=" . urlencode($error_message));
    }
}
else {
    $error_message = "Az email cím nem létezik.";
    header("Location: forgot_password.php?error_message=" . urlencode($error_message));
}




