<?php
$servername = "localhost";

$dbname = "id21264970_projektmunka";
$username = "id21264970_esp_board";
$password = "Admin123!";
$password1 = $_POST['password1'];
$user = $_POST['username1'];
$login = 0;
$storedPasswordHash = "";

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT password_hash FROM users WHERE username = '$user'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $storedPasswordHash = $row["password_hash"];
    }
} else {
    // Sikertelen bejelentkezés
    #echo "Hibás jelszó vagy felhasználónév!";
    $error_messagelog = "Hibás felhasználónév vagy jelszó!";
    //echo $error_message;
    header("Location: index.php?error_messagelog=" . urlencode($error_messagelog));
    exit;
}

if (password_verify($password1 , $storedPasswordHash)) {
    // Sikeres bejelentkezés
    echo "Sikeres bejelentkezés!";
    $login = 1;
} else {
    // Sikertelen bejelentkezés
    $error_messagelog = "Hibás felhasználónév vagy jelszó!";
    //header("Location: index.php");
    header("Location: index.php?error_messagelog=" . urlencode($error_messagelog));
    exit;
}


$conn->close();
if ($login == 1) {
    $user_id = uniqid(); // Az egyedi felhasználó azonosító generálása
    setcookie("user_id", $user_id, time() + 3600, "/");
    header("Location: index2.php");
}
else{
    header("Location: index.php");
}
exit;
