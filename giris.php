<?php
if(session_id() == ''){
    session_start();
}
if (isset($_SESSION['giris'])){
    echo'<script type="text/javascript">
    document.location.href = "/forum/anasayfa.php";
    </script>'; 
}
if(isset($_POST['gonderGiris'])){
        $vtabani = new mysqli("localhost", "root", "", "forum");
        $kullaniciAdi = $vtabani-> real_escape_string($_POST['kAd']);
        $sifre = $vtabani-> real_escape_string($_POST['sifre']);
        $sorgu = $vtabani->query("SELECT * from accounts WHERE username = '$kullaniciAdi' and pass = '$sifre'");
        if ($sorgu->num_rows<=0){
            $error = "Yanlış kullanıcı adı veya şifre.";
            $vtabani->close();
            }
        else{
            $sorgu = $vtabani->query("SELECT perm from accounts WHERE username = '$kullaniciAdi' and pass = '$sifre'");
            $_SESSION['giris'] = true;
            $_SESSION["login_time_stamp"] = time();  
            $_SESSION['isim'] = $kullaniciAdi;
            $_SESSION['yetki'] = $sorgu;
            $vtabani->close();
            echo'<script type="text/javascript">
            document.location.href = "/forum/anasayfa.php";
            </script>';
        }
    }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/forum/kayitol.css?v=1.1">
    <title>Forum - Giriş Yap!</title>
</head>
<body>
    <div class="blur"></div>
    <div class="container">
        <form class="register" method="POST">
            <input type="text" placeholder="Kullanıcı adını gir" name="kAd"><br>
            <input type="password" placeholder="Şifreni gir" name="sifre"><br>
            <input type="submit" value="Giriş Yap" name="gonderGiris" class="submit">
            <p>Hesabın yok mu?</p><a style="color: #2667b3;" href="kayitol.php">Kayıt Ol!</a>
        </form>
        <?php 
        if(!empty($error))
        {
            echo '<div class="hata" id="hata"><p style="color:red;">'.$error.'</p></div>
            <div id="hataNerede" style="display: none;">giris</div>';
        } ?>
    </div>
    
</body>
</html>

