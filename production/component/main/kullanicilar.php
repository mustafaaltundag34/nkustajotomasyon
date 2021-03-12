<?php
$kullanici=array();
$query = $db->prepare("select *,COUNT(*) as toplam from kullanici group by kullanicituru order by toplam DESC");
$query->execute();
$toplam_kisi=0;
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  $toplam_kisi+=$row["toplam"];

  $kullanici[]=$row;
}

?>

<!-- Personel Dağılumu -->
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel tile fixed_height_220">
    <div class="x_title">
      <h2>Kullanicilarimiz</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
     <!-- <h4>Kullanici Dağılımı <small>(<?php echo $toplam_kisi; ?>)</small></h4>-->
      <?php foreach ($kullanici as $value) {  
          $yuzde = ($value["toplam"]*100)/$toplam_kisi;

        ?>
        <div class="widget_summary">
          <div class="w_left w_25">
            <span><?php echo $value["kullanicituru"]; ?></span><br>
            <small>(<?php echo substr($yuzde,0,4); ?>%)</small>
          </div>
          <div class="w_center w_55">
            <div class="progress">
              <div class="progress-bar bg-black" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $yuzde; ?>%;">
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