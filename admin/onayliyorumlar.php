<?php define('guvenlikadmin',true);
require_once 'inc/ust.php'; ?>
    <!-- Sidebar menu-->
<?php require_once 'inc/sol.php'; ?>

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> YORUMLAR</h1>
          <p>Onaylanmış Yorum Listesi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Yorumlar</li>
          <li class="breadcrumb-item active"><a href="#">Onaylanmış Yorum Listesi</a></li>
        </ul>
      </div>
      <div class="row">
      <?php
                  # Sayfalama
                  $s = @intval(get('s'));
                  if(!$s) $s = 1;

                  $toplam = say('yorumlar','yorum_durum',1); // toplam kategori sayısını verir.
                  $lim = 10;
                  $goster = $s * $lim - $lim;
                  # Sayfalama

                  $yorumlar = $db->prepare('SELECT * FROM yorumlar INNER JOIN yazilar ON yazilar.yazi_id = yorumlar.yorum_yazi_id WHERE yorum_durum=:d ORDER BY id DESC LIMIT :goster, :lim');
                  $yorumlar->bindValue(':goster',$goster,PDO::PARAM_INT);
                  $yorumlar->bindValue(':lim',$lim,PDO::PARAM_INT);
                  $yorumlar->bindValue(':d',1,PDO::PARAM_INT);
                  $yorumlar->execute();

                  if($s > ceil($toplam/$lim)) $s = 1;

                  
        ?>
        <div class="clearfix"></div>
        <div class="col-md-12">
          <div class="tile">
            <?php  if($yorumlar->rowCount()){ ?>
            <h3 class="tile-title">Onaylanmış Yorum Listesi (<?=say('yorumlar','yorum_durum',1)?>)</h3>
            <div class="table-responsive table-hover">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>İSİM</th>
                    <th>EPOSTA</th>
                    <th>YAZI</th>
                    <th>TARİH</th>
                    <th>WEBSİTE</th>
                    <th>İŞLEM</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($yorumlar as $yorum){ ?>
                  <tr>
                    <td><?=$yorum['id']?></td>
                    <td><?=$yorum['yorum_isim']?></td>
                    <td><b><?=$yorum['yorum_eposta']?></b></td>
                    <td><?=$yorum['yazi_baslik']?></td>
                    <td><?=date('d.m.Y',strtotime($yorum['yorum_tarih']))?></td>
                    <td><?=$yorum['yorum_website'] ? $yorum['yorum_website'] : '<div style="color:red;font-weight:bold">Belirtilmemiş</div>' ?></td>
                      <td><a href="<?=$yonetim.'/islemler.php?islem=yorumoku&id='.$yorum['id']?>"><i class="fa fa-eye"></i></a> | <a onclick="return confirm('Yorum silinecek. Onaylıyor musunuz?');" href="<?=$yonetim.'/islemler.php?islem=yorumsil&id='.$yorum['id']?>"><i class="fa fa-eraser"></i></a></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <ul class="pagination">
			        <?php 
                if($toplam > $lim){
                    pagination($s,ceil($toplam/$lim),'onayliyorumlar.php?s=');
                }
                ?>
			      </ul>
            <?php } else { 
                        echo '<div class="alert alert-danger">Yorum bulunmuyor..</div>';
            } ?>
          </div>

        </div>
      </div>
    </main>
    
<?php require_once 'inc/alt.php'; ?>