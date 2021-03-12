<?php
require_once "netting/connection.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>NKU Staj Sistemi</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->	
	<!-- <link rel="icon" type="image/png" href="login_files/images/icons/favicon.ico"/> -->
	<link rel="icon" type="image/png" href="login_files/images/icons/stajdb.png"/>
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/vendor/animate/animate.css">
	<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login_files/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/vendor/select2/select2.min.css">
	<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login_files/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/css/util.css">
	<link rel="stylesheet" type="text/css" href="login_files/css/main.css">
	<!--===============================================================================================-->

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
<body style="background-color: #666666;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="netting/islem-giris.php" method="POST">
					<span class="login100-form-title p-b-43"> 
						|     NKU Staj Sistemi     | <br>
						      Panele Giriş 	</span>
					
					
					<div class="wrap-input100 validate-input" data-validate = "Email adresi girilmeli: ex@abc.xyz">
						<input class="input100" type="text" name="kullanicimail">
						<span class="focus-input100"></span>
						<span class="label-input100">Email</span>
					</div>
					
					
					<div class="wrap-input100 validate-input" data-validate="Şifre girilmeli">
						<input class="input100" type="password" name="kullanicisifre">
						<span class="focus-input100"></span>
						<span class="label-input100">Şifre</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div >
							<a href="uyekayitekle.php" target="popup" onclick="pencereac()" class="txt3">
								Yeni Uye
							</a>
						</div>

						<div>
							<a href="sifremi-unuttum" class="txt3">

							</a>
						</div>

						<div >
							<a href="sifremi-unuttum" class="txt3">
								
							</a>
						</div>

						<div >
							<a href="sifremi-unuttum" class="txt3">

							</a>
						</div>

						<div>
							<a href="sifremi-unuttum" class="txt1">
								Şifremi Unuttum
							</a>
						</div>
					</div>


					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn" name="login-control" id="login-control">
							Giriş
						</button>
					</div>
					<div class="mt-4">
						<?php 	if (isset($_GET["durum"]) && $_GET["durum"]=="hata") { ?>

							<span class="alert alert-danger">Hatalı giriş. Sisteme giriş yapılmadı.</span>					 			

						<?php 	} elseif (isset($_GET["durum"]) && $_GET["durum"]=="izinsiz-giris") { ?>

							<span class="alert alert-danger">İzinsiz Giriş!. Lütfen giriş yapınız.</span>

						<?php 	} elseif (isset($_GET["durum"]) && $_GET["durum"]=="exit") { ?>

							<span class="alert alert-success">Başarıyla çıkış yapıldı.</span>

						<?php } ?>


					</div>
				</form>

				<div class="login100-more" style="background-image: url('login_files/images/nkulogin.jpg');background-size: 100% 100%;">
				</div>
			</div>
		</div>
	</div>

	<?php

	if (isset($_GET["durum"]) && $_GET["durum"]=="exit") { ?>

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


<!--===============================================================================================-->
<script src="login_files/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="login_files/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="login_files/vendor/bootstrap/js/popper.js"></script>
<script src="login_files/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="login_files/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="login_files/vendor/daterangepicker/moment.min.js"></script>
<script src="login_files/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="login_files/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="login_files/js/main.js"></script>

<!-- fatura eklendikten sonra popup kapanıp sayfa reflesh yapma -->
<script type="text/javascript">

  function pencereac(){
    var win = window.open('uyekayitekle.php','popup','width=800,height=600');
    // return false;
    var timer = setInterval(function() {   
      if(win.closed) {  
        clearInterval(timer);  
        setTimeout(() => window.location.reload(), 2000);
        swal("Başarılı","Kayit Eklendi","success");       }  
      }, 1000); 
  }
</script>

</body>
</html>