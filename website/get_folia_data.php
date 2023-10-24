<?php
header('Content-Type: application/json');

define('DB_HOST', 'localhost:3307');
define('DB_USERNAME', 'id21264970_esp_board');
define('DB_PASSWORD', 'Admin123!');
define('DB_NAME', 'id21264970_projektmunka');

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$mysqli) {
    die("Connection failed: " . $mysqli->error);
}

$query = "SELECT distance, moisture, humidity, temperature, lightSensor, reading_time FROM foliasator  ORDER BY ID DESC LIMIT 2";
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
?>
