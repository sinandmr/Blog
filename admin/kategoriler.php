<?php define('guvenlikadmin',true);
require_once 'inc/ust.php'; ?>
    <!-- Sidebar menu-->
<?php require_once 'inc/sol.php'; ?>

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Kategoriler</h1>
          <p>Kategori Listesi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Kategoriler</li>
          <li class="breadcrumb-item active"><a href="#">Kategori Listesi</a></li>
        </ul>
      </div>
      <div class="row">
      <?php
                  # Sayfalama
                  $s = @intval(get('s'));
                  if(!$s) $s = 1;

                  $toplam = say('kategoriler'); // toplam kategori sayısını verir.
                  $lim = 10;
                  $goster = $s * $lim - $lim;
                  # Sayfalama

                  $kategoriler = $db->prepare('SELECT * FROM kategoriler ORDER BY id DESC LIMIT :goster, :lim');
                  $kategoriler->bindValue(':goster',$goster,PDO::PARAM_INT);
                  $kategoriler->bindValue(':lim',$lim,PDO::PARAM_INT);
                  $kategoriler->execute();

                  if($s > ceil($toplam/$lim)) $s = 1;

                  
        ?>
        <div class="clearfix"></div>
        <div class="col-md-12">
          <div class="tile">
            <?php  if($kategoriler->rowCount()){ ?>
            <h3 class="tile-title">Kategori Listesi (<?=say('kategoriler')?>)</h3>
            <div class="table-responsive table-hover">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>KATEGORİ ADI</th>
                    <th>KATEGORİ KELİMELERİ</th>
                    <th>KATEGORİ AÇIKLAMA</th>
                    <th>İŞLEMLER</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($kategoriler as $kategori){ ?>
                  <tr>
                    <td><?=$kategori['id']?></td>
                    <td><?=$kategori['kat_adi']?></td>
                    <td><?=$kategori['kat_keyw']?></td>
                    <td><?=$kategori['kat_desc']?></td>
                      <td><a href="<?=$yonetim.'/islemler.php?islem=kategoriduzenle&id='.$kategori['id']?>"><i class="fa fa-edit"></i></a> | <a onclick="return confirm('Kategori silindiği zaman bu kategoriye ait tüm konular pasif duruma gelecektir. Onaylıyor musunuz?');" href="<?=$yonetim.'/islemler.php?islem=kategorisil&id='.$kategori['id']?>"><i class="fa fa-eraser"></i></a></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <ul class="pagination">
			        <?php 
                if($toplam > $lim){
                    pagination($s,ceil($toplam/$lim),'kategoriler.php?s=');
                }
                ?>
			      </ul>
            <?php } else { 
                        echo '<div class="alert alert-danger">Kategori bulunmuyor..</div>';
            } ?>
          </div>

        </div>
      </div>
    </main>
    
<?php require_once 'inc/alt.php'; ?>