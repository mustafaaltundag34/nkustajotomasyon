<?php
$kisiler=array();
$query = $db->prepare("select * from firmahavuzu order by firmaid desc limit 4");
$query->execute(array(
  //"logislem" => "Başarılı Login Islemi"
));
$sayi = $query->rowCount();
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  $firma[]=$row;
}

?>

<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>En Son Katilan Firmalar <small></small></h2>
      <div class="clearfix"></div>
    </div>
    <ul class="list-unstyled top_profiles scroll-view">
      <?php foreach ($firma as $value) { ?>
        <li class="media event">
            <a class="pull-left border-aero profile_thumb">
              <i class="fa fa-user blue"></i>
            </a>

          <div class="media-body"> 

                  <td><?php if (strlen($value["firmafoto"])>0) { ?> <img src="dimg/<?php echo $value['firmafoto']; ?>" width="100" height="75"> <?php echo $value["firmaadi"]; ?>  
                        <?php
                      }else{
                        ?>
                        <img src="dimg/user.png" alt="Firma-Resim" width="100" height="75"><?php echo $value["firmaadi"]; ?>

                      <?php } ?>
                    </td>

          </div>
        </li>
      <?php    }  ?>

     
    </ul>
  </div>
</div>