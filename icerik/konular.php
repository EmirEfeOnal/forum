<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="konular.css?v=1.1">
    <title>Forum - Konular: <?php $vtabani = new mysqli("localhost", "root", "", "forum");$vtabani -> real_escape_string($_GET['kategori']); $vtabani -> close();?></title>
</head>
<body>
    <?php include '../nav.php'?>
    <div>
        <?php
        if (isset($_SESSION['giris'])){
            echo '<div class="ekleme"><a href=/forum/konuekle.php>Konu Eklemek için TIKLA</a></div>';
        }
        $vtabani = new mysqli("localhost", "root", "", "forum");
        $kategori = $vtabani -> real_escape_string($_GET['kategori']);
        $iddegeri = $vtabani->query('Select sub_cat_id from sub_categories WHERE sub_cat_name ="'.$kategori.'"');
        foreach($iddegeri as $veri){
            $idkesin = $veri['sub_cat_id'];
            break;
        }
        
        if (isset($idkesin)){
            $sorgu = $vtabani->query('SELECT icerik_baslik, icerik_sahip, icerik_id from icerik WHERE sub_category_id ='.$idkesin);
            foreach($sorgu as $veri){
                echo '
                <ul>
                <div class="alt_konu"><a href=/forum/konu.php?id='.$veri['icerik_id'].'>'.$veri['icerik_baslik'].'</a></div>
                <div class="alt_konu_aciklama"><a>'.$veri['icerik_sahip'].'</a></div>
                </ul>';
            }
        }
        $vtabani->close();
        ?>
    </div>
</body>
</html>