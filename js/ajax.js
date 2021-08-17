function mesajGonder() {
  const deger = $('#iletisimformu').serialize();
  $.ajax({
    type: 'POST',
    url: './inc/mesajgonder.php',
    data: deger,
    success: function (sonuc) {
      if ($.trim(sonuc) == 'bos') {
        swal('Hata', 'Lütfen tüm alanları doldurun', 'error');
      } else if ($.trim(sonuc) == 'format') {
        swal('Hata', 'Eposta formatı yanlış.', 'error');
      } else if ($.trim(sonuc) == 'hata') {
        swal('Hata', 'Sistem hatası oluştu.', 'error');
      } else if ($.trim(sonuc) == 'basarili') {
        swal(
          'Başarılı',
          'Mesajınız alınmıştır. En kısa sürede dönüş sağlanacaktır.',
          'success'
        );
        $('input[name=ad]').val('');
        $('input[name=eposta]').val('');
        $('input[name=konu]').val('');
        $('textarea[name=mesaj]').val('');
      }
    },
  });
}

function yorumYap() {
  console.log('sea');
  const deger = $('#yorumformu').serialize();
  $.ajax({
    type: 'POST',
    url: './inc/yorumyap.php',
    data: deger,
    success: function (sonuc) {
      if ($.trim(sonuc) == 'bos') {
        swal('Hata', 'Lütfen tüm alanları doldurun', 'error');
      } else if ($.trim(sonuc) == 'format') {
        swal('Hata', 'Eposta formatı yanlış.', 'error');
      } else if ($.trim(sonuc) == 'hata') {
        swal('Hata', 'Sistem hatası oluştu.', 'error');
      } else if ($.trim(sonuc) == 'basarili') {
        swal(
          'Başarılı',
          'Mesajınız alınmıştır. Yönetici tarafından onaylandıktan sonra gösterilecektir.',
          'success'
        );
        $('input[name=adsoyad]').val('');
        $('input[name=eposta]').val('');
        $('input[name=website]').val('');
        $('textarea[name=yorum]').val('');
      }
    },
  });
}

function aboneOl() {
  const deger = $('#aboneformu').serialize();
  $.ajax({
    type: 'POST',
    url: './inc/abone.php',
    data: deger,
    success: function (sonuc) {
      if ($.trim(sonuc) == 'bos') {
        swal('Hata', 'Lütfen E-Posta adresinizi giriniz.', 'error');
      } else if ($.trim(sonuc) == 'format') {
        swal('Hata', 'E-Posta formatı yanlış.', 'error');
      } else if ($.trim(sonuc) == 'kayitli') {
        swal('Hata', 'Bu E-Posta zaten abone.', 'error');
      } else if ($.trim(sonuc) == 'hata') {
        swal('Hata', 'Sistem hatası oluştu.', 'error');
      } else if ($.trim(sonuc) == 'basarili') {
        swal(
          'Başarılı',
          'Bülten aboneliğiniz başarılı bir şekilde gerçekleştirilmiştir. Yeni bir yazı paylaşıldığında E-Posta adresinizden görebileceksiniz.',
          'success'
        );
        $('input[name=eposta]').val('');
      }
    },
  });
}
