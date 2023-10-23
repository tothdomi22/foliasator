<?php
// Ellenőrizze, hogy a "felhasznalonev" sütikezet létezik-e
if (isset($_COOKIE["user_id"])) {
    $user_id = $_COOKIE["user_id"];
    header("Location: index2.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Regisztráció</title>
</head>
<body>
<h2>Regisztráció</h2>
<form action="register.php" method="POST">
    <label for="username">Felhasználónév:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="email">E-mail cím:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Jelszó:</label>
    <input type="password" id="password" name="password" required><br><br>
    <span class='error'>
        <?php
        if (isset($_GET["error_messagereg"])) {
            $error_messagereg = urldecode($_GET["error_messagereg"]);
            echo $error_messagereg;
        } ?></span><br><br>
    <input type="submit" value="Regisztráció">
</form>
<h2>Bejelentkezés</h2>
<form action="login.php" method="post">
    <label for="username">Felhasználónév:</label>
    <input type="text" id="username1" name="username1" required><br><br>

    <label for="password">Jelszó:</label>
    <input type="password" id="password1" name="password1" required><br><br>
    <span class='error'>
        <?php
        if (isset($_GET["error_messagelog"])) {
            $error_messagelog = urldecode($_GET["error_messagelog"]);
            echo $error_messagelog;
        } ?></span><br><br>
    <input type="submit" value="Bejelentkezés">
</form>
</body>
</html>