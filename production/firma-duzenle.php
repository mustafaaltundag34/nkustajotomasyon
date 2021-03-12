<!-- header -->
<?php 

// require_once "component/header.php"; 
require_once "../netting/connection.php";
//Giriş yapmış kişinin bilgilerine ulaşmak için...
$query=$db->prepare("SELECT * FROM kullanici where kullanicimail=:kullanicimail");
$query->execute(array(
  'kullanicimail' => $_SESSION['kullanicimail']
));
$row=$query->rowCount();
$data=$query->fetch(PDO::FETCH_ASSOC);
//Eğerki giriş yapmadan url kısmından giriş yapılmışsa satır sayısı 0 olucak ve direk header ile yönlendirme yapıyoruz.
if ($row==0) {

  header("Location:../index?durum=izinsiz-giris");
  exit;

}
?>
<!-- header -->

<?php
//url'den giriş yapılınca admin değilse direk main sayfasına yönlendirme yapılıyor.
require_once "../netting/fonksiyonlar.php";
//adminkontrol($data["kullanici_yetki"]);

$firmaid = $_GET["firmaid"];
$query_person = $db->prepare("select * from firmahavuzu where firmaid=:firmaid");
$query_person->execute(array(
  "firmaid" => $firmaid

)); 


$query_person_data = $query_person->fetch(PDO::FETCH_ASSOC); 

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Firma Duzenle</title>

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
              <h2>Firma Düzenle
                <?php
                // Eğer güncelleme başarılı olursa mesaj göstertme alanı
                if (isset($_GET["durum"]) && $_GET["durum"]=="ok") { ?>

                  <b class="alert alert-success small" style="color:white;">Güncelleme Başarılı.</b>

                <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="no") { ?>

                  <b class="alert alert-danger small" style="color:white;">Hata. Güncelleme yapılmadı.</b>

                  <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="dosyabuyuk") { ?>

                <b class="alert alert-warning small" style="color:white;">Resim boyutu 1MB'dan düşük olmalı.</b>
                <script type="text/javascript">
                  swal("Başarısız","Resim boyutu 1MB'dan düşük olmalı.","warning");
                </script>

              <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="formhata") { ?>

                <b class="alert alert-warning small" style="color:white;">Resim uzantısı jpg yada png olmalı.</b>
                <script type="text/javascript">
                  swal("Başarısız","Resim uzantısı jpg yada png olmalı.","warning");
                </script>

                <?php } ?>
              </h2>
              <div class="clearfix"></div>
              <div align="right">
                <!-- <a href="kullanici-tanim"><button class="btn btn-success btn-xs">Geri Dön</button></a> -->
              </div>
            </div>
            <div class="x_content">
              <br />
              <form action="../netting/firma-islemler.php" enctype="multipart/form-data" method="POST" id="demo-form2"  data-parsley-validate class="form-horizontal form-label-left">

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Firma Logo<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
                    if (strlen($query_person_data["firmafoto"])>0) { ?>
                      <img src="dimg/<?php echo $query_person_data['firmafoto']; ?>">
                      <?php
                    }else{
                      ?>
                      <img src="dimg/user.png" alt="firmafoto1" width="75" height="75">

                    <?php } ?>
                  </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmafoto">Logo Seç<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="file" id="firmafoto" name="firmafoto" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>
              <input type="hidden" name="eski_yol" value="dimg/<?php echo $query_person_data['firmafoto']; ?>"> <!--eski resmin yolu klasörden silmek için-->

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmaadi">Firma Adi<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="firmaadi" id="firmaadi" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $query_person_data['firmaadi']; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmasehir">Firma Sehir<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="firmasehir" class="form-control" name="firmasehir" required>
                      <option value="Istanbul" <?php echo $query_person_data["firmasehir"]=="Istanbul" ? "selected" : ""; ?>>Istanbul</option>
                      <option value="Ankara" <?php echo $query_person_data["firmasehir"]=="Ankara" ? "selected" : ""; ?> >Ankara</option>
                      <option value="Izmir" <?php echo $query_person_data["firmasehir"]=="Izmir" ? "selected" : ""; ?> >Izmir</option>
                      <option value="Bursa" <?php echo $query_person_data["firmasehir"]=="Bursa" ? "selected" : ""; ?> >Bursa</option>
                    </select>
                  </div>
                </div>  

                  <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmaadres">Firma Adres<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="firmaadres" id="firmaadres" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $query_person_data['firmaadres']; ?>">
                  </div>
                </div>


                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmasektor">Firma Sektoru<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="firmasektor" class="form-control" name="firmasektor" required>
                      <option value="Bilişim" <?php echo $query_person_data["firmasektor"]=="Bilişim" ? "selected" : ""; ?> >Bilişim</option>
                      <option value="Yazilim" <?php echo $query_person_data["firmasektor"]=="Yazilim" ? "selected" : ""; ?> >Yazilim</option>
                      <option value="Donanim" <?php echo $query_person_data["firmasektor"]=="Donanim" ? "selected" : ""; ?> >Donanim</option>
                      <option value="Elektronik" <?php echo $query_person_data["firmasektor"]=="Elektronik" ? "selected" : ""; ?> >Elektronik</option>
                      <option value="Insaat" <?php echo $query_person_data["firmasektor"]=="Insaat" ? "selected" : ""; ?> >Insaat</option>
                      <option value="Endustri" <?php echo $query_person_data["firmasektor"]=="Endustri" ? "selected" : ""; ?> >Endustri</option>
                      <option value="Çevre" <?php echo $query_person_data["firmasektor"]=="Çevre" ? "selected" : ""; ?> >Çevre</option>                                                          
                      <option value="Telekominikasyon" <?php echo $query_person_data["firmasektor"]=="Telekominikasyon" ? "selected" : ""; ?> >Telekomunikasyon</option>
                      <option value="Hizmet" <?php echo $query_person_data["firmasektor"]=="Hizmet" ? "selected" : ""; ?> >Hizmet</option>
                      <option value="Gida" <?php echo $query_person_data["firmasektor"]=="Gida" ? "selected" : ""; ?> >Gida</option>                      
                      <option value="Tekstil" <?php echo $query_person_data["firmasektor"]=="Tekstil" ? "selected" : ""; ?> >Tekstil</option>                      
                    </select>
                  </div>
                </div>            


                  <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmamail">Firma Mail<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="firmamail" id="firmamail" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $query_person_data['firmamail']; ?>">
                  </div>
                </div>

                  <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmatel">Firma Telefonu<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="firmatel" id="firmatel" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $query_person_data['firmatel']; ?>">
                  </div>
                </div>

                  <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmacalisansayisi">Firma Calisan Sayisi<span></span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" name="firmacalisansayisi" id="firmacalisansayisi" class="form-control col-md-7 col-xs-12" value="<?php echo $query_person_data['firmacalisansayisi']; ?>">
                  </div>
                </div>


                  <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmatel">Firma Yetkili<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="firmayetkili" id="firmayetkili" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $query_person_data['firmayetkili']; ?>">
                  </div>
                </div>

          <?php if ($_SESSION["kullanicituru"]=='Ogruyesi') { ?> 
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmaaktif">Aktiflik<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="firmaaktif" class="form-control" name="firmaaktif" required <?php echo $_SESSION["kullanicituru"] !='Ogruyesi' ? 'disabled' :";"?>>
                      <option value="1" <?php echo $query_person_data["firmaaktif"]=="1" ? "selected" : ""; ?> >Aktif</option>
                      <option value="0" <?php echo $query_person_data["firmaaktif"]=="0" ? "selected" : ""; ?> >Pasif</option>
                    </select>
                  </div>
                </div>
          <?php } ?>  

          <?php if ($_SESSION["kullanicituru"]=='Ogrenci') { ?>
          <div class="form-group">
                <input type="hidden" name="firmaaktif" value="<?php echo $query_person_data['firmaaktif']; ?>">
                </div>
          <?php } ?>
          
                <input type="hidden" name="firmaid" value="<?php echo $firmaid; ?>">

                <div class="ln_solid"></div>
                <div class="form-group">
                  <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button name="firmaguncelle" type="submit" class="btn btn-success">Güncelle</button>

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


</body>






