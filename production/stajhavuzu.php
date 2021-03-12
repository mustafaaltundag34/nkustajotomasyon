<!-- header -->
<?php require_once "component/header.php"; ?>
<!-- header -->

<?php
// bu sayfaya sadece admin, satis ve muhasebeci ulaşsın
//if ($data["kullanici_yetki"]!="admin" && ($data["kullanici_yetki"]!="satis") && ($data["kullanici_yetki"]!="muhasebe")) { 
// header("Location:main");
// exit;



//kullanici bilgilerini listeleme
// $caritanim=$db->prepare("select * from caritanim");
// $caritanim->execute();
$stajhavuzu1=$db->prepare("select * from stajhavuzu where stajaktif=:stajaktif order by stajid desc");
$stajhavuzu1->execute(array(
  "stajaktif" => 1
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
            <h2>Staj Havuzu Listeleme
             <?php
                // Eğer güncelleme başarılı olursa mesaj göstertme alanı
             if (isset($_GET["sil"]) && $_GET["sil"]=="ok") { ?>

              <b class="alert alert-success small" style="color:white;">Silindi.</b>
              <script type="text/javascript">
                swal("Silindi","başarıyla silindi.","success");
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
            <a href="staj-ekle.php" target="popup" onclick="pencereac()"><button class="btn btn-success btn-xl">Staj Ekle</button></a>
          </div>
        </div>
        <div class="x_content">

          <br />
          <table id="datatable-buttons" class="table table-striped table-bordered  dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th></th>
                <th>Staj ID</th>
                <th>Stajyer Adi Soyadi</th>
                <th>Staj Firma Logosu</th>
                <th>Staj Yapilan Firma</th>
                <th>Staj Yapilan Bolum</th>
                <th>Staj Hocasi</th>
                <th>Staj Onay Durumu</th>
                <th>Staj Puani</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
                //kisileri listeleme
              $i=0;
              while ($stajhavuzu=$stajhavuzu1->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr <?php echo $i%2==0 ? "style='background-color: #CCCCCC;'" : "";?>>
                  <td><center><a href="staj-duzenle?stajid=<?php echo $stajhavuzu["stajid"]; ?>" target="popup"  onclick="detay()"><button class="btn btn-primary btn-xs">Detay</button></a></center></td>
                  <td><?php echo $stajhavuzu["stajid"]; ?></td>
                  <td><?php echo $stajhavuzu["stajogradisoyadi"]; ?></td>
                  <td align="center"><?php if (strlen($stajhavuzu["stajfirmalogo"])>0) { ?> <img src="dimg/<?php echo $stajhavuzu['stajfirmalogo']; ?>"  width="125" height="75">
                        <?php
                      }else{
                        ?>
                        <img src="dimg/user.png" alt="Firma-Resim" width="125" height="75">

                      <?php } ?>
                    </td> 
                  <td><?php echo $stajhavuzu["stajfirma"]; ?></td>
                  <td><?php echo $stajhavuzu["stajbolum"]; ?></td>
                  <td><?php echo $stajhavuzu["stajhocasi"]; ?></td>
                  <td><?php echo $stajhavuzu["stajonay"]; ?></td>
                  <td><?php echo $stajhavuzu["stajpuani"]; ?></td>
                  <td><center><a href="staj-rapor-yazdir.php?stajid=<?php echo $stajhavuzu['stajid']; ?>" target="popup"  onclick="detayYazdir()"><button class="btn btn-primary btn-xs">Staj Rapor</button></a></center></td>
                  <td><center> <a onclick="sil(<?php echo $stajhavuzu['stajid']; ?>)"> <button <?php echo $_SESSION["kullanicituru"] !='Ogruyesi' ? 'disabled' :";"?> class="btn btn-danger btn-xs">Sil</button> </a> </center></td>

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
    var win = window.open('staj-ekle.php','popup','width=800,height=800');
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
      title:"Staj Silme",
      text:"Staji Silmek İstiyor musunuz?",
      icon:"warning",
      buttons:true,
      dangerMode:true
    }).then((sil)=>{
      if (sil) {
        var win = window.open(`../netting/staj-islemler.php?stajid=${id}&stajsil=ok`,"_self");
      }
      else{
        swal("İptal","Staj Silme İptal Edildi.","info");
      }
    });
    
  }

  function detay(){
    var win = window.open('staj-duzenle?stajid=<?php echo $stajhavuzu["stajid"]; ?>','popup','width=800,height=800');
    // return false;
    var timer = setInterval(function() {   
      if(win.closed) {  
        clearInterval(timer);  
        window.location.reload();
        swal("Başarılı","Listeleme Basarili","success");         }  
      }, 1000); 
  }



  function detayYazdir(){
    var win = window.open('staj-rapor-yazdir.php?stajid=<?php echo $stajhavuzu['stajid']; ?>','popup','width=800,height=800');
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








