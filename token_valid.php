<?php

require 'vendor/autoload.php'; // Include the JWT library

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function verifyToken($tokens, $secrets) {
    try {
        // Az aktuális időpont lekérése
        $currentTime = time();

        // Token dekódolása
        $token = JWT::decode($tokens, new Key($secrets, 'HS256'));

        // Lejárati idő lekérése a tokenből
        $expirationTime = $token->exp;

        // Ellenőrzés, hogy a token még érvényes-e
        if ($currentTime <= $expirationTime) {
            return 1; // Token érvényes
        } else {
            return 0; // Token lejárt
        }
    } catch (Exception $e) {
        return 0; // Token érvénytelen
    }
}



