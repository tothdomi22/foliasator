<?php

require 'vendor/autoload.php'; // Include the JWT library

use Firebase\JWT\JWT;
function setCookies($user_id) {
    // Get the configuration
    include('get_config_json.php');
    $configuration = $_SESSION['configuration'];

// Access the configuration variables like this:
    $access_secret = $configuration['access_secret'];
    $refresh_secret = $configuration['refresh_secret'];
    $domain = $configuration['domain'];
    $URL = $configuration['URL'];

    $refresh_token_expiry = time() + 30 * 24 * 60 * 60;
    $access_token_expiry = time() + 3600;

    // Generate a new access token
    $access_token = JWT::encode(['user_id' => $user_id], $access_secret, 'HS256', $access_token_expiry);

    // Generate a refresh token
    $refresh_token = JWT::encode(['user_id' => $user_id], $refresh_secret, 'HS256', $refresh_token_expiry);

    setcookie('access_token', $access_token, $access_token_expiry, "/", "$domain");
    setcookie("refresh_token", $refresh_token, $refresh_token_expiry, "/", "$domain");
    header("Location:$URL/index2.php");
}