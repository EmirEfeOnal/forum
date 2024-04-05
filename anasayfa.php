<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="anasayfa.css?v=1.6">
    <title>Forum - Anasayfa</title>
</head>
<body>
    <?php include 'nav.php';?>
    
    <div class="main">
        <div class="konular">
            <?php
                $vtabani = new mysqli("localhost", "root", "", "forum");
                $gruplar = $vtabani->query('Select category_name, category_id from categories');
                foreach($gruplar as $kategoriler)
                {
                    echo'
                    <div class="grup-baslik">
                    <a>'.$kategoriler['category_name'].'</a></div>';
                    $altgruplar = $vtabani->query('Select sub_cat_name from sub_categories WHERE category_id ='.$kategoriler['category_id']);
                    foreach($altgruplar as $altkategoriler)
                    {
                        echo'
                        <div class="yan-icerik">
                            <h6><a href="icerik/konular.php?kategori='.$altkategoriler['sub_cat_name'].'">'.$altkategoriler['sub_cat_name'].'</a></h6>
                            <a href="icerik/konular.php?kategori='.$altkategoriler['sub_cat_name'].'">'.$altkategoriler['sub_cat_name'].' içerikli kodları, tanıtımları, eğitim içeriklerini buradan bulabilirsin.</a>
                        </div>';
                    }
                }
            ?>
        </div>
        <div class="yan">
            <ul>
                <div class="yan-baslik">
                    <a>Son Konular</a>
                    <div class="yan-icerik">
                        <?php 
                            $baglanti = new mysqli("localhost", "root", "", "forum");
                            $sonuc = $baglanti ->query("SELECT icerik_baslik,icerik_id from icerik ORDER BY icerik_id DESC LIMIT 5");
                            foreach($sonuc as $veri){
                                echo '<div><a href=konu.php?id='.$veri["icerik_id"].'>'.$veri["icerik_baslik"].'</a></div>';
                            }
                            $baglanti->close();
                            ?>
                    </div>
                </div>
            </ul>
            <ul>
                <div class="yan-baslik">
                    <a>bilgiler</a>
                    <div class="yan-icerik">
                        <?php
                        $vtabani = new mysqli("localhost", "root", "", "forum");
                        $ipler = $vtabani->query('SELECT COUNT(ip) FROM iplist');
                        foreach($ipler as $say){
                        echo '<a>Gün içerisindeki ziyaretci sayısı:'.$say['COUNT(ip)'].'</a>';}
                        ?>
                        
                    </div>
                </div>
            </ul>
        </div>
    </div>
</body>
</html>