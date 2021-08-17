-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 17 Ağu 2021, 21:04:20
-- Sunucu sürümü: 10.3.31-MariaDB
-- PHP Sürümü: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `sinangsf_blog`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aboneler`
--

CREATE TABLE `aboneler` (
  `id` int(11) NOT NULL,
  `abone_mail` varchar(200) NOT NULL,
  `abone_tarih` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `abone_ip` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `aboneler`
--

INSERT INTO `aboneler` (`id`, `abone_mail`, `abone_tarih`, `abone_ip`) VALUES
(5, 'sinan.logs@gmail.com', '2021-08-09 19:17:33', '::1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE `ayarlar` (
  `id` int(11) NOT NULL,
  `site_url` varchar(255) NOT NULL,
  `site_baslik` varchar(255) NOT NULL,
  `site_keyw` varchar(255) NOT NULL,
  `site_desc` varchar(255) NOT NULL,
  `site_harita` text NOT NULL,
  `site_mail` varchar(255) NOT NULL,
  `site_logo` varchar(255) NOT NULL,
  `site_favicon` varchar(255) NOT NULL,
  `google_dogrulama_kodu` varchar(255) NOT NULL,
  `yandex_dogrulama_kodu` varchar(255) NOT NULL,
  `bing_dogrulama_kodu` varchar(255) NOT NULL,
  `analytics_kodu` mediumtext NOT NULL,
  `site_durum` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ayarlar`
--

INSERT INTO `ayarlar` (`id`, `site_url`, `site_baslik`, `site_keyw`, `site_desc`, `site_harita`, `site_mail`, `site_logo`, `site_favicon`, `google_dogrulama_kodu`, `yandex_dogrulama_kodu`, `bing_dogrulama_kodu`, `analytics_kodu`, `site_durum`) VALUES
(1, 'https://blog.sinandemir.cloud', 'Sinan Demir - Kişisel Blog', 'Sinan Demir - Kişisel Blog', 'Sinan Demir - Kişisel Blog', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d98030.18655654934!2d33.45296754709025!3d39.841896941316456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4081df188742e1bb%3A0x4f1a4dd9f400e5bc!2zS8SxcsSxa2thbGUsIEvEsXLEsWtrYWxlIE1lcmtlei9LxLFyxLFra2FsZQ!5e0!3m2!1str!2str!4v1628536965511!5m2!1str!2str', 'blog@sinandemir.cloud', 'logo.png', 'favicon.ico', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `id` int(11) NOT NULL,
  `kat_adi` varchar(255) NOT NULL,
  `kat_sef` varchar(255) NOT NULL,
  `kat_keyw` varchar(255) NOT NULL,
  `kat_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`id`, `kat_adi`, `kat_sef`, `kat_keyw`, `kat_desc`) VALUES
(1, 'PHP', 'php', 'php dersleri,pdo dersleri', 'php dersleri,pdo dersleri'),
(2, 'JavaScript', 'javascript', 'javascript', 'javascript notları'),
(5, 'Plesk Panel', 'plesk-panel', 'Plesk Panel hakkında her şey.', 'Plesk Panel hakkında her şey.');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mesajlar`
--

CREATE TABLE `mesajlar` (
  `id` int(11) NOT NULL,
  `isim` varchar(255) NOT NULL,
  `konu` varchar(255) NOT NULL,
  `eposta` varchar(255) NOT NULL,
  `mesaj` text NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `durum` tinyint(1) NOT NULL DEFAULT 2,
  `ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `mesajlar`
--

INSERT INTO `mesajlar` (`id`, `isim`, `konu`, `eposta`, `mesaj`, `tarih`, `durum`, `ip`) VALUES
(8, 'sinan', 'Merhaba hocam', 'sinan.logs@gmail.com', 'Deneme mesajı hocam bu ne yazayım.', '2021-08-09 21:43:53', 1, '::1'),
(9, 'Ahmet', 'Merhaba hocam', 'ahmet@gmail.com', 'Merhaba hocam Merhaba hocam Merhaba hocam Merhaba hocam Merhaba hocam Merhaba hocam Merhaba hocam', '2021-08-09 19:12:54', 1, '::1'),
(10, 'sinan', 'sadsa', 'sinan.logs@gmail.com', 'sadsasadsasadsasadsav', '2021-08-10 08:02:25', 1, '95.65.220.193'),
(11, 'sinan demir', 'sadsa', 'sinan.logs@gmail.com', 'asdsadasd', '2021-08-17 17:46:46', 2, '95.65.220.249');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sosyalmedya`
--

CREATE TABLE `sosyalmedya` (
  `id` int(11) NOT NULL,
  `ikon` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `durum` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `sosyalmedya`
--

INSERT INTO `sosyalmedya` (`id`, `ikon`, `link`, `durum`) VALUES
(1, 'instagram', 'https://www.instagram.com/sinanmercury', 1),
(4, 'linkedin', 'https://www.linkedin.com/in/sinanmercury/', 1),
(5, 'twitter', 'https://twitter.com/Sinand_71', 1),
(9, 'facebook', 'https://www.facebook.com/profile.php?id=100005339806324', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yazilar`
--

CREATE TABLE `yazilar` (
  `yazi_id` int(11) NOT NULL,
  `yazi_kat_id` int(11) NOT NULL,
  `yazi_baslik` varchar(255) NOT NULL,
  `yazi_sef` varchar(255) NOT NULL,
  `yazi_foto` varchar(255) NOT NULL,
  `yazi_icerik` text NOT NULL,
  `yazi_etiketler` varchar(255) NOT NULL,
  `yazi_sef_etiketler` varchar(255) NOT NULL,
  `yazi_tarih` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `yazi_durum` tinyint(1) NOT NULL DEFAULT 1,
  `yazi_goruntulenme` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `yazilar`
--

INSERT INTO `yazilar` (`yazi_id`, `yazi_kat_id`, `yazi_baslik`, `yazi_sef`, `yazi_foto`, `yazi_icerik`, `yazi_etiketler`, `yazi_sef_etiketler`, `yazi_tarih`, `yazi_durum`, `yazi_goruntulenme`) VALUES
(58, 1, 'PHP PDO Kullanımı ve bilinmesi gerekenler', 'php-pdo-kullanimi-ve-bilinmesi-gerekenler', 'fotograf-feddb28ba43c813b0690d151b343fc49.jpg', '<ul>\r\n	<li>\r\n	<p><strong><code>PDO::FETCH_LAZY</code></strong>:&nbsp;<strong><code>PDO::FETCH_BOTH</code></strong>&nbsp;ve&nbsp;<strong><code>PDO::FETCH_OBJ</code></strong>&nbsp;sabitlerinin birleşimidir.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong><code>PDO::FETCH_NAMED</code></strong>: Aynı isimde birden fazla s&uuml;tun olmaması şartıyla&nbsp;<strong><code>PDO::FETCH_ASSOC</code></strong>&nbsp;sabitindeki gibi bir dizi d&ouml;nd&uuml;r&uuml;r. Bir anahtar tarafından atıfta bulunulan değer, anahtarla aynı isimli s&uuml;tundaki t&uuml;m değerlerin dizisini i&ccedil;erecektir.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong><code>PDO::FETCH_NUM</code></strong>: S&uuml;tun numaralarına g&ouml;re indislenmiş bir dizi d&ouml;ner. İlk s&uuml;tunun indisi 0&#39;dır.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong><code>PDO::FETCH_OBJ</code></strong>: &Ouml;zellik isimlerinin sınıf isimlerine denk d&uuml;şt&uuml;ğ&uuml; bir anonim nesne &ouml;rneği d&ouml;nd&uuml;r&uuml;r.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong><code>PDO::FETCH_PROPS_LATE</code></strong>:&nbsp;<strong><code>PDO::FETCH_CLASS</code></strong>&nbsp;ile birlikte kullanıldığında, &ouml;zellikler ilgili s&uuml;tundaki değerlere atanmadan &ouml;nce sınıf kurucusu &ccedil;ağrılır.</p>\r\n	</li>\r\n</ul>\r\n', 'php,pdo,fetch,object', 'php-pdo-kullanimi-ve-bilinmesi-gerekenler', '2021-08-17 18:00:00', 1, 12),
(59, 2, 'JavaScript yararlı array Metodları', 'javascript-yararli-array-metodlari', 'fotograf-6b88d51143eb4cb4c3adcc35a1892b81.jpg', '<p>In JavaScript, an array is a data structure that contains list of elements which store multiple values in a single variable. The strength of JavaScript arrays lies in the array methods. Array methods are functions built-in to JavaScript that we can apply to our arrays &mdash; Each method has a unique function that performs a change or calculation to our array and saves us from writing common functions from scratch</p>\r\n', 'javascript, array, method, map', 'javascript,array,method,map', '2021-08-17 18:00:03', 1, 13),
(60, 5, 'Plesk Panel nedir ve ne işe yarar ?', 'plesk-panel-nedir-ve-ne-ise-yarar', 'fotograf-e1f7e4444c010b1ead5b6e5109547b2b.png', '<p>Web sitenizi internet &uuml;zerindeki kullanıcılara a&ccedil;abilmeniz i&ccedil;in ihtiya&ccedil; duyacağınız en &ouml;nemli iki kavram, domain ve hostingdir. Domain diğer adıyla alan adı sitenizin internet &uuml;zerindeki adresidir.&nbsp;<strong>Hosting&nbsp;</strong>ise sitenize ait t&uuml;m verilerin internet &uuml;zerinde erişilebilmesi sağlayan barındırma servisidir. Hosting hizmeti, servis sağlayacı firmalar tarafından verilirken, web sitenizin y&ouml;netimi site sahiplerine aittir. Hosting ile ilgili t&uuml;m konuları y&ouml;netebilmeniz i&ccedil;in ise pratik paneller kullanılmaktadır.</p>\r\n\r\n<p>Hosting işlemlerini kolayca uygulayabileceğiniz kontrol panelleri arasında, Plesk Panel &ouml;n plana &ccedil;ıkar. İnternet sitenizi y&ouml;netmenize yardımcı olan Plesk Panel;&nbsp;<strong>alan adı değiştirme</strong>, e-mail hesabı oluşturma, klas&ouml;r izinlerini ayarlama ve &ccedil;eşitli dizinleri erişime a&ccedil;ma gibi işlemleri son derece basit bir şekilde uygulayabilmenize yardımcı olur. Bu sayede hostingle ilgili işlemleri ger&ccedil;ekleştirirken vakit kaybetmenizin &ouml;n&uuml;ne ge&ccedil;er.</p>\r\n\r\n<p>T&uuml;m internet sitelerinde kullanabileceğiniz Plesk Panel,&nbsp;<strong>Linux&nbsp;</strong>ve Windows işletim sistemleri &uuml;zerine kurulabilir. Linux &uuml;zerinden Plesk Panel kurulumu ger&ccedil;ekleştirmeniz i&ccedil;in SSH ekranı &uuml;zerinden birka&ccedil; kod girmeniz yeterli olur. Windows &uuml;zerinden kurulum yapmak i&ccedil;in ise Windows kullanıcıları i&ccedil;in erişime a&ccedil;ılan .exe uzantılı kurulum dosyasını indirip kişisel ayarlarınızı yapmanız gerekir. Vargonen hosting servislerinde ise Plesk panel hazır kurulu şekilde teslim edilmektedir ve sitenizi tanımladığınız andan itibaren ise Plesk Panel kullanmaya başlayabilirsiniz.&nbsp;</p>\r\n', 'plesk,cpanel', 'plesk-panel-nedir-ve-ne-ise-yarar', '2021-08-17 18:00:20', 1, 6);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yoneticiler`
--

CREATE TABLE `yoneticiler` (
  `id` int(11) NOT NULL,
  `kadi` varchar(200) NOT NULL,
  `eposta` varchar(200) NOT NULL,
  `sifre` varchar(200) NOT NULL,
  `son_ip` varchar(200) NOT NULL,
  `son_tarih` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `yoneticiler`
--

INSERT INTO `yoneticiler` (`id`, `kadi`, `eposta`, `sifre`, `son_ip`, `son_tarih`) VALUES
(1, 'Sinan', 'admin@gmail.com', 'adcd7048512e64b48da55b027577886ee5a36350', '95.65.220.249', '2021-08-17 21:00:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `id` int(11) NOT NULL,
  `yorum_yazi_id` int(11) NOT NULL,
  `yorum_isim` varchar(255) NOT NULL,
  `yorum_eposta` varchar(255) NOT NULL,
  `yorum_icerik` text NOT NULL,
  `yorum_tarih` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `yorum_durum` tinyint(1) NOT NULL DEFAULT 0,
  `yorum_ip` varchar(255) NOT NULL,
  `yorum_website` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`id`, `yorum_yazi_id`, `yorum_isim`, `yorum_eposta`, `yorum_icerik`, `yorum_tarih`, `yorum_durum`, `yorum_ip`, `yorum_website`) VALUES
(21, 58, 'Sinan Demir', 'sinan.logs@gmail.com', 'Çok açıklayıcı olmuş. Teşekkürler.', '2021-08-09 19:11:13', 1, '::1', 'https://www.sinandemir.cloud'),
(22, 60, 'sinan demir', 'sinan.logs@gmail.com', 'Çok açıklayıcı olmuş. Teşekkürler.', '2021-08-09 19:11:07', 1, '::1', 'https://www.sinandemir.cloud'),
(23, 59, 'sinan demir', 'sinan.logs@gmail.com', 'Çok açıklayıcı olmuş. Teşekkürler.', '2021-08-17 12:41:44', 1, '::1', 'https://www.sinandemir.cloud'),
(25, 59, 'sinan', 'sinan.logq@gmail.com', 'selam', '2021-08-17 12:41:33', 1, '37.154.144.185', 'https://blog.sinandemir.cloud');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `aboneler`
--
ALTER TABLE `aboneler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ayarlar`
--
ALTER TABLE `ayarlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `mesajlar`
--
ALTER TABLE `mesajlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sosyalmedya`
--
ALTER TABLE `sosyalmedya`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yazilar`
--
ALTER TABLE `yazilar`
  ADD PRIMARY KEY (`yazi_id`);

--
-- Tablo için indeksler `yoneticiler`
--
ALTER TABLE `yoneticiler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `aboneler`
--
ALTER TABLE `aboneler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `ayarlar`
--
ALTER TABLE `ayarlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `mesajlar`
--
ALTER TABLE `mesajlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `sosyalmedya`
--
ALTER TABLE `sosyalmedya`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `yazilar`
--
ALTER TABLE `yazilar`
  MODIFY `yazi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Tablo için AUTO_INCREMENT değeri `yoneticiler`
--
ALTER TABLE `yoneticiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
