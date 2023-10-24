<?php

$servername = "localhost:3307";

$dbname = "id21264970_projektmunka";
$username = "id21264970_esp_board";
$password = "Admin123!";

$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $distance = $moisture = $humidity = $temperature = $lightSensor = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $distance = test_input($_POST["distance"]);
        $moisture = test_input($_POST["moisture"]);
        $humidity = test_input($_POST["humidity"]);
        $lightSensor = test_input($_POST["lightSensor"]);
        $temperature = test_input($_POST["temperature"]);
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO foliasator (distance, moisture, humidity, temperature, lightSensor)
        VALUES ('" . $distance . "', '" . $moisture . "', '" . $humidity . "', '" . $temperature . "', '" . $lightSensor . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
