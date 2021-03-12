<?php
require_once "connection.php"; //bağlantımızı gerçekleştiriyoruz



// *******************GÜNCELLEME******************************************************************************
 	//Cari güncelleme.
if(isset($_POST["cariguncelle"])){
	$caritanim_id=$_POST["caritanim_id"];
	$query=$db->prepare("update caritanim set 
		caritanim_adres=:caritanim_adres,
		caritanim_telefon=:caritanim_telefon,
		caritanim_eposta=:caritanim_eposta,
		caritanim_aciklama=:caritanim_aciklama,
		caritanim_aktiflik=:caritanim_aktiflik
		where caritanim_id=:id");
	$update=$query->execute(array(
		"caritanim_adres" => $_POST["caritanim_adres"],
		"caritanim_telefon" => $_POST["caritanim_telefon"],
		"caritanim_eposta" => $_POST["caritanim_eposta"],
		"caritanim_aciklama" => $_POST["caritanim_aciklama"],
		"caritanim_aktiflik" => $_POST["caritanim_aktiflik"],
		"id" => $caritanim_id
	));
	if($update){
		$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		$log_query->execute(array(
			"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
			"email" => htmlspecialchars($_SESSION["kullanici_email"]),
			"aciklama" => "Cari güncellendi",
			"ip" => $_SERVER["REMOTE_ADDR"]
		));
		header("Location:../production/cari-duzenle?caritanim_id=$caritanim_id&durum=ok");
		exit;
	}
	else
	{
		header("Location:../production/cari-duzenle?caritanim_id=$caritanim_id&durum=no");
		exit;
	}
}


	//Cari aktifi pasif yapma
if (isset($_GET["caritanim_aktif"]) && $_GET["caritanim_aktif"]=="ok") {
	$active=$db->prepare("update caritanim set caritanim_aktiflik=:aktiflik where caritanim_id=:caritanim_id
		");
	$control=$active->execute(array(
		"aktiflik" => 0,
		"caritanim_id" => $_GET["caritanim_id"],
	));

	if($control){
		$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		$log_query->execute(array(
			"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
			"email" => htmlspecialchars($_SESSION["kullanici_email"]),
			"aciklama" => "Cari pasif yapıldı",
			"ip" => $_SERVER["REMOTE_ADDR"]
		));
		header("Location:../production/cari-tanim?pasiflik=ok");
		exit;
	}
	else
	{
		header("Location:../production/cari-tanim?pasiflik=no");
		exit;
	}
}

	//Cari pasifi aktif yapma
if ($_GET["caritanim_pasif"]=="ok") {
	$passive=$db->prepare("update caritanim set caritanim_aktiflik=:aktiflik where caritanim_id=:caritanim_id
		");
	$control=$passive->execute(array(
		"aktiflik" => 1,
		"caritanim_id" => $_GET["caritanim_id"],
	));

	if($control){
		$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		$log_query->execute(array(
			"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
			"email" => htmlspecialchars($_SESSION["kullanici_email"]),
			"aciklama" => "Cari aktif yapıldı",
			"ip" => $_SERVER["REMOTE_ADDR"]
		));
		header("Location:../production/cari-tanim?aktiflik=ok");
		exit;
	}
	else
	{
		header("Location:../production/cari-tanim?aktiflik=no");
		exit;
	}
}
















// *******************EKLEME******************************************************************************

//Cari ekleme.
if(isset($_POST["cariekle"])){
	//cari adsoyad önceden ekliyse hata verdirt.
	$query_adsoyad = $db->prepare("select * from caritanim where CARIADISOYADI=:CARIADISOYADI");
	$query_adsoyad->execute(array(
		"CARIADISOYADI" => $_POST["CARIADISOYADI"]
	));
	$row_adsoyad = $query_adsoyad->rowCount();
	if ($row_adsoyad==1) {
		header("Location:../production/cari-ekle?durum=cariadsoyadhata");
		exit;
	}
	else
	{	
		$query=$db->prepare("insert into caritanim set 
			CARIADISOYADI=:CARIADISOYADI,
			caritanim_adres=:caritanim_adres,
			caritanim_telefon=:caritanim_telefon,
			caritanim_eposta=:caritanim_eposta,
			caritanim_aciklama=:caritanim_aciklama,
			caritanim_aktiflik=:caritanim_aktiflik");
		$update=$query->execute(array(
			"CARIADISOYADI" => $_POST["CARIADISOYADI"],
			"caritanim_adres" => $_POST["caritanim_adres"],
			"caritanim_telefon" => $_POST["caritanim_telefon"],
			"caritanim_eposta" => $_POST["caritanim_eposta"],
			"caritanim_aciklama" => $_POST["caritanim_aciklama"],
			"caritanim_aktiflik" => $_POST["caritanim_aktiflik"]
		));
		if($update){
			$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
			$log_query->execute(array(
				"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
				"email" => htmlspecialchars($_SESSION["kullanici_email"]),
				"aciklama" => "Cari Eklendi",
				"ip" => $_SERVER["REMOTE_ADDR"]
			));
			header("Location:../production/cari-ekle?durum=ok");
			exit;
		}
		else
		{
			header("Location:../production/cari-duzenle?durum=no");
			exit;
		}
	}
}











// *******************SİLME******************************************************************************

	 //Cari silme
if ($_GET["caritanim_sil"]=="ok") {
	$delete=$db->prepare("update caritanim set
		caritanim_sil=:caritanim_sil
	 where caritanim_id=:id
		");
	$control=$delete->execute(array(
		"caritanim_sil" => 1,
		"id" => $_GET["caritanim_id"],
	));

	if($control){
		$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		$log_query->execute(array(
			"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
			"email" => htmlspecialchars($_SESSION["kullanici_email"]),
			"aciklama" => "Cari Silindi",
			"ip" => $_SERVER["REMOTE_ADDR"]
		));
		header("Location:../production/cari-tanim?sil=ok");
		exit;
	}
	else
	{
		header("Location:../production/cari-tanim?sil=no");
		exit;
	}
	// $delete=$db->prepare("delete from caritanim where caritanim_id=:id
	// 	");
	// $control=$delete->execute(array(
	// 	"id" => $_GET["caritanim_id"],
	// ));

	// if($control){
	// 	$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
	// 	$log_query->execute(array(
	// 		"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
	// 		"email" => htmlspecialchars($_SESSION["kullanici_email"]),
	// 		"aciklama" => "Cari Silindi",
	// 		"ip" => $_SERVER["REMOTE_ADDR"]
	// 	));
	// 	header("Location:../production/cari-tanim?sil=ok");
	// 	exit;
	// }
	// else
	// {
	// 	header("Location:../production/cari-tanim?sil=no");
	// 	exit;
	// }
}