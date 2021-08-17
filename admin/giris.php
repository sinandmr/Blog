<?php 

require_once 'sistem/fonksiyon.php';

if(isset($_SESSION['oturum'])) # oturum adında bir session yok ise giriş yapmak için giris.php adresine yönlendirme yapıyor.
{
    header('Location:index.php');
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Yönetim Paneli</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Yönetim Paneli</h1>
      </div>
      <?php
      if($_POST)
      {

        $eposta = $_POST['eposta'];
        $sifre = sha1(md5($_POST['sifre']));
        if(!$eposta || !$sifre)
        {

          echo '<div class="alert alert-danger">Boş alan bırakmayınız.</div>';
          header('refresh:1;url=giris.php');

        } else
        {

          if(!filter_var($eposta,FILTER_VALIDATE_EMAIL)){
          echo '<div class="alert alert-danger">E-posta formatı yanlış girildi.</div>';
          header('refresh:1;url=giris.php');

          } else 
          {
            $girisYap = $db->prepare('SELECT * FROM yoneticiler WHERE eposta=:e AND sifre=:s LIMIT :lim');
            //$girisYap->execute([':e' => $eposta, ':s' => $sifre]);
            
            $girisYap->bindValue(':e',$eposta,PDO::PARAM_STR);
            $girisYap->bindValue(':s',$sifre,PDO::PARAM_STR);
            $girisYap->bindValue(':lim',1,PDO::PARAM_INT);
            $girisYap->execute();
            
            if($girisYap->rowCount())
            {

              $cek = $girisYap->fetch(PDO::FETCH_OBJ);

              $songiris = $db->prepare('UPDATE yoneticiler SET son_tarih=:s,son_ip=:ip WHERE id=:id');
              $songiris->execute([':s'=>date('Y-m-d H:i:s'),'ip'=>IP(),':id'=>$cek->id]);

              $adminid = $cek->id.IP(); // admin'in id'si ile ip adresini birleştiriyoruz.
              $kripto = sha1(md5($adminid));

              $_SESSION['oturum'] = $kripto;
              $_SESSION['id'] = $cek->id;

                echo '<div class="alert alert-success">Başarıyla giriş yapıldı. Yönlendiriliyorsunuz...</div>';
                header('refresh:3;url=index.php');
            } else 
            {
              echo '<div class="alert alert-danger">Böyle bir yönetici yok.</div>';
              header('refresh:1;url=giris.php');
            }

          }
        }
      }


      ?>

      <div class="login-box">



        <form class="login-form" action="" method="POST">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Yönetici Girişi</h3>
          <div class="form-group">
            <label class="control-label">E-posta</label>
            <input class="form-control" name="eposta" type="text" placeholder="E-posta" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">Şifre</label>
            <input class="form-control" name="sifre" type="password" placeholder="Şifre">
          </div>

          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Giriş Yap</button>
          </div>
        </form>

      </div>
    </section>

  </body>
</html>