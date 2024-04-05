<?php
session_start();
if (isset($_SESSION['giris'])){
    $id = $_POST["id"];
    $isim = $_SESSION['isim'];
    $baglanti = new mysqli("localhost", "root", "", "forum");
    $k_id = $baglanti->query("SELECT id from accounts where username ='".$isim."'");
    $k_id = mysqli_fetch_assoc($k_id);
    $ekleme = $baglanti->query("INSERT INTO begenme (account_id, icerik_id) VALUES (".$k_id['id'].",".$id.")");
    $baglanti ->close();
}
?>