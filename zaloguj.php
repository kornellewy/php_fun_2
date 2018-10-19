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
            echo "Error: ".$polaczenie->connect_errno;
        }
        else
        {
            
            $login = $_POST['login'];
            $haslo = $_POST['haslo'];

            $sql = "SELECT * FROM uzytkownicy WHERE user = '$login' AND pass='$haslo'";

            if ($rezultat = @$polaczenie->query($sql)) 
            {
                $ilu_userow = $rezultat->num_rows;
                if ($ilu_userow>0) 
                {
                    $wiersz = $rezultat->fetch_assoc();
                    $user = $wiersz['user'];
                    // przekierowanie do panelu gry
                    header('Location: gra.php');
                    $rezultat->free();
                }
                else 
                {
                    
                }
            }

            //echo $login;
            //echo $haslo;

            //$polaczenie->close();

        }

    ?>
</body>
</html>