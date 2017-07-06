<?php
    session_start();

if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
{
    header('Location: api.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osadnicy - online game</title>
</head>

<body>
    Przejmij kontrolę nad swoimi finansami!<br/><br/>
    
    <a href="rejestracja.php">Rejestracja - załóż darmowe konto!</a>
    <br /><br />
    
    <form action="zaloguj.php" method="post">
        Login: <br/><input type="text" name="login"/><br/>
        Hasło: <br/><input type="password" name="password"/><br>
        <input type="submit" value="Zaloguj się"/>
    </form>
    
<?php
  if(isset($_SESSION['blad']))echo $_SESSION['blad'];  
?>
    
</body>
</html>
