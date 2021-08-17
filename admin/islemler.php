<?php define('guvenlikadmin',true);
require_once 'inc/ust.php'; ?>
    <!-- Sidebar menu-->
<?php require_once 'inc/sol.php'; ?>

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> İşlemler</h1>
          <p>İşlem Listesi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">İşlemler</li>
          <li class="breadcrumb-item active"><a href="#">İşlem Listesi</a></li>
        </ul>
      </div>
      <div class="row">

        <div class="clearfix"></div>
        <div class="col-md-12">
          <div class="tile">
          <h3 class="tile-title" style="border-bottom:2px solid #dee2e6;padding-bottom:10px">İşlemler</h3>
          <?php 
          # Mail göndermek için gerekli olan tanımlamalar.
          use PHPMailer\PHPMailer\PHPMailer;
          require 'inc/mail/Exception.php';
          require 'inc/mail/PHPMailer.php';
          require 'inc/mail/SMTP.php';


          if($_SESSION['oturum'] == sha1(md5($yid.IP()))){
          
          $islem = @get('islem');
          if(!$islem) header('Location:'.$yonetim);

          switch($islem){
            # Silme işlemleri başlangıç

            # Profil işlemleri
            case 'profil':
                if(isset($_POST['profilguncelle'])){
                  $kadi = post('kadi');
                  $eposta = post('eposta');
                  if(!$kadi || !$eposta){
                    echo '<div class="alert alert-danger">Lütfen tüm alanları doldurunuz!</div>';
                  } else {
                    if(!filter_var($eposta, FILTER_VALIDATE_EMAIL)){
                      echo '<div class="alert alert-danger">Eposta adresi geçersiz!</div>';
                    } else {
                      $guncelle = $db->prepare('UPDATE yoneticiler SET kadi=:kadi, eposta=:eposta WHERE id=:id');
                      $guncelle->execute(array(':kadi'=>$kadi, ':eposta'=>$eposta, ':id'=>$yid));
                      if($guncelle){
                        echo '<div class="alert alert-success">Profiliniz güncellendi.</div>';
                        header('refresh:1;url='.$yonetim.'/islemler.php?islem=profil');
                      } else {
                        echo '<div class="alert alert-danger">Profiliniz güncellenemedi!</div>';
                      }

                    }
                  }
                }

                ?>
                
                <form class="form-horizontal" method="POST" action="">
                          <div class="tile-body">
                            <div class="form-group row">
                              <label class="control-label col-md-3">Kullanıcı Adı</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="kadi" value="<?=$ykadi?>">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="control-label col-md-3">Eposta</label>
                              <div class="col-md-8">
                                <input class="form-control col-md-8" type="text" name="eposta" value="<?=$yeposta?>">
                              </div>
                            </div>

                            <div class="tile-footer">
                              <div class="row">
                                <div class="col-md-8 col-md-offset-3">

                                  <button class="btn btn-primary" name="profilguncelle" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Profili Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?=$yonetim?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Ana Sayfaya Dön</a>
                              </div>
                            </div>
                          </div>
                        </form>

                <?php
            break;

            # Sifre değiştir
            case 'sifre':
              if(isset($_POST['sifredegistir'])){
                $sifre1 = post('sifre1');
                $sifre2 = post('sifre2');
                $sifrele = sha1(md5($sifre1));
                if(!$sifre1 || !$sifre2){
                  echo '<div class="alert alert-danger">Lütfen tüm alanları doldurunuz!</div>';
                } else {
                  if($sifre1 == $sifre2){
                
                    $guncelle = $db->prepare('UPDATE yoneticiler SET sifre=:sifre WHERE id=:id');
                    $guncelle->execute(array(':sifre'=>$sifrele,':id'=>$yid));
                    if($guncelle){
                      echo '<div class="alert alert-success">Şifreniz değiştirildi.</div>';
                      header('refresh:1;url='.$yonetim.'/islemler.php?islem=sifre');
                    } else {
                      echo '<div class="alert alert-danger">Şifreniz değiştirilemedi!</div>';
                    }

                } else {
                  echo '<div class="alert alert-danger">Şifreler birbiriyle uyuşmuyor.</div>';

                }
                }
              }

              ?>
              
              <form class="form-horizontal" method="POST" action="">
                        <div class="tile-body">
                          <div class="form-group row">
                            <label class="control-label col-md-3">Yeni Şifre</label>
                            <div class="col-md-8">
                              <input class="form-control" type="password" name="sifre1" placeholder="Yeni Şifre" >
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="control-label col-md-3">Yeni Şifre Tekrar</label>
                            <div class="col-md-8">
                              <input class="form-control" type="password" name="sifre2" placeholder="Yeni Şifre Tekrar" >
                            </div>
                          </div>

                          <div class="tile-footer">
                            <div class="row">
                              <div class="col-md-8 col-md-offset-3">

                                <button class="btn btn-primary" name="sifredegistir" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Şifreyi Değiştir</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?=$yonetim?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Ana Sayfaya Dön</a>
                            </div>
                          </div>
                        </div>
                      </form>

              <?php
            break;

            # Çıkış yap
            case 'cikis':
              session_destroy();
              header('Location:giris.php');
            break;
            // KATEGORİ SİL
            case 'kategorisil':
                $id = get('id');
                if(!$id) header('location:'.$yonetim.$_SERVER['HTTP_REFERER']);
                $kategoriSil = $db->prepare('DELETE FROM kategoriler WHERE id=:id');
                $kategoriSil->execute([':id'=>$id]);
                if($kategoriSil){
                  # kategori silindiğinde kategorinin yazıları pasif hale gelsin.
                  $yaziPasif = $db->prepare('UPDATE yazilar SET yazi_durum=:d WHERE yazi_kat_id=:id');
                  $yaziPasif->execute([':d'=>0,':id'=>$id]);
                  echo '<div class="alert alert-success">Kategori başarıyla silindi ve bu kategoriye ait yazılar pasif konuma getirildi.</div>';
                  header('refresh:2;url='.$_SERVER['HTTP_REFERER']);

                } else { 
                  echo '<div class="alert alert-danger">Hata oluştu."</div>';
                }
            break;
            
            // MESAJ SİL
            case 'mesajsil':
                $id = get('id');
                if(!$id) header('location:'.$_SERVER['HTTP_REFERER']); # islemler.php'ye gelinen sayfaya geri dönderir.
                $mesajSil = $db->prepare('DELETE FROM mesajlar WHERE id=:id');
                $mesajSil->execute([':id'=>$id]);
                if($mesajSil){
                  echo '<div class="alert alert-success">Mesaj başarıyla silindi.</div>';
                  header('refresh:2;url='.$_SERVER['HTTP_REFERER']);
                } else { 
                  echo '<div class="alert alert-danger">Hata oluştu."</div>';
                }
            break;

            // YORUM SİL
            case 'yorumsil':
                $id = get('id');
                if(!$id) header('location:'.$yonetim.'/onayliyorumlar.php');
                $yorumSil = $db->prepare('DELETE FROM yorumlar WHERE id=:id');
                $yorumSil->execute([':id'=>$id]);
                if($yorumSil){
                  echo '<div class="alert alert-success">Yorum başarıyla silindi.</div>';
                  header('refresh:2;url='.$yonetim.'/onayliyorumlar.php');
                } else { 
                  echo '<div class="alert alert-danger">Hata oluştu."</div>';
                }
            break;

            // YAZI SİL
            case 'yazisil':
                $id = get('id');
                if(!$id) header('location:'.$_SERVER['HTTP_REFERER']); # islemler.php'ye gelinen sayfaya geri dönderir.

                $yaziBul = $db->prepare('SELECT * FROM yazilar WHERE yazi_id=:id');
                $yaziBul->execute([':id'=>$id]);
                if($yaziBul->rowCount()){
                  $yaziCek = $yaziBul->fetch(PDO::FETCH_OBJ);

                  $yaziSil = $db->prepare('DELETE FROM yazilar WHERE yazi_id=:id');
                  $yaziSil->execute([':id'=>$id]);
                  if($yaziSil){

                    # Yazıya ait yorumlar silinsin.
                    $yorumSil = $db->prepare('DELETE FROM yorumlar WHERE yorum_yazi_id=:id');
                    $yorumSil->execute([':id'=>$id]);
                    # Yazıya ait fotoğraf silinsin.
                    unlink('../images/'.$yaziCek->yazi_foto);

                    echo '<div class="alert alert-success">Yazı başarıyla silindi.</div>';
                    header('refresh:2;url='.$_SERVER['HTTP_REFERER']);
                  } else { 
                    echo '<div class="alert alert-danger">Hata oluştu."</div>';
                  }
                }


            break;

            // SOSYAL MEDYA HESABI SİL
            case 'sosyalmedyasil':
                $id = get('id');
                if(!$id) header('location:'.$_SERVER['HTTP_REFERER']); # islemler.php'ye gelinen sayfaya geri dönderir.
                $medyaSil = $db->prepare('DELETE FROM sosyalmedya WHERE id=:id');
                $medyaSil->execute([':id'=>$id]);
                if($medyaSil){
                  echo '<div class="alert alert-success">Sosyal medya hesabı başarıyla silindi.</div>';
                  header('refresh:2;url='.$_SERVER['HTTP_REFERER']);
                } else { 
                  echo '<div class="alert alert-danger">Hata oluştu."</div>';
                }
            break;
            
            // ABONE SİL
            case 'abonesil':
                $id = get('id');
                if(!$id) header('location:'.$_SERVER['HTTP_REFERER']); # islemler.php'ye gelinen sayfaya geri dönderir.
                $aboneSil = $db->prepare('DELETE FROM aboneler WHERE id=:id');
                $aboneSil->execute([':id'=>$id]);
                if($aboneSil){
                  echo '<div class="alert alert-success">Abone başarıyla silindi.</div>';
                  header('refresh:2;url='.$_SERVER['HTTP_REFERER']);
                } else { 
                  echo '<div class="alert alert-danger">Hata oluştu."</div>';
                }
            break;
            # Silme işlemleri son

            # Ekleme işlemleri başlangıç

            # Yeni Kategori Ekle
              case 'yenikategori':

                if(isset($_POST['kategoriekle'])){
                  $katadi = post('katadi');
                  $katsef = sef_link($katadi);
                  $katkeyw = post('katkeyw');
                  $katdesc = post('katdesc');
                  if(!$katadi || !$katkeyw || !$katdesc){         
                      echo '<div class="alert alert-danger">Lütfen tüm alanları doldurun.</div>';
                  } else {
                    # Kategori var mı diye kontrol edelim.
                    $kontrol = $db->prepare('SELECT * FROM kategoriler WHERE kat_sef=:sef');
                    $kontrol->execute([':sef'=>$katsef]);
                    if($kontrol->rowCount()) {
                      echo '<div class="alert alert-danger">Bu kategori zaten kayıtlı..</div>';
                    } else {
                      # Kategori yoksa kategoriyi db'ye ekleyelim.
                      $kategoriEkle = $db->prepare('INSERT INTO kategoriler SET kat_adi=:ad,kat_sef=:sef,kat_keyw=:keyw,kat_desc=:desci');
                      $kategoriEkle->execute([':ad'=>$katadi,':sef'=>$katsef,':keyw'=>$katkeyw,':desci'=>$katdesc]);
                      if($kategoriEkle){
                      echo '<div class="alert alert-success">Kategori başarıyla eklendi.</div>';
                      header('refresh:3;url='.$yonetim.'/kategoriler.php');
                      } else {
                      echo '<div class="alert alert-danger">Hata oluştu.</div>';
                      }
                    }
                  } 
                }
                ?>
                  <form class="form-horizontal" method="POST" action="">
                    <div class="tile-body">
                        <div class="form-group row">
                          <label class="control-label col-md-3">Kategori Adı</label>
                          <div class="col-md-8">
                            <input class="form-control" type="text" name="katadi" placeholder="Kategori Adı">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="control-label col-md-3">Kategori Anahtar Kelimeleri</label>
                          <div class="col-md-8">
                            <input class="form-control col-md-8" type="text" name="katkeyw" placeholder="Kategori Anahtar Kelimeleri">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="control-label col-md-3">Kategori Açıklaması</label>
                          <div class="col-md-8">
                            <input class="form-control col-md-8" type="text" name="katdesc" placeholder="Kategori Açıklaması">
                          </div>
                        </div>

                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">

                              <button class="btn btn-primary" name="kategoriekle" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kategori Ekle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?=$yonetim.'/kategoriler.php'?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>

                            </div>
                          </div>
                        </div>

                      </form>
                    

                <?php 
              break;

            # Yeni Sosyal Medya Hesabı Ekle
              case 'yenimedya':

                  if(isset($_POST['medyaekle'])){
                    $ikon = post('ikon');
                    $url = post('url');
                    if(!$ikon || !$url){         
                        echo '<div class="alert alert-danger">Lütfen tüm alanları doldurun.</div>';
                    } else {
                        if (!filter_var($url, FILTER_VALIDATE_URL)) {
                          echo '<div class="alert alert-danger">URL adresini doğru girin.</div>';
                        } else {
                        # Sosyal medya hesabı var mı diye kontrol edelim.
                        $kontrol = $db->prepare('SELECT * FROM sosyalmedya WHERE ikon=:ikon');
                        $kontrol->execute([':ikon'=>$ikon]);
                        if($kontrol->rowCount()) {
                          echo '<div class="alert alert-danger">Bu sosyal medya hesabı zaten kayıtlı..</div>';
                        } else {
                          # Sosyal medya hesabı yoksa Sosyal medyayı db'ye ekleyelim.
                          $medyaEkle = $db->prepare('INSERT INTO sosyalmedya SET ikon=:ikon,link=:link');
                          $medyaEkle->execute([':ikon'=>$ikon,':link'=>$url]);
                          if($medyaEkle){
                          echo '<div class="alert alert-success">Sosyal medya hesabı başarıyla eklendi.</div>';
                          header('refresh:2;url='.$yonetim.'/sosyalmedya.php');
                          } else {
                          echo '<div class="alert alert-danger">Hata oluştu.</div>';
                          }
                        }
                      } 
                    }
                  }
                  ?>
                    <form class="form-horizontal" method="POST" action="">
                      <div class="tile-body">
                          <div class="form-group row">
                            <label class="control-label col-md-3">İkon Adı</label>
                            <div class="col-md-8">
                              <input class="form-control" type="text" name="ikon" placeholder="İkon Adı">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="control-label col-md-3">URL Adresi</label>
                            <div class="col-md-8">
                              <input class="form-control col-md-8" type="text" name="url" placeholder="URL Adresi">
                            </div>
                          </div>


                          <div class="tile-footer">
                            <div class="row">
                              <div class="col-md-8 col-md-offset-3">

                                <button class="btn btn-primary" name="medyaekle" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Sosyal Medya Hesabı Ekle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?=$yonetim.'/kategoriler.php'?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>

                              </div>
                            </div>
                          </div>

                        </form>

                      </div>

                  <?php 
              break;

              # Yeni Yazı Ekle
              case 'yeniyazi':

                  if(isset($_POST['yaziekle'])){
                    require_once 'inc/class.upload.php';

                    $baslik = post('baslik');
                    $kategori = post('kategori');
                    $sefBaslik = sef_link($baslik);
                    $foto = $_FILES['foto'];
                    $icerik = $_POST['icerik'];
                    $etiketler = post('etiketler');

                    if(!$baslik || !$foto || !$icerik || !$etiketler){

                      echo '<div class="alert alert-danger">Lütfen boş alan bırakmayınız.</div>';

                    } else {
                      # Etiketlerin sef link'e çevirilmesi.
                      $sefYap = explode(',',$etiketler);
                      $dizi = array();
                      foreach($sefYap as $par){
                        $dizi[] = sef_link($par);
                      }
                      $deger = implode(',',$dizi);

                      $image = new upload($_FILES['foto']);
                      if($image->uploaded){

                        $rname = 'fotograf-'.md5(uniqid());
                        $image->allowed = array('image/*');
                        $image->file_new_name_body = $rname;
                        $uzanti = $image->file_src_name_ext; // foto uzantısını alıyoruz.
                        $image->image_text_position = "BR";
                        $image->process('../images');

                        if($image->processed){
                          $yaziEkle = $db->prepare('INSERT INTO yazilar SET yazi_baslik=:b,yazi_sef=:s,yazi_kat_id=:k,yazi_foto=:r,yazi_icerik=:i,yazi_etiketler=:e,yazi_sef_etiketler=:se');
                          $yaziEkle->execute([':b'=>$baslik,':s'=>$sefBaslik,':k'=>$kategori,':r'=>$rname.'.'.$uzanti,':i'=>$icerik,':e'=>$etiketler,':se'=>$deger]);

                          if($yaziEkle->rowCount()){
                            $sonid = $db->lastInsertId();
                            
                            # Yazı ekleme başarılı olduysa bonelere mail yollayalım.

                            $gonderen = 'blog@sinandemir.cloud';
                            $sifre = 'mailsifreniz';
                            $mail = new PHPMailer();
                            $mail->Host       = 'mail.hostadresiniz.com';
                            $mail->Port       = 465;
                            $mail->SMTPSecure = 'ssl';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = $gonderen;
                            $mail->Password   = $sifre;
                            $mail->IsSMTP();

                            $mail->From       = $gonderen;
                            $mail->FromName   = 'Sinan Demir | Yeni Yazı Paylaşıldı.';
                            $mail->CharSet    = 'UTF-8';
                            $mail->Subject    = 'Yeni konu eklendi.';

                            $aboneler = $db->prepare('SELECT * FROM aboneler');
                            $aboneler->execute();
                            if($aboneler->rowCount()){
                              foreach($aboneler as $abone){
                                $mail->AddBCC($abone['abone_mail']);

                              }
                            }

                            $yazibul = $db->prepare('SELECT * FROM yazilar WHERE yazi_id=:i');
                            $yazibul->execute([':i'=>$sonid]);
                            $cek = $yazibul->fetch(PDO::FETCH_OBJ);
                            
                            $mailicerik = 'Konu Başlığı : '.$cek->yazi_baslik.'<br> Konu linki : '.$siteURL.'/yazidetay.php?yazi_sef='.$cek->yazi_sef.'&id='.$cek->yazi_id;

                            $mail->MsgHTML($mailicerik);
                            if($mail->Send()){
                                echo '<div class="alert alert-success">Yazı başarıyla yayınlandı.</div>';
                                echo '<div class="alert alert-success">Abonelere mail gönderildi.</div>';
                                header('refresh:2;url='.$yonetim.'/yazilar.php'); 
                                
                            } else {
                              echo '<div class="alert alert-danger">Mail gönderilemedi.</div>';

                            }
                          } else {
                          echo '<div class="alert alert-danger">Yazı eklenirken hata oluştu.</div>';
                          }


                        } else {
                          echo '<div class="alert alert-danger">Fotoğraf yükleme başarısız.</div>';

                        }


                      } else {
                          echo '<div class="alert alert-danger">Fotoğraf seçmediniz.</div>';
                      }
                    }
                  }

                  ?>
                
                    <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                      <div class="tile-body">
                          <div class="form-group row">
                            <label class="control-label col-md-3">Yazı Başlık</label>
                            <div class="col-md-8">
                              <input class="form-control" type="text" name="baslik" placeholder="Yazı Başlık">
                            </div>
                          </div>
                                          
                          <div class="form-group row">
                            <label class="control-label col-md-3">Yazı Kategori</label>
                            <div class="col-md-8">
                              <select name="kategori" class="form-control">
                                <?php
                                  $kategoriler = $db->prepare('SELECT * FROM kategoriler');
                                  $kategoriler->execute();
                                  if($kategoriler->rowCount()){
                                    foreach($kategoriler as $kategori){
                                      echo '<option value="'.$kategori['id'].'">'.$kategori['kat_adi'].'</option>';
                                    }
                                  }
                                ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="control-label col-md-3">Yazı Fotoğraf</label>
                            <div class="col-md-8">
                              <input class="form-control" type="file" name="foto"/>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="control-label col-md-3">Yazı İçerik</label>
                            <div class="col-md-8">
                            <textarea name="icerik" class="ckeditor"></textarea>                           
                          </div>
                          </div>
                          
                          <div class="form-group row">
                            <label class="control-label col-md-3">Yazı Etiketler</label>
                            <div class="col-md-8">
                              <input class="form-control" type="text" name="etiketler" placeholder="Her bir etiketi virgül ile ayırın."/>
                            </div>
                          </div>
                          

                          <div class="tile-footer">
                            <div class="row">
                              <div class="col-md-8 col-md-offset-3">

                                <button class="btn btn-primary" name="yaziekle" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Yazı Ekle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?=$yonetim.'/yazilar.php'?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>

                              </div>
                            </div>
                          </div>

                        </form>

                      </div>

                  <?php 
              break;
            
            # Ekleme işlemleri son

            # Düzenleme ve okuma işlemleri başlangıç

              # Yazı Düzenle
              case 'yaziduzenle':
              $id = get('id');
              if(!$id){
               header('Location:'.$yonetim.'/yazilar.php');
              }
              $yaziCek = $db->prepare('SELECT * FROM yazilar WHERE yazi_id=:id');
              $yaziCek->execute([':id'=>get('id')]);
              $cek = $yaziCek->fetch(PDO::FETCH_OBJ);

              if(isset($_POST['yaziduzenle'])){
                require_once 'inc/class.upload.php';

                $baslik = post('baslik');
                $kategori = post('kategori');
                $sefBaslik = sef_link($baslik);
                $foto = $_FILES['foto'];
                $icerik = $_POST['icerik'];
                $etiketler = post('etiketler');
                $durum = post('durum');

                if(!$baslik || !$kategori || !$icerik || !$etiketler || !$durum){

                  echo '<div class="alert alert-danger">Lütfen boş alan bırakmayınız.</div>';

                } else {
                  # Etiketlerin sef link'e çevirilmesi.
                  $sefYap = explode(',',$etiketler);
                  $dizi = array();
                  foreach($sefYap as $par){
                    $dizi[] = sef_link($par);
                  }
                  $deger = implode(',',$dizi);

                  $image = new upload($_FILES['foto']);
                  if($image->uploaded){

                    $rname = 'fotograf-'.md5(uniqid());
                    $image->allowed = array('image/*');
                    $image->file_new_name_body = $rname;
                    $uzanti = $image->file_src_name_ext; // foto uzantısını alıyoruz.
                    $image->image_text_position = "BR";
                    $image->process('../images');

                    if($image->processed){
                      $yaziGuncelle = $db->prepare('UPDATE yazilar SET yazi_baslik=:b,yazi_sef=:s,yazi_kat_id=:k,yazi_foto=:r,yazi_icerik=:i,yazi_etiketler=:e,yazi_sef_etiketler=:se,yazi_durum=:durum WHERE yazi_id=:id');
                      $yaziGuncelle->execute([':b'=>$baslik,':s'=>$sefBaslik,':k'=>$kategori,':r'=>$rname.'.'.$uzanti,':i'=>$icerik,':e'=>$deger,':se'=>$sefBaslik,':id'=>$id,':durum'=>$durum]);

                      if($yaziGuncelle){
                        echo '<div class="alert alert-success">Yazı başarıyla düzenlendi.</div>';
                        header('refresh:1;url='.$yonetim.'/islemler.php?islem=yaziduzenle&id='.$id);
                      } else {
                      echo '<div class="alert alert-danger">Yazı eklenirken hata oluştu.</div>';
                      }


                    } else {
                      echo '<div class="alert alert-danger">Fotoğraf yükleme başarısız.</div>';

                    }


                  } else {
                      $yaziGuncelle2 = $db->prepare('UPDATE yazilar SET 
                      yazi_baslik=:b,
                      yazi_sef=:s,
                      yazi_kat_id=:k,
                      yazi_icerik=:i,
                      yazi_etiketler=:e,
                      yazi_sef_etiketler=:se,
                      yazi_durum=:durum WHERE yazi_id=:id');
                      $yaziGuncelle2->execute([':b'=>$baslik,':s'=>$sefBaslik,':k'=>$kategori,':i'=>$icerik,':e'=>$deger,':se'=>$sefBaslik,':id'=>$id,':durum'=>$durum]);

                      if($yaziGuncelle2->rowCount()){
                        echo '<div class="alert alert-success">Yazı başarıyla güncellendi.</div>';
                        header('refresh:1;url='.$yonetim.'/islemler.php?islem=yaziduzenle&id='.$id);
                  
                      } else {
                      echo '<div class="alert alert-danger">Yazı eklenirken hata oluştu.</div>';
                      }


                  }
                }
              }

              ?>
            
                <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                  <div class="tile-body">
                      <div class="form-group row">
                        <label class="control-label col-md-3">Başlık</label>
                        <div class="col-md-8">
                          <input class="form-control" type="text" name="baslik" value="<?=$cek->yazi_baslik?>">
                        </div>
                      </div>
                                      
                      <div class="form-group row">
                        <label class="control-label col-md-3">Kategori</label>
                        <div class="col-md-8">
                          <select name="kategori" class="form-control">
                            <?php
                              $kategoriler = $db->prepare('SELECT * FROM kategoriler');
                              $kategoriler->execute();
                              if($kategoriler->rowCount()){
                                foreach($kategoriler as $kategori){
                                  if($cek->yazi_kat_id == $kategori['id']){
                                    echo '<option value="'.$kategori['id'].'" selected>'.$kategori['kat_adi'].'</option>';
                                  } else {
                                    echo '<option value="'.$kategori['id'].'">'.$kategori['kat_adi'].'</option>';
                                  }
                                  
                                }
                              }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="control-label col-md-3">Fotoğraf</label>
                        <div class="col-md-8">
                          <img src="<?=$siteURL.'/images/'.$cek->yazi_foto?>" width="250" height="auto" alt="">
                          <input type="file" name="foto" class="form-control">

                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="control-label col-md-3">İçerik</label>
                        <div class="col-md-8">
                        <textarea name="icerik" class="ckeditor"><?=$cek->yazi_icerik?></textarea>                           
                      </div>
                      </div>
                      
                      <div class="form-group row">
                        <label class="control-label col-md-3">Etiketler</label>
                        <div class="col-md-8">
                          <input class="form-control" type="text" name="etiketler" value="<?=$cek->yazi_etiketler?>"/>
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <label class="control-label col-md-3">Durum</label>
                        <div class="col-md-8">
                          <select name="durum" class="form-control">
                            <?php 
                            if($cek->yazi_durum == 1){ ?>
                              <option value="2">Pasif</option>
                              <option value="1" selected>Aktif</option>
                            <?php } else { ?>
                              <option value="2" selected>Pasif</option>
                              <option value="1">Aktif</option>
                            <?php } ?>

                          </select>
                        </div>
                      </div>
                      

                      <div class="tile-footer">
                        <div class="row">
                          <div class="col-md-8 col-md-offset-3">

                            <button class="btn btn-primary" name="yaziduzenle" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Yazıyı Düzenle</button>
                            <a class="btn btn-secondary" href="<?=$yonetim.'/yazilar.php'?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>

                          </div>
                        </div>
                      </div>

                    </form>

                  </div>

              <?php 
              break;
              # Kategori düzenleme
              case 'kategoriduzenle':
                $id = get('id');
                if(!$id){
                  header('Location:'.$yonetim.'/kategoriler.php');
                } else {
                  $kategoribul = $db->prepare('SELECT * FROM kategoriler WHERE id=:i');
                  $kategoribul->execute([':i'=>$id]);
                  if($kategoribul->rowCount()){

                    $cek = $kategoribul->fetch(PDO::FETCH_OBJ);

                    if(isset($_POST['kategoriguncelle'])){

                      $katadi = post('katadi');
                      $katsef = sef_link($katadi);
                      $katkeyw = post('katkeyw');
                      $katdesc = post('katdesc');

                      if(!$katadi || !$katkeyw || !$katdesc){
                        echo '<div class="alert alert-danger">Lütfen tüm alanları doldurunuz.</div>';
                    } else {

                      # bir kategorinin kat_sef'i başka id'li bir kategoriye atanmak istenirse hata vermesi için..
                      $varmi = $db->prepare('SELECT * FROM kategoriler WHERE  kat_sef=:ksef AND id!=:id');
                      $varmi->execute([':ksef'=>$katsef,':id'=>$id]);

                      if($varmi->rowCount()){
                        
                        echo '<div class="alert alert-danger">Bu kategori zaten mevcut.</div>';

                      } else {

                        $kategoriduzenle = $db->prepare('UPDATE kategoriler SET kat_adi=:k, kat_keyw=:k2, kat_desc=:k3 WHERE id=:i');
                        $kategoriduzenle->execute([':k'=>$katadi,':k2'=>$katkeyw,':k3'=>$katdesc,':i'=>$id]);
                        if($kategoriduzenle){

                          echo '<div class="alert alert-success">Kategori başarıyla güncellendi.</div>';
                          header('refresh:2;url='.$yonetim.'/kategoriler.php');

                        }

                      }
                    }
                  }
                  ?>
                    <form class="form-horizontal" method="POST" action="">
                      <div class="tile-body">
                        <div class="form-group row">
                          <label class="control-label col-md-3">Kategori Adı</label>
                          <div class="col-md-8">
                            <input class="form-control" type="text" name="katadi" value="<?=$cek->kat_adi?>">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="control-label col-md-3">Kategori Anahtar Kelimeleri</label>
                          <div class="col-md-8">
                            <input class="form-control col-md-8" type="text" name="katkeyw" value="<?=$cek->kat_keyw?>">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="control-label col-md-3">Kategori Açıklaması</label>
                          <div class="col-md-8">
                            <input class="form-control col-md-8" type="text" name="katdesc" value="<?=$cek->kat_desc?>">
                          </div>
                        </div>

                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">

                              <button class="btn btn-primary" name="kategoriguncelle" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kategoriyi Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?=$yonetim.'/kategoriler.php'?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>
                          </div>
                        </div>
                      </div>
                    </form>
                  
                  <?php } else {
                    header('Location:'.$yonetim.'/kategoriler.php');
                }  
                }
              break;

              # Mesaj oku
              case 'mesajoku':
                $id = get('id');
                if(!$id){
                  header('Location:'.$yonetim.'/yenimesajlar.php');
                }
                $mesajbul = $db->prepare('SELECT * FROM mesajlar WHERE id=:i');
                $mesajbul->execute([':i'=>$id]);
                if($mesajbul->rowCount()){
                  
                  $cek = $mesajbul->fetch(PDO::FETCH_OBJ);
                  $guncelle = $db->prepare('UPDATE mesajlar SET durum=:d WHERE id=:id');
                  $guncelle->execute([':d'=>1,':id'=>$id]);
                  echo '<b>İsim : </b>'.$cek->isim.'<br>';
                  echo '<b>Konu : </b>'.$cek->konu.'<br>';
                  echo '<b>Eposta : </b>'.$cek->eposta.'<br>';
                  echo '<b>Mesaj : </b>'.$cek->mesaj.'<br>'; 
                  echo '<hr>';
                  echo '<div class="alert alert-info">Bu mesaj <b>'.date('d.m.Y H:i',strtotime($cek->tarih)).'</b> tarihinde <b>'.$cek->ip.'</b> ip adresinden gönderilmiştir.</div>';
                  echo '<a class="btn btn-secondary" href="'.$yonetim.'/yenimesajlar.php"><i class="fa fa-arrow-left" ></i>Listeye Dön</a>';


                } else {
                  header('Location:'.$yonetim.'/yenimesajlar.php');
                }

              break;

              # Yorum okuma
              case 'yorumoku':
                $id = get('id');
                if(!$id){
                  header('Location:'.$yonetim.'/bekleyenyorumlar.php');
                }
                $yorumbul = $db->prepare('SELECT * FROM yorumlar INNER JOIN yazilar ON yazilar.yazi_id = yorumlar.yorum_yazi_id WHERE id=:i');
                $yorumbul->execute([':i'=>$id]);
                if($yorumbul->rowCount()){
                  
                  $cek = $yorumbul->fetch(PDO::FETCH_OBJ);
                  echo '<b>İsim : </b>'.$cek->yorum_isim.'<br>';
                  echo '<b>Eposta : </b>'.$cek->yorum_eposta.'<br>';
                  echo '<b>Yazı : </b><a href="'.$siteURL.'/yazidetay.php?yazi_sef='.$cek->yazi_sef.'&id='.$cek->yazi_id.'">'.$cek->yazi_baslik.'</a><br>';
                  echo '<b>Website : </b><a href="'.$cek->yorum_website.'">'.$cek->yorum_website.'</a><br>'; 
                  echo '<b>İçerik : </b>'.$cek->yorum_icerik.'<br>'; 
                  echo '<hr>';
                  echo '<div class="alert alert-info">Bu mesaj <b>'.date('d.m.Y H:i',strtotime($cek->yorum_tarih)).'</b> tarihinde <b>'.$cek->yorum_ip.'</b> ip adresinden gönderilmiştir.</div>';
                  echo '<hr>';
                  echo !$cek->yorum_durum ? '<a class="btn btn-success" href="'.$yonetim.'/islemler.php?islem=yorumonayla&id='.$cek->id.'"><i class="fa fa-check"></i>Yorumu Onayla</a> ' : '<a class="btn btn-danger" href="'.$yonetim.'/islemler.php?islem=yorumsil&id='.$cek->id.'"><i class="fa fa-times"></i>Yorumu Sil</a> ';
                  echo '<a class="btn btn-secondary" href="'.$yonetim.'/bekleyenyorumlar.php"><i class="fa fa-arrow-left" ></i>Listeye Dön</a>';
                } else {
                  header('Location:'.$yonetim.'/yenimesajlar.php');
                }
              break;
              # Yorum onayla
              case 'yorumonayla':
                $id = get('id');
                if(!$id){
                  header('Location:'.$yonetim.'/bekleyenyorumlar.php');
                }
                $yorumonayla = $db->prepare('UPDATE yorumlar SET yorum_durum=:d WHERE id=:id');
                $yorumonayla->execute([':d'=>1,':id'=>$id]);
                if($yorumonayla){
                  echo '<div class="alert alert-success">Yorum onaylandı.</div>';
                  header('refresh:2;url='.$yonetim.'/islemler.php?islem=yorumoku&id='.$id);
                } else {
                  echo '<div class="alert alert-danger">Yorum onaylama işlemi başarısız!</div>';
                  header('Location:'.$yonetim.'/bekleyenyorumlar.php');
                }
              break;
              
              # Sosyal medya düzenle
              case 'sosyalmedyaduzenle':
                $id = get('id');
                if(!$id){
                  header('Location:'.$yonetim.'/sosyalmedya.php');
                } else {
                  $medyabul = $db->prepare('SELECT * FROM sosyalmedya WHERE id=:i');
                  $medyabul->execute([':i'=>$id]);
                  if($medyabul->rowCount()){

                    $cek = $medyabul->fetch(PDO::FETCH_OBJ);

                    if(isset($_POST['sosyalmedyaguncelle'])){

                      $ikon = post('ikon');
                      $link = post('link');

                      if(!$ikon || !$link){
                        echo '<div class="alert alert-danger">Lütfen tüm alanları doldurunuz.</div>';
                    } else {

                        $medyaguncelle = $db->prepare('UPDATE sosyalmedya SET ikon=:i, link=:l WHERE id=:id');
                        $medyaguncelle->execute([':i'=>$ikon,':l'=>$link,':id'=>$id]);
                        if($medyaguncelle){
                          echo '<div class="alert alert-success">Sosyal medya hesabı başarıyla güncellendi.</div>';
                          header('refresh:2;url='.$yonetim.'/sosyalmedya.php');
                        }                      
                   }
                  }
                  ?>
                    <form class="form-horizontal" method="POST" action="">
                      <div class="tile-body">
                        <div class="form-group row">
                          <label class="control-label col-md-3">İkon Adı</label>
                          <div class="col-md-8">
                            <input class="form-control" type="text" name="ikon" value="<?=$cek->ikon?>">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="control-label col-md-3">Link</label>
                          <div class="col-md-8">
                            <input class="form-control col-md-8" type="text" name="link" value="<?=$cek->link?>">
                          </div>
                        </div>

                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">

                              <button class="btn btn-primary" name="sosyalmedyaguncelle" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Sosyal Medya Hesabını Güncelle</button>
                              <?php
                              if(!$cek->durum){
                                echo '<a class="btn btn-success" href="'.$yonetim.'/islemler.php?islem=sosyalmedyadurum&id='.$cek->id.'&durum=1"><i class="fa fa-check"></i>Aktif Hale Getir</a>';
                              } else {
                                echo '<a class="btn btn-danger" href="'.$yonetim.'/islemler.php?islem=sosyalmedyadurum&id='.$cek->id.'&durum=0"><i class="fa fa-times"></i>Pasif Hale Getir</a>';  
                              }
                              ?>
                              <a class="btn btn-secondary" href="<?=$yonetim.'/sosyalmedya.php'?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>                              
                          </div>
                        </div>
                      </div>
                    </form>
                  
                  <?php } else {
                    header('Location:'.$yonetim.'/kategoriler.php');
                }  
              }
              break;

              # Sosyal medya durum belirleme
              case 'sosyalmedyadurum':
                $id = get('id');
                $durum = get('durum');
                  if(!$id){
                    header('Location:'.$yonetim.'/sosyalmedya.php');
                  }

                  $medyadurum = $db->prepare('UPDATE sosyalmedya SET durum=:d WHERE id=:id');
                  $medyadurum->execute([':d'=>$durum,':id'=>$id]);
                  if($medyadurum){
                    if($durum == 1){
                      echo '<div class="alert alert-info">Sosyal medya hesabı <b>Aktif</b> hale getirildi.</div>';
                      header('refresh:2;url='.$yonetim.'/sosyalmedya.php');
                    } else {
                      echo '<div class="alert alert-info">Sosyal medya hesabı <b>Pasif</b> hale getirildi.</div>';
                      header('refresh:2;url='.$yonetim.'/sosyalmedya.php');
                    }
                  } else {
                    echo '<div class="alert alert-danger">İşlem başarısız!</div>';
                    header('refresh:2;url='.$yonetim.'/sosyalmedya.php');
                  }
              break;

              # Genel ayarlar
              case 'genelayar':
                  $ayarCek = $db->prepare('SELECT * FROM ayarlar');
                  $ayarCek->execute();
                  $cek = $ayarCek->fetch(PDO::FETCH_OBJ);
                    if(isset($_POST['ayarguncelle'])){
                      $url = post('url');
                      $baslik = post('baslik');
                      $keyw = post('keyw');
                      $desc = post('desc');
                      $bakim = post('bakimmodu');
                      $mail = post('mail');
                      
                      if(!$url || !$baslik || !$keyw || !$desc || !$bakim || !$mail){
                        echo '<div class="alert alert-danger">Lütfen tüm alanları doldurunuz.</div>';
                      } else {

                        $ayarguncelle = $db->prepare('UPDATE ayarlar SET site_url=:u, site_baslik=:b, site_keyw=:k, site_desc=:d, site_durum=:durum, site_mail=:m WHERE id=:id');
                        $ayarguncelle->execute([':u'=>$url,':b'=>$baslik,':k'=>$keyw,':d'=>$desc,':durum'=>$bakim,':m'=>$mail,':id'=>1]);
                        if($ayarguncelle){
                          header('location:'.$yonetim.'/islemler.php?islem=genelayar');
                        } else {
                          echo '<div class="alert alert-danger">İşlem başarısız!</div>';
                        }
                      }
                    }
                  ?>

                        <form class="form-horizontal" method="POST" action="">
                          <div class="tile-body">

                              <div class="form-group row">
                                <label class="control-label col-md-3">URL (Sonunda / olmadan yazınız)</label>
                                <div class="col-md-8">
                                  <input class="form-control" type="text" name="url" value="<?=$cek->site_url?>">
                                </div>
                              </div>
                              
                              <div class="form-group row">
                                <label class="control-label col-md-3">Mail</label>
                                <div class="col-md-8">
                                  <input class="form-control" type="text" name="mail" value="<?=$cek->site_mail?>">
                                </div>
                              </div>

                              <div class="form-group row">
                                <label class="control-label col-md-3">Başlık</label>
                                <div class="col-md-8">
                                  <input class="form-control" type="text" name="baslik" value="<?=$cek->site_baslik?>">
                                </div>
                              </div>
                              
                              <div class="form-group row">
                                <label class="control-label col-md-3">Anahtar Kelimeler</label>
                                <div class="col-md-8">
                                  <input class="form-control" type="text" name="keyw" value="<?=$cek->site_keyw?>">
                                </div>
                              </div>
                              
                              <div class="form-group row">
                                <label class="control-label col-md-3">Açıklama</label>
                                <div class="col-md-8">
                                  <input class="form-control" type="text" name="desc" value="<?=$cek->site_desc?>">
                                </div>
                              </div>
                                              
                              <div class="form-group row">
                                <label class="control-label col-md-3">Bakım Modu</label>
                                <div class="col-md-8">
                                  <select name="bakimmodu" class="form-control">
                                    <?php 
                                      if($cek->site_durum == 2){ ?>
                                      <option value="1">Pasif</option>
                                      <option value="2" selected>Aktif</option>
                                    <?php } else { ?>
                                      <option value="1" selected>Pasif</option>
                                      <option value="2">Aktif</option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              
                              <div class="tile-footer">
                                <div class="row">
                                  <div class="col-md-8 col-md-offset-3">

                                    <button class="btn btn-primary" name="ayarguncelle" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Ayarları Güncelle</button> 
                                    <a class="btn btn-secondary" href="<?=$yonetim?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Ana Sayfaya Dön</a>

                                  </div>
                                </div>
                              </div>
                          </div>
                        </form>

                  <?php
                    
              break;

              # İletişim Güncelle
              case 'iletisim': 
                $ayarlar = $db->prepare('SELECT * FROM ayarlar');
                $ayarlar->execute();
                $cek = $ayarlar->fetch(PDO::FETCH_OBJ);

                if(isset($_POST['iletisimguncelle'])){
                  $mail = post('mail');
                  $harita = post('harita');
                  if(!$mail || !$harita){
                    echo'<div class="alert alert-danger">Lütfen tüm alanları doldurunuz.</div>';
                  } else {
                    $iletisimguncelle = $db->prepare('UPDATE ayarlar SET site_mail=:m, site_harita=:h');
                    $iletisimguncelle->execute([':m'=>$mail,':h'=>$harita]);
                    if($iletisimguncelle){
                      header('Location:'.$yonetim.'/islemler.php?islem=iletisim');
                    }
                  }
                } 
                ?>
              
               
                <form class="form-horizontal" method="POST" action="">
                          <div class="tile-body">

                              <div class="form-group row">
                                <label class="control-label col-md-3">Mail Adresi</label>
                                <div class="col-md-8">
                                  <input class="form-control" type="text" name="mail" value="<?=$cek->site_mail?>">
                                </div>
                              </div>
                              
                              <div class="form-group row">
                                <label class="control-label col-md-3">Harita Adresi</label>
                                <div class="col-md-8">
                                  <input class="form-control" type="text" name="harita" value="<?=$cek->site_harita?>">
                                </div>
                              </div>
                              
                              <div class="tile-footer">
                                <div class="row">
                                  <div class="col-md-8 col-md-offset-3">

                                    <button class="btn btn-primary" name="iletisimguncelle" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>İletişimi Güncelle</button> 
                                    <a class="btn btn-secondary" href="<?=$yonetim?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Ana Sayfaya Dön</a>

                                  </div>
                                </div>
                              </div>
                          </div>
                        </form>

                <?php 
              break;

              # Logo güncelle
              case 'logo':
                  include 'inc/class.upload.php';
                  $ayarlar = $db->prepare('SELECT * FROM ayarlar WHERE id=:id');
                  $ayarlar->execute([':id'=>1]);
                  $cek = $ayarlar->fetch(PDO::FETCH_OBJ);

                  if(isset($_POST['logoguncelle'])){
                    $image = new upload($_FILES['foto']);
                    if($image->uploaded){

                      $rname = 'logo-'.uniqid();
                      $image->allowed = array('image/*');
                      $image->file_new_name_body = $rname;
                      $uzantı = $image->file_src_name_ext; // foto uzantısını alıyoruz.
                      $image->process('../images/logo');

                      if($image->processed){
                        $guncelle = $db->prepare('UPDATE ayarlar SET site_logo=:l WHERE id=:id');
                        $guncelle->execute([':l'=>$rname.'.'.$uzantı,':id'=>1]);
                        if($guncelle){
                          echo '<div class="alert alert-success">Logo güncellendi.</div>';
                          header('refresh:2;url='.$yonetim.'/islemler.php?islem=logo');
                        } else {
                          echo '<div class="alert alert-danger">Logo güncellenemedi.</div>';
                        }

                    } else {

                      echo '<div class="alert alert-danger">Fotoğraf yüklenemedi.</div>';
                    }
                  } else {
                      echo '<div class="alert alert-danger">Fotoğraf seçmediniz.</div>';
                  }

                }                  
                ?>
                <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                        <div class="tile-body">

                            <div class="form-group row">
                              <label class="control-label col-md-3"></label>
                              <div class="col-md-8">
                                <img src="<?=$siteURL.'/images/logo/'.$cek->site_logo?>" width="150" height="150">
                              </div>
                            </div>
                                            
                            <div class="form-group row">
                              <label class="control-label col-md-3">Yeni Logo</label>
                              <div class="col-md-8">
                                <input class="form-control" type="file" name="foto"/>
                              </div>
                            </div>
                
                            <div class="tile-footer">
                              <div class="row">
                                <div class="col-md-8 col-md-offset-3">

                                  <button class="btn btn-primary" name="logoguncelle" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Logo Güncelle</button>
                                  <a class="btn btn-secondary" href="<?=$yonetim?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Ana Sayfaya Dön</a>

                                </div>
                              </div>
                            </div>

                          </form>
                <?php
              break;

              # Favicon güncelle
              case 'favicon':
                  include 'inc/class.upload.php';
                  $ayarlar = $db->prepare('SELECT * FROM ayarlar WHERE id=:id');
                  $ayarlar->execute([':id'=>1]);
                  $cek = $ayarlar->fetch(PDO::FETCH_OBJ);

                  if(isset($_POST['faviconguncelle'])){
                    $image = new upload($_FILES['foto']);
                    if($image->uploaded){

                      $rname = 'favicon-'.uniqid();
                      $image->allowed = array('image/*');
                      $uzantı = $image->file_src_name_ext; // foto uzantısını alıyoruz.
                      $image->file_new_name_body = $rname;
                      $image->process('../images/favicon');

                      if($image->processed){
                        $guncelle = $db->prepare('UPDATE ayarlar SET site_favicon=:fav WHERE id=:id');
                        $guncelle->execute([':fav'=>$rname.'.'.$uzantı,':id'=>1]);
                        if($guncelle){
                          echo '<div class="alert alert-success">Favicon güncellendi.</div>';
                          header('refresh:2;url='.$yonetim.'/islemler.php?islem=favicon');
                        } else {
                          echo '<div class="alert alert-danger">Favicon güncellenemedi.</div>';
                        }

                    } else {

                      echo '<div class="alert alert-danger">Fotoğraf yüklenemedi.</div>';
                    }
                  } else {
                      echo '<div class="alert alert-danger">Fotoğraf seçmediniz.</div>';
                  }
                }
                    
                ?>
                <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                        <div class="tile-body">

                            <div class="form-group row">
                              <label class="control-label col-md-3"></label>
                              <div class="col-md-8">
                                <img src="<?=$siteURL.'/images/favicon/'.$cek->site_favicon?>" width="50" height="50">
                              </div>
                            </div>
                                            
                            <div class="form-group row">
                              <label class="control-label col-md-3">Yeni Favicon</label>
                              <div class="col-md-8">
                                <input class="form-control" type="file" name="foto"/>
                              </div>
                            </div>
                
                            <div class="tile-footer">
                              <div class="row">
                                <div class="col-md-8 col-md-offset-3">

                                  <button class="btn btn-primary" name="faviconguncelle" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Favicon Güncelle</button>
                                  <a class="btn btn-secondary" href="<?=$yonetim?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Ana Sayfaya Dön</a>

                                </div>
                              </div>
                            </div>

                          </form>
                <?php
              break;

              # Doğrulama ayarları
              case 'dogrulama':
                    $cek = $db->prepare('SELECT * FROM ayarlar WHERE id=:id');
                    $cek->execute([':id'=>1]);
                    $cek = $cek->fetch(PDO::FETCH_OBJ);

                    if(isset($_POST['dogrulamaguncelle'])){
                      $google = post('google');
                      $yandex = post('yandex');
                      $bing = post('bing');
                      $analytics = post('analytics');
                      if(!$google || !$yandex || !$bing || !$analytics){
                        echo '<div class="alert alert-danger">Lütfen tüm alanları doldurunuz.</div>';
                      } else {
                        $guncelle = $db->prepare('UPDATE ayarlar SET google_dogrulama_kodu=:google, yandex_dogrulama_kodu=:yandex, bing_dogrulama_kodu=:bing, analytics_kodu=:analytics WHERE id=:id');
                        $guncelle->execute([':google'=>$google,':yandex'=>$yandex,':bing'=>$bing,':analytics'=>$analytics,':id'=>1]);
                        if($guncelle){
                          echo '<div class="alert alert-success">Doğrulama ayarları güncellendi.</div>';
                          header('refresh:1;url='.$yonetim.'/islemler.php?islem=dogrulama');
                        } else {
                          echo '<div class="alert alert-danger">Doğrulama ayarları güncellenemedi.</div>';
                        }
                      }
                    }
                  ?>

                        <form class="form-horizontal" method="POST" action="">
                          <div class="tile-body">

                            <div class="form-group row">
                              <label class="control-label col-md-3">Google Doğrulama Kodu</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="google" value="<?=$cek->google_dogrulama_kodu?>">
                              </div>
                            </div>
                            
                            <div class="form-group row">
                              <label class="control-label col-md-3">Yandex Doğrulama Kodu</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="yandex" value="<?=$cek->yandex_dogrulama_kodu?>">
                              </div>
                            </div>
                            
                            <div class="form-group row">
                              <label class="control-label col-md-3">Bing Doğrulama Kodu</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="bing" value="<?=$cek->bing_dogrulama_kodu?>">
                              </div>
                            </div>
                            
                            <div class="form-group row">
                              <label class="control-label col-md-3">Analytics Kodu</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="analytics" value="<?=$cek->analytics_kodu?>">
                              </div>
                            </div>


                            <div class="tile-footer">
                              <div class="row">
                                <div class="col-md-8 col-md-offset-3">
                                  <button class="btn btn-primary" name="dogrulamaguncelle" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Güncelle</button>
                                  <a class="btn btn-secondary" href="<?=$yonetim?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Ana Sayfaya Dön</a>                              
                              </div>
                            </div>
                          </div>
                        </form>

                  <?php
              break;
            # Düzenleme işlemleri son

            }
          }
          ?>

          </div>

        </div>
      </div>
    </main>

    
<?php require_once 'inc/alt.php'; ?>