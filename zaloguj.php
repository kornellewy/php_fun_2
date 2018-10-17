<!DOCTYPE HTML>
<html>
<head>
    <meta charset = "utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Osadnicy - konto</title>
</head>

<body>
    <?php

        require_once "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

        if ($polaczenie -> connect_error!=0) 
        {
            echo "Error: ".$polaczenie->connect_errno."opis: ".$polaczenie->connection_error;
        }
        else
        {
            
            $login = $_POST['login'];
            $haslo = $_POST['haslo'];

            echo $login;
            echo $haslo;

            $polaczenie->close();

        }

    ?>
</body>
</html>