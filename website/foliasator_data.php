<!DOCTYPE html>
<html lang="hu">

<head>
  <title>
    Foliasatordata
  </title>
</head>

<body>
  <?php


  use Configurat\ConfigurationLoader;

  ConfigurationLoader::loadConfiguration();
  $configuration = $_SESSION['configuration'];

  // Access the configuration variables like this:
  $servername = $configuration['servername'];
  $dbname = $configuration['dbname'];
  $username = $configuration['username'];
  $password = $configuration['password'];

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT id, distance, moisture, humidity, temperature, lightSensor, reading_time
  FROM foliasator ORDER BY id DESC";

  echo '<table cellspacing="5" cellpadding="5">
      <tr>
        <td>ID</td>
        <td>Distance</td>
        <td>Moisture</td>
        <td>Humidity</td>
        <td>Temperature</td>
        <td>Light Sensor</td>
        <td>Timestamp</td>
      </tr></table>';

  if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
      $row_id = $row["id"];
      $row_distance = $row["distance"];
      $row_moisture = $row["moisture"];
      $row_humidity = $row["humidity"];
      $row_temperature = $row["temperature"];
      $row_lightSensor = $row["lightSensor"];
      $row_reading_time = $row["reading_time"];


      echo '<tr>
                <td>' . $row_id . '</td>
                <td>' . $row_distance . '</td>
                <td>' . $row_moisture . '</td>
                <td>' . $row_humidity . '</td>
                <td>' . $row_temperature . '</td>
                <td>' . $row_lightSensor . '</td>
                <td>' . $row_reading_time . '</td>
              </tr>';
    }
    $result->free();
  }

  $conn->close();
  ?>

</body>

</html>