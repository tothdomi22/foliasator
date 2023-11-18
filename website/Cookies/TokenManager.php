<?php

namespace Cookies;

require_once 'vendor/autoload.php'; // Include the JWT library

use Firebase\JWT\JWT;
use Configurat\ConfigurationLoader;

// Assuming that the session has been started before this point
session_start();

ConfigurationLoader::loadConfiguration();

class TokenManager
{
    public static function setCookies($user_id)
    {
        // Get the configuration
        $configuration = $_SESSION['configuration'];

        // Access the configuration variables like this:
        $access_secret = $configuration['access_secret'];
        $refresh_secret = $configuration['refresh_secret'];
        $domain = $configuration['domain'];
        $url = $configuration['URL'];

        $refresh_token_expiry = time() + 30 * 24 * 60 * 60;
        $access_token_expiry = time() + 3600;

        $access_token_data = array(
            'user_id' => $user_id,
            'exp' => $access_token_expiry,
        );

        $refresh_token_token_data = array(
            'user_id' => $user_id,
            'exp' => $refresh_token_expiry,
        );

        // Generate a new access token
        $access_token = JWT::encode($access_token_data, $access_secret, 'HS256', $access_token_expiry);

        // Generate a refresh token
        $refresh_token = JWT::encode($refresh_token_token_data, $refresh_secret, 'HS256', $refresh_token_expiry);

        setcookie('access_token', $access_token, $access_token_expiry, "/", "$domain");
        setcookie("refresh_token", $refresh_token, $refresh_token_expiry, "/", "$domain");
        header("Location:$url/index2.php");
    }
}


