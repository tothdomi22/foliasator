<!DOCTYPE html>
<html lang="hu">

<head>
    <title>Elfelejtetted a jelszavad?</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #0074cc;
            /* Kék háttérszín */
            color: white;
            padding: 10px;
        }

        .reset-password-body {
            text-align: center;
            margin: 20px auto;
            max-width: 400px;
        }

        .reset-password-body label {
            display: block;
            margin-bottom: 10px;
        }

        .reset-password-body input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .reset-password-body input[type="submit"] {
            background-color: #0074cc;
            /* Kék színű gomb */
            color: white;
            padding: 10px 20px;
            border: none;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Állítsd vissza a jelszavad</h1>
    </div>
    <div class="reset-password-body">
        <form action="email_send.php" method="POST">
            <label for="email">
                Adja meg felhasználói fiókjához hozzáadott e-mail címét, és küldünk egy jelszó-visszaállítási emailt.
            </label><br><br>
            <input type="email" name="email" id="email" placeholder="Adja meg az email címet" required><br><br>
            <span class='error'>
                <?php
                if (isset($_GET["error_message"])) {
                    $error_message = urldecode($_GET["error_message"]);
                    echo $error_message;
                }
                ?>
            </span><br><br>
            <input type="submit" value="Jelszó-visszaállítási e-mail küldése">
        </form>
    </div>
</body>

</html>