<?php
        session_start();

        if (isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==true))
        {
            header('Location: gra.php');
            exit();
        }
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset = "utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Osadnicy</title>
</head>

<body>
    <form action="zaloguj.php" method="post">
        login: <br><input type="text" name = "login"><br/>
        haslo: <br><input type="password" name = "haslo"><br/>
        <input type="submit" value="zaloguj sie">
    </form>
    <?php
        if (isset($_SESSION['blad'])) 
        {
            echo $_SESSION['blad'];
        }
    ?>
</body>
</html>