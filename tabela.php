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
    
    require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        try{
            $polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
            if ($polaczenie->connect_errno!=0){
                throw new Exception(mysql_connect_errno());
            }
            else{
                $user = $_SESSION['user'];
                
                $result1 = $polaczenie->query("SELECT*FROM uzytkownicy WHERE user='".$user."'");
                $row1 = $result1->fetch_assoc();
                $id_uzytkownika = $row1['id'];
                
                $result2 = $polaczenie->query("SELECT count(1) FROM wydatki WHERE id_uzytkownika='".$id_uzytkownika."'");
                $row2 = $result2->fetch_assoc();
                $rows = $row2['count(1)'];
                
                echo "<p>Aktualnie wprowadziłeś ".$rows." wydatków</p>";
                echo "<table border=2 cellpadding=5 cellspacing=2 bgcolor='#99CC33'><tr><th>Data</th><th>Nazwa</th><th>Wartość</th><th>Kategoria</th></tr>";
                $result3 = $polaczenie->query("SELECT data, nazwa, ROUND(wartosc, 2) AS wartosc_z, kategoria FROM wydatki WHERE id_uzytkownika='".$id_uzytkownika."'");
                while($array = $result3->fetch_assoc()){
                    echo "<tr><td>{$array['data']}</td><td>{$array['nazwa']}</td><td align='right'>{$array['wartosc_z']}</td><td>{$array['kategoria']}</td></tr>";
                }
                echo "</table>";
                
                $polaczenie->close();
            }
            
        }catch(Exception $e){
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności.</span>';
            echo '<br/>Informacja deweloperska: '.$e;
        }
?>
    
    
    <br/><br/>
    
    <a href="api.php">Powrót do menu głównego!</a>
    <br /><br />
        
    
    
</body>
</html>
