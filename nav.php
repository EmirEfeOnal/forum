<?php 
if(session_id() == ''){
    session_start();
}
if(isset($_SESSION["giris"])) 
{
    if(time()-$_SESSION["login_time_stamp"] > 86400)  
    {
        session_unset();
        session_destroy();
    }
}
$vtabani = new mysqli("localhost", "root", "", "forum");
$adresi = $_SERVER['REMOTE_ADDR'];
$ipler = $vtabani->query('SELECT * FROM iplist WHERE ip ="'.$adresi.'"');
if ($ipler->num_rows<=0){
    $vtabani->query('INSERT INTO iplist(ip) VALUES ("'.$adresi.'")');
}
$vtabani->close();

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/forum/nav.css?v=1.21">
    <script src="https://kit.fontawesome.com/c0ceee8b72.js" crossorigin="anonymous"></script>
    <script src="/forum/nav.js?v=1.33"></script>
</head>
<div class="navbar">
        <div class="logreg">
            <?php 
            if(isset($_SESSION['giris'])){
                echo '<li><i class="fa-solid fa-bars" onClick="menuOpen()"></i>
                        <div id="menu">
                            <ul><a href="/forum/begendiklerin.php">Beğendiklerin</a></ul>
                            <ul><a href="#" id="cikis">Çıkış Yap</a></ul>
                        </div>
                    </li>';
                echo "<a>".$_SESSION['isim']."</a>";
            }
            else{
                echo '
                <a href="#" id="login" class="giris">Giriş Yap</a>
                <a href="#" id="register">Kayıt Ol</a>';
            }
            ?>
            
            
        </div>
        <div class="logo">
            <a href="/forum/anasayfa.php">FORUM</a>
        </div>
    </div>

<?php
    if(!isset($_SESSION["giris"])) {
        echo'<div id="giris" class="girisAktivite">';
            include 'giris.php';
        echo '</div>';
    }
    if(!isset($_SESSION["giris"])) {
        echo'<div id="kayit" class="girisAktivite">';
            include 'kayitol.php';
        echo '</div>';
    }
?>