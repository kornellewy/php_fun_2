<?php
        session_start();

        if (!isset($_SESSION['udanarejestracja']))
        {
            header('Location: index.php');
            exit();
        }
        else
        {
            unset($_SESSION['udanarejestracja']);
        }
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset = "utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Osadnicy - udana rejestracja</title>
</head>

<body>
    <h1>Dzieki za rejstracje</h1>
    <a href="index.php">zaloguj sie na konto</a>
</body>
</html>