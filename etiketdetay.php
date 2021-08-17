<?php 
define('guvenlik',true);

require_once 'inc/ust.php'; ?>


<!-- Header -->
<?php require_once 'inc/menu.php'; ?>
<!-- end: Header -->

<!-- Content -->
<section id="page-content">
    <div class="container">
        <!-- post content -->
        
<?php
$s = @intval($_GET['sayfa']);
if(!$s) $s = 1;

$etiket = strip_tags($_GET['etiket']);
if(!$etiket) header('Location:'.$arow->site_url);


$sorgu = $db->prepare("SELECT yazi_kat_id,yazi_durum,yazi_etiketler FROM yazilar INNER JOIN kategoriler ON kategoriler.id = yazilar.yazi_kat_id WHERE yazi_durum=:d AND yazi_etiketler LIKE :etiket");
$sorgu->execute([':d' => 1,':etiket' => '%'.$etiket.'%']);

$toplam = $sorgu->rowCount();
$lim = 1; // 1 sayfada 9 tane listelensin.
$goster = $s * $lim - $lim; // sayfa sayısı * limit * limit
?>
        <!-- Page title -->
        <div class="page-title">
            <h1>Arama Sonuçları (<?=$toplam?>)</h1>
            <div class="breadcrumb float-left">
                <ul>
                    <li><a href="<?=$arow->site_url?>">Ana Sayfa</a>
                    </li>
                    <li><a href="#">Kategoriler</a>
                    </li>
                    <li class="active"><a href="#"><?=$etiket?> etiketine sahip yazılar</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- end: Page title -->

        <!-- Blog -->
        <div id="blog" class="grid-layout post-3-columns m-b-30" data-item="post-item">

            <!-- Post item-->
            <?php

                        $sorgu2 = $db->prepare("SELECT * FROM yazilar INNER JOIN kategoriler ON kategoriler.id = yazilar.yazi_kat_id WHERE yazi_durum=:d AND yazi_etiketler LIKE :etiket ORDER BY yazi_tarih DESC LIMIT :goster, :lim");
                        $sorgu2->bindValue(":d", 1, PDO::PARAM_INT);
                        $sorgu2->bindValue(":etiket", '%'.$etiket.'%', PDO::PARAM_STR);
                        $sorgu2->bindValue(":goster", $goster, PDO::PARAM_INT);
                        $sorgu2->bindValue(":lim", $lim, PDO::PARAM_INT);
                        $sorgu2->execute();
                        if($s > ceil($toplam/$lim)){
                            $s = 1;
                        }

                        if($sorgu2->rowCount()){
                            foreach($sorgu2 as $row){
                        ?>


            <div class="post-item border">
                <div class="post-item-wrap">
                    <div class="post-image">
                        <a href="<?php echo $arow->site_url; ?>/yazidetay.php?yazi_sef=<?=$row['yazi_sef']?>&id=<?=$row['yazi_id']?>"
                            class="item-link">
                            <img width="525" height="350" alt="<?=$row['yazi_baslik']?>"
                                src="images/<?=$row['yazi_foto']?>">
                        </a>
                        <span class="post-meta-category"><a
                                href="<?=$arow->site_url?>/kategoriler.php?kat_sef=<?=$row['kat_sef']?>"><?=$row['kat_adi']?></a></span>
                    </div>
                    <div class="post-item-description">
                        <span class="post-meta-date"><i
                                class="fa fa-calendar-o"></i><?php echo date('d.m.Y',strtotime($row['yazi_tarih'])); ?></span>
                        <span class="post-meta-comments"><a href=""><i
                                    class="fa fa-eye"></i><?=$row['yazi_goruntulenme']?> Görüntülenme</a></span>
                        <h2><a href="<?php echo $arow->site_url; ?>/yazidetay.php?yazi_sef=<?=$row['yazi_sef']?>&id=<?=$row['yazi_id']?>"
                                class="item-link"><?=$row['yazi_baslik']?></a></h2>
                        <p style="word-wrap: break-word;"><?php echo mb_substr($row['yazi_icerik'],0,250,'utf8').'...'; ?></p>

                        <a href="<?php echo $arow->site_url; ?>/yazidetay.php?yazi_sef=<?=$row['yazi_sef']?>&id=<?=$row['yazi_id']?>"
                            class="item-link">Devamını oku <i class="fa fa-arrow-right"></i></a>

                    </div>
                </div>
            </div>

            <?php } ?>

        </div>
        <ul class="pagination">
            <?php 
                if($toplam > $lim){
                    pagination($s,ceil($toplam/$lim),'etiketdetay.php?etiket='.$etiket.'&sayfa=');
                }
                ?>
        </ul>
        <?php
                            
                        
                        } else { 
                        echo '<div class="alert alert-danger">'.$etiket.' kelimesine uygun bir yazı bulunamadı.</div>';
                    } ?>
        <!-- end: Post item-->



        <!-- Pagination -->


        <!-- end: Pagination -->

    </div>
    <!-- end: post content -->

</section>
<!-- end: Content -->
<!-- Footer -->
<?php require_once 'inc/alt.php'; ?>