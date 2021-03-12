<?php
require_once "connection.php"; //bağlantımızı gerçekleştiriyoruz


//Giriş için kontrol ettiriyoruz.
//Sistem Yonetici Kullanici Adi ve Sifresi
if(isset($_POST["login-control"])){
	$query = $db->prepare("select * from kullanici where kullanicimail=:kullanicimail and (kullanicisifre=:kullanicisifre or kullanicisifre=:kullanicisifre1)  and kullaniciaktif=:kullaniciaktif");
	$query->execute(array(
		"kullanicimail" => htmlspecialchars(trim($_POST["kullanicimail"])),  //htmlspeacialchars --> zararlı karakterlerden arındırmak için
		"kullanicisifre" => htmlspecialchars(trim(md5($_POST["kullanicisifre"]))), //trim --> sağ ve soldan boşluk varsa siler
		"kullanicisifre1" => htmlspecialchars(trim(($_POST["kullanicisifre"]))),
		"kullaniciaktif" => 1

	));
	$row = $query->rowCount();
	$data = $query->fetch(PDO::FETCH_ASSOC);
	if($row==1){
		$_SESSION["kullanicimail"] = $_POST["kullanicimail"];
		$_SESSION["kullaniciadisoyadi"] = $data["kullaniciadisoyadi"];
		$_SESSION["kullanicituru"] = $data["kullanicituru"];
		$_SESSION["kullaniciid"] = $data["kullaniciid"];

		//// giris log yazma

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarılı Login Islemi"
				));

		////
		
	header("Location:../production/main?durum=ok");
		exit;
	}
	else{

		header("Location:../index?durum=hata");
		exit;
	}
}



//Şifremi unuttum kontrol mail gönderme.
if (isset($_POST["send-password"])) {
	//önce güvenlik kodu kontrol yapıyoruz
	require_once '../securimage/securimage.php';
	$securimage = new Securimage();
	if ($securimage->check($_POST['captcha_code']) == false) {
		header("Location:../sifremi-unuttum?durum=captchahata");
		exit;
	}

	//güvenlik kodu doğru girilirse aşağıdan devam edilir....
	$kullanicimail = htmlspecialchars(trim($_POST["kullanicimail"])); //şifresini öğrenilicek mail

	$query = $db->prepare("select * from kullanici where kullanicimail=:kullanicimail and kullaniciaktif=:kullaniciaktif");
	$query->execute(array(
		"kullanicimail" => $kullanicimail,
		"kullaniciaktif" => 1
	));

	$row = $query->rowCount(); 
	$data = $query->fetch(PDO::FETCH_ASSOC);
	//satır varsa mail doğru yazılmıştır...
	if($row==1){

		$uretilensifre=uniqid();//mailde bu gösterilicek
	 	$sifrekaydet=md5($uretilensifre); //veritabanında sifrelenmiş kaydedilicek

	 	$query_sifre = $db->prepare("update kullanici set kullanicisifre=:kullanicisifre where kullanicimail=:kullanicimail");
	 	$query_sifre->execute(array(
	 		"kullanicisifre" => $sifrekaydet,
	 		"kullanicimail" => $kullanicimail
	 	));

		// mail adresi veritabanında kayıtlı ise mail göndersin
		include("../phpmail/class.phpmailer.php"); //Mail gönderme bağlantıları.
		$adsoyad = "NKU Staj Sistemi";	

		$mail = new PHPMailer();
		$mail->IsSMTP();

		$mail->SMTPAuth = true;
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->Username = 'crmwebotomasyon@gmail.com'; //gönderen mail
		$mail->Password = 'Crm2020202000';  //gönderen şifre

		$mail->SetFrom($mail->Username, $adsoyad);

		$mail->AddAddress($kullanicimail, $adsoyad);
		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'Şifre Hatırlatma NKU Staj Sistemi';
		$content = '
		<b>Şifre Hatırlatma Formu</b><br>
		<table align="left" class="tg" style="undefined;table-layout: fixed; width: 535px">

		<tr>
		<td class="tg-031e">Mailiniz</td>
		<td class="tg-031e">:</td>
		<td class="tg-031e">'.$kullanicimail.'</td>
		</tr>
		<tr>
		<td class="tg-031e">Şifreniz</td>
		<td class="tg-031e">:</td>
		<td class="tg-031e">'.$uretilensifre.'</td>
		</tr>

		</table>';
		
		$mail->MsgHTML($content);
		if($mail->Send()) {

			header("Location:../sifremi-unuttum?durum=ok");
			exit;

		} 
		else {

			header("Location:../sifremi-unuttum?durum=mailhata");
			exit;

		}

	}
	else{
		header("Location:../sifremi-unuttum?durum=hata");
		exit;
	}
}

?>