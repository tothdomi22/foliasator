<?php
/*
 * This php get the date from the sql and convert into json.
 */
include('get_config_json.php');
$configuration = $_SESSION['configuration'];

// Access the configuration variables like this:
$servername = $configuration['servername'];
$dbname = $configuration['dbname'];
$username = $configuration['username'];
$password = $configuration['password'];

header('Content-Type: application/json');

$mysqli = new mysqli($servername,$username ,$password ,$dbname);

$query = "SELECT distance, moisture, humidity, temperature, lightSensor, reading_time FROM foliasator  ORDER BY ID";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {

    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $mysqli->close();

    if (!empty($data)) {
        $json_data = json_encode($data);
    } else {
        $json_data = json_encode([]);
    }


    echo $json_data;
} else {

    echo json_encode([]);
}
