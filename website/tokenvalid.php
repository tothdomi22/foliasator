<?php
include('get_config_json.php');

require 'vendor/autoload.php'; // Include the JWT library

use Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$token_is_valid = 0;


if (isset($_COOKIE['access_token']) && is_string($_COOKIE['access_token'])) {
    $access_token = $_COOKIE['access_token'];
    try {
        // Verify the access token
        $decoded_access = JWT::decode($access_token, new Key($access_secret, 'HS256'));
        $token_is_valid = 1;
        // Access token is valid
        // Continue processing the request
    } catch (Exception $e) {
        // Access token is invalid
    }
} else {
    echo "Invalid or missing access token cookie.";
}

if (isset($_COOKIE['refresh_token']) && is_string($_COOKIE['refresh_token'])) {
    $refresh_token = $_COOKIE['refresh_token'];
    try {
        // Verify the refresh token
        $decoded_refresh = JWT::decode($refresh_token, new Key($refresh_secret, 'HS256'));
        $token_is_valid = 1;
        // Refresh token is valid
        // Issue a new access token and respond to the request
    } catch (Exception $e) {
        // Refresh token is invalid, the user needs to reauthenticate
    }
} else {
    echo "Invalid or missing refresh token cookie.";
}

// Continue with your code
