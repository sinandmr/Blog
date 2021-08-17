<?php 
echo defined('guvenlik') ? null : die();
?>
<div class="sidebar sticky-sidebar col-lg-3">
                            <!--widget newsletter-->
                            <div class="widget  widget-newsletter">
                            <form id="widget-search-form-sidebar" action="ara.php" method="get" class="form-inline">
                                <div class="input-group">
                                    <input type="text" aria-required="true" name="q" class="form-control widget-search-form" placeholder="Yazı arayın...">
                                    <div class="input-group-append">
                                        <span class="input-group-btn">
                                        <button type="submit" id="widget-widget-search-form-button" class="btn"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            </div>
                            <!--end: widget newsletter-->

                            <!--Tabs with Posts-->
                            <div class="widget">                         <div class="tabs">
                                <ul class="nav nav-tabs" id="tabs-posts" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab">Popüler Konular</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="tabs-posts-content">
                                    <div class="tab-pane fade show active" id="popular" role="tabpanel" aria-labelledby="popular-tab">
                                        <div class="post-thumbnail-list">

                                        <?php 

                                        $populerSorgu = $db->prepare('SELECT * FROM yazilar INNER JOIN kategoriler ON kategoriler.id = yazilar.yazi_kat_id WHERE yazi_durum=:d ORDER BY yazi_goruntulenme DESC LIMIT :lim');
                                        $populerSorgu->bindValue(':d',1,PDO::PARAM_INT);
                                        $populerSorgu->bindValue(':lim',5,PDO::PARAM_INT);
                                        $populerSorgu->execute();
                                        if($populerSorgu->rowCount()){
                                            foreach($populerSorgu as $item){ ?>
                                        
                                        <div class="post-thumbnail-entry">
                                                <img alt="<?=$item['yazi_baslik']?>" src="<?=$arow->site_url?>/images/<?=$item['yazi_foto']?>">
                                                <div class="post-thumbnail-content">
                                                    <a href="<?=$arow->site_url?>/yazidetay.php?yazi_sef=<?=$item['yazi_sef']?>&id=<?=$item['yazi_id']?>"><?=$item['yazi_baslik']?></a>
                                                    <span class="post-date"><i class="far fa-clock"></i><?php echo date('d.m.Y',strtotime($item['yazi_tarih']))?></span>
                                                    <span class="post-category"><i class="fa fa-tag"></i><?=$item['kat_adi']?></span>
                                                </div>
                                        </div>
                                        
                                        <?php
                                            }
                                        }


                                        ?>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <!--End: Tabs with Posts-->
                            <!-- Bülten Aboneliği -->
                            <div class="widget  widget-newsletter">
                            <h4 class="widget-title">Bülten Aboneliği</h4>
                            <form id="aboneformu" action="" onsubmit="return false" method="post" class="form-inline">
                                <div class="input-group">
                                    <input type="text" aria-required="true" name="eposta" class="form-control widget-search-form" placeholder="E-Posta adresiniz">
                                    <div class="input-group-append">
                                        <span class="input-group-btn">
                                        <button type="submit" id="widget-widget-search-form-button" onclick="aboneOl()" class="btn"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            </div>
                            <!-- end: Bülten Aboneliği -->

                            <!--widget tags -->
                            <div class="widget  widget-tags">
                                <h4 class="widget-title">Etiket Bulutu</h4>
                                <div class="tags">
                                <?php echo etiketler()?>
                                </div>
                            </div>
                            <!--end: widget tags -->


</div>