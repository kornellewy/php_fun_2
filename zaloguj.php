<?php
        session_start();

        if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
        {
            header('Location: index.php');
            exit();
        }
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset = "utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Osadnicy - konto</title>
</head>

<body>
    <?php

        session_start();

        require_once "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

        if ($polaczenie -> connect_error!=0) 
        {
            echo "Error: ".$polaczenie->connect_errno;
        }
        else
        {
            
            $login = $_POST['login'];
            $login = htmlentities($login, ENT_QUOTES, "UFT-8");
            $haslo = $_POST['haslo'];
            $haslo = htmlentities($haslo, ENT_QUOTES, "UFT-8");

            $sql = "SELECT * FROM uzytkownicy WHERE user = '$login' AND pass='$haslo'";

            if ($rezultat = @$polaczenie->query(
                sprintf("SELECT * FROM uzytkownicy WHERE user = '%s' AND pass='%s'",
                mysqli_real_escape_string($polaczenie,$login),
                mysqli_real_escape_string($polaczenie,$haslo)))) 
            {
                $ilu_userow = $rezultat->num_rows;
                if ($ilu_userow>0) 
                {
                    $_SESSION['zalogowany'] = true;
                    $wiersz = $rezultat->fetch_assoc();
                    $user = $wiersz['user'];
                    $_SESSION['id'] = $wiersz['id'];
                    $_SESSION['user'] = $wiersz['user'];
                    $_SESSION['email'] = $wiersz['email'];
                    $_SESSION['drewno'] = $wiersz['drewno'];
                    $_SESSION['kamien'] = $wiersz['kamien'];
                    $_SESSION['zboze'] = $wiersz['zboze'];
                    $_SESSION['dnipremium'] = $wiersz['dnipremium'];

                    unset($_SESSION['blad']);

                    $rezultat->free();
                    // przekierowanie do panelu gry
                    header('Location: gra.php');
                }
                else 
                {
                    
                    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                    header('Location: index.php');

                }
            }

            //echo $login;
            //echo $haslo;

            $polaczenie->close();

        }

    ?>
</body>
</html>