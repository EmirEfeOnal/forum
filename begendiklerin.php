<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="begendiklerin.css?v=1.0">
    <title>Beğendiklerin</title>
</head>
<body>
    <?php
    include 'nav.php';
    $baglanti = new mysqli("localhost", "root", "", "forum");
    $sorgu = $baglanti->query("SELECT icerik_id from begenme WHERE account_id = (SELECT id from accounts WHERE username ='".$_SESSION['isim']."')");
    foreach($sorgu as $veri){
        $begenilenKonular = $baglanti->query('SELECT icerik_baslik, icerik_sahip from icerik WHERE icerik_id ='.$veri['icerik_id']);
        foreach($begenilenKonular as $bK){
            echo'
            <ul>
                <div class="begenilen"><a href=/forum/konu.php?id='.$veri['icerik_id'].'>'.$bK['icerik_baslik'].'</a></div>
                <div class="begenilen_aciklama"><a>'.$bK['icerik_sahip'].'</a></div>
            </ul>';
        }
    }
    ?>
</body>
</html>