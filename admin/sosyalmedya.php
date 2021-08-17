<?php define('guvenlikadmin',true);
require_once 'inc/ust.php'; ?>
    <!-- Sidebar menu-->
<?php require_once 'inc/sol.php'; ?>

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Sosyal Medya</h1>
          <p>Sosyal Medya Hesapları</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Sosyal Medya</li>
          <li class="breadcrumb-item active"><a href="#">Sosyal Medya Hesapları</a></li>
        </ul>
      </div>
      <div class="row">
      <?php
                  # Sayfalama
                  $s = @intval(get('s'));
                  if(!$s) $s = 1;

                  $toplam = say('sosyalmedya'); // toplam sosyal medya hesap sayısını verir.
                  $lim = 10;
                  $goster = $s * $lim - $lim;
                  # Sayfalama

                  $sosyalMedya = $db->prepare('SELECT * FROM sosyalmedya ORDER BY id DESC LIMIT :goster, :lim');
                  $sosyalMedya->bindValue(':goster',$goster,PDO::PARAM_INT);
                  $sosyalMedya->bindValue(':lim',$lim,PDO::PARAM_INT);
                  $sosyalMedya->execute();

                  if($s > ceil($toplam/$lim)) $s = 1;

                  
        ?>
        <div class="clearfix"></div>
        <div class="col-md-12">
          <div class="tile">
            <?php  if($sosyalMedya->rowCount()){ ?>
            <h3 class="tile-title">Sosyal Medya Hesapları (<?=say('sosyalmedya')?>)</h3>
            <div class="table-responsive table-hover">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>İKON</th>
                    <th>LİNK</th>
                    <th>DURUM</th>
                    <th>İŞLEMLER</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($sosyalMedya as $hesap){ ?>
                  <tr>
                    <td><?=$hesap['id']?></td>
                    <td><?=$hesap['ikon']?></td>
                    <td><?=$hesap['link']?></td>
                    <td><?php echo $hesap['durum'] ? '<div style="color:green;font-weight:bold">Aktif</div>' : '<div style="color:red;font-weight:bold">Pasif</div>'?></td>
                    <td><a href="<?=$yonetim.'/islemler.php?islem=sosyalmedyaduzenle&id='.$hesap['id']?>"><i class="fa fa-edit"></i></a> | <a onclick="return confirm('Sosyal medya hesabınız silinecek. Onaylıyor musunuz?');" href="<?=$yonetim.'/islemler.php?islem=sosyalmedyasil&id='.$hesap['id']?>"><i class="fa fa-eraser"></i></a></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <ul class="pagination">
			        <?php 
                if($toplam > $lim){
                    pagination($s,ceil($toplam/$lim),'sosyalmedya.php?s=');
                }
                ?>
			      </ul>
            <?php } else { 
                        echo '<div class="alert alert-danger">Sosyal medya hesabı bulunmuyor..</div>';
            } ?>
          </div>

        </div>
      </div>
    </main>
    
<?php require_once 'inc/alt.php'; ?>