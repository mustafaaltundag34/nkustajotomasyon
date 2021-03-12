<?php
$stok=array();
$query = $db->prepare("select *,count(*) as toplam from  stajhavuzu where stajaktif=:stajaktif group by stajonay order by toplam DESC");
$query->execute(array(
  "stajaktif" => 1));
$toplam_sayi=0;

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  $toplam_sayi+=$row["toplam"];
  $stok[]=$row;
}

?>

<!-- Personel Dağılumu -->
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel tile fixed_height_220">
    <div class="x_title">
      <h2>Staj Havuz Oranlari</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <?php foreach ($stok as $value) {  
       $yuzde = ($value["toplam"]*100)/$toplam_sayi;
       ?>
       <div class="widget_summary">
        <div class="w_left w_25">
          <span><?php echo $value["stajonay"]; ?></span><br>
          <small>(<?php echo substr($yuzde,0,4); ?>%)</small>
        </div>
        <div class="w_center w_55">
          <div class="progress">
            <div class="progress-bar <?php echo  $value['stokonay']=='stokonay' ? 'bg-red' : 'bg-green' ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $yuzde; ?>%;">
              <span class="sr-only">60% Complete</span>
            </div>
          </div>
        </div>
        <div class="w_right w_20">
          <span><?php echo $value["toplam"]; ?></span>
        </div>
        <div class="clearfix"></div>
      </div>
    <?php } ?>



  </div>
</div>
</div>
        <!-- Personel Dağılumu -->