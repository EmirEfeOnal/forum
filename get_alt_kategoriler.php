<?php
// Veritabanı bağlantısı
$vtabani = new mysqli("localhost", "root", "", "forum");

// Kategori adını al
$kategoriAd = $_GET['kategori_id'];

$sorgu = $vtabani->prepare("SELECT sub_cat_name FROM sub_categories WHERE sub_categories.category_id = (Select category_id from categories WHERE category_name = ?)");
$sorgu->bind_param("s", $kategoriAd);
$sorgu->execute();
$sonuc = $sorgu->get_result();

// Alt kategorileri HTML içeriği olarak oluştur
$htmlIcerik = '<option value="">Alt kategori seçin</option>';
while ($satir = $sonuc->fetch_assoc()) {
    $altKategoriAdi = $satir["sub_cat_name"];
    $htmlIcerik .= "<option value='$altKategoriAdi'>$altKategoriAdi</option>";
}

// Sonucu geri döndür
echo $htmlIcerik;

// Bağlantıyı kapat
$vtabani->close();
?>
