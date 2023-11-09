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

    $access_token_data = array(
        'user_id' => $user_id, // Példa adat: felhasználói azonosító
        'exp' => $access_token_expiry, // A lejárati idő beállítása 1 óra múlva
    );

    $refresh_token_token_data = array(
        'user_id' => $user_id, // Példa adat: felhasználói azonosító
        'exp' => $refresh_token_expiry, // A lejárati idő beállítása 1 óra múlva
    );


    // Generate a new access token
    $access_token = JWT::encode($access_token_data, $access_secret, 'HS256', $access_token_expiry);

    // Generate a refresh token
    $refresh_token = JWT::encode($refresh_token_token_data, $refresh_secret, 'HS256', $refresh_token_expiry);

    setcookie('access_token', $access_token, $access_token_expiry, "/", "$domain");
    setcookie("refresh_token", $refresh_token, $refresh_token_expiry, "/", "$domain");
    header("Location:$URL/index2.php");
}