<?php
require_once 'vendor/autoload.php';

use Configurat\ConfigurationLoader;

ConfigurationLoader::loadConfiguration();
$configuration = $_SESSION['configuration'];
$domain = $configuration['domain'];

// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete all cookies
foreach ($_COOKIE as $name => $value) {
    setcookie($name, '', time() - 3600, '/', "$domain");
}

// Redirect to the login page
header("location: index.php");
exit;
