<?php
/*
 * this php reads the config file and converts the data in it into a variable.
 */


namespace Configurat;

class ConfigurationLoader
{
    public static function loadConfiguration()
    {
        if (!isset($_SESSION['configuration'])) {
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
    }
}
