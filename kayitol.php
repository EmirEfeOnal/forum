<?php
if(session_id() == ''){
    session_start();
}
if (isset($_SESSION['giris'])){
    echo'<script type="text/javascript">
    document.location.href = "/forum/anasayfa.php";
    </script>'; 
}
if(isset($_POST['gonderKayit'])){
    if(!empty($_POST['email']) && !empty($_POST['sifre']) && !empty($_POST['kAd'])){
        $kAd = $_POST['kAd'];
        $email = $_POST['email'];
        if(strlen($_POST['kAd']) > 3){
            if(strlen($_POST['sifre']) > 7){
                $vtabani = new mysqli("localhost", "root", "", "forum");
                $kullaniciAdi = $vtabani-> real_escape_string($_POST['kAd']);
                $eMailGiris = $vtabani-> real_escape_string($_POST['email']);
                $sifre = $vtabani-> real_escape_string($_POST['sifre']);
                $sorgu = $vtabani->query("SELECT * from accounts WHERE username = '$kullaniciAdi' or email = '$eMailGiris'");
                if ($sorgu->num_rows<=0){
                    $hazirla = $vtabani->prepare('INSERT INTO accounts(email, pass, username, perm) VALUES (?,?,?,1)');
                    if(!$hazirla)
                        die("Kayıt işleminde hata oluştu.");
                    else{
                        $hazirla->bind_param('sss', $eMailGiris, $sifre, $kullaniciAdi);
                        $hazirla->execute();
                        $vtabani->close();
                    }
                }
                else{
                    $error = "Bu kullanıcı adı veya e posta adresi zaten kayıtlı.";
                    $vtabani->close();
                }
            }
            else{
                $error = "Şifreniz en az 8 karakterden oluşmalıdır.";
            }
        }
        else{
            $error = "Kullanıcı adınız en az 4 karakter içermelidir.";
        }
    }
    else{
        $error = "Kullanıcı adınızı, e posta adresinizi veya şifrenizi boş giremezsiniz.";
    }
}
?>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="kayitol.css?v=1.1">
    <title>Forum - Kayıt Ol!</title>
</head>
<body>
    <div class="blur"></div>
    <div class="container">
        <form class="register" method="POST" target="">
            <?php if(!empty($kAd)){
                    echo '<input type="text" placeholder="Kullanıcı adını gir" name="kAd" value="'.$kAd.'"><br>';
                } 
                else{
                    echo '<input type="text" placeholder="Kullanıcı adını gir" name="kAd"><br>';
                }
            ?>
            <?php if(!empty($email)){
                    echo '<input type="email" placeholder="E-posta adresini gir" name="email" value="'.$email.'"><br>';
                } 
                else{
                    echo '<input type="email" placeholder="E-posta adresini gir" name="email"><br>';
                }
            ?>
            <input type="password" placeholder="Şifreni gir" name="sifre"><br>
            <input type="submit" value="Kayıt Ol" name="gonderKayit" class="submit">
            <p>Zaten hesabın var mı?</p><a style="color: #2667b3;" href = "#" id = "girisEkrani">Giriş Yap</a>
        </form>
        <?php 
        if(!empty($error))
        {
            echo '<div class="hata" id="hata"><p style="color:red;">'.$error.'</p></div>
            <div id="hataNerede" style="display: none;">kayit</div>';
        } ?>
    </div>
    
</body>
</html>

