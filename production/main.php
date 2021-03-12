<!-- header -->
<?php require_once "component/header.php"; ?>
<!-- header -->
<?php

//Toplam Satış
$satis=$db->prepare("select * from faturatanim where CARIISLEMTURU=:CARIISLEMTURU");
$satis->execute(array(
  "CARIISLEMTURU" => "SATISFATURASI"
));
$toplamSatis=0;
while($row=$satis->fetch(PDO::FETCH_ASSOC)){
  $toplamSatis += $row["TUTAR"];
}
$formattoplamSatis = number_format($toplamSatis, 2, ',', '.');

//Toplam Alış
$alis=$db->prepare("select * from faturatanim where CARIISLEMTURU=:CARIISLEMTURU");
$alis->execute(array(
  "CARIISLEMTURU" => "ALISFATURASI"
));
$toplamAlis=0;
while($row=$alis->fetch(PDO::FETCH_ASSOC)){
  $toplamAlis += $row["TUTAR"];
}
$formattoplamAlis = number_format($toplamAlis, 2, ',', '.');

//Toplam Staj
$musteri=$db->prepare("select * from stajhavuzu where stajaktif=:stajaktif");
$musteri->execute(array(
"stajaktif"=>1));
$toplamstaj = $musteri->rowCount();
$formattoplamstaj = number_format($toplamstaj,0, ',', '.');


//Toplam Log
$musteri=$db->prepare("select * from log");
$musteri->execute();
$toplamlog = $musteri->rowCount();
$formattoplamlog = number_format($toplamlog,0, ',', '.');

//Toplam Firma
$musteri=$db->prepare("select * from firmahavuzu");
$musteri->execute();
$toplamfirma = $musteri->rowCount();
$formattoplamfirma = number_format($toplamfirma,0, ',', '.');


//Toplam Ogrenci
$personel=$db->prepare("select * from kullanici where kullanicituru=:kullanicituru");
$personel->execute(array(
  "kullanicituru" => "Ogrenci")
);
$toplamPersonel = $personel->rowCount();
$formattoplamPersonel = number_format($toplamPersonel,0, ',', '.');

//Toplam Ogretimuyesi
$personel=$db->prepare("select * from kullanici where kullanicituru=:kullanicituru");
$personel->execute(array(
  "kullanicituru" => "Ogruyesi")
);
$toplamogruyesi = $personel->rowCount();
$formattoplamogruyesi = number_format($toplamogruyesi,0, ',', '.');

//Onaylanmış Staj Sayisi
$personel=$db->prepare("select * from stajhavuzu where stajonay=:stajonay and stajaktif=:stajaktif");
$personel->execute(array(
  "stajonay" => "Onaylanmadi",
  "stajaktif" => 1
)
);
$toplamonaysizstaj = $personel->rowCount();
$formattoplamonaysizstaj = number_format($toplamonaysizstaj,0, ',', '.');

//Onaylanmamış Staj Sayisi
$personel=$db->prepare("select * from stajhavuzu where stajonay=:stajonay and stajaktif=:stajaktif");
$personel->execute(array(
  "stajonay" => "Onaylandi",
  "stajaktif" => 1
)
);
$toplamonaylistaj = $personel->rowCount();
$formattoplamonaylistaj = number_format($toplamonaylistaj,0, ',', '.');

?>



<!-- page content -->
<div class="right_col" role="main">    <div class="row tile_count">
  <!-- top tiles  (admin giriş yapmışssa gözüksün)-->
       <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user-plus"></i>Staj Havuzu</span>
        <div class="count"  style="font-size: 25px!important;"><?php echo $formattoplamstaj; ?></div>
        <button border:10px;><a href="stajhavuzu.php">  <img src="images/stajdb.png" width="100" height="100" style="border:5px outset white;"></a></button>
      </div>

      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-database"></i> Toplam Islem Hacmi</span>
        <div class="count green"  style="font-size: 25px!important;"><?php echo $formattoplamlog; ?></div>
      <button border:10px;><a href="kullanici-log.php">  <img src="images/database.png" width="100" height="100" style="border:5px outset white;"></a></button>
      </div>


      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-users"></i> Toplam Firma Sayısı </span>
        <div class="count"  style="font-size: 25px!important;"><?php echo $formattoplamfirma; ?></div>
        <button border:10px;> <a href='firmahavuzu.php'>
                 <img src="images/cari.png" width="100" height="100" style="border:5px outset white;"></a></button>
      </div>


      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Ogrenci Havuzu</span>
        <div class="count"  style="font-size: 25px!important;"><?php echo $formattoplamPersonel; ?></div>
        <button border:10px;> <?php  if ($data["kullanicituru"]=="Ogruyesi") {  ?> <a href='kullanicihavuzu.php'><?php } ?>
        <img src="images/users.png" width="100" height="100" style="border:5px outset white;"></a></button>
      </div>


      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-university"></i> Ogretim Uyesi Havuzu</span>
        <div class="count" style="font-size: 25px!important;"><?php echo $formattoplamogruyesi; ?></div>
        <button border:10px;> <?php  if ($data["kullanicituru"]=="Ogruyesi") {  ?> <a href='kullanicihavuzu.php'><?php } ?>
        <img src="images/ogruyesi1.png" width="100" height="100" style="border:5px outset white;"></a></button>
      </div>


        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        
        <?php if ($formattoplamonaysizstaj==0) { ?><span class="count_top"><i class="fa fa-check"></i> Toplam Onaylanmış Staj</span>
        <div class="count"  style="font-size: 25px!important;"> <?php echo $formattoplamonaylistaj; ?></div>
       <button border:10px;><a href="stajhavuzu.php">  <img src="images/onaylistaj.png" width="100" height="100" style="border:5px outset white;"></a></button>
        <?php } elseif ($formattoplamonaysizstaj>0) { ?><span class="count_top"><p class="blink"> Toplam Onaylanmamış Staj</p></span>
        <div  style="font-size: 25px!important; font-weight: bold;"> <?php echo $formattoplamonaysizstaj; ?></div>
       <button border:10px;><a href="stajhavuzu.php">  <img src="images/onaysizstaj.png" width="100" height="100" style="border:5px outset white;"></a></button>
        <?php }
        ?> 
      </div>

   
    </div>



  <br />

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Staj ve STE Havuzu

                <?php
                // Eğer güncelleme başarılı olursa mesaj göstertme alanı
                if (isset($_GET["durum"]) && $_GET["durum"]=="ok") { ?>
              <script type="text/javascript">
                swal("Login Basarili","Listeleme Basarili.","success");
              </script>
                  <b class="alert alert-success small" style="color:white;">Güncelleme Başarılı.</b>

                <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="no") { ?>

                  <b class="alert alert-danger small" style="color:white;">Hata. Güncelleme yapılmadı.</b>

                <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="yetkinizyok") { ?>
              <script type="text/javascript">
                swal("Yetkiniz Yok","Bu sayfaya giris yetkiniz yok.","error");
              </script>
                  <b class="alert alert-danger small" style="color:white;">Hata. Bu Sayfaya giris yetkiniz yok.</b>

                <?php }


                ?>

            </h2>
          <div class="clearfix"></div>
        </div>

        <div class="x_content">
         <div class="container">
           <div class="row">
             <div class="col-md-6">
              <?php include "component/main/kullanicilar.php"; ?>  
            </div>
            <div class="col-md-6">
              <?php include "component/main/staj-oran.php"; ?>  
            </div>
          </div>
        </div>


        <div class="container">
         <div class="row">
           <div class="col-md-6">
            <?php include "component/main/son-girisler.php"; ?>  
          </div>
          <div class="col-md-6">
            <?php include "component/main/son-firmalar.php"; ?>  
          </div>
        </div>
      </div>


    </div>
  </div>
</div>

</div>

</div>
<!-- /page content -->

<?php

if (isset($_GET["durum"]) && $_GET["durum"]=="ok") { ?>
 
<div class="loader-wrapper">
  <span class="loader"><span class="loader-inner"></span></span>
</div>


<script>
  $(window).on("load",function(){
          // $(".loader-wrapper").fadeOut(2000, "linear",complete);
          $(".loader-wrapper").delay(1000).fadeOut("slow");
        });
      </script>

 <?php
}

?>

    <style>
      .blink {
      animation: blinker 0.9s linear infinite;
      color: #ff6a6a;
      font-size: 14px;
      font-weight: bold;
      font-family: sans-serif;
      }
      @keyframes blinker {  
      50% { opacity: 0; }
      }
    </style>


      <!-- footer -->
      <?php require_once "component/footer.php"; ?>
      <!-- footer -->










