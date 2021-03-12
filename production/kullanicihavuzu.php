<!-- header -->
<?php require_once "component/header.php"; ?>
<!-- header -->
<?php
// bu sayfaya sadece admin, satis ve muhasebeci ulaşsın
//if ($data["kullanicituru"]!="Ogruyesi") { 
 //header("Location:main");
//exit;
require_once "../netting/fonksiyonlar.php";
adminkontrol($_SESSION["kullanicituru"]);


//kullanici bilgilerini listeleme
// $caritanim=$db->prepare("select * from caritanim");
// $caritanim->execute();
$kullanicihavuzu1=$db->prepare("select * from kullanici where kullaniciaktif=:kullaniciaktif order by kullaniciid desc ");
$kullanicihavuzu1->execute(array(
  "kullaniciaktif" => 1
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
            <h2>Kullanici Havuzu Listeleme
             <?php
                // Eğer güncelleme başarılı olursa mesaj göstertme alanı
             if (isset($_GET["sil"]) && $_GET["sil"]=="ok") { ?>

              <b class="alert alert-success small" style="color:white;">Silindi.</b>
              <script type="text/javascript">
                swal("Silindi"," başarıyla silindi.","success");
              </script>
            <?php } elseif (isset($_GET["sil"]) && $_GET["sil"]=="no") { ?>

              <b class="alert alert-danger small" style="color:white;">Hata.  silinmedi.</b>

            <?php  } elseif (isset($_GET["pasiflik"]) && $_GET["pasiflik"]=="ok") { ?>

              <b class="alert alert-success small" style="color:white;"> PASİF yapıldı.</b>

            <?php }  elseif (isset($_GET["aktiflik"]) && $_GET["aktiflik"]=="ok") { ?>

              <b class="alert alert-success small" style="color:white;"> AKTİF yapıldı.</b>

            <?php } ?>
          </h2>
           <div class="clearfix"></div>
          <div align="right">
            <a href="kullanici-ekle.php" target="popup" onclick="pencereac()"><button title="Yalnizca Ogretim Uyelerine mahsus"  <?php echo ($_SESSION["kullanicituru"] !='Ogruyesi') ? 'disabled' :";"?> class="btn btn-success btn-xl">Kullanici Ekle</button></a>
          </div>
        </div>
        <div class="x_content">
          <br />
            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" binfo="true" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th></th>
                <th>Foto</th>
                <th>Kullanici ID</th>
                <th>Kullanici Mail</th>
                <th>Kullanici Adi Soyadi</th>
                <th>Kullanici Bolum</th>
                <th>Kullanici Turu</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
                //kisileri listeleme
              $i=0;
              while ($kullanicihavuzu=$kullanicihavuzu1->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr <?php echo $i%2==0 ? "style='background-color: #CCCCCC;'" : "";?>>
                  <td><center><a href="kullanici-duzenle.php?kullaniciid=<?php echo $kullanicihavuzu["kullaniciid"]; ?>" target="popup" onclick="detay()"><button class="btn btn-primary btn-xs">Detay</button></a></center></td>
                  <td align="center"><?php if (strlen($kullanicihavuzu["kullanicifoto"])>0) { ?> <img src="dimg/<?php echo $kullanicihavuzu['kullanicifoto']; ?>" width="75" height="75">
                        <?php
                      }else{
                        ?>
                        <img src="dimg/user.png" alt="Firma-Resim" width="75" height="75">

                      <?php } ?>
                    </td>
                  <td><?php echo $kullanicihavuzu["kullaniciid"]; ?></td>
                  <td><?php echo $kullanicihavuzu["kullanicimail"]; ?></td>
                  <td><?php echo $kullanicihavuzu["kullaniciadisoyadi"]; ?></td>
                  <td><?php echo $kullanicihavuzu["kullanicibolum"]; ?></td>
                  <td><?php echo $kullanicihavuzu["kullanicituru"]; ?></td>
                  <td><center><a href="kullanici-havuz-yazdir.php?kullaniciadisoyadi=<?php echo $kullanicihavuzu['kullaniciadisoyadi']; ?>&kullaniciid=<?php echo $kullanicihavuzu['kullaniciid']; ?>" target="popup"  onclick="detayYazdir()"><button class="btn btn-primary btn-xs">Kullanici Rapor</button></a></center></td>
                  <td><center> <a onclick="sil(<?php echo $kullanicihavuzu['kullaniciid']; ?>)"> <button <?php echo ($_SESSION["kullanicituru"] !='Ogruyesi') ? 'disabled' :";"?> class="btn btn-danger btn-xs">Sil</button> </a> </center></td>

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


<script type="text/javascript">

  function pencereac(){
    var win = window.open('kullanici-ekle.php','popup','width=800,height=800');
    // return false;
    var timer = setInterval(function() {   
      if(win.closed) {  
        clearInterval(timer);  
        setTimeout(() => window.location.reload(), 2000);
        swal("Başarılı","Listeleme Basarili","success");       }  
      }, 1000); 
  }
</script>

<script type="text/javascript">
  function sil(id){
    swal({
      title:"Kullanici Silme",
      text:"Kullaniciyi Silmek İstiyor musunuz?",
      icon:"warning",
      buttons:true,
      dangerMode:true
    }).then((sil)=>{
      if (sil) {
        var win = window.open(`../netting/admin-islemler.php?kullaniciid=${id}&kullaniciaktif=ok`,"_self");
      }
      else{
        swal("İptal","Kullanici Silme İptal Edildi.","info");
      }
    });
    
  }

  function detay(){
    var win = window.open('kullanici-duzenle.php?kullaniciid=<?php echo $kullanicihavuzu["kullaniciid"]; ?>','popup','width=800,height=800');
    // return false;
    var timer = setInterval(function() {   
      if(win.closed) {  
        clearInterval(timer);  
        setTimeout(() => window.location.reload(), 2000);
        swal("Başarılı","Listeleme Basarili","success");       }  
      }, 1000); 
  }



  function detayYazdir(){
    var win = window.open('kullanici-havuz-yazdir.php?kullaniciadisoyadi=<?php echo $kullanicihavuzu['kullaniciadisoyadi']; ?>&kullaniciid=<?php echo $kullanicihavuzu['kullaniciid']; ?>','popup','width=800,height=800');
    // return false;
    var timer = setInterval(function() {   
      if(win.closed) {  
        clearInterval(timer);  
        window.location.reload();     
      }  
    }, 1000); 
  }
</script>




<!-- footer -->
<?php require_once "component/footer.php"; ?>
<!-- footer -->








