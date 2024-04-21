<?php
session_start();
$baglanti = new mysqli("localhost", "root", "", "forum");
if(isset($_GET['id'])){
$konu_id = $baglanti -> real_escape_string($_GET['id']);
    if (is_numeric($konu_id)== 1){
        $sonuc = $baglanti ->query("SELECT icerik_icerik, icerik_baslik from icerik WHERE icerik_id =".$konu_id);
        foreach($sonuc as $veri){
            $icerik = $veri['icerik_icerik'];
            $baslik = $veri['icerik_baslik'];
            break;
        }
    }
}
$baglanti ->close();
if (isset($_POST['yorumGonder'])){
    if(!empty($_POST['yorum'])){
        if(isset($_SESSION['giris'])){
            $baglanti = new mysqli("localhost", "root", "", "forum");
            $konu_id = $baglanti -> real_escape_string($_GET['id']);
            $yorum = $baglanti -> real_escape_string($_POST['yorum']);
            date_default_timezone_set("Turkey");
            $baglanti ->query("INSERT INTO comments (comment_comment, comment_owner, comment_date, icerik_id) VALUES ('".$yorum."', (SELECT id from accounts WHERE username ='".$_SESSION['isim']."'),'".date("Y-m-d")." ".date("H:i:s")."',".$konu_id.")");
            $baglanti -> close();
            header("location: konu.php?id=".$konu_id);
        }
    }
}
?>
<html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="konu.css?v=1.22">
    <script src="konu.js?v=1.11"></script>
    <title>Forum - <?php echo $baslik;?></title>
</head>
<body>
    <?php include 'nav.php'?>
    <div class="baslik">
    <?php
        if(isset($icerik)){
            echo '<a class="baslik-yazi">'.$baslik.'</a>';
        }
     ?>
    </div>
    <?php
    if(isset($icerik)){
        echo'
        <div class="icerik">
        '.$icerik.
        '</div>';
        if(isset($_SESSION['giris'])){
            echo'
            <div class="begen">
                <div class="begeniYer">
                    <div class="begeniText">';
                        $baglanti = new mysqli("localhost", "root", "", "forum");
                        $konu_id = $baglanti -> real_escape_string($_GET['id']);
                        $isim = $_SESSION['isim'];
                        $ac_id = $baglanti->query("SELECT id from accounts where username ='".$isim."'");
                        $ac_id = mysqli_fetch_assoc($ac_id);
                        $k_id = $baglanti->query("SELECT account_id from begenme where icerik_id =".$konu_id. " and account_id = ".$ac_id['id']);
                        if(mysqli_num_rows($k_id) > 0){
                            echo '<a href="#">Bu konuyu beğenmişsin <i class="fa-regular fa-face-laugh"></i></a>';
                        }
                        else{
            echo'
                        <a href="#" id="begen">Bu konuyu beğenmek için tıkla <i class="fa-regular fa-thumbs-up"></i></a>';}
                        $baglanti->close();
                        echo'
                    </div>
                </div>
            </div>
            <div class="yorum">
                <form action="" method="POST">
                    <div id="uyari"></div>
                    <textarea placeholder="Yorumunuzu buraya yazabilirsiniz!" rows=10 id="yorumAlani" name="yorum"></textarea>
                    <input type="submit" name="yorumGonder">
                </form>
            </div>';
        }
        echo'<div class="yorumlar">';
            $baglanti = new mysqli("localhost", "root", "", "forum");
            $konu_id = $baglanti -> real_escape_string($_GET['id']);
            $sorgu = $baglanti->query('SELECT comment_comment, comment_owner, comment_date from comments WHERE icerik_id ='.$konu_id);
            foreach($sorgu as $veri){
                $isim = $baglanti->query('SELECT username from accounts where id ='.$veri['comment_owner']);
                foreach($isim as $kayit){
                    $yorum_sahibi = $kayit['username'];
                }
            echo'
            <ul>
                <div class="tarih"><xmp>'.$veri['comment_date'].'</xmp></div>
                <div class="yazan"><xmp>'.$yorum_sahibi.'</xmp></div>
                <div class="gonderi"><xmp>'.$veri['comment_comment'].'</xmp></div>
            </ul>';}
            $baglanti -> close();
        echo'</div>';
        }
            else{
                echo 'Aradığınız konu sonsuzluk içerisinde kayıplara karışmış.</div>';
            }
        ?>
    
    
</body>
</html>