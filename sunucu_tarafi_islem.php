<?php
$jsonVeri = json_decode(file_get_contents('php://input'), true);
$icerik = $jsonVeri['icerik'];
$baslik = $jsonVeri['baslik'];
$kategori = $jsonVeri['kategori'];
$alt_kategori = $jsonVeri['alt_kategori'];
session_start();
$baglanti = new mysqli("localhost", "root", "", "forum");
$isim = $_SESSION['isim'];
$stmt = $baglanti->prepare("INSERT INTO icerik(icerik_sahip ,sub_category_id, category_id, icerik_baslik, icerik_icerik) VALUES (?, (SELECT sub_cat_id FROM sub_categories WHERE sub_cat_name = ?),(SELECT category_id FROM categories WHERE category_name= ?), ?, ?)");
$stmt->bind_param("sssss", $isim, $alt_kategori, $kategori, $baslik, $icerik);
echo 'test';
$stmt->execute();
$stmt->close();
$baglanti->close();
?>