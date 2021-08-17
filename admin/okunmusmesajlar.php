<?php define('guvenlikadmin',true);
require_once 'inc/ust.php'; ?>
    <!-- Sidebar menu-->
<?php require_once 'inc/sol.php'; ?>

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Mesajlar</h1>
          <p>Okunmuş Mesaj Listesi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Mesajlar</li>
          <li class="breadcrumb-item active"><a href="#">Okunmuş Mesaj Listesi</a></li>
        </ul>
      </div>
      <div class="row">
      <?php
                  # Sayfalama
                  $s = @intval(get('s'));
                  if(!$s) $s = 1;

                  $toplam = say('mesajlar','durum',1); // toplam kategori sayısını verir.
                  $lim = 10;
                  $goster = $s * $lim - $lim;
                  # Sayfalama

                  $mesajlar = $db->prepare('SELECT * FROM mesajlar WHERE durum=:d ORDER BY id DESC LIMIT :goster, :lim');
                  $mesajlar->bindValue(':goster',$goster,PDO::PARAM_INT);
                  $mesajlar->bindValue(':lim',$lim,PDO::PARAM_INT);
                  $mesajlar->bindValue(':d',1,PDO::PARAM_INT);
                  $mesajlar->execute();

                  if($s > ceil($toplam/$lim)) $s = 1;

                  
        ?>
        <div class="clearfix"></div>
        <div class="col-md-12">
          <div class="tile">
            <?php  if($mesajlar->rowCount()){ ?>
            <h3 class="tile-title">Okunmuş Mesaj Listesi (<?=say('mesajlar','durum','1')?>)</h3>
            <div class="table-responsive table-hover">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>İSİM</th>
                    <th>KONU</th>
                    <th>EPOSTA</th>
                    <th>TARİH</th>
                    <th>İŞLEM</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($mesajlar as $mesaj){ ?>
                  <tr>
                    <td><?=$mesaj['id']?></td>
                    <td><?=$mesaj['isim']?></td>
                    <td><?=$mesaj['konu']?></td>
                    <td><?=$mesaj['eposta']?></td>
                    <td><?=date('d.m.Y',strtotime($mesaj['tarih']))?></td>
                      <td><a href="<?=$yonetim.'/islemler.php?islem=mesajoku&id='.$mesaj['id']?>"><i class="fa fa-eye"></i></a> | <a onclick="return confirm('Mesaj silinecek. Onaylıyor musunuz?');" href="<?=$yonetim.'/islemler.php?islem=mesajsil&id='.$mesaj['id']?>"><i class="fa fa-eraser"></i></a></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <ul class="pagination">
			        <?php 
                if($toplam > $lim){
                    pagination($s,ceil($toplam/$lim),'okunmusmesajlar.php?s=');
                }
                ?>
			      </ul>
            <?php } else { 
                        echo '<div class="alert alert-danger">Mesaj bulunmuyor..</div>';
            } ?>
          </div>

        </div>
      </div>
    </main>
    
<?php require_once 'inc/alt.php'; ?>