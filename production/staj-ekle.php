<!-- header -->


<?php
//url'den giriş yapılınca admin değilse direk main sayfasına yönlendirme yapılıyor.
require_once "../netting/connection.php";
require_once "../netting/fonksiyonlar.php";
// adminkontrol($data["kullanici_yetki"]);

 
//KULLANICI LİSTELEMEK İÇİN(MODAL)

$musteriler = array();
$musteri_query = $db->prepare("select * from kullanici where kullaniciaktif=:kullaniciaktif and kullanicituru=:kullanicituru");
$musteri_query->execute(array(
  "kullaniciaktif" => 1,
  "kullanicituru"=> "Ogrenci"
));
while ($musteri_data = $musteri_query->fetch(PDO::FETCH_ASSOC)) {
  $musteriler[] = $musteri_data;
}

//FIRMA LİSTELEMEK İÇİN(MODAL)
//Firmalarimiz
$musteriler1 = array();
$musteri_query1 = $db->prepare("select * from firmahavuzu where firmaaktif=:firmaaktif");
$musteri_query1->execute(array(
  "firmaaktif" => 1
));
while ($musteri_data1 = $musteri_query1->fetch(PDO::FETCH_ASSOC)) {
  $musteriler1[] = $musteri_data1;
}

//HOCA LİSTELEMEK İÇİN(MODAL)

$musteriler2 = array();
$musteri_query2 = $db->prepare("select * from kullanici where kullaniciaktif=:kullaniciaktif and kullanicituru=:kullanicituru");
$musteri_query2->execute(array(
  "kullaniciaktif" => 1,
  "kullanicituru"=> "Ogruyesi"
));
while ($musteri_data2 = $musteri_query2->fetch(PDO::FETCH_ASSOC)) {
  $musteriler2[] = $musteri_data2;
}

 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Staj Ekle</title>

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
            <h2>Staj Ekle
              <?php
                // Eğer güncelleme başarılı olursa mesaj göstertme alanı
              if (isset($_GET["durum"]) && $_GET["durum"]=="ok") { ?>

                <b class="alert alert-success small" style="color:white;">Ekleme Başarılı.</b>
                <script type="text/javascript">
                  swal("Başarılı","Staj Eklendi","success");
                </script>

              <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="no") { ?>

                <b class="alert alert-danger small" style="color:white;">Hata. Ekleme yapılmadı.</b>
                <script type="text/javascript">
                  swal("Başarısız","Staj Eklenemedi","error");
                </script>

              <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="firmaadihata") { ?>

                <b class="alert alert-warning small" style="color:white;">Staj kayıtlı.</b>
                <script type="text/javascript">
                  swal("Başarısız","Staj  kayıtlı.","warning");
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
            <form action="../netting/staj-islemler.php" enctype="multipart/form-data"  method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stajogradisoyadi">Ogrenci Adi Soyadi</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="stajogradisoyadi" class="form-control" name="stajogradisoyadi">
                    <?php 
                    foreach($musteriler as $key){
                      ?>
                      <option value="<?php echo $key['kullaniciadisoyadi']; ?>"><?php echo $key['kullaniciadisoyadi']; ?></option>
                      <?php   
                    }
                    ?>
                  </select>
                </div>
                </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stajfirma">Staj Firma</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="stajfirma" class="form-control" name="stajfirma">
                    <?php 
                    foreach($musteriler1 as $key){
                      ?>
                      <option value="<?php echo $key['firmaadi']; ?>"><?php echo $key['firmaadi']; ?></option>
                      <?php   
                    }
                    ?>
                  </select>
                </div>
                </div>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stajfirma">Staj Firma Logo<span></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="stajfirma" id="stajfirma" class="form-control col-md-7 col-xs-12" disabled="true">
                </div>
              </div>
              
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stajbolum">Staj Yapilan Bolum<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="stajbolum" class="form-control" name="stajbolum" required>
                      <option value="Bilgisayar Mühendisliği">Bilgisayar Mühendisliği</option>
                      <option value="Elektronik Mühendisliği">Elektronik Mühendisliği</option>
                      <option value="Endüstri Mühendisliği">Endüstri Mühendisliği</option>
                      <option value="İnşaat Mühendisliği">İnşaat Mühendisliği</option>
                      <option value="Çevre Mühendisliği">Çevre Mühendisliği</option>
                      <option value="Tekstil Mühendisliği">Tekstil Mühendisliği</option>
                      <option value="Biyomedikal Mühendisliği">Biyomedikal Mühendisliği</option>
                    </select>
                  </div>
                </div>  

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stajtarihi">Staj Baslama Tarihi<span></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="stajtarihi" id="stajtarihi" class="form-control col-md-7 col-xs-12" value="<?php echo date("d-m-Y H:i:s");?>"  >
                </div>
              </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stajtipisuresi">Staj Tipi/Süresi<span></span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="stajtipisuresi" class="form-control" name="stajtipisuresi" required>
                      <option value="60 Gün">60 Gün</option>
                      <option value="45 Gün">45 Gün</option>
                      <option value="30 Gün">30 Gün</option>
                      <option value="20 Gün">20 Gün</option>
                      <option value="STE Uzun Dönem">STE Uzun Dönem</option>
                    </select>
                  </div>
                </div>  


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="yapilanprojeis">Yapilan Proje / İş<span></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="yapilanprojeis" id="yapilanprojeis" class="form-control col-md-7 col-xs-12"  >
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="yorumlar">Yorumlar<span></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea rows="10" cols="60" name="yorumlar" id="yorumlar" class="form-control col-md-7 col-xs-12"></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stajhocasi">Staj Hocasi</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="stajhocasi" class="form-control" name="stajhocasi">
                    <?php 
                    foreach($musteriler2 as $key){
                      ?>
                      <option value="<?php echo $key['kullaniciadisoyadi']; ?>"><?php echo $key['kullaniciadisoyadi']; ?></option>
                      <?php   
                    }
                    ?>
                  </select>
                </div>
                </div>



              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stajpuani">Staj Puani<span></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" name="stajpuani" id="stajpuani"  class="form-control col-md-7 col-xs-12" required <?php echo $_SESSION["kullanicituru"] !='Ogruyesi' ? 'disabled' :";"?>>
                </div>
              </div>



              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stajonay">Staj Onay Durumu<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="stajonay" class="form-control" name="stajonay" required <?php echo $_SESSION["kullanicituru"] !='Ogruyesi' ? 'disabled' :";"?>>
                    <option value="Onaylanmadi"  >Onaylanmadi</option>
                    <option value="Onaylandi"  >Onaylandi</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stajaktif">Aktiflik<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="stajaktif" class="form-control" name="stajaktif" required <?php echo $_SESSION["kullanicituru"] !='Ogruyesi' ? 'disabled' :";"?>>
                    <option value="1"  >Aktif</option>
                    <option value="0"  >Pasif</option>
                  </select>
                </div>
              </div>


              
              <div class="ln_solid"></div>
              <div class="form-group">
                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button name="stajekle" type="submit" class="btn btn-success">Kaydet</button>
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








