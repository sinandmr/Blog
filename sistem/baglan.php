<?php 
ob_start();
try {
    $db = new PDO("mysql:host=localhost;dbname=sinanblog;charset=utf8","root","");
    $db->query("SET CHARACTER SET UTF8");
    $db->query("SET NAMES UTF8");
} catch(PDOException $hata) {
    echo $hata->getMessage();
}
/*
 * baglan.php dosyasını blog'un tüm sayfalarında kullanmak için header kısmındaki üst.php'ye include edersek
 * tüm sayfalarda kullanmış oluruz.
 * Tüm sayfalar veritabanına bağlanmış olur.
 *
 * Fonksiyon dosyamızı da kullanmak için baglan.php dosyamızı fonksiyon.php'ye çekeceğiz.
 * Üstteki yaptığımız işlemin yerine üst.php'ye fonksiyon.php'yi dahil edeceğiz.
 */

# AYARLAR TABLOSUNA BAĞLANALIM
$ayarlar = $db->prepare('SELECT * FROM ayarlar');
$ayarlar->execute();
$arow = $ayarlar->fetch(PDO::FETCH_OBJ);
$site = $arow->site_url;
$siteBaslik = $arow->site_baslik;
$logo = $arow->site_logo;
$sitekeyw = $arow->site_keyw;
$sitedesc = $arow->site_desc;
# Ayarlar tablosuna bağlandığımıza göre ust.php'den başlığı falan düzeltebiliriz.

if($arow->site_durum == 2){
    header('Location:bakim.php');
}
