<?php 
define('guvenlik',true);
require_once 'inc/ust.php';?>

    <!-- Header -->
    <?php require_once 'inc/menu.php';?>
    <!-- end: Header -->

    <!-- Page title -->
    <section id="page-title" data-parallax-image="<?= $arow->site_url; ?>/images/iletisim.png">
        <div class="container">
            <div class="page-title">
                <h1>Bana Ulaşın</h1>
            <div class="breadcrumb">
                <ul>
                    <li><a href="<?=$site?>">Ana Sayfa</a> </li>
                    <li class="active"><a href="<?=$site.'/iletisim.php'?>">İletişim</a> </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end: Page title -->

    <!-- CONTENT -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="text-uppercase">Bize Yazın</h3>
                    <p>Lütfen iletişim formunu eksiksiz doldurunuz. Projeleriniz ve diğer sorunlarınız için <b><?= $arow->site_mail ?></b> adresine mail atabilirsiniz.</p>
                    <div class="m-t-30">
                        <form id="iletisimformu" onsubmit="return false;" class="widget-contact-form" action="" role="form" method="post">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">İsim</label>
                                    <input type="text" aria-required="true" name="ad" class="form-control required name" placeholder="Adınız">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Eposta</label>
                                    <input type="email" aria-required="true" name="eposta" class="form-control required email" placeholder="Eposta Adresiniz">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="subject">Konu</label>
                                    <input type="text" name="konu" class="form-control required" placeholder="Konu...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message">Mesaj</label>
                                <textarea type="text" name="mesaj" rows="5" class="form-control required" placeholder="Mesajınızı yaz."></textarea>
                            </div>

                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6Le_8O0bAAAAAIUiN-H-xwRKlQ-TT-1b4oX5x8BZ"></div>                               
                            </div>


                            <button class="btn" onclick="mesajGonder()" type="submit" id="form-submit"><i class="fa fa-paper-plane"></i>&nbsp;Mesaji Gönder</button>
                        </form>

                    </div>
                </div>
                <div class="col-lg-6">
                    <h3 class="text-uppercase">Neredeyim ?</h3>
                    <!-- Google map sensor -->
                    <iframe src="<?= $arow->site_harita ?>" width="600" height="400"></iframe>
                    <!-- Google map sensor -->

                </div>
            </div>
        </div>
    </section>
    <!-- end: CONTENT -->

<?php require_once 'inc/alt.php'; ?>