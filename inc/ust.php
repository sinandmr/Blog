<?php 
echo defined('guvenlik') ? null : die();
require_once 'sistem/fonksiyon.php'; ?>
<!DOCTYPE html>
<html lang="en">

 <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="<?= $arow->site_baslik ?>" />
    <meta name="keywords" content="<?= $tit['kelimeler'] ?>" />
    <meta name="description" content="<?=$tit['aciklama']?>">
    <link rel="icon" href="<?='images/favicon/'.$arow->site_favicon?>" type="image/x-icon" />
    <!-- Document title -->
    <title><?= $tit['baslik'] ?></title>
    <!-- Stylesheets & Fonts -->
    <link href="css/plugins.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="js/sweetalert/sweetalert.css" rel="stylesheet">
    <meta name="google-site-verification" content="<?=$arow->google_dogrulama_kodu?>"/>
    <meta name="msvalidate.01" content="<?=$arow->bing_dogrulama_kodu?>" />
    <meta name="yandex-verification" content="<?=$arow->yandex_dogrulama_kodu?>"/>
    <meta name="robots" content="index, follow">



 </head>

<body data-animation-in="fadeIn"  data-animation-out="fadeOut" data-icon="2" data-icon-color="#072a16" data-speed-in="1000" data-speed-out="1000">

    <!-- Body Inner -->
    <div class="body-inner">