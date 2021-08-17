<?php 
echo defined('guvenlikadmin') ? null : die();
?>
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" width="100" height="100" src="https://icon2.cleanpng.com/20180712/cir/kisspng-computer-icons-icon-design-business-administration-admin-icon-5b46fc466e6446.7801239015313787584522.jpg" alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><?=$ykadi?></p>
            <p class="app-sidebar__user-designation">Yönetici</p>
        </div>
    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item active" href="index.php"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Ana Sayfa</span></a></li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-list"></i><span class="app-menu__label">Kategoriler</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?=$yonetim.'/kategoriler.php'?>"><i class="icon fa fa-cog"></i> Kategori Listesi ( <?=say('kategoriler')?> )</a></li>
                <li><a class="treeview-item" href="<?=$yonetim.'/islemler.php?islem=yenikategori'?>"><i class="icon fa fa-cog"></i> Yeni Kategori Ekle</a></li>

            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Yazılar</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?=$yonetim.'/yazilar.php'?>"><i class="icon fa fa-cog"></i> Yazı Listesi ( <?=say('yazilar')?> )</a></li>
                <li><a class="treeview-item" href="<?=$yonetim.'/islemler.php?islem=yeniyazi'?>"><i class="icon fa fa-cog"></i> Yeni Yazı Ekle</a></li>

            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-comment"></i><span class="app-menu__label">Yorumlar</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?=$yonetim.'/onayliyorumlar.php'?>"><i class="icon fa fa-cog"></i> Onaylı Yorumlar ( <?=say('yorumlar','yorum_durum',1)?> )</a></li>
                <li><a class="treeview-item" href="<?=$yonetim.'/bekleyenyorumlar.php'?>"><i class="icon fa fa-cog"></i> Onay Bekleyen Yorumlar ( <?=say('yorumlar','yorum_durum',0)?> )</a></li>

            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-envelope"></i><span class="app-menu__label">Mesajlar</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?=$yonetim.'/okunmusmesajlar.php'?>"><i class="icon fa fa-cog"></i> Okunmuş Mesajlar ( <?=say('mesajlar','durum',1)?> )</a></li>
                <li><a class="treeview-item" href="<?=$yonetim.'/yenimesajlar.php'?>"><i class="icon fa fa-cog"></i> Yeni Mesajlar ( <?=say('mesajlar','durum',2)?> ) </i></a></li>

            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-facebook-square"></i><span class="app-menu__label">Sosyal Medya</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?=$yonetim.'/sosyalmedya.php'?>"><i class="icon fa fa-cog"></i> Sosyal Medya Listesi ( <?=say('sosyalmedya')?> )</i></a></li>
                <li><a class="treeview-item" href="<?=$yonetim.'/islemler.php?islem=yenimedya'?>"><i class="icon fa fa-cog"></i> Yeni Sosyal Medya Ekle</a></li>

            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Aboneler </span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?=$yonetim.'/aboneler.php'?>"><i class="icon fa fa-cog"></i> Abone Listesi ( <?=say('aboneler')?> )</a></li>

            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Ayarlar</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?=$yonetim.'/islemler.php?islem=genelayar'?>"><i class="icon fa fa-cog"></i> Genel Ayarlar</a></li>
                <li><a class="treeview-item" href="<?=$yonetim.'/islemler.php?islem=iletisim'?>"><i class="icon fa fa-cog"></i> İletişim Ayarları</a></li>
                <li><a class="treeview-item" href="<?=$yonetim.'/islemler.php?islem=logo'?>"><i class="icon fa fa-cog"></i> Logo Ayarları</a></li>
                <li><a class="treeview-item" href="<?=$yonetim.'/islemler.php?islem=favicon'?>"><i class="icon fa fa-cog"></i> Favicon Ayarları</a></li>
                <li><a class="treeview-item" href="<?=$yonetim.'/islemler.php?islem=dogrulama'?>"><i class="icon fa fa-cog"></i> Doğrulama Ayarları</a></li>

            </ul>
        </li>


    </ul>
</aside>