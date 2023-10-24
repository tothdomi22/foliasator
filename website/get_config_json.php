<?php
$configFile = 'config.json';
if (file_exists($configFile)) {
    $config = json_decode(file_get_contents($configFile), true);

    // Ellenőrizd, hogy a fájl sikeresen beolvasható-e
    if ($config === null) {
        die('Hiba a konfigurációs fájl beolvasása közben.');
    }
} else {
    die('A konfigurációs fájl nem található.');
}
$access_secret = $config['access_secret'];
$refresh_secret = $config['refresh_secret'];