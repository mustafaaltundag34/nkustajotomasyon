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

$kullaniciid = $_GET["kullaniciid"]; //kullanincinin ID'sini url'den alıyoruz
  //$kullaniciid =$_SESSION['kullaniciid'];
$query_person = $db->prepare("select * from kullanici where kullaniciid=:kullaniciid");
$query_person->execute(array(
  "kullaniciid" => $kullaniciid

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

  <title>Profil Duzenle</title>

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
              <h2>Profil Düzenle
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
              <form action="../netting/admin-islemler.php" enctype="multipart/form-data" method="POST" id="demo-form2"  data-parsley-validate class="form-horizontal form-label-left">

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Profil Resmi<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
                    if (strlen($query_person_data["kullanicifoto"])>0) { ?>
                      <img src="dimg/<?php echo $query_person_data['kullanicifoto']; ?>">
                      <?php
                    }else{
                      ?>
                      <img src="dimg/user.png" alt="kullanicifoto1" width="75" height="75">

                    <?php } ?>
                  </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicifoto">Resim Seç<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="file" id="kullanicifoto" name="kullanicifoto" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>
              <input type="hidden" name="eski_yol" value="dimg/<?php echo $query_person_data['kullanicifoto']; ?>"> <!--eski resmin yolu klasörden silmek için-->

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicimail">Email<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="kullanicimail" id="kullanicimail" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $query_person_data['kullanicimail']; ?>" disabled>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullaniciadisoyadi">Ad Soyad<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="kullaniciadisoyadi" id="kullaniciadisoyadi" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $query_person_data['kullaniciadisoyadi']; ?>">
                  </div>
                </div>

                  <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicino">No<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="kullanicino" id="kullanicino" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $query_person_data['kullanicino']; ?>">
                  </div>
                </div>


                  <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicikayittarihi">Kayit Tarihi<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="kullanicikayittarihi" id="kullanicikayittarihi" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $query_person_data['kullanicikayittarihi']; ?>">
                  </div>
                </div>                


                  <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicitel">Telefon<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="kullanicitel" id="kullanicitel" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $query_person_data['kullanicitel']; ?>">
                  </div>
                </div>

                  <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicilog">Detaylar<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="kullanicilog" id="kullanicilog" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $query_person_data['kullanicilog']; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullaniciuniversite">Universite<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="kullaniciuniversite" class="form-control" name="kullaniciuniversite" required>
                      <option value="Namık Kemal Universitesi" <?php echo $query_person_data["kullaniciuniversite"]=="Namık Kemal Universitesi" ? "selected" : ""; ?> >Namık Kemal Universitesi</option>
                      <option value="Trakya Universitesi" <?php echo $query_person_data["kullaniciuniversite"]=="Trakya Universitesi" ? "selected" : ""; ?> >Trakya Universitesi</option>
                      <option value="Kirklareli Universitesi" <?php echo $query_person_data["kullaniciuniversite"]=="Kirklareli Universitesi" ? "selected" : ""; ?> >Kirklareli Universitesi</option>
                      <option value="Istanbul Universitesi" <?php echo $query_person_data["kullaniciuniversite"]=="Istanbul Universitesi" ? "selected" : ""; ?> >Istanbul Universitesi</option>
                      <option value="Marmara Universitesi" <?php echo $query_person_data["kullaniciuniversite"]=="Marmara Universitesi" ? "selected" : ""; ?> >Marmara Universitesi</option>
                      <option value="Yildiz Teknik Universitesi" <?php echo $query_person_data["kullaniciuniversite"]=="Yildiz Teknik Universitesi" ? "selected" : ""; ?> >Yildiz Teknik Universitesi</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicibolum">Bölüm<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="kullanicibolum" class="form-control" name="kullanicibolum" required>
                      <option value="Bilgisayar Mühendisliği" <?php echo $query_person_data["kullanicibolum"]=="Bilgisayar Mühendisliği" ? "selected" : ""; ?> >Bilgisayar Mühendisliği</option>
                      <option value="Elektronik Mühendisliği" <?php echo $query_person_data["kullanicibolum"]=="elektronik Mühendisliği" ? "selected" : ""; ?> >Elektronik Mühendisliği</option>
                      <option value="İnşaat Mühendisliği" <?php echo $query_person_data["kullanicibolum"]=="İnşaat Mühendisliği" ? "selected" : ""; ?> >İnşaat Mühendisliği</option>
                      <option value="Çevre Mühendisliği" <?php echo $query_person_data["kullanicibolum"]=="Çevre Mühendisliği" ? "selected" : ""; ?> >Çevre Mühendisliği</option>
                      <option value="Endustri Mühendisliği" <?php echo $query_person_data["kullanicibolum"]=="Endustri Mühendisliği" ? "selected" : ""; ?> >Endustri Mühendisliği</option>
                      <option value="Tekstil Mühendisliği" <?php echo $query_person_data["kullanicibolum"]=="Tekstil Mühendisliği" ? "selected" : ""; ?> >Tekstil Mühendisliği</option>
                    </select>
                  </div>
                </div>

          <?php if ($_SESSION["kullanicituru"]=='Ogruyesi') { ?>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicituru">Kullanici Turu<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="kullanicituru" class="form-control" name="kullanicituru" required <?php echo $_SESSION["kullanicituru"] !='Ogruyesi' ? 'disabled' :";"?>>
                      <option selected><?php echo $query_person_data['kullanicituru']; ?> </option>
                      <option value="Ogrenci" <?php echo $query_person_data["kullanicituru"]=="Ogrenci" ? "selected" : ""; ?> >Ogrenci</option>
                      <option value="Ogruyesi" <?php echo $query_person_data["kullanicituru"]=="Ogruyesi" ? "selected" : ""; ?> >Ogruyesi</option>
                    </select>
                  </div>
                </div>
          <?php } ?>

          <?php if ($_SESSION["kullanicituru"]=='Ogrenci') { ?>
                <div class="form-group">
                <input type="hidden" name="kullanicituru" value="<?php echo $query_person_data['kullanicituru']; ?>">
                </div>
          <?php } ?>

          <?php if ($_SESSION["kullanicituru"]=='Ogruyesi') { ?>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullaniciaktif">Aktiflik<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="kullaniciaktif" class="form-control" name="kullaniciaktif" required <?php echo $_SESSION["kullanicituru"] !='Ogruyesi' ? 'disabled' :";"?>>
                      <option selected><?php echo $query_person_data['kullaniciaktif']; ?> </option>
                      <option value="1">Aktif</option>
                      <option value="0">Pasif</option>
                    </select>
                  </div>
                </div>
          <?php } ?>

          <?php if ($_SESSION["kullanicituru"]=='Ogrenci') { ?>
                  <div class="form-group">
                <input type="hidden" name="kullaniciaktif" value="<?php echo $query_person_data['kullaniciaktif']; ?>">
                </div>
          <?php } ?>

                <input type="hidden" name="kullaniciid" value="<?php echo $kullaniciid; ?>">

                <div class="ln_solid"></div>
                <div class="form-group">
                  <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button name="kullaniciguncelle" type="submit" class="btn btn-success">Güncelle</button>

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






