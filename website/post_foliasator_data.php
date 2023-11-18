<?php
require_once 'vendor/autoload.php';

use Configurat\ConfigurationLoader;

ConfigurationLoader::loadConfiguration();
$configuration = $_SESSION['configuration'];

// Access the configuration variables like this:
$servername = $configuration['servername'];
$dbname = $configuration['dbname'];
$username = $configuration['username'];
$password = $configuration['password'];

$api_key_value = "tPmAT5Ab3j7F9";

$api_key = $distance = $moisture = $humidity = $temperature = $lightSensor = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = TestInput($_POST["api_key"]);
    if ($api_key == $api_key_value) {
        $distance = TestInput($_POST["distance"]);
        $moisture = TestInput($_POST["moisture"]);
        $humidity = TestInput($_POST["humidity"]);
        $lightSensor = TestInput($_POST["lightSensor"]);
        $temperature = TestInput($_POST["temperature"]);

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO foliasator (distance, moisture, humidity, temperature, lightSensor)
        VALUES ('" . $distance . "', '" . $moisture . "
        ', '" . $humidity . "', '" . $temperature . "', '" . $lightSensor . "')";

        if ($conn->query($sql) === true) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Wrong API Key provided.";
    }

} else {
    echo "No data posted with HTTP POST.";
}

function testInput($data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}
