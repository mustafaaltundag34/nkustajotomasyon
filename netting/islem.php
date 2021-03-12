<?php 
require_once "connection.php"; //bağlantımızı gerçekleştiriyoruz


//Profil Ayar Güncelleme
if(isset($_POST["profil-ayar-guncelle"])){
	$kullanici_id = $_POST["kullanici_id"];
	$query = $db->prepare("update kullanici set 
		kullanici_adsoyad=:kullanici_adsoyad
		where kullanici_id=:id");
	$update = $query->execute(array(
		"kullanici_adsoyad" => $_POST["kullanici_adsoyad"],
		"id" => $kullanici_id
	));
	if($update){
		$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		$log_query->execute(array(
			"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
			"email" => htmlspecialchars($_SESSION["kullanici_email"]),
			"aciklama" => "Profil Güncellendi",
			"ip" => $_SERVER["REMOTE_ADDR"]
		));
		header("Location:../production/profil-ayar?kullanici_id=$kullanici_id&durum=ok");
		exit;
	}
	else
	{
		header("Location:../production/profil-ayar?kullanici_id=$kullanici_id&durum=no");
		exit;
	}
}


//Profil Fotoğrafı Güncelleme
if(isset($_POST["profil-resim-duzenle"])){
	$kullanici_id = $_POST["kullanici_id"];
	//resim boyutu 1mb'dan büyükse izin verme
	if ($_FILES['kullanici_resim']['size']>1048576) {
		Header("Location:../production/profil-ayar?kullanici_id=$kullanici_id&durum=dosyabuyuk");
		exit;
	}
	//jpg yada png dışında resim ekletme
	$izinli_uzantilar=array('jpg','png');
	$ext=strtolower(substr($_FILES['kullanici_resim']["name"],strpos($_FILES['kullanici_resim']["name"],'.')+1));

	if (in_array($ext, $izinli_uzantilar) === false) {
		Header("Location:../production/profil-ayar?kullanici_id=$kullanici_id&durum=formhata");
		exit;
	}


	$uploads_dir='kullanici_profil';

	@$tmp_name=$_FILES['kullanici_resim']['tmp_name'];
	@$name=$_FILES["kullanici_resim"]["name"];

	//İmage Resize İşlemleri
	include('SimpleImage.php');
	$image = new SimpleImage();
	$image->load($tmp_name);
	$image->resize(128,128);
	$image->save($tmp_name);


	$benzersizsayi4=rand(20000,32000);
	$refimgyol=$uploads_dir."/".$benzersizsayi4.$name;
	@move_uploaded_file($tmp_name, "../production/dimg/$uploads_dir/$benzersizsayi4$name");

	$duzenle=$db->prepare("update kullanici set 
		kullanici_resim=:kullanici_resim
		where kullanici_id=:id
		");
	$update=$duzenle->execute(array(
		"kullanici_resim" => $refimgyol,
		"id" => $kullanici_id
	));

	if($update){
		$resimsilunlink=$_POST["eski_yol"];
		unlink("../production/$resimsilunlink"); //resmi klasörden silme
		$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		$log_query->execute(array(
			"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
			"email" => htmlspecialchars($_SESSION["kullanici_email"]),
			"aciklama" => "Profil fotoğrafı güncellendi",
			"ip" => $_SERVER["REMOTE_ADDR"]
		));
		header("Location:../production/profil-ayar?kullanici_id=$kullanici_id&durum=ok");
		exit;
	}
	else
	{
		header("Location:../production/profil-ayar?kullanici_id=$kullanici_id&durum=no");
		exit;
	}
}


//Profil Şifre Yenile
if(isset($_POST["profil-sifre-yenile"])){
	$kullanici_id = $_POST["kullanici_id"];

	$eski_sifre = md5($_POST["eski_sifre"]);

	//girilen eski şifremi önce kontrol edilmeli.
	$query = $db->prepare("select * from kullanici where kullanici_id=:id and kullanici_sifre=:sifre");
	$query->execute(array(
		"id" => $kullanici_id,
		"sifre" => $eski_sifre
	));
	
	$row = $query->rowCount();
	if ($row==1) {
		if ($_POST["yeni_sifre"]==$_POST["yeni_sifre1"]) {
			$query_password = $db->prepare("update kullanici set kullanici_sifre=:sifre where kullanici_id=:id");
			$update = $query_password->execute(array(
				"sifre" => md5($_POST["yeni_sifre"]),
				"id" => $kullanici_id
			));
			if ($update) {
				$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
				$log_query->execute(array(
					"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
					"email" => htmlspecialchars($_SESSION["kullanici_email"]),
					"aciklama" => "Profil şifre güncelledi",
					"ip" => $_SERVER["REMOTE_ADDR"]
				));
				header("Location:../production/sifre-yenile?kullanici_id=$kullanici_id&durum=ok");
				exit;
			}
			else
			{
				header("Location:../production/sifre-yenile?kullanici_id=$kullanici_id&durum=no");
				exit;
			}

		}
		else{
			header("Location:../production/sifre-yenile?kullanici_id=$kullanici_id&durum=yenisifreleruyusmadi");
			exit;
		}		 
	}
	else
	{
		header("Location:../production/sifre-yenile?kullanici_id=$kullanici_id&durum=sifrehatali");
		exit;
	}
}







?>