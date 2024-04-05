<?php 
    session_start();
    if (!isset($_SESSION['giris'])){
        echo'<script type="text/javascript">
        document.location.href = "/forum/anasayfa.php";
        </script>'; 
    }
    $vtabani = new mysqli("localhost", "root", "", "forum");
    $sorgu = $vtabani->query("SELECT category_name from categories ORDER BY category_name DESC");
    $vtabani->close();
?>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="konuekle.css?v=1.5">
    <script src="konuekle.js?v=1.54"></script>
    <title>Forum - Konu Ekle</title>
</head>
<body>
    <?php include 'nav.php'?>
    <div id="uyari"></div>
        <form class="ekleme" action="/forum/anasayfa.php">
            <select id="category">
                <option value="">Bir Kategori Seç</option>
                <?php
                while ($satir = $sorgu->fetch_assoc()) {
                    $kategoriAdi = $satir["category_name"];
                    echo "<option value='$kategoriAdi'>$kategoriAdi</option>";
                }?>
            </select>
            <select id="sub_category">
                <option value="">Alt kategori Seç</option>
                <?php
                while ($satir = $sorgu->fetch_assoc()) {
                    $kategoriAdi = $satir["category_name"];
                    echo "<option value='$kategoriAdi'>$kategoriAdi</option>";
                }?>
            </select>
            <input type="text" placeholder="Başlık" class="baslik" id="baslik">
            <div class="butonlar">
                <input type="button" onClick="ekle('b')" value="Kalın Yazı">
                <input type="button" onClick="ekle('i')" value="İtalik Yazı">
                <input type="button" onClick="ekle('u')" value="Altı Çizili Yazı">
                <input type="button" onClick="ekle('orta')" value="Yazıyı Ortala">
                <input type="button" onClick="ekle('sol')" value="Yazıyı Sola Yapıştır">
                <input type="button" onClick="ekle('sağ')" value="Yazıyı Sağa Yapıştır">
                <input type="button" onClick="boyut()" value="Yazı Boyutu Ayarı Ekle">
                <input type="button" onClick="renk()" value="Yazı Rengi Ayarı Ekle">
            </div>
            <textarea id="yaziAlani" rows="15" placeholder="İçeriğini buraya yazabilirsin!"></textarea>
            <a style="text-align:center; margin-bottom:2%">Buradan içeriğin yayınlandığında nasıl görüneceği bilgisine ulaşabilirsin.</a>
        <div id="goster" class="goster"></div>
        <input type="submit" value="Yayınlamak için tıkla!" id="gonder">
    </form>
</body>
</html>