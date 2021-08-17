<?php 
define('guvenlikadmin',true);
require_once 'inc/ust.php'; ?>
    <!-- Sidebar menu-->
<?php require_once 'inc/sol.php'; ?>

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Aboneler</h1>
          <p>Abone Listesi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Aboneler</li>
          <li class="breadcrumb-item active"><a href="#">Abone Listesi</a></li>
        </ul>
      </div>
      <div class="row">
      <?php
                  # Sayfalama
                  $s = @intval(get('s'));
                  if(!$s) $s = 1;

                  $toplam = say('aboneler'); // toplam abone sayısını verir.
                  $lim = 10;
                  $goster = $s * $lim - $lim;
                  # Sayfalama

                  $aboneler = $db->prepare('SELECT * FROM aboneler ORDER BY id DESC LIMIT :goster, :lim');
                  $aboneler->bindValue(':goster',$goster,PDO::PARAM_INT);
                  $aboneler->bindValue(':lim',$lim,PDO::PARAM_INT);
                  $aboneler->execute();

                  if($s > ceil($toplam/$lim)) $s = 1;

                  
        ?>
        <div class="clearfix"></div>
        <div class="col-md-12">
          <div class="tile">
            <?php  if($aboneler->rowCount()){ ?>
            <h3 class="tile-title">Abone Listesi (<?=say('aboneler')?>)</h3>
            <div class="table-responsive table-hover">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>EPOSTA</th>
                    <th>İP ADRESİ</th>
                    <th>TARİH</th>
                    <th>İŞLEMLER</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($aboneler as $abone){ ?>
                  <tr>
                    <td><?=$abone['id']?></td>
                    <td><?=$abone['abone_mail']?></td>
                    <td><?=$abone['abone_ip']?></td>
                    <td><?=date('d.m.Y',strtotime($abone['abone_tarih']))?></td>
                      <td><a onclick="return confirm('Bülten aboneniz silinecek. Onaylıyor musunuz?');" href="<?=$yonetim.'/islemler.php?islem=abonesil&id='.$abone['id']?>"><i class="fa fa-eraser"></i></a></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <ul class="pagination">
			        <?php 
                if($toplam > $lim){
                    pagination($s,ceil($toplam/$lim),'aboneler.php?s=');
                }
                ?>
			      </ul>
            <?php } else { 
                        echo '<div class="alert alert-danger">Abone bulunmuyor..</div>';
            } ?>
          </div>

        </div>
      </div>
    </main>
    
<?php require_once 'inc/alt.php'; ?>