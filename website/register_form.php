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
	<meta charset="utf-8">
	<title>Regisztráció</title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="css/roboto-font.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-5/css/fontawesome-all.min.css">
	<!-- Main Style Css -->
	<link rel="stylesheet" href="css/style.css" />
</head>

<body class="form-v5">
	<div class="page-content">
		<div class="form-v5-content">
			<form class="form-detail" action="register.php" method="post">
				<h2>Regisztráció</h2>
				<div class="form-row">
					<label for="username_reg">Felhasználónév</label>
					<input type="text" name="username_reg" id="username_reg" class="input-text"
						placeholder="Felhasználónév" required>
					<i class="fas fa-user"></i>
				</div>
				<div class="form-row">
					<label for="your-email">Email</label>
					<input type="text" name="email" id="email" class="input-text" placeholder="Email" required
						pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}">
					<i class="fas fa-envelope"></i>
				</div>
				<div class="form-row">
					<label for="password">Jelszó</label>
					<input type="password" name="password_reg" id="password_reg" class="input-text" placeholder="Jelszó"
						required>
					<i class="fas fa-lock"></i>
				</div>

				<span class='error'>
					<?php
					if (isset($_GET["error_messagereg"])) {
						$error_messagereg = urldecode($_GET["error_messagereg"]);
						echo $error_messagereg;
					} ?>
				</span><br><br>

				<div class="form-row-last">
					<input type="submit" name="register" class="register" value="Regisztráció">
				</div>
			</form>
		</div>
	</div>
</body>

</html>