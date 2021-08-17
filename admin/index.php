<?php 
define('guvenlikadmin',true);
require_once 'inc/ust.php'; ?>
<?php echo sha1(md5('123'))?>
    <!-- Sidebar menu-->
    <?php require_once 'inc/sol.php'; ?>


    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Yönetim Paneli</h1>
          <p>Blog Sitesi | Yönetim Paneli</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Ana Sayfa</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4>Aboneler</h4>
              <p><b><?=say('aboneler')?> Adet</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-comment fa-3x"></i>
            <div class="info">
              <h4>Yorumlar</h4>
              <p><b><?=say('yorumlar')?> Adet</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
              <h4>Yazılar</h4>
              <p><b><?=say('yazilar')?> Adet</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-envelope fa-3x"></i>
            <div class="info">
              <h4>Mesajlar</h4>
              <p><b><?=say('mesajlar')?> Adet</b></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Son 10 Mesaj</h3>
            
            <?php

            $mesajlar = $db->prepare('SELECT * FROM mesajlar ORDER BY id DESC LIMIT :lim');
            $mesajlar->bindValue(':lim',10,PDO::PARAM_INT);
            $mesajlar->execute();
            if($mesajlar->rowCount()){ ?>
            <div class="table-responsive table-hover">
                  <table class="table">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>İsim</th>
                            <th>Konu</th>
                            <th>Tarih</th>
                            <th>Detaylar</th>
                        </tr>
                      </thead>
              <?php foreach($mesajlar as $mesaj){ ?>

                      <tbody>
                        <tr>
                            <td><?=$mesaj['id']?></td>
                            <td><?=$mesaj['isim']?></td>
                            <td><?=$mesaj['konu']?></td>
                            <td><?=date('d.m.Y',strtotime($mesaj['tarih']))?></td>
                            <td><a href="<?=$yonetim?>/islemler.php?islem=mesajoku&id=<?=$mesaj['id']?>"><i class="fa fa-eye"></i></a></td>
                        </tr>
                      </tbody>
              
              <?php } ?>
              </table>
              </div>  

            <?php } else {
              echo '<div class="alert alert-danger">Mesaj bulunmuyor..</div>';
            }
          ?>

            <div class="embed-responsive embed-responsive-16by9">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Son 10 Yorum</h3>
            <?php

            $yorumlar = $db->prepare('SELECT * FROM yorumlar INNER JOIN yazilar ON yazilar.yazi_id = yorumlar.yorum_yazi_id ORDER BY yorum_tarih DESC LIMIT :lim');
            $yorumlar->bindValue(':lim',10,PDO::PARAM_INT);
            $yorumlar->execute();
            if($yorumlar->rowCount()){ ?>
            <div class="table-responsive table-hover">
                  <table class="table">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>İsim</th>
                            <th>Yazı</th>
                            <th>Tarih</th>
                            <th>Detaylar</th>
                        </tr>
                      </thead>
              <?php foreach($yorumlar as $yorum){ ?>

                      <tbody>
                        <tr>
                            <td><?=$yorum['id']?></td>
                            <td><?=$yorum['yorum_isim']?></td>
                            <td><?=$yorum['yazi_baslik']?></td>
                            <td><?=date('d.m.Y',strtotime($yorum['yorum_tarih']))?></td>
                            <td><a href="<?=$yonetim?>/islemler.php?islem=yorumoku&id=<?=$yorum['id']?>"><i class="fa fa-eye"></i></a></td>
                        </tr>
                      </tbody>
              
              <?php } ?>
              </table>
              </div>  

            <?php } else {
              echo '<div class="alert alert-danger">Mesaj bulunmuyor..</div>';
            }
            ?>
            <div class="embed-responsive embed-responsive-16by9">

            </div>
          </div>
        </div>
      </div>
    </main>


<?php require_once 'inc/alt.php'; ?>