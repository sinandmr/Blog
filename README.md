## About The Project

<img src="https://i.hizliresim.com/fqs1bm6.PNG" alt="home" width="600px" height="auto">
<img src="https://i.hizliresim.com/6q8l025.png" alt="admin" width="600px" height="auto">


Blog project that can be controlled with the admin panel and everything is dynamic.

## Built With

* [PHP](https://www.php.net/)
* [MySQL](https://www.mysql.com/)
* [AJAX](https://jquery.com/)

## Installation

1. Import the sinanblog.sql file into your database.
2. Enter your database information in config.js `sistem/baglan.php` and `admin/sistem/baglan.php`
   ```PHP
   $db = new PDO("mysql:host=localhost;dbname=sinanblog;charset=utf8","root","");
   ```
3. Enter your e-mail information in `admin/islemler.php`.
   ```PHP
   $gonderen = 'email';
   $sifre = 'password';
   $mail = new PHPMailer();
   $mail->Host       = 'mail.host.com';
   $mail->Port       = 465;
   $mail->SMTPSecure = 'ssl';
   ```

## Live
  * [Home Page](https://blog.sinandemir.cloud)
  * [Admin Panel](https://blog.sinandemir.cloud/admin)
  * E-mail : `admin@gmail.com`
  * Password : `123`
