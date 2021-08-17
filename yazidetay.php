<?php 
define('guvenlik',true);

require_once 'inc/ust.php'; ?>

<!-- Header -->
<?php require_once 'inc/menu.php';?>
<!-- end: Header -->
<!-- Page Content -->
<section id="page-content" class="sidebar-right">
    <div class="container">
        <div class="row">
            <!-- content -->
            <div class="content col-lg-9">
                <!-- Blog -->
                <?php

$yazi_id = strip_tags(trim($_GET['id']));
$yazi_sef = strip_tags(trim($_GET['yazi_sef']));

if(!$yazi_id || !$yazi_sef) header('Location:'.$arow->site_url);

$sorgu = $db->prepare('SELECT * FROM yazilar INNER JOIN kategoriler ON kategoriler.id = yazilar.yazi_kat_id WHERE yazi_id=:id AND yazi_sef=:sef AND yazi_durum=:durum');
$sorgu->execute([':id'=> $yazi_id, ':sef' => $yazi_sef,':durum' => 1]);
if($sorgu->rowCount()){
$cek = $sorgu->fetch(PDO::FETCH_OBJ);

$goruntulenme = @$_COOKIE[$cek->yazi_id];
if(!$goruntulenme){
    $okunmaSayisi = $db->prepare('UPDATE yazilar SET yazi_goruntulenme=:g WHERE yazi_id=:id');
    $okunmaSayisi->execute([':g'=>$cek->yazi_goruntulenme + 1, ':id'=>$yazi_id]);
    setcookie($cek->yazi_id,'1',time()+3600); // 1 saatlik cookie oluşturur. Böylece her yenilediğimizde görüntülenme artmaz.
}

$sonrakiKonuId = $yazi_id+1;
$oncekiKonuId = $yazi_id-1;
# Konuları db'den çekelim
$sonrakiSorgu = $db->prepare('SELECT yazi_id,yazi_sef,yazi_baslik FROM yazilar WHERE yazi_id=:id AND yazi_durum=:durum');
$sonrakiSorgu->execute([':id' => $sonrakiKonuId, ':durum' => 1]);
$cekSonra = $sonrakiSorgu->fetch(PDO::FETCH_OBJ);

$oncekiSorgu = $db->prepare('SELECT yazi_id,yazi_sef,yazi_baslik FROM yazilar WHERE yazi_id=:id AND yazi_durum=:durum');
$oncekiSorgu->execute([':id' => $oncekiKonuId, ':durum' => 1]);
$cekOnce = $oncekiSorgu->fetch(PDO::FETCH_OBJ);
?>
                <div id="blog" class="single-post">
                    <!-- Post single item-->
                    <div class="post-item">
                        <div class="post-item-wrap">
                            <div class="post-image">
                                <a href="#">
                                    <img alt="<?=$cek->yazi_baslik?>"
                                        src="<?=$arow->site_url?>/images/<?=$cek->yazi_foto?>">
                                </a>
                            </div>
                            <div class="post-item-description">
                                <h2><?=$cek->yazi_baslik?></h2>
                                <div class="post-meta">

                                    <span class="post-meta-date"><i
                                            class="fa fa-calendar-o"></i><?php echo date('d.m.Y.',strtotime($cek->yazi_tarih));?></span>
                                    <span class="post-meta-comments"><a href="#"><i
                                                class="fa fa-eye"></i><?=$cek->yazi_goruntulenme?>
                                            Görüntülenme</a></span>
                                    <span class="post-meta-category"><a
                                            href="<?php echo $arow->site_url.'/kategoriler.php?kat_sef='.$cek->kat_sef?>"><i
                                                class="fa fa-tag"></i><?=$cek->kat_adi?></a></span>
                                    <div class="post-meta-share">
                                        <a target="_blank" class="btn btn-xs btn-slide btn-facebook"
                                            href="https://www.facebook.com/sharer.php?u=<?= getCurURL()?>">
                                            <i class="fab fa-facebook-f"></i>
                                            <span>Facebook</span>
                                        </a>
                                        <a target="_blank" class="btn btn-xs btn-slide btn-twitter"
                                            href="https://twitter.com/intent/tweet?text=<?=$cek->yazi_baslik?>&url=<?=getCurURL()?>&via=Sinand_71"
                                            data-width="100">
                                            <i class="fab fa-twitter"></i>
                                            <span>Twitter</span>
                                        </a>
                                        <a target="_blank" class="btn btn-xs btn-slide btn-googleplus"
                                            href="mailto:sinan.logs@gmail.com?subject=<?=$cek->yazi_baslik?>&body=<?=getCurURL()?>"
                                            data-width="80">
                                            <i class="far fa-envelope"></i>
                                            <span>Mail</span>
                                        </a>
                                    </div>
                                </div>
                                <p style="word-wrap: break-word;"><?=$cek->yazi_icerik?></p>

                            </div>
                            <div class="post-tags">
                                <?php

                                    $etiketler = explode(',',$cek->yazi_etiketler); // Aralarında virgül olanları ayırıyor.
                                    $dizi = array();
                                    foreach($etiketler as $etiket){
                                        $dizi[] = '<a title="'.$etiket.'" href="etiketdetay.php?etiket='.sef_link($etiket).'">'.$etiket.'</a>';
                                    }
                                    $sonuc = implode(' ',$dizi);
                                    echo $sonuc;


                                    ?>
                            </div>
                            <div class="post-navigation">
                                <?php if($oncekiSorgu->rowCount()){ ?>
                                <a href="<?=$arow->site_url?>/yazidetay.php?yazi_sef=<?=$cekOnce->yazi_sef?>&id=<?=$cekOnce->yazi_id?>"
                                    class="post-prev">
                                    <div class="post-prev-title"><span>Önceki Konu</span><?=$cekOnce->yazi_baslik?>
                                    </div>
                                </a>
                                <?php } else { ?>
                                <a href="#" class="post-prev">
                                    <div class="post-prev-title"><span>Önceki Konu</span>Önceki konu bulunmuyor.</div>
                                </a>
                                <?php } ?>
                                <a href="<?=$arow->site_url?>" class="post-all"> <i class="icon-grid"></i></a>
                                <?php
                                    if($sonrakiSorgu->rowCount()){ // Eğer sonraki konu varsa..
                                    ?>
                                <a href="<?=$arow->site_url?>/yazidetay.php?yazi_sef=<?=$cekSonra->yazi_sef?>&id=<?=$cekSonra->yazi_id?>"
                                    class="post-next">
                                    <div class="post-next-title"><span>Sonraki Konu</span><?=$cekSonra->yazi_baslik?>
                                    </div>
                                </a>
                                <?php               
                                    } else {
                                    ?>
                                <a href="#" class="post-next">
                                    <div class="post-next-title"><span>Sonraki Konu</span>Sonraki konu bulunmuyor.</div>
                                </a>
                                <?php } ?>
                            </div>
                            <?php
                                $yorumSorgu = $db->prepare('SELECT * FROM yorumlar WHERE yorum_yazi_id=:id AND yorum_durum=:durum');
                                $yorumSorgu->execute([':id' => $cek->yazi_id,':durum'=>1]);

                                ?>

                            <!-- Comments -->
                            <div class="comments" id="comments">
                                <div class="comment_number">
                                    Yorumlar <span>(<?=$yorumSorgu->rowCount()?>)</span>
                                </div>
                                <div class="comment-list">
                                    <?php

                                if($yorumSorgu->rowCount()){        
                                    foreach($yorumSorgu as $yorum){ 
                                    if($yorum['yorum_durum']==1){
                                    ?>
                                    <!-- Comment -->
                                    <div class="comment" id="comment-1">
                                        <div class="image"><img alt="" src="images/1.jpg" class="avatar">
                                        </div>
                                        <div class="text">
                                            <h5 class="name"><?=$yorum['yorum_isim']?></h5>
                                            <span
                                                class="comment_date"><?=date('d.m.Y H.i',strtotime($yorum['yorum_tarih']))?></span>
                                            <div class="text_holder">
                                                <p><?=$yorum['yorum_icerik']?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end: Comment -->

                                    <?php
                                    }
                                }
                            }
                            ?>
                                </div>
                            </div>
                            <!-- end: Comments -->
                            <div class="respond-form" id="respond">
                                <div class="respond-comment">
                                    <span>Yorum Yap</span>
                                </div>
                                <form class="form-gray-fields" id="yorumformu" method="POST" action=""
                                    onsubmit="return false">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="upper" for="name">Ad Soyad</label>
                                                <input class="form-control required" name="adsoyad" placeholder="Adınız"
                                                    id="adsoyad" aria-required="true" type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="upper" for="email">E-Posta (Yayınlanmayacaktır)</label>
                                                <input class="form-control required email" name="eposta"
                                                    placeholder="E-Posta adresiniz" id="eposta" aria-required="true"
                                                    type="email">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="upper" for="website">URL</label>
                                                <input class="form-control website" name="website"
                                                    placeholder="http//: ile başlayın." id="website"
                                                    aria-required="false" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="upper" for="comment">Yorum</label>
                                                <textarea class="form-control required" name="yorum" rows="9"
                                                    placeholder="Yorumunuz" id="comment"
                                                    aria-required="true"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group text-center">
                                                <input type="hidden" value="<?=$cek->yazi_id?>" name="yaziid">
                                                <button class="btn" onclick="yorumYap()" type="submit">Yorum
                                                    Yap</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end: Post single item-->
                </div>
                <?php
} else {
    header('Location:'.$arow->site_url);
}
?>


            </div>
            <!-- end: content -->

            <!-- Sidebar-->
            <?php require_once 'inc/sag.php';?>
            <!-- end: Sidebar-->
        </div>
    </div>
</section>
<!-- end: Page Content -->
<!-- Footer -->
<?php require_once 'inc/alt.php'; ?>