<?php
    session_start();

if(!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
<?php
    echo "<p>Witaj ".$_SESSION['user'].'![<a href="logout.php">Wyloguj się!</a>]</p><br/>';
    echo "<p> Wprowadź swoje wydatki".'[<a href="wydatki.php">Wprowadź wydatki</a>]</p></br>';
    echo "<p> Zobacz tabelę swoich rozchodów".'[<a href="tabela.php">Zobacz tabelę</a>]</p></br>';
    //echo "<p><b>Drewno</b>: ".$_SESSION['drewno'];
    //echo " | <b>Zboże</b>: ".$_SESSION['zboze'];
    //echo " | <b>Kamień</b>: ".$_SESSION['kamien']."</p>";
    
    echo "<p><b>E-mail</b>: ".$_SESSION['email'];
   //echo " | <b>Dni premium</b>: ".$_SESSION['dnipremium']."</p>";
?>
    
</body>
</html>
