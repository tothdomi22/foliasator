<?php
namespace Token;

require_once 'vendor/autoload.php'; // Include the JWT library

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenVerifier
{
    public static function verifyToken($tokens, $secrets)
    {
        // Get current time
        $currentTime = time();

        // Token dekoding
        $token = JWT::decode($tokens, new Key($secrets, 'HS256'));

        // Get expiration time
        $expirationTime = $token->exp;

        // Check if token is valid
        if ($currentTime <= $expirationTime) {
            return 1; // Token valid
        } else {
            return 0; // Token invalid
        }
    }
}



