<?php
        session_start();

        if (isset($_POST['email'])) 
        {   
            // walidacja danych, tutaj zakladamy tak
            $wszystko_ok = true;
            // spr pprawnosc nica
            $nick = $_POST['nick'];
            // spr dlugos nicka
            if ((strlen($nick)<3) || (strlen($nick)>20)) {
                $wszystko_ok = false;
                $_SESSION['e_nick']="nick min 3 or max 20";
            }

            // czy nick to liczby i cyfry
            if (ctype_alnum($nick)==false) 
            {
                $wszystko_ok = false;
                $_SESSION['e_nick'] = " nick tylko z liter i cyfr";
            }

            // spr pprawnosc email
            $email = $_POST['email'];
            $email_safe = filter_var($email, FILTER_SANITIZE_EMAIL);

            if ((filter_var($email_safe, FILTER_VALIDATE_EMAIL)==false)||($email!=$email_safe)) 
            {
                $wszystko_ok = false;
                $_SESSION['e_email'] = " email tylko z liter i cyfr";
            }

            // spr pprawnosc hasel
            $haslo = $_POST['haslo'];
            $haslo_potwierdzenie = $_POST['haslo_potwierdzenie'];

            // spr dlugos hasla
            if ((strlen($haslo)<8) || (strlen($haslo)>20)) {
                $wszystko_ok = false;
                $_SESSION['e_haslo']="haslo min 8 or max 20";
            }
            // spr czy haslo jest takie same jak haslo_
            if ($haslo!=$haslo_potwierdzenie) {
                $wszystko_ok = false;
                $_SESSION['e_haslo']="podane hasła nie sa identyczne";
            }

            $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
            // spr czy zanzaczono regulamin
            if (!isset($_POST['regulamin'])) {
                $wszystko_ok = false;
                $_SESSION['e_regulamin']="prosze potwierdzic regulamin";
            }

            //spr bot
            $sekret = "6LcLJXYUAAAAANpLVE95TRjifIkK6UuTCtTkHoYI";
            // get json form gooogle
            $sprawdzenie = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
            // decode form json
            $odpowiedz = json_decode($sprawdzenie);

            if ($odpowiedz->success==false) 
            {
                $wszystko_ok = false;
                $_SESSION['e_bot']="huja jestes botem";
            }

            require_once "connect.php";
            mysqli_report(MYSQLI_REPORT_STRICT);

            try
            {
                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                if ($polaczenie -> connect_error!=0) 
                {
                    throw new Exception(mysqli_connect_errno());
                }
                else
                {
                    //spr czy email juz byl uzyty
                    $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");

                    if (!$rezultat) throw new Exception($polaczenie->error);

                    $ile_takich_maili = $rezultat->num_rows;
                    if ($ile_takich_maili>0) {
                        $wszystko_ok = false;
                        $_SESSION['e_email']="email juz uzyty";
                    }

                    //spr czy nick juz byl uzyty
                    $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$nick'");

                    if (!$rezultat) throw new Exception($polaczenie->error);

                    $ile_takich_maili = $rezultat->num_rows;
                    if ($ile_takich_maili>0) {
                        $wszystko_ok = false;
                        $_SESSION['e_nick']="nick juz uzyty";
                    }

                    if ($wszystko_ok==true) 
                    {
                        if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email',100,100,100,14)")) {
                            $_SESSION['udanarejestracja'] = true;
                            header('Location: witamy.php');
                        }
                        else
                        {
                            throw new Exception($polaczenie->error);
                        }
                    }
                    $polaczenie->close();
                }
            }
            catch(Exception $e)
            {
                echo "bład serwera ";
                //echo $e;
            }
        }
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset = "utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Osadnicy - zaloz darmowe konto!</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>

    <form method="post">
        nick: <br><input type="text" name="nick"> <br/>
        <?php
            if (isset($_SESSION['e_nick']))
            {
                echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                unset($_SESSION['e_nick']);
            }
        ?>
        email: <br><input type="text" name="email"> <br/>
        <?php
            if (isset($_SESSION['e_email']))
            {
                echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                unset($_SESSION['e_email']);
            }
        ?>
        haslo: <br><input type="text" name="haslo"> <br/>
        haslo potwierdzenie: <br><input type="text" name="haslo_potwierdzenie"> <br/>
        <?php
            if (isset($_SESSION['e_haslo']))
            {
                echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                unset($_SESSION['e_haslo']);
            }
        ?>
        <label>
            <input type="checkbox" name="regulamin"> Akceptuje regulamin
        </label>
        <?php
            if (isset($_SESSION['e_regulamin']))
            {
                echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                unset($_SESSION['e_regulamin']);
            }
        ?>
        <div class="g-recaptcha" data-sitekey="6LcLJXYUAAAAAAklhMBzS7w9nnUg2ZE_vKAQTfkT"></div>
        <?php
            if (isset($_SESSION['e_bot']))
            {
                echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                unset($_SESSION['e_bot']);
            }
        ?>
        <br><input type="submit" value="Zarejestruj się"> <br/>
    </form>

</body>
</html>