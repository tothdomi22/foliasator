<?php
require_once 'vendor/autoload.php';

use Configurat\ConfigurationLoader;

ConfigurationLoader::loadConfiguration();
$configuration = $_SESSION['configuration'];

// Access the configuration variables like this:
$url = $configuration['URL'];
$domain = $configuration['domain'];
$access_secret = $configuration['access_secret'];
$refresh_secret = $configuration['refresh_secret'];

$token_is_valid = 0;

use Token\TokenVerifier;

if (isset($_COOKIE['access_token']) && is_string($_COOKIE['access_token'])) {
    $token_is_valid = TokenVerifier::verifyToken($_COOKIE['access_token'], $access_secret);
}
if (isset($_COOKIE['access_token']) && is_string($_COOKIE['access_token'])) {
    $token_is_valid = TokenVerifier::verifyToken($_COOKIE['refresh_token'], $refresh_secret);
}
// if the jwt token is valid this change the page to $URL/index.php

if ($token_is_valid == 0) {
    header("Location:$url/index.php");
    exit(); // if not exit the php
}
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foliasator automatizalas</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container">

        <div id="title" class="title">
            <h5>Fóliasátor automatizálás</h5>
        </div>
        <!--sliders-->
        <div class="sliders">
            <div class="sliderbox1"></div>
            <div class="sliderbox2"></div>
            <div class="moisture_slider_container">
                <h6>Watering%
                </h6>
                <label for="moisture_slider"></label><input type="range" min="1" max="100" value="50"
                    class="slider_moisture" id="moisture_slider">
                <p> <span id="moisture_value"></span>%</p>
            </div>
            <div class="watering_slider_container">
                <h6>Duration</h6>
                <label for="duration_slider"></label><input type="range" min="1" max="60" value="3"
                    class="slider_watering" id="duration_slider">
                <p> <span id="duration_value"></span>s</p>
            </div>
        </div>
        <div id="temp" class="temp" onclick="changecolor(this)">
            <h5 id="temptext"><span class="material-symbols-outlined">
                    device_thermostat
                </span>Temp</h5>
            <p id="tempvalue">-</p>
        </div>

        <div id="hum" class="hum" onclick="changecolor(this)">
            <h5><span class="material-symbols-outlined">
                    humidity_percentage
                </span>Hum</h5>
            <p id="humvalue">-</p>
        </div>

        <div id="moist" class="moist" onclick="changecolor(this)">
            <h5><span class="material-symbols-outlined">
                    potted_plant
                </span>Moist</h5>
            <p id="moistvalue">-</p>
        </div>

        <div id="water" class="water" onclick="changecolor(this)">
            <h5><span class="material-symbols-outlined">
                    water_full
                </span>W. lvl</h5>
            <p id="watervalue">-</p>
        </div>

        <div id="light" class="light" onclick="changecolor(this)">
            <h5><span class="material-symbols-outlined">
                    light_mode
                </span>Light</h5>
            <p id="lightvalue">-</p>
        </div>

        <div class="temp_graph" id="temp_graph"><canvas id="temp_chart"></canvas></div>
        <div class="hum_graph" id="hum_graph"><canvas id="hum_chart"></canvas></div>
        <div class="moist_graph" id="moist_graph"><canvas id="moist_chart"></canvas></div>
        <div class="water_graph" id="water_graph"><canvas id="water_chart"></canvas></div>
        <div class="light_graph" id="light_graph"><canvas id="light_chart"></canvas></div>

        <div class="last_update">
            <h5>Last update</h5>
            <p id="updatevalue">-</p>
        </div>


        <div id="logout_container">
            <a href="logout.php" id="logout_button" class="logout_button">
                <h6>Logout</h6>
            </a>
        </div>
        <!--button-->
        <div class="button_container">
            <div class="buttonbox"></div>
            <button class="button" onclick="changeColor_watering()">MANUAL WATERING</button>
            <p class="watering_progress">Watering status</p>
            <div class="light_button" id="light_button"></div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>
