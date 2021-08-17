<?php
session_start();
ob_start();
date_default_timezone_set('Europe/Istanbul'); // Son giriş tarihini ülkemizin tarih biçimine uygun bir şekilde eklemesi için.
require_once 'fonksiyon.php';

try {

    $db = new PDO("mysql:host=localhost;dbname=sinanblog;charset=utf8","root","");
    $db->query("SET CHARACTER SET UTF8");
    $db->query("SET NAMES UTF8");

} catch(PDOException $hata) {

    echo $hata->getMessage();
    
}

$ayarlar = $db->prepare('SELECT site_url FROM ayarlar');
$ayarlar->execute();
$ayarCek = $ayarlar->fetch(PDO::FETCH_OBJ);
$siteURL = $ayarCek->site_url;
$yonetim = $ayarCek->site_url.'/admin';

if(@$_SESSION['oturum'] == sha1(md5(@$_SESSION['id'].IP()))){
    $yoneticiBul = $db->prepare('SELECT * FROM yoneticiler WHERE id=:id');
    $yoneticiBul->execute([':id'=>@$_SESSION['id']]);
    if($yoneticiBul->rowCount()){

        $cek = $yoneticiBul->fetch(PDO::FETCH_OBJ);
        $yid = $cek->id;
        $ykadi = $cek->kadi;
        $yeposta = $cek->eposta;
    }
}
