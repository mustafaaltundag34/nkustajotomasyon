<!-- header -->
<?php
 // require_once "component/header.php"; 
require_once "../netting/connection.php";

?>
<!-- header -->

<?php

$kullaniciadisoyadi = $_GET["kullaniciadisoyadi"]; 
$kullaniciid = $_GET["kullaniciid"]; 

//Kullanicilar
$cari = array();
$query_cari = $db->prepare("select * from kullanici where kullaniciid=:kullaniciid");
$query_cari->execute(array(
  "kullaniciid" =>  $kullaniciid

)); 
$cari_data = $query_cari->fetch(PDO::FETCH_ASSOC);


//STAJLAR
$datas = array();
$query = $db->prepare("select * from stajhavuzu where  stajogradisoyadi=:stajogradisoyadi and stajaktif=:stajaktif");
$query->execute(array(
  "stajogradisoyadi" => $kullaniciadisoyadi,
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
            <h3>Kullanici ID  : <?php echo $cari_data["kullaniciid"]; ?></h3>
            <h4>Kullanici Adi Soyadi  : <?php echo $cari_data["kullaniciadisoyadi"]; ?></h4>
            <h4>Kullanici E-mail  : <?php echo $cari_data["kullanicimail"]; ?></h4>
            <h4>Kullanici Universite  : <?php echo $cari_data["kullaniciuniversite"]; ?></h4>
            <h4>Kullanici Bolum : <?php echo $cari_data["kullanicibolum"]; ?></h4>
            <h4>Kullanici Turu  : <?php echo $cari_data["kullanicituru"]; ?></h4>
            <h4>Telefon   : <?php echo $cari_data["kullanicitel"]; ?></h4>          
            <div style="border-bottom:12px solid gray;width:100%;"></div>

            <div class="x_content">
              <br />
              <h1>Stajlar</h1>
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">

                <tr>
                  <th>Staj ID</th>
                  <th>Staj Adi Soyadi</th>
                  <th>Staj Firmasi</th>
                  <th>Staj Hocasi</th>
                  <th>Staj Onayi</th>
                  <th>Staj Puani</th>
                </tr>
                <tbody>
                  <?php
                  foreach ($datas as $key) { 
                    ?>
                    <tr>
                      <td><?php echo $key["stajid"]; ?></td>
                      <td><?php echo $key["stajogradisoyadi"]; ?></td>
                      <td><?php echo $key["stajfirma"]; ?></td>
                      <td><?php echo $key["stajhocasi"]; ?></td>
                      <td><?php echo $key["stajonay"]; ?></td>
                      <td><?php echo $key["stajpuani"]; ?></td>
                    </tr>

                  <?php }
                  ?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
              <br>
              <div style="border-bottom:12px solid gray;width:100%;"></div>


            </div>
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





