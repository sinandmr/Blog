<?php 
echo defined('guvenlik') ? null : die();
?>
<header id="header">
            <div class="header-inner">
                <div class="container">
                    <!--Logo-->
                    <div id="logo">
                        <a href="<?php echo $arow->site_url; ?>" class="logo" data-src-dark="images/logo/<?php echo $arow->site_logo?>"> <img style="width:150px;height:auto;margin-top:20px" src="images/logo/<?php echo $arow->site_logo; ?>" alt="Polo Logo"> </a>
                    </div>
                    <!--End: Logo-->

                     <!-- Search -->
                    <div id="search">
                        <div id="search-logo"><img src="images/logo/<?php echo $arow->site_logo?>" alt="Polo Logo"></div>
                        <button id="btn-search-close" class="btn-search-close" aria-label="Close search form"><i
                                class="icon-x"></i></button>
                        <form class="search-form" action="ara.php" method="get">
                            <input class="form-control" name="q" type="search" placeholder="Yazı Arayın..."
                                autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                            <span class="text-muted">Yazılar arasında arama yapabilirsiniz.</span>
                        </form>

                        <div class="search-suggestion-wrapper">

                        <?php 

                        $populerSorgu = $db->prepare('SELECT * FROM yazilar WHERE yazi_durum=:d ORDER BY yazi_goruntulenme DESC LIMIT :lim');
                        $populerSorgu->bindValue(':d',1,PDO::PARAM_INT);
                        $populerSorgu->bindValue(':lim',3,PDO::PARAM_INT);
                        $populerSorgu->execute();
                        if($populerSorgu->rowCount()){
                            foreach($populerSorgu as $item){ ?>

                            <div class="search-suggestion">
                                <h3><?=$item['yazi_baslik']?></h3>
                                <p><?=mb_substr($item['yazi_icerik'],0,150,'utf8')?> ...</p>
                                <p><a href="<?php echo getCurURL().'yazidetay.php?yazi_sef='.$item['yazi_sef'].'&id='.$item['yazi_id'] ?>">Devamını okumak için tıkla!</a></p>
                            </div>
                                <?php }} ?>

                        </div></div>
                    <div class="header-extras">
                        <ul>
                            <li>
                                <!--search icon-->
                                <a id="btn-search" href="#"> <i class="icon-search1"></i></a>
                                <!--end: search icon-->
                            </li>
                        </ul>
                    </div>
                    <!-- end: search -->
                    <!--Navigation Resposnive Trigger-->
                    <div id="mainMenu-trigger">
                        <button class="lines-button x"> <span class="lines"></span> </button>
                    </div>
                    <!--end: Navigation Resposnive Trigger-->

                    <!--Navigation-->
                    <div id="mainMenu">
                        <div class="container">
                            <nav>
                                <ul>
                                    <li><a href="<?php echo $arow->site_url; ?>"><i class="fa fa-home"></i>Ana Sayfa</a></li>
                                    <li class="dropdown"> <a href="#"><i class="fa fa-list"></i>Kategoriler</a>
                                        <ul class="dropdown-menu">

                                            <?php

                                            $kategoriler = $db->prepare("SELECT * FROM kategoriler");
                                            $kategoriler->execute();
                                            if($kategoriler->rowCount()){ // kategorilerdeki elemanların sayısını dönderir. Eğer 0 ise burası çalışmaz.
                                                foreach($kategoriler as $row) {

                                                    $yaziSay = $db->prepare('SELECT yazi_kat_id,yazi_durum FROM yazilar WHERE yazi_kat_id=:id AND yazi_durum=:durum');
                                                    $yaziSay->execute([':id'=> $row['id'],':durum'=>1]);

                                                    echo '<li><a href="'.$arow->site_url.'/kategoriler.php?kat_sef='.$row['kat_sef'].'">'.$row['kat_adi'].'('.$yaziSay->rowCount().')'.'</a></li>';
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                    <li class="dropdown"> <a href="<?php echo $arow->site_url.'/iletisim.php';?>"><i class="fa fa-envelope"></i>İletişim</a>
                            </nav>
                        </div>
                    </div>
                    <!--END: NAVIGATION-->
                </div>
            </div>
        </header>