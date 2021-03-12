<!-- header -->
<?php require_once "component/header.php"; ?>
<!-- header -->

<?php
//url'den giriş yapılınca admin değilse direk main sayfasına yönlendirme yapılıyor.
require_once "../netting/fonksiyonlar.php";
adminkontrol($_SESSION["kullanicituru"]);



//log bilgilerini listeleme
$log1=$db->prepare("select * from log  order by logid desc LIMIT 50");
$log1->execute(array(

));

?>



<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Kullanıcı Logları
             <?php
                // Eğer güncelleme başarılı olursa mesaj göstertme alanı
             if (isset($_GET["sil"]) && $_GET["sil"]=="ok") { ?>

              <b class="alert alert-success small" style="color:white;">Cari Silindi.</b>

            <?php } elseif (isset($_GET["sil"]) && $_GET["sil"]=="no") { ?>

              <b class="alert alert-danger small" style="color:white;">Hata. Cari silinmedi.</b>

            <?php  } elseif (isset($_GET["pasiflik"]) && $_GET["pasiflik"]=="ok") { ?>

              <b class="alert alert-success small" style="color:white;">Cari PASİF yapıldı.</b>

            <?php }  elseif (isset($_GET["aktiflik"]) && $_GET["aktiflik"]=="ok") { ?>

              <b class="alert alert-success small" style="color:white;">Cari AKTİF yapıldı.</b>

            <?php } ?>
          </h2>
          <div class="clearfix"></div>
          <div align="right">
            <!-- <a href="cari-ekle"><button class="btn btn-success btn-xs">Ekle</button></a> -->
          </div>
        </div>
        <div class="x_content">
          <div>
            <!-- <a href="component/export?ad=cari"><button class="btn btn-warning ">Export(.xls)</button></a> -->
          </div>
          <br />
          <table id="datatable-responsive-bs" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Log ID</th>
                <th>Kullanıcı Adı</th>
                <th>İşlem</th>
                <th>İşlem Zamani</th>
                <!-- <th></th> -->
              </tr>
            </thead>
            <tbody>
              <?php
                //kisileri listeleme
              $i=0;
              while ($logdata=$log1->FETCH(PDO::FETCH_ASSOC)) {
                ?>
                <tr <?php echo $i%2==0 ? "style='background-color: #CCCCCC;'" : "";?>>
                  <td><?php echo $logdata["logid"]; ?></td>
                  <td><?php echo $logdata["logkullaniciadi"]; ?></td>
                  <td><?php echo $logdata["logislem"]; ?></td>
                  <td><?php echo $logdata["logtarihi"]; ?></td>
               </tr>
               <?php
               $i++;
             }
             ?>
           </tbody>
         </table>
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









