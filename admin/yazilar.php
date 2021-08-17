<?php define('guvenlikadmin',true);
require_once 'inc/ust.php'; ?>
    <!-- Sidebar menu-->
<?php require_once 'inc/sol.php'; ?>

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Yazılar</h1>
          <p>Yazı Listesi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Yazılar</li>
          <li class="breadcrumb-item active"><a href="#">Yazı Listesi</a></li>
        </ul>
      </div>
      <div class="row">
      <?php
                  # Sayfalama
                  $s = @intval(get('s'));
                  if(!$s) $s = 1;

                  $toplam = say('yazilar'); // toplam kategori sayısını verir.
                  $lim = 10;
                  $goster = $s * $lim - $lim;
                  # Sayfalama

                  $yazilar = $db->prepare('SELECT * FROM yazilar INNER JOIN kategoriler ON kategoriler.id = yazilar.yazi_kat_id ORDER BY yazi_id DESC LIMIT :goster, :lim');
                  $yazilar->bindValue(':goster',$goster,PDO::PARAM_INT);
                  $yazilar->bindValue(':lim',$lim,PDO::PARAM_INT);
                  $yazilar->execute();

                  if($s > ceil($toplam/$lim)) $s = 1;

                  
        ?>
        <div class="col-md-12">
          <form action="<?=$yonetim.'/yaziara.php'?>" method="GET">
            <input type="text" class="form-control" name="q" placeholder="Bulmak istediğiniz yazı başlığını girin.">
          </form><br>
        </div>

        <div class="clearfix"></div>
        <div class="col-md-12">
          <div class="tile">
            <?php  if($yazilar->rowCount()){ ?>
            <h3 class="tile-title">Yazı Listesi (<?=say('yazilar')?>)</h3>
            <div class="table-responsive table-hover">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>FOTOĞRAF</th>
                    <th>BAŞLIK</th>
                    <th>KATEGORİ</th>
                    <th>TARİH</th>
                    <th>DURUM</th>
                    <th>GÖRÜNTÜLENME</th>
                    <th>İŞLEM</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($yazilar as $yazi){ ?>
                  <tr>
                    <td><?=$yazi['yazi_id']?></td>
                    <td><img src="../images/<?=$yazi['yazi_foto']?>" width="100" height="100" alt=""></td>
                    <td><b><?=$yazi['yazi_baslik']?></b></td>
                    <td><?=$yazi['kat_adi']?></td>
                    <td><?=date('d.m.Y',strtotime($yazi['yazi_tarih']))?></td>
                    <td><?php echo $yazi['yazi_durum']==1 ? '<div style="color:green;font-weight:bold">Aktif</div>' : '<div style="color:red;font-weight:bold">Pasif</div>'?></td>
                    <td><b><?=$yazi['yazi_goruntulenme']?></b></td>
                      <td><a href="<?=$yonetim.'/islemler.php?islem=yaziduzenle&id='.$yazi['yazi_id']?>"><i class="fa fa-edit"></i></a> | <a onclick="return confirm('Yazı silinecek. Onaylıyor musunuz?');" href="<?=$yonetim.'/islemler.php?islem=yazisil&id='.$yazi['yazi_id']?>"><i class="fa fa-eraser"></i></a></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <ul class="pagination">
			        <?php 
                if($toplam > $lim){
                    pagination($s,ceil($toplam/$lim),'yazilar.php?s=');
                }
                ?>
			      </ul>
            <?php } else { 
                        echo '<div class="alert alert-danger">Yazı bulunmuyor..</div>';
            } ?>
          </div>

        </div>
      </div>
    </main>
    
<?php require_once 'inc/alt.php'; ?>