<?php
    session_start();

    if(!isset($_SESSION['zalogowany']))
    {
        header('Location: index.php');
        exit();
    }

    if(isset($_POST['nazwa']))
    {
        $is_OK=true;
        
        //poprawność daty
        $data=$_POST['data'];
        
        //poprawność nazwy
        $nazwa=$_POST['nazwa'];
        
        if(strlen($nazwa)>50)
        {
            $is_OK=false;
            $_SESSION['e_nazwa']="Wprowadzony tekst jest za długi (max 50 znaków!)";
        }
        
        //poprawność wartości
        $wartosc1=$_POST['wartosc'];
        if(!is_numeric($wartosc1))
        {
            $is_OK=false;
            $_SESSION['e_wartosc']="Wartość zakupu musi być liczbą!";
        }        
        $wartosc = round($wartosc1,2);
        
        
        $kategoria=$_POST['kategoria'];
        
        //checkbox regulamin
        if(!isset($_POST['regulamin']))
        {
            $is_OK=false;
            $_SESSION['e_regulamin']="Zaakceptuj regulamin!";
        }
        
        //zapamietaj wprowadzone dane
        $_SESSION['fr_data'] = $data;
        $_SESSION['fr_nazwa'] = $nazwa;
        $_SESSION['fr_wartosc'] = $wartosc;
        $_SESSION['fr_kategoria'] = $kategoria;
        if(isset($_POST['regulamin']))$_SESSION['fr_regulamin']=true;
        
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        try{
            $polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
            if ($polaczenie->connect_errno!=0){
                throw new Exception(mysql_connect_errno());
            }
            else{
                
                if($is_OK==true)
                    {
                    //walidacja zakończona pomyślnie
                    $user = $_SESSION['user'];
                    $result = $polaczenie->query("SELECT*FROM uzytkownicy WHERE user='".$user."'");
                    $row = $result->fetch_assoc();
                    $id_uzytkownika = $row['id'];
                    if($polaczenie->query("INSERT INTO wydatki VALUES (NULL,'$id_uzytkownika','$data','$nazwa','$wartosc','$kategoria')"))
                        {
                            $_SESSION['daneprawidlowe']=true;
                            header('Location: sukces.php');
                        }
                    else
                    {
                        throw new Exception($polaczenie->error);
                    }  
                }
                
                $polaczenie->close();
            }
            
        }catch(Exception $e){
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie.</span>';
            echo '<br/>Informacja deweloperska: '.$e;
        }
        
        
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
    echo "<p> Wpisz wszystkie potrzebne dane i zatwierdź przyciskiem pod formularzem.</p>";
?>
    
    <form method="post">
    
        Data: <br/><input type="date" value="<?php
            if(isset($_SESSION['fr_data']))
            {
                echo $_SESSION['fr_data'];
                unset($_SESSION['fr_data']);
            }
            ?>" name="data"/><br/>
       <?php        
            /*if(isset($_SESSION['e_nick']))
            {
                echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                unset($_SESSION['e_nick']);
            } */       
        ?>
        
        Na co wydano pieniądze?: <br/><input type="text" value="<?php
            if(isset($_SESSION['fr_nazwa']))
            {
                echo $_SESSION['fr_nazwa'];
                unset($_SESSION['fr_nazwa']);
            }
            ?>" name="nazwa"/><br/>
        <?php        
            if(isset($_SESSION['e_nazwa']))
            {
                echo '<div class="error">'.$_SESSION['e_nazwa'].'</div>';
                unset($_SESSION['e_nazwa']);
            }        
        ?>
        
        Wartość: <br/><input type="text" value="<?php
            if(isset($_SESSION['fr_wartosc']))
            {
                echo $_SESSION['fr_wartosc'];
                unset($_SESSION['fr_wartosc']);
            }
            ?>" name="wartosc"/><br/>
        <?php        
            if(isset($_SESSION['e_wartosc']))
            {
                echo '<div class="error">'.$_SESSION['e_wartosc'].'</div>';
                unset($_SESSION['e_wartosc']);
            }      
        ?>
        
        Kategoria: <br/><select name="kategoria">
            <option value="zywnosc">żywność</option>
            <option value="higiena">higiena</option>
            <option value="bilety">bilety</option>
            <option value="samochod">samochód</option>
            <option value="mieszkanie">mieszkanie</option>
            <option value="rekreacja">rekreacja</option>
            <option value="prezenty">prezenty</option>
            <option value="ubrania">ubrania</option>
            <option value="celeCharytatwne">cele charytatywne</option>
            <option value="paliwo">paliwo</option>
            <option value="rachunki">rachunki</option>
            <option value="inne">inne</option>
            </select><br/>
        <label>
        <input type="checkbox" name="regulamin" <?php
            if(isset($_SESSION['fr_regulamin']))
            {
                echo "checked";
                unset($_SESSION['fr_regulamin']);
            }
            ?>/>Akceptuję regulamin
        </label>
        <?php        
            if(isset($_SESSION['e_regulamin']))
            {
                echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                unset($_SESSION['e_regulamin']);
            }        
        ?>
        <br/>
        <input type="submit" value="Zatwierdź wydatek"/>
        
    </form>
    
</body>
</html>
