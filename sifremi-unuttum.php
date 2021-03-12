<?php
require_once "netting/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Şifremi Unuttum</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->	
	<!-- <link rel="icon" type="image/png" href="login_files/images/icons/favicon.ico"/> -->
	<link rel="icon" type="image/png" href="login_files/images/icons/1548182.png"/>
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
</head>
<body style="background-color: #666666;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="netting/islem-giris.php" method="POST">
					<span class="login100-form-title p-b-20">
						NKU Staj Sistemi <br>
						Şifremi Unuttum Formu
					</span>
					
					
					<div class="wrap-input100 validate-input" data-validate = "Email adresi girilmeli: ex@abc.xyz">
						<input class="input100" type="text" name="kullanicimail">
						<span class="focus-input100"></span>
						<span class="label-input100">Email</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-10">
						<div class="contact100-form-checkbox">
							 <label class="control-label" for="first-name">Güvenlik Kodu *</label>
                             <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
                             <a class="btn btn-danger" href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Değiştir ]</a>
						</div>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Güvenlik kodunu giriniz.">
						<input class="input100" type="text" name="captcha_code" >
						<span class="focus-input100"></span>
						<span class="label-input100">Güvenlik Kodu</span>
					</div>
 					<div class="flex-sb-m w-full p-t-3 p-b-10">
						<div class="contact100-form-checkbox">
							<!-- <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Beni hatırla
							</label> -->
						</div>

						<div>
							<a href="index" class="txt1">
								Geri Dön
							</a>
						</div>
					</div>
 
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn" name="send-password">
							Şifremi Gönder
						</button>
					</div>
					 <div class="mt-4">
					 	<?php 	if (isset($_GET["durum"]) && $_GET["durum"]=="hata") { ?>
					 	 	
					 	 	<span class="alert alert-danger">Mail adresi kayıtlı değil.</span>					 			
					 	
					 	<?php 	}  elseif (isset($_GET["durum"]) && $_GET["durum"]=="ok") { ?>

					 	 	<span class="alert alert-success">Mail adresinizi kontrol ediniz. Şifreniz gönderilmiştir.</span>					 			

					 	<?php  	}  elseif (isset($_GET["durum"]) && $_GET["durum"]=="captchahata") { ?>

					 		<span class="alert alert-warning">Güvenlik kodu hatalı girildi.</span>

					 	<?php 	} elseif (isset($_GET["durum"]) && $_GET["durum"]=="mailhata") { ?>

					 		<span class="alert alert-danger">Şifre göndermede hata oluştu(Sistemsel Hata).</span>

					 	<?php 	} ?>
					 </div>
				</form>

				<div class="login100-more" style="background-image: url('login_files/images/sifremiunuttum2.jpg');">
				</div>
			</div>
		</div>
	</div>
	
	

	
	
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

</body>
</html>