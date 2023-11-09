<?php
/*
 * this php reads the config file and converts the data in it into a variable.
 */


if (!isset($_SESSION['configuration'])) {
    // If configuration is not already stored in the session, load it from the JSON file
    $configFile = 'config.json';

    if (file_exists($configFile) && is_readable($configFile)) {
        $config = json_decode(file_get_contents($configFile), true);

        if ($config !== null) {
            $_SESSION['configuration'] = $config;
        } else {
            die('Error decoding the configuration file.');
        }
    } else {
        die('The configuration file is not found or not readable.');
    }
}
