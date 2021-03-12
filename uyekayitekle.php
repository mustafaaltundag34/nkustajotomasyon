
<!-- header -->
<?php require_once ("headeruyekayit.php"); 
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>
<!-- header -->
<?php
//url'den giriş yapılınca admin değilse direk main sayfasına yönlendirme yapılıyor.
require_once "netting/fonksiyonlar.php";
//adminkontrol($data["kullanici_yetki"]);
 
?>



<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Kullanıcı Ekleme

              <?php
                // Eğer güncelleme başarılı olursa mesaj göstertme alanı
              if (isset($_GET["durum"]) && $_GET["durum"]=="kayitli") {?>

                <b class="alert alert-danger small" style="color:white;">Email Kayıtlıdır. Başka Email deneyiniz.</b>
                <script type="text/javascript">
                	swal("Tekrar Deneyiniz","Email Kayıtlıdır. Başka Email deneyiniz.","warning");
                </script>

              <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="ok") { ?>

                <b class="alert alert-success small" style="color:white;">Kayıt Başarılı. Maile şifre gönderilmiştir.</b>
                <script type="text/javascript">
                	swal("Başarılı","Kayıt Başarılı. Maile şifre gönderilmiştir.","success");
                </script>

              <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="no") { ?>

                <b class="alert alert-danger small" style="color:white;">Hata. Kayıt yapılmadı.</b>
                <script type="text/javascript">
                	swal("Hata","Hata. Kayıt yapılmadı..","error");
                </script>

              <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="mailhata") { ?>

                <b class="alert alert-danger small" style="color:white;">Mail yollamada hata oluştu.</b>
                <script type="text/javascript">
                	swal("Hata","Mail yollamada hata oluştu.","warning");
                </script>

              <?php } ?>
            </h2>
            <div class="clearfix"></div>
            <div align="right">
              <a href="javascript:window.close();"><button class="btn btn-success btn-xs">Geri Dön</button></a>
            </div>
          </div>
          <div class="x_content">
            <br />
            <form action="netting/admin-islemler.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicimail">Email<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="kullanicimail" id="kullanicimail" required="required" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullaniciadisoyadi">Ad Soyad<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="kullaniciadisoyadi" id="kullaniciadisoyadi" required="required" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicino">No<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="kullanicino" id="kullanicino" required="required" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>


               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicituru">Kullanici Turu<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="kullanicituru" class="form-control" name="kullanicituru" required  disabled>
                    <option value="Ogrenci">Ogrenci</option>
                    <option value="Ogruyesi">Ogruyesi</option>
                  </select>
                </div>
              </div>

              <div class="ln_solid"></div>
              <div class="form-group">
                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button name="kullanicikaydetindex" type="submit" class="btn btn-success">Kaydet</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- /page content -->














