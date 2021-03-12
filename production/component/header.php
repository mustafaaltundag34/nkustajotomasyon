<?php 
require_once ("../netting/connection.php");
//Giriş yapmış kişinin bilgilerine ulaşmak için...
$query=$db->prepare("SELECT * FROM kullanici where kullanicimail=:kullanicimail");
$query->execute(array(
	'kullanicimail' => $_SESSION['kullanicimail']
));
$row=$query->rowCount();
$data=$query->fetch(PDO::FETCH_ASSOC);
//Eğerki giriş yapmadan url kısmından giriş yapılmışsa satır sayısı 0 olucak ve direk header ile yönlendirme yapıyoruz.
if ($row==0) {

	header("Location:../index?durum=izinsiz-giris");
	exit;

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<title>NKU Staj Sistemi</title>

	<!-- Bootstrap -->
	<link rel="icon" type="image/png" href="login_files/images/icons/stajdb.png"/>
	
	<link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!-- bootstrap-progressbar -->
	<link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
	<!-- JQVMap -->
	<link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
	<!-- bootstrap-daterangepicker -->
	<link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- Datatables -->
	<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
	<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
	<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
	<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

	<!-- CK Editör -->
	<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
	<!-- Custom Theme Style -->
	<link href="../build/css/custom.min.css" rel="stylesheet">

	<!-- SweetAlert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<!-- after login progress -->
	<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

	<style type="text/css">
		.loader-wrapper {
			width: 100%;
			height: 100%;
			position: absolute;
			top: 0;
			left: 0;
			background-color: #242f3f;
			display:flex;
			justify-content: center;
			align-items: center;
			z-index: 1;
		}
		.loader {
			display: inline-block;
			width: 30px;
			height: 30px;
			position: relative;
			border: 4px solid #Fff;
			animation: loader 2s infinite ease;
		}
		.loader-inner {
			vertical-align: top;
			display: inline-block;
			width: 100%;
			background-color: #fff;
			animation: loader-inner 2s infinite ease-in;
		}
		@keyframes loader {
			0% { transform: rotate(0deg);}
			25% { transform: rotate(180deg);}
			50% { transform: rotate(180deg);}
			75% { transform: rotate(360deg);}
			100% { transform: rotate(360deg);}
		}
		@keyframes loader-inner {
			0% { height: 0%;}
			25% { height: 0%;}
			50% { height: 100%;}
			75% { height: 100%;}
			100% { height: 0%;}
		}
	</style>

</head>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">
						<a href="main" class="site_title"><i class="fa fa-database"></i> <span>NKU Staj Sistemi</span></a>

					</div>

					<div class="clearfix"></div>

					<!-- menu profile quick info -->
					<div class="profile clearfix">
						<div class="profile_pic">
							<?php
							if (strlen($data["kullanicifoto"])>0) { ?>
								<img src="dimg/<?php echo $data['kullanicifoto']; ?>" width="200" alt="Profil-Resim" class="img-circle profile_img">
								<?php
							}else{
								?>
								<img src="dimg/user.png" width="200" alt="Profil-Resim" class="img-circle profile_img">

							<?php } ?>
						</div>

						<div class="profile_info">
							<span>Hoşgeldiniz,</span>
							<p></p>
							<h2><?php echo mb_convert_case($data["kullaniciadisoyadi"], MB_CASE_TITLE, "UTF-8");//ilk harfleri büyük yaptık ?></h2>
							<span><?php echo date('d.m.Y H:i:s');?></span>
							<br>
							<b class="badge"><?php echo $data["kullanicituru"]=="Ogruyesi" ? ucwords($data["kullanicituru"]) : ""; ?></b>
							<b class="badge"><?php echo $data["kullanicituru"]=="Ogrenci" ? ucwords($data["kullanicituru"]) : ""; ?></b>
						</div>
					</div>
					<!-- /menu profile quick info -->

					<br />

					<!-- sidebar menu -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
						<div class="menu_section">
							<!--<h2><b>ISLEM MENUSU</b></h2>-->
							<ul class="nav side-menu">
								<li><a href="main"><i class="fa fa-home"></i>Ana Sayfa</a></li>
								<li><a href='kullanicihavuzu.php'><i class='fa fa-users'></i>Kullanıcı Havuzu</a></li>
								<li><a href="firmahavuzu.php"><i class="fa fa-cubes"></i>Firma Havuzu</a></li>
								<li><a href="stajhavuzu.php"><i class="fa fa-database"></i>Staj Havuzu</a></li>
								<li><a href="kullanici-duzenle.php?kullaniciid=<?php echo $_SESSION['kullaniciid']; ?>" target="popup" onclick="profil()"><i class="fa fa-user"></i>Profil Ayarlari</a></li>
								<li><a href="kullanici-log.php"><i class="fa fa-server"></i>Kullanici Loglari</a></li>
								<li><a href="hakkimizda"><i class="fa fa-question-circle"></i>Hakkimizda</a></li>

								<li><a href="https://drive.google.com/file/d/1ceZpZ3EdDLguv8_BSdBMwmkltcL3Okgv/view?usp=sharing" target="_blank"><i class="fa fa-info-circle"></i>Kullanım Kılavuzu</a></li>
								<li><a href="../netting/islem-cikis.php?cikis=ok"><i class="fa fa-power-off"></i>Uygulamadan ÇIKIŞ</a></li>
								<!-- <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li> -->
							</ul>
						</div>
<!--						<hr></hr>
						<marquee scrollamount="1" height="50%" width="100%" direction="down" >WEBCEBİR.COM</marquee>-->
					</div>
					<!-- /sidebar menu -->

					<!-- /menu footer buttons -->
					<div class="sidebar-footer hidden-small">
						<a data-toggle="tooltip" data-placement="top" title="Profil Ayar" href="kullanici-duzenle.php?kullaniciid=<?php echo $_SESSION['kullaniciid']; ?>" target="popup" onclick="profil()"></i>
							<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Sayfa Yenile" href="main.php">
							<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Kullanım Kılavuzu" href="https://drive.google.com/file/d/1ceZpZ3EdDLguv8_BSdBMwmkltcL3Okgv/view?usp=sharing" target="_blank">
							<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Çıkış" href="../netting/islem-cikis.php?cikis=ok">
							<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
						</a>
					</div>
					<!-- /menu footer buttons -->

				</div>
			</div>



			<!-- top navigation -->
			<div class="top_nav">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i></a>
						</div>
						<ul class="nav navbar-nav navbar-right">
							<li class="">
								<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

									<?php
									if (strlen($data["kullanicifoto"])>0) { ?>
										<img src="dimg/<?php echo $data['kullanicifoto']; ?>" alt="Profil-Resim">
										<?php
									}else{
										?>
										<img src="dimg/user.png" alt="Profil-Resim">

									<?php } ?>
									<?php echo $data["kullanicimail"]; ?>
									<span class=" fa fa-angle-down"></span>
								</a>
								<ul class="dropdown-menu dropdown-usermenu pull-right">
									<!-- <li><a href="javascript:;"> Profil</a></li> -->
                  <!-- <li>
                    <a href="javascript:;">
                      <span class="badge bg-red pull-right">50%</span>
                      <span>Settings</span>
                    </a>
                </li> -->
                <li><a href="kullanici-duzenle.php?kullaniciid=<?php echo $_SESSION['kullaniciid']; ?>" target="popup" onclick="profil()">Profil Ayar</a></li>
                <li><a href="../netting/islem-cikis.php?cikis=ok"><i class="fa fa-sign-out pull-right"></i> Çıkış</a></li>
            </ul>
        </li>

          <li class="">
          	<a href="javascript:;">
          		<b class="badge">Giriş:<?php echo ucwords($data["kullanicituru"]); ?></b>
          	</a>
          </li>
      </ul>
  </nav>
</div>
</div>
<!-- /top navigation -->

<script type="text/javascript">

  function profilayarla(){
    var win = window.open('kullanici-duzenle.php','popup','width=800,height=900');
    // return false;
    var timer = setInterval(function() {   
      if(win.closed) {  
        clearInterval(timer);  
        setTimeout(() => window.location.reload(), 2000);
        swal("Yenileme Basarili","Basarili Listeleme.","success");   }  
      }, 1000); 
  }



  function profil(){
    var win = window.open('kullanici-duzenle.php?kullaniciid=<?php echo $_SESSION['kullaniciid']; ?>','popup','width=800,height=800');
    // return false;
    var timer = setInterval(function() {   
      if(win.closed) {  
        clearInterval(timer);  
        setTimeout(() => window.location.reload(), 2000);
        swal("Başarılı","Listeleme Basarili","success");       }  
      }, 1000); 
  }


</script>