<?php
$kisiler=array();
$query = $db->prepare("select * from log  order by logid desc limit 4");
$query->execute(array(
  //"logislem" => "Başarılı Login Islemi"
));
$sayi = $query->rowCount();
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  $kisiler[]=$row;
}

?>

<!--SON GİRİŞLER-->

<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Son Islemler <small></small></h2>
      <div class="clearfix"></div>
    </div>
    <ul class="list-unstyled top_profiles scroll-view">
      <?php foreach ($kisiler as $value) { ?>
        <li class="media event">
            <a class="pull-left border-aero profile_thumb">
              <i class="fa fa-user blue"></i>
            </a>

          <div class="media-body"> 
             <?php echo $value["logkullaniciadi"]; ?>  
            <p><strong> <?php echo $value["logislem"]; ?> </strong></p>
            <p> <small><?php echo $value["logtarihi"]; ?></small>
            </p>
          </div>
        </li>
      <?php    }  ?>
      
      
    </ul>
  </div>
</div>
      <!--SON GİRİŞLER-->