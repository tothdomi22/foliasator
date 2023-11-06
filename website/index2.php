<?php

include('get_config_json.php');
$configuration = $_SESSION['configuration'];

// Access the configuration variables like this:
$URL = $configuration['URL'];
$domain = $configuration['domain'];

$token_is_valid = 0;

include('token_valid.php');

// if the jwt token is valid this change the page to $URL/index.php

if ($token_is_valid==0) {
    header("Location:$URL/index.php");
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
</head>
<body>
    <div class="container">

        <div id="title" class="title">
            <h2>Fóliasátor automatizálás</h2>
        </div>

        <div class="last_update">
            <h2>Last update</h2>
            <p id="updatevalue">-</p>
        </div>

        <div id= "temp" class="temp" onclick="changecolor(this)">
            <h2 id="temptext"><span class="material-symbols-outlined">
device_thermostat
                </span>Temp</h2>
            <p id="tempvalue">-</p>
        </div>

        <div id="hum" class="hum" onclick="changecolor(this)">
            <h2><span class="material-symbols-outlined">
humidity_percentage
                </span>Hum</h2>
            <p id="humvalue">-</p>
        </div>

        <div id="moist" class="moist" onclick="changecolor(this)">
            <h2><span class="material-symbols-outlined">
potted_plant
                </span>Moist</h2>
            <p id="moistvalue">-</p>
        </div>

        <div id="water" class="water" onclick="changecolor(this)">
            <h2><span class="material-symbols-outlined">
water_full
                </span>W. lvl</h2>
            <p id="watervalue">-</p>
        </div>

        <div id="light" class="light" onclick="changecolor(this)">
            <h2><span class="material-symbols-outlined">
light_mode
                </span>Light</h2>
            <p id="lightvalue">-</p>
        </div>

        <div class="temp_graph">
            <canvas id="myChart"></canvas>
        </div>
        <div class="hum_graph"></div>
        <div class="moist_graph"></div>
        <div class="water_graph"></div>
        <div class="light_graph"></div>

    </div>
    <script src="script.js"></script>
</body>
</html>