<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Firebase\JWT\JWT;

//Load Composer's autoloader
require_once 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(false);

use Configurat\ConfigurationLoader;

ConfigurationLoader::loadConfiguration();
$configuration = $_SESSION['configuration'];

// Access the configuration variables like this:
$email_password = $configuration['email_password'];
$servername = $configuration['servername'];
$dbname = $configuration['dbname'];
$username = $configuration['username'];
$password = $configuration['password'];
$reset_password_secret = $configuration['reset_password_secret'];
$url = $configuration['URL'];
$email_sent = $configuration['email_sent'];

$email = "";
$user_id = "";
$username_login = "";

if (isset($_POST['email'])) {
    $email = $_POST['email'];
}

$reset_password_token_expiry = time() + 3600;


$conn = new mysqli($servername, $username, $password, $dbname); // Connect to sql.

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT email,username,user_id FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    session_destroy();
    while ($row = $result->fetch_assoc()) {
        $username_login = $row["username"];
        $user_id = $row["user_id"];
    }
    $reset_password_token_data = array(
        'user_id' => $user_id, //User id
        'exp' => $reset_password_token_expiry, //Token expiry time (current time + 1 hour)
    );
    $reset_password_token = JWT::encode( // Generate token
        $reset_password_token_data,
        $reset_password_secret,
        'HS256',
        $reset_password_token_expiry
    );

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.hostinger.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = "$email_sent";                     //SMTP username
        $mail->Password = "$email_password";                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;

        //Recipients
        $mail->setFrom("$email_sent", 'Foliasator');
        $mail->addAddress("$email", "$username_login");     //Add a recipient
        $mail->addReplyTo("$email_sent", 'Foliasator');

        //Content
        $mail->isHTML(true); //Set email format to HTML
        //$mail->CharSet = 'UTF-8';
        //$mail->Subject = '=?UTF-8?B?' . base64_encode('Jelszó-visszaállítási e-mail') . '?=';
        $mail->Subject = 'Jelszo visszaallitasa';
        $mail->Body = "
        <div style='text-align: center;'>
            <h3>Jelszó emlékeztető</h3>
            <p>Kattints az alábbi gombra a jelszavad visszaállításához:</p>
            <p><a href='$url/reset_password.php?token=$reset_password_token'>
                <button style='background-color: #007BFF;
                color: white; border: none; padding: 10px 20px;
                text-align: center; text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
                border-radius: 5px;
                '>Jelszó visszaállítása</button>
            </a></p>
            <p>Ha nem kérted a jelszó visszaállítását, akkor hagyd figyelmen kívül ezt az e-mailt.</p>
            <p><small style='color: #808080;
            font-size: 14px;
            '>Vagy kattints erre a hivatkozásra:
            <a href='$url/reset_password.php?token=$reset_password_token'>
            $url/reset_password.php?token=$reset_password_token</a></small></p>
            </div>
        ";

        $mail->AltBody = "$url/reset_password.php?token=$reset_password_token";

        $mail->send();
    } catch (Exception $e) {
        $error_message = "Az email küldése sikertelen kérjük probálja meg újra.";
        header("Location: forgot_password.php?error_message=" . urlencode($error_message));
    }
} else {
    $error_message = "Az email cím nem létezik.";
    header("Location: forgot_password.php?error_message=" . urlencode($error_message));
}




