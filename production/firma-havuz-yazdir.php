<!-- header -->
<?php
 // require_once "component/header.php"; 
require_once "../netting/connection.php";

?>
<!-- header -->

<?php

$firmaid = $_GET["firmaid"]; 
$firmaadi = $_GET["firmaadi"]; 

//Firma bilgileri
$cari = array();
$query_cari = $db->prepare("select * from firmahavuzu where firmaid=:firmaid");
$query_cari->execute(array(
  "firmaid" =>  $_GET["firmaid"]

)); 
$cari_data = $query_cari->fetch(PDO::FETCH_ASSOC);


//Firmada yapilan stajlar
$datas = array();
$toplam_tahsilat=0;
$query = $db->prepare("select * from stajhavuzu where stajfirma=:stajfirma and stajaktif=:stajaktif");
$query->execute(array(
  "stajfirma" => $_GET["firmaadi"],
  "stajaktif"=>1
)); 
while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
  $datas[] = $data;
}



?>
<!-- türkçe karakter sorununu çözmek için -->
<style>
  *{
    font-family:"DeJaVu Sans Mono",monospace;
  }
</style>



<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h3>Firma ID       : <?php echo $cari_data["firmaid"]; ?></h3>
            <h4>Firma Adi   : <?php echo $cari_data["firmaadi"]; ?></h4>          
            <h4>Firma Sehir   : <?php echo $cari_data["firmasehir"]; ?></h4>          
            <h4>Firma Sektor   : <?php echo $cari_data["firmasektor"]; ?></h4>          
            <h4>Firma Eposta   : <?php echo $cari_data["firmamail"]; ?></h4>   
            <h4>Firma Tel   : <?php echo $cari_data["firmatel"]; ?></h4>          
            <h4>Firma Yetkili   : <?php echo $cari_data["firmayetkili"]; ?></h4>               
        
            <div style="border-bottom:12px solid gray;width:100%;"></div>

 
              <h1>Firmada Yapilan Stajlar</h1>
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">

                <tr>
                  <th>Staj ID</th>
                  <th>Staj Ogrencisi</th>
                  <th>Staj Bolumu</th>
                  <th>Staj Hocasi</th>
                  <th>Staj Onayi</th>
                </tr>
                <tbody>
                  <?php
                  foreach ($datas as $key) { 
                    ?>
                    <tr>
                      <td><?php echo $key["stajid"]; ?></td>
                      <td><?php echo $key["stajogradisoyadi"]; ?></td>
                      <td><?php echo $key["stajbolum"]; ?></td>
                      <td><?php echo $key["stajhocasi"]; ?></td>
                      <td><?php echo $key["stajonay"]; ?></td>
                    </tr>

                  <?php }
                  ?>
                  <tr>

                  </tr>
                </tbody>
              </table>



            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php
  $html = ob_get_clean();
  require_once 'dompdf/autoload.inc.php';
  use Dompdf\Dompdf;
  use Dompdf\Options;
  // DomPdf options ile Php kullanımını aktif etmeniz gerekiyor. Aksi takdirde php ile gönderdiğiniz sorgular çalışmayacaktır.
  $options = new Options();
  $options->set('isPhpEnabled', TRUE);
  $dompdf = new Dompdf($options);
  $dompdf->loadHtml($html);

  // Bu satırda pdf dosyamızın ölçüsünü belirliyoruz. Örnek A4 ve (portrait) Dikey olacak gibi.. Yatay yapmak için Landscape yazmanız yeterli.
  $dompdf->setPaper('A4', 'portrait');

  // Html çıktısı pdf'e dönüştürülüyor.
  $dompdf->render();

  // Attachment değerini 0 verirseniz pdf dosyanız browser üzerinden görüntülenecektir. 1 verirseniz kullanıcının bilgisayarına indirme işlemine geçecektir.
  $dompdf->stream("bswebtools-blog",array("Attachment"=>0));
  ?>

  <!-- /page content -->





