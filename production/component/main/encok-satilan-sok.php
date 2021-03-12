<?php
$stok=array();
$query = $db->prepare("select *,count(*) as toplam,sum(fthareket_tutar) as top from faturatanimhareket group by fthareket_stokadi order by count(*) desc limit 5");
$query->execute();
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  $stok[]=$row;
}

?>

<!-- En çok satılan stok -->
<div class="col-md-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>En Çok Satılan Ürünler <small>Top 5</small></h2>
      <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Settings 1</a>
            </li>
            <li><a href="#">Settings 2</a>
            </li>
          </ul>
        </li>
        <li><a class="close-link"><i class="fa fa-close"></i></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <?php $a=1; foreach ($stok as $value) { ?>
        <article class="media event">
          <a class="pull-left date">
            <p class="day"> <?php echo $a; ?></p>
          </a>
          <div class="media-body">
           <b><?php echo $value["fthareket_stokadi"];?></b>
           <p style="color:green;"><?php echo $value["top"];?>₺ Kazanç</p>
         </div>
       </article>
     <?php $a++; } ?>
      

   </div>
 </div>
</div>
      <!-- En çok satılan stok -->