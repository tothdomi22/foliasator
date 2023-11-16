<?php
require_once 'vendor/autoload.php';

session_start();

use Configurat\ConfigurationLoader;

ConfigurationLoader::loadConfiguration();

$configuration = $_SESSION['configuration'];

// Access the configuration variables like this:
$url = $configuration['URL'];
$domain = $configuration['domain'];
$access_secret = $configuration['access_secret'];
$refresh_secret = $configuration['refresh_secret'];

$token_is_valid = 0;

use Token\TokenVerifier;

if (isset($_COOKIE['access_token']) && is_string($_COOKIE['access_token'])) {
	$token_is_valid = TokenVerifier::verifyToken($_COOKIE['access_token'], $access_secret);
}
if (isset($_COOKIE['access_token']) && is_string($_COOKIE['access_token'])) {
	$token_is_valid = TokenVerifier::verifyToken($_COOKIE['refresh_token'], $refresh_secret);
}

if ($token_is_valid == 1) { // if the jwt token is valid this change the page to $URL/index2.php
	header("Location:$url/index2.php"); // This
	exit(); // if not exit the php
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
	<title>Bejelentkezés</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="login.php" method="post">
					<span class="login100-form-title">
						Bejelentkezés
					</span>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="username_log" id="username_log"
							placeholder="Felhasználónév">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="password" name="password_log" id="password_log"
							placeholder="Jelszó">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					<span class='error'>
						<?php
						if (isset($_GET["error_messagelog"])) {
							$error_messagelog = urldecode($_GET["error_messagelog"]);
							echo $error_messagelog;
						} ?>
					</span><br><br>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Belépés
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Elfelejtett
						</span>
						<a class="txt2" href="<?php echo "$url/forgot_password.php"; ?>">
							Felhasználónév / Jelszó?
						</a>
					</div>

					<div class="text-center p-t-80">
						<a class="txt2" href="<?php echo "$url/register_form.php"; ?>">
							Regisztráció
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>

</html>