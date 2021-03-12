<?php
require_once "connection.php"; //bağlantımızı gerçekleştiriyoruz
error_reporting(E_ALL);
ini_set("display_errors", 1);


// *******************ANA INDEKSTEN UYE EKLEME******************************************************************************


//Kullanıcı Ekleme
if(isset($_POST["kullanicikaydetindex"])){

	//ilk olarak mail adresi kayıtlımı ona bakıyoruz.
	$query = $db->prepare("select * from kullanici where kullanicimail=:kullanicimail");
	$query->execute(array(
		"kullanicimail" => htmlspecialchars(trim($_POST["kullanicimail"]))
	));
	$row = $query->rowCount();



	if($row==1){

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarısız Kullanici Kayit Islemi"
				));

		////
		header("Location:../uyekayitekle.php?durum=kayitli");
		exit;
	}
	else{
	 	//mail adresi kayıtlı degilse kayıt işlemlerini gerçekleştiriyoruz ve sifreyi maile gönderiyoruz

	 	$uretilensifre=uniqid();//mailde bu gösterilicek
	 	$sifrekaydet=md5($uretilensifre); //veritabanında sifrelenmiş kaydedilicek

	 	//maile mesaj göndertme kodlarını yaz....
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

		$mail->AddAddress(htmlspecialchars(trim($_POST["kullanicimail"])), $adsoyad);
		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'Yeni Kayıt NKU Staj Sistemi';
		$content = '
		<b>KAYIT BİLGİLERİ</b><br>
		<table align="left" class="tg" style="undefined;table-layout: fixed; width: 535px">

		<tr>
		<td class="tg-031e">Mailiniz</td>
		<td class="tg-031e">:</td>
		<td class="tg-031e">'.htmlspecialchars(trim($_POST["kullanicimail"])).'</td>
		</tr>
		<tr>
		<td class="tg-031e">Şifreniz</td>
		<td class="tg-031e">:</td>
		<td class="tg-031e">'.$uretilensifre.'</td>
		</tr>
		<tr>
		<td class="tg-031e">Sisteme giriş yapabilirsiniz...</td>
		<td class="tg-031e"></td>
		<td class="tg-031e"></td>
		</tr>
		</table>';
		
		$mail->MsgHTML($content);
		if($mail->Send()) {

			$user_query = $db->prepare("insert into kullanici set
				kullanicimail=:kullanicimail,
				kullanicisifre=:kullanicisifre,
				kullaniciadisoyadi=:kullaniciadisoyadi,
				kullanicino=:kullanicino,
				kullanicituru=:kullanicituru,
				kullaniciaktif=:kullaniciaktif
								");
			$insert = $user_query->execute(array(
				"kullanicimail" => htmlspecialchars(trim($_POST["kullanicimail"])),
				"kullanicisifre" => $sifrekaydet,
				"kullaniciadisoyadi" => htmlspecialchars(trim($_POST["kullaniciadisoyadi"])),
				"kullanicino" => htmlspecialchars(trim($_POST["kullanicino"])),
				"kullanicituru" => "Ogrenci",
				"kullaniciaktif" => 1
			));
				
				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarılı Kullanici Ekleme Islemi"
				));

		////
				header("Location:../uyekayitekle.php?durum=ok");
				echo "<script type=\"text/javascript\" charset=\"utf-8\">window.self.close()</script>"; //sayfayı kapattırıyorum.
				exit;
			}

		else {
			header("Location:../uyekayitekle.php?durum=mailhata");
			exit;
				
}
}}

	// *******************ANA INDEKSTEN UYE EKLEME******************************************************************************

	// *******************MAIN SAYFASINDAN EKLEME******************************************************************************



//Kullanıcı Ekleme
if(isset($_POST["kullaniciekle"])){
	//ilk olarak mail adresi kayıtlımı ona bakıyoruz.
	$query = $db->prepare("select * from kullanici where kullanicimail=:kullanicimail");
	$query->execute(array(
		"kullanicimail" => htmlspecialchars(trim($_POST["kullanicimail"]))
	));
	$row = $query->rowCount();



	if($row==1){

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarısız Kullanıcı Ekleme Islemi"
				));

		////
		header("Location:../production/kullanici-ekle?durum=kayitli");
		exit;
	}
	else{
	 	//mail adresi kayıtlı degilse kayıt işlemlerini gerçekleştiriyoruz ve sifreyi maile gönderiyoruz

	 	$uretilensifre=uniqid();//mailde bu gösterilicek
	 	$sifrekaydet=md5($uretilensifre); //veritabanında sifrelenmiş kaydedilicek

	 	//maile mesaj göndertme kodlarını yaz....
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

		$mail->AddAddress(htmlspecialchars(trim($_POST["kullanicimail"])), $adsoyad);
		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'Yeni Kayıt NKU Staj Sistemi';
		$content = '
		<b>KAYIT BİLGİLERİ</b><br>
		<table align="left" class="tg" style="undefined;table-layout: fixed; width: 535px">

		<tr>
		<td class="tg-031e">Mailiniz</td>
		<td class="tg-031e">:</td>
		<td class="tg-031e">'.htmlspecialchars(trim($_POST["kullanicimail"])).'</td>
		</tr>
		<tr>
		<td class="tg-031e">Şifreniz</td>
		<td class="tg-031e">:</td>
		<td class="tg-031e">'.$uretilensifre.'</td>
		</tr>
		<tr>
		<td class="tg-031e">Sisteme giriş yapabilirsiniz...</td>
		<td class="tg-031e"></td>
		<td class="tg-031e"></td>
		</tr>
		</table>';
		
		$mail->MsgHTML($content);
		if($mail->Send()) {

			$user_query = $db->prepare("insert into kullanici set
				kullanicimail=:kullanicimail,
				kullanicisifre=:kullanicisifre,
				kullaniciadisoyadi=:kullaniciadisoyadi,
				kullanicino=:kullanicino,
				kullaniciuniversite=:kullaniciuniversite,
				kullanicibolum=:kullanicibolum,
				kullanicisehir=:kullanicisehir,
				kullanicitel=:kullanicitel,
				kullanicituru=:kullanicituru,
				kullanicilog=:kullanicilog,
				kullaniciaktif=:kullaniciaktif

				");
			$insert = $user_query->execute(array(
				"kullanicimail" => htmlspecialchars(trim($_POST["kullanicimail"])),
				"kullanicisifre" => $sifrekaydet,
				"kullaniciadisoyadi" => htmlspecialchars(trim($_POST["kullaniciadisoyadi"])),
				"kullanicino" => htmlspecialchars(trim($_POST["kullanicino"])),
				"kullaniciuniversite" => htmlspecialchars(trim($_POST["kullaniciuniversite"])),
				"kullanicibolum" => htmlspecialchars(trim($_POST["kullanicibolum"])),
				"kullanicisehir" => htmlspecialchars(trim($_POST["kullanicisehir"])),
				"kullanicitel" => htmlspecialchars(trim($_POST["kullanicitel"])),
				"kullanicituru" => htmlspecialchars(trim($_POST["kullanicituru"])),
				"kullanicilog" => htmlspecialchars(trim($_POST["kullanicilog"])),
				"kullaniciaktif" => htmlspecialchars(trim($_POST["kullaniciaktif"]))

			));
			if ($insert) {
	

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarılı Kullanici Ekleme Islemi"
				));

		////
					header("Location:../production/kullanici-ekle?durum=ok");
					echo "<script type=\"text/javascript\" charset=\"utf-8\">window.self.close()</script>"; //sayfayı kapattırıyorum.
				exit;
			}
			else{
				header("Location:../production/kullanici-ekle?durum=no");
				exit;
			}

		} 
		else {
			header("Location:../production/kullanici-ekle?durum=mailhata");
			exit;

		}
	}
}
	// *******************MAIN SAYFASINDAN EKLEME******************************************************************************




// *******************GÜNCELLEME******************************************************************************


//Kullanıcı Güncelleme
if(isset($_POST["kullaniciguncelle"])){

	$kullaniciid = $_POST["kullaniciid"];
	//$kullaniciid = $_SESSION["kullaniciid"];
/////resim ekleme////
	if (strlen($_FILES['kullanicifoto']["name"])>0) {
	//resim boyutu 1mb'dan büyükse izin verme
		if ($_FILES['kullanicifoto']['size']>1048576) {
			Header("Location:../production/kullanici-duzenle?kullaniciid=$kullaniciid&durum=dosyabuyuk");
			exit;
		}
			//jpg yada png dışında resim ekletme
		$izinli_uzantilar=array('jpg','png');
		$ext=strtolower(substr($_FILES['kullanicifoto']["name"],strpos($_FILES['kullanicifoto']["name"],'.')+1));

		if (in_array($ext, $izinli_uzantilar) === false) {
			Header("Location:../production/kullanici-duzenle?kullaniciid=$kullaniciid&durum=formhata");
			exit;
		}

		$uploads_dir='kullanicifoto';

		@$tmp_name=$_FILES['kullanicifoto']['tmp_name'];
		@$name=$_FILES["kullanicifoto"]["name"];

			//İmage Resize İşlemleri
		include('SimpleImage.php');
		$image = new SimpleImage();
		$image->load($tmp_name);
		$image->resize(128,128);
		$image->save($tmp_name);


		$benzersizsayi4=rand(20000,32000);
		$refimgyol=$uploads_dir."/".$benzersizsayi4.$name;
		@move_uploaded_file($tmp_name, "../production/dimg/$uploads_dir/$benzersizsayi4$name");


/////resim ekleme////

	$user_query = $db->prepare("update kullanici set
		kullaniciadisoyadi=:kullaniciadisoyadi,
		kullanicituru=:kullanicituru,
		kullanicino=:kullanicino,
		kullanicitel=:kullanicitel,
		kullaniciaktif=:kullaniciaktif,		
		kullanicilog=:kullanicilog,
		kullaniciuniversite=:kullaniciuniversite,
		kullanicifoto=:kullanicifoto,
		kullanicibolum=:kullanicibolum
		where kullaniciid=:kullaniciid
		");
	$update = $user_query->execute(array(
		"kullaniciadisoyadi" => $_POST["kullaniciadisoyadi"],
		"kullanicituru" => $_POST["kullanicituru"],
		"kullanicino" => $_POST["kullanicino"],
		"kullanicitel" => $_POST["kullanicitel"],
		"kullaniciaktif" => $_POST["kullaniciaktif"],
		"kullanicilog" => $_POST["kullanicilog"],
		"kullaniciuniversite" => $_POST["kullaniciuniversite"],
		"kullanicibolum" => $_POST["kullanicibolum"],
		"kullanicifoto" =>  $refimgyol,
		"kullaniciid" => $kullaniciid
	));

if($update){

				//echo ("basarili 1");
				$resimsilunlink=$_POST["eski_yol"];
				if ($resimsilunlink!="dimg/user.png") {
					unlink("../production/$resimsilunlink"); //resmi klasörden silme
				}

		echo "<script type=\"text/javascript\" charset=\"utf-8\">window.self.close()</script>"; //sayfayı kapattırıyorum.
		exit;
	}
	else{
					//echo ("basarisiz 1");
		header("Location:../production/kullanici-duzenle?kullaniciid=$kullaniciid&durum=no");
		exit;
	}

} else
		{

			$query = $db->prepare("update kullanici set
		kullaniciadisoyadi=:kullaniciadisoyadi,
		kullanicituru=:kullanicituru,
		kullanicino=:kullanicino,
		kullanicitel=:kullanicitel,
		kullaniciaktif=:kullaniciaktif,		
		kullanicilog=:kullanicilog,
		kullaniciuniversite=:kullaniciuniversite,
		kullanicifoto=:kullanicifoto,
		kullanicibolum=:kullanicibolum
		where kullaniciid=:kullaniciid
		");
			$update = $query->execute(array(
		"kullaniciadisoyadi" => $_POST["kullaniciadisoyadi"],
		"kullanicituru" => $_POST["kullanicituru"],
		"kullanicino" => $_POST["kullanicino"],
		"kullanicitel" => $_POST["kullanicitel"],
		"kullaniciaktif" => $_POST["kullaniciaktif"],
		"kullanicilog" => $_POST["kullanicilog"],
		"kullaniciuniversite" => $_POST["kullaniciuniversite"],
		"kullanicibolum" => $_POST["kullanicibolum"],
		"kullanicifoto" =>  substr($_POST["eski_yol"],5),
		"kullaniciid" => $kullaniciid
	));

			if ($update) {
			//echo ("basarili 2");

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarılı Kullanici Guncelleme Islemi"
				));

		////
			echo "<script type=\"text/javascript\" charset=\"utf-8\">window.self.close()</script>"; //sayfayı kapattırıyorum.
				exit;
			}
			else
			{
			//	echo ("basarisiz 2");
			header("Location:../production/kullanici-duzenle?kullaniciid=$kullaniciid&durum=no");
			exit;
			}
		}
}
// *******************GÜNCELLEME******************************************************************************


// *******************SİLME******************************************************************************



	//kullanıcı silme
if ($_GET["kullaniciaktif"]=="ok") {
	$delete=$db->prepare("update kullanici set 
		kullaniciaktif=:kullaniciaktif
		where kullaniciid=:kullaniciid
		");
	$control=$delete->execute(array(
		"kullaniciaktif" => 0,
		"kullaniciid" => $_GET["kullaniciid"],
	));

	if($control){

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarılı Kullanici Silme Islemi"
				));

		////
		header("Location:../production/kullanicihavuzu.php?sil=ok");
		exit;
	}
	else
	{
		header("Location:../production/kullanicihavuzu.php?sil=no");
		exit;
	}

}

// *******************SİLME******************************************************************************




?>