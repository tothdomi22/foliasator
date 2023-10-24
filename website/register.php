<?php
$servername = "localhost:3307";

$dbname = "id21264970_projektmunka";
$username = "id21264970_esp_board";
$password = "Admin123!";

#$password1 = 'Danika30';
$password1 = $_POST['password'];
#$user = 'nagysas';
$user = $_POST['username'];
#$email = 'hornyada@gmail.com';
$email = $_POST['email'];
$login = 0;

$usernamenotexist = 1;

// Ellenőrizze, hogy a jelszó megfelel-e a kritériumoknak
if (strlen($password1) < 8) {
    $error_messagereg = "A jelszónak legalább 8 karakter hosszúnak kell lennie.";
} elseif (!preg_match('/[A-Z]/', $password1)) {
    $error_messagereg = "A jelszónak tartalmaznia kell legalább egy nagybetűt.";
} elseif (!preg_match('/\d/', $password1)) {
    $error_messagereg = "A jelszónak tartalmaznia kell legalább egy számot.";
} elseif (!preg_match('/[!@#\$%\^&\*\(\)_\+=\-{}[\]:;"\'<>,.?]/', $password1)) {
    $error_messagereg = "A jelszónak tartalmaznia kell legalább egy speciális karaktert.";
    }
// Ha a jelszó nem felel meg a kritériumoknak, visszatérünk a regisztrációs oldalra hibaüzenettel
    if (isset($error_messagereg)) {
        header("Location: index.php?error_messagereg=" . urlencode($error_messagereg));
        exit;
    }


$passwordHash = password_hash($password1, PASSWORD_DEFAULT);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username FROM users WHERE username = '$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // A felhasználónév már létezik az adatbázisban
    echo "A felhasználónév már létezik.";
    $error_messagereg = "A felhasználónév már létezik.";
    //header("Location: index.php");
    header("Location: index.php?error_messagereg=" . urlencode($error_messagereg));
    exit;
} else {
    // A felhasználónév még nem létezik, így hozzáadható az adatbázishoz
    $sql = "INSERT INTO users (username, email, password_hash) 
            VALUES ('$user', '$email', '$passwordHash')";

    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$sql = "SELECT password_hash FROM users WHERE username = '$user'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $storedPasswordHash = $row["password_hash"];
    }
}
echo $storedPasswordHash;
if (password_verify($password1 , $storedPasswordHash)) {
    // Sikeres bejelentkezés
    echo "Sikeres bejelentkezés!";
    $login = 1;
} else {
    // Sikertelen bejelentkezés
    echo "Hibás jelszó vagy felhasználónév!";
}

#$sql = "DELETE FROM users WHERE username = 'nagysas1'";
#if ($conn->query($sql) === TRUE) {
#    echo "New record created successfully";
#} else {
#    echo "Error: " . $sql . "<br>" . $conn->error;
#}
$conn->close();
if ($login == 1) {
    $user_id = uniqid(); // Az egyedi felhasználó azonosító generálása
    setcookie("user_id", $user_id, time() + 3600, "/");
    header("Location: index2.php");
}
exit;
