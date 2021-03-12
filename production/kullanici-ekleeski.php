<!-- header -->
<?php require_once "component/header.php"; ?>
<!-- header -->

<?php
//url'den giriş yapılınca admin değilse direk main sayfasına yönlendirme yapılıyor.
require_once "../netting/fonksiyonlar.php";
adminkontrol($data["kullanici_yetki"]);


 
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
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings 1</a>
                  </li>
                  <li><a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
            <div align="right">
              <a href="kullanici-tanim"><button class="btn btn-success btn-xs">Geri Dön</button></a>
            </div>
          </div>
          <div class="x_content">
            <br />
            <form action="../netting/admin-islemler.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_email">Email<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="kullanici_email" id="kullanici_email" required="required" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_adsoyad">Ad Soyad<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="kullanici_adsoyad" id="kullanici_adsoyad" required="required" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_yetki">Yetki<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="kullanici_yetki" class="form-control" name="kullanici_yetki" required>
                    <option value="admin">Admin</option>
                    <option value="muhasebe">Muhasebe</option>
                    <option value="satis">Satış</option>
                    <option value="depo">Depo</option>
                  </select>
                </div>
              </div>

<!--               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_aktiflik">Menu Durum<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="kullanici_aktiflik" class="form-control" name="kullanici_aktiflik" required>
                    <option value="1" >Aktif</option>
                    <option value="0" >Pasif</option>
                  </select>
                </div>
              </div> -->

              <div class="ln_solid"></div>
              <div class="form-group">
                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button name="kullanicikaydet" type="submit" class="btn btn-success">Kaydet</button>
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





<!-- footer -->
<?php require_once "component/footer.php"; ?>
<!-- footer -->








