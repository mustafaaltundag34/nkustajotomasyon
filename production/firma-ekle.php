<!-- header -->

<!-- header -->

<?php
//url'den giriş yapılınca admin değilse direk main sayfasına yönlendirme yapılıyor.
require_once "../netting/connection.php";
require_once "../netting/fonksiyonlar.php";
// adminkontrol($data["kullanici_yetki"]);

 

 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Staj Duzenle</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- bootstrap-progressbar -->
  <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- JQVMap -->
  <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
  <!-- bootstrap-daterangepicker -->
  <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

  <!-- CK Editör -->
  <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Firma Ekle
              <?php
                // Eğer güncelleme başarılı olursa mesaj göstertme alanı
              if (isset($_GET["durum"]) && $_GET["durum"]=="ok") { ?>

                <b class="alert alert-success small" style="color:white;">Ekleme Başarılı.</b>
                <script type="text/javascript">
                  swal("Başarılı","Firma Eklendi","success");
                </script>

              <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="no") { ?>

                <b class="alert alert-danger small" style="color:white;">Hata. Ekleme yapılmadı.</b>
                <script type="text/javascript">
                  swal("Başarısız","Firma Eklenemedi","error");
                </script>

              <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="firmaadihata") { ?>

                <b class="alert alert-warning small" style="color:white;">Firma kayıtlı.</b>
                <script type="text/javascript">
                  swal("Başarısız","Firma  kayıtlı.","warning");
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
            <form action="../netting/firma-islemler.php" enctype="multipart/form-data"  method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmaadi">Firma Adi<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="firmaadi" id="firmaadi" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmasehir">Firma Sehir<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="firmasehir" class="form-control" name="firmasehir" required>
                      <option value="Istanbul">Istanbul</option>
                      <option value="Ankara">Ankara</option>
                      <option value="Izmir">Izmir</option>
                      <option value="Bursa">Bursa</option>
                    </select>
                  </div>
                </div>  



              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmaadres">Firma Adres<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="firmaadres" id="firmaadres" required="required" class="form-control col-md-7 col-xs-12"  >
                </div>
              </div>


                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmasektoru">Firma Sektoru<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="firmasektoru" class="form-control" name="firmasektoru" required>
                      <option value="Bilişim">Bilişim</option>
                      <option value="Yazilim">Yazilim</option>
                      <option value="Donanim">Donanim</option>
                      <option value="Elektronik">Elektronik</option>
                      <option value="Insaat">Insaat</option>
                      <option value="Endustri">Endustri</option>
                      <option value="Çevre">Çevre</option>                                                          
                      <option value="Telekominikasyon">Telekomunikasyon</option>
                      <option value="Hizmet">Hizmet</option>
                      <option value="Gida">Gida</option>                      
                      <option value="Tekstil">Tekstil</option>                      
                    </select>
                  </div>
                </div>  
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmamail">Firma E-Mail<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="firmamail" id="firmamail" required="required" class="form-control col-md-7 col-xs-12"  >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmatel">Firma Telefon<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="firmatel" id="firmatel" required="required" class="form-control col-md-7 col-xs-12"  >
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmacalisansayisi">Firma Calisan Sayisi<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" name="firmacalisansayisi" id="firmacalisansayisi" required="required" class="form-control col-md-7 col-xs-12"  >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmayetkili">Firma Yetkili<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="firmayetkili" id="firmayetkili" required="required" class="form-control col-md-7 col-xs-12"  >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmaaktif">Aktiflik<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="firmaaktif" class="form-control" name="firmaaktif" required <?php echo $_SESSION["kullanicituru"] !='Ogruyesi' ? 'disabled' :";"?>>
                    <option value="1"  >Aktif</option>
                    <option value="0"  >Pasif</option>
                  </select>
                </div>
              </div>


              
              <div class="ln_solid"></div>
              <div class="form-group">
                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button name="firmaekle" type="submit" class="btn btn-success">Kaydet</button>
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










