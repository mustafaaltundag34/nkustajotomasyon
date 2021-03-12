<!-- header -->
<?php
 // require_once "component/header.php"; 
require_once "../netting/connection.php";

?>
<!-- header -->

<?php
 
$stajid = $_GET["stajid"]; 

//Kullanicilar
$cari = array();
$query_cari = $db->prepare("select * from stajhavuzu where stajid=:stajid and stajaktif=:stajaktif");
$query_cari->execute(array(
  "stajid" =>  $stajid,
  "stajaktif"=>1
)); 
$cari_data = $query_cari->fetch(PDO::FETCH_ASSOC);


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
            <h1>Ogrenci STAJ RAPORU</h1>
              <br>
              <div style="border-bottom:12px solid gray;width:100%;"></div>              
            <h3>Staj ID            : <?php echo $cari_data["stajid"]; ?></h3>
            <h4>Staj Ogr Ad Soyad  : <?php echo $cari_data["stajogradisoyadi"]; ?></h4>
            <h4>Staj Firmasi       : <?php echo $cari_data["stajfirma"]; ?></h4>
            <h4>Staj Bolum         : <?php echo $cari_data["stajbolum"]; ?></h4>
            <h4>Staj Tarihi        : <?php echo $cari_data["stajtarihi"]; ?></h4>
            <h4>Staj Tipi Suresi   : <?php echo $cari_data["stajtipisuresi"]; ?></h4>
            <h4>Staj Projesi       : <?php echo $cari_data["yapilanprojeis"]; ?></h4>
            <h4>Staj Hocasi        : <?php echo $cari_data["stajhocasi"]; ?></h4>
            <h4>Staj Puani         : <?php echo $cari_data["stajpuani"]; ?></h4>
            <h4>Staj Onayi         : <?php echo $cari_data["stajonay"]; ?></h4>
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





