<?php
    session_start();

if((!isset($_SESSION['daneprawidlowe'])))
{
    header('Location: wydatki.php');
    exit();
}
   else{
       unset($_SESSION['daneprawidlowe']);
   }

//usuwanie zmiennych pamietajacych dane
if(isset($_SESSION['fr_data']))unset($_SESSION['fr_data']);
if(isset($_SESSION['fr_nazwa']))unset($_SESSION['fr_nazwa']);
if(isset($_SESSION['fr_wartosc']))unset($_SESSION['fr_wartosc']);
if(isset($_SESSION['fr_kategoria']))unset($_SESSION['fr_kategoria']);
if(isset($_SESSION['fr_regulamin']))unset($_SESSION['fr_regulamin']);

//usuwanie błędów rejestracji
if(isset($_SESSION['e_nazwa']))unset($_SESSION['e_nazwa']);
if(isset($_SESSION['e_wartosc']))unset($_SESSION['e_wartosc']);
if(isset($_SESSION['e_regulamin']))unset($_SESSION['e_regulamin']);
if(isset($_SESSION['e_bot']))unset($_SESSION['e_bot']);
?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menedżer finansów</title>
</head>

<body>
    Dane wprowadzono do bazy Twoich wydatków!
    <br/><br/>
    
    <a href="api.php">Powrót do menu głównego!</a>
    <br /><br />
</body>
</html>
