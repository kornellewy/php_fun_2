<?php
        session_start();
        if (!isset($_SESSION['zalogowany']))
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
    <title>Osadnicy - gra</title>
</head>

<body>

    <?php
    
        echo "<p>Witaj: ".$_SESSION['user'].'[<a href="logout.php">wyloguj sie</a>]</p>';
        echo "<br><br/>";
        echo "<p>drewno: ".$_SESSION['drewno']."</p>";
        echo "<br><br/>";
        echo "<p>kamien ".$_SESSION['kamien']."</p>";
        echo "<br><br/>";
        echo "<p>zboze ".$_SESSION['zboze']."</p>";
        echo "<br><br/>";
        echo "<p>email: ".$_SESSION['email']."</p>";
        echo "<br><br/>";
        echo "<p>dni premium: ".$_SESSION['dnipremium']."</p>";
        echo "<br><br/>";
    ?>

</body>
</html>