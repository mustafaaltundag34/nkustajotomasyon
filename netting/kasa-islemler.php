<?php
require_once "connection.php"; //bağlantımızı gerçekleştiriyoruz
// *******************GÜNCELLEME******************************************************************************

 	//kasa Güncelleme
if (isset($_POST["kasaguncelle"])) {

	$kasatanim_id=$_POST["kasatanim_id"];

	$query=$db->prepare("update kasatanim set 
		kasatanim_aciklama=:kasatanim_aciklama,
		kasatanim_aktiflik=:kasatanim_aktiflik 
		where kasatanim_id=:kasatanim_id");
	$update=$query->execute(array(
		"kasatanim_aciklama" => $_POST["kasatanim_aciklama"],
		"kasatanim_aktiflik" => $_POST["kasatanim_aktiflik"],
		"kasatanim_id" => $kasatanim_id
	));
	if($update){
		$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		$log_query->execute(array(
			"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
			"email" => htmlspecialchars($_SESSION["kullanici_email"]),
			"aciklama" => "Kasa Güncelledi",
			"ip" => $_SERVER["REMOTE_ADDR"]
		));
		header("Location:../production/kasa-duzenle?kasatanim_id=$kasatanim_id&durum=ok");
		exit;
	}
	else
	{
		header("Location:../production/kasa-duzenle?kasatanim_id=$kasatanim_id&durum=no");
		exit;
	}	

}





	//kasa aktifi pasif yapma
if (isset($_GET["kasatanim_aktif"]) && $_GET["kasatanim_aktif"]=="ok") {
	$active=$db->prepare("update kasatanim set kasatanim_aktiflik=:aktiflik where kasatanim_id=:kasatanim_id
		");
	$control=$active->execute(array(
		"aktiflik" => 0,
		"kasatanim_id" => $_GET["kasatanim_id"],
	));

	if($control){
		$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		$log_query->execute(array(
			"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
			"email" => htmlspecialchars($_SESSION["kullanici_email"]),
			"aciklama" => "Kasa pasif yapıldı",
			"ip" => $_SERVER["REMOTE_ADDR"]
		));
		header("Location:../production/kasa-tanim?pasiflik=ok");
		exit;
	}
	else
	{
		header("Location:../production/kasa-tanim?pasiflik=no");
		exit;
	}
}

	//kasa pasifi aktif yapma
if (isset($_GET["kasatanim_pasif"]) && $_GET["kasatanim_pasif"]=="ok") {
	$passive=$db->prepare("update kasatanim set kasatanim_aktiflik=:aktiflik where kasatanim_id=:kasatanim_id
		");
	$control=$passive->execute(array(
		"aktiflik" => 1,
		"kasatanim_id" => $_GET["kasatanim_id"],
	));

	if($control){
		$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		$log_query->execute(array(
			"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
			"email" => htmlspecialchars($_SESSION["kullanici_email"]),
			"aciklama" => "Kasa aktif yapıldı",
			"ip" => $_SERVER["REMOTE_ADDR"]
		));
		header("Location:../production/kasa-tanim?aktiflik=ok");
		exit;
	}
	else
	{
		header("Location:../production/kasa-tanim?aktiflik=no");
		exit;
	}
}






if (isset($_POST["kasaislemler-guncelle"])) {
	$query=$db->prepare("update kasaislem set
		TUTAR=:TUTAR,
		kasaislem_aciklama=:kasaislem_aciklama,ISLEMTARIHI=:ISLEMTARIHI where kasaislem_id=:kasaislem_id
		");
	$update = $query->execute(array(
		"TUTAR" => $_POST["TUTAR"],
		"kasaislem_aciklama" => $_POST["kasaislem_aciklama"],
		"ISLEMTARIHI" => $_POST["ISLEMTARIHI"],
		"kasaislem_id" => $_POST["id"]

	));
	if ($update) {
		$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		$log_query->execute(array(
			"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
			"email" => htmlspecialchars($_SESSION["kullanici_email"]),
			"aciklama" => "Kasa işlem güncelledi",
			"ip" => $_SERVER["REMOTE_ADDR"]
		));
		echo "<script type=\"text/javascript\" charset=\"utf-8\">window.self.close()</script>"; //sayfayı kapattırıyorum.
		exit;
	}
	else{
		header("Location:../production/kasa-islem?durum=$durum&durum=no");
		exit;
	}
}









// *******************EKLEME******************************************************************************



 	//kasa Ekleme
if (isset($_POST["kasaekle"])) {

	 //kasa ad kayıtlımı değilmi bakalıyoruz.
	$query_adkontrol = $db->prepare("select * from kasatanim where KASAADI=:KASAADI");
	$query_adkontrol->execute(array(
		"KASAADI" => $_POST["KASAADI"]
	));
	$row_ad_kontrol = $query_adkontrol->rowCount();
	if ($row_ad_kontrol==1) {
		header("Location:../production/kasa-ekle?durum=adhata");
		exit;
	}
	else
	{	

		$query=$db->prepare("insert into kasatanim set 
			KASAADI=:KASAADI,
			kasatanim_aciklama=:kasatanim_aciklama,
			kasatanim_aktiflik=:kasatanim_aktiflik");
		$update=$query->execute(array(
			"KASAADI" => $_POST["KASAADI"],
			"kasatanim_aciklama" => $_POST["kasatanim_aciklama"],
			"kasatanim_aktiflik" => $_POST["kasatanim_aktiflik"]
		));
		if($update){
			$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
			$log_query->execute(array(
				"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
				"email" => htmlspecialchars($_SESSION["kullanici_email"]),
				"aciklama" => "Kasa eklendi",
				"ip" => $_SERVER["REMOTE_ADDR"]
			));
			header("Location:../production/kasa-ekle?durum=ok");
			exit;
		}
		else
		{
			header("Location:../production/kasa-duzenle?durum=no");
			exit;
		}	

	}


}




 	//kasa İşlem Ekleme
if (isset($_POST["kasaislemler"])) {
	$durum=$_POST["durum"];
	if ($durum=="tahsilat") {
		$ISLEMTURU="TAHSILAT";
	}
	elseif($durum=="odeme")
	{
		$ISLEMTURU="ODEME";
	}
	$query=$db->prepare("insert into kasaislem set
		KASAADI=:KASAADI,
		CARIADISOYADI=:CARIADISOYADI,
		ISLEMTURU=:ISLEMTURU,
		TUTAR=:TUTAR,
		kasaislem_aciklama=:kasaislem_aciklama
		");
	$insert = $query->execute(array(
		"KASAADI" => $_POST["KASAADI"],
		"CARIADISOYADI" => $_POST["CARIADISOYADI"],
		"ISLEMTURU" => $ISLEMTURU,
		"TUTAR" => $_POST["TUTAR"],
		"kasaislem_aciklama" => $_POST["kasaislem_aciklama"]
	));
	if ($insert) {
		$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		$log_query->execute(array(
			"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
			"email" => htmlspecialchars($_SESSION["kullanici_email"]),
			"aciklama" => "Kasa işlem eklendi",
			"ip" => $_SERVER["REMOTE_ADDR"]
		));
		echo "<script type=\"text/javascript\" charset=\"utf-8\">window.self.close()</script>"; //sayfayı kapattırıyorum.
		exit;
	}
	else{
		header("Location:../production/kasa-islem?durum=$durum&durum=no");
		exit;
	}

}










// *******************SİLME******************************************************************************

	//Kasa tanım silme
if ($_GET["kasatanim_sil"]=="ok") {
	$delete=$db->prepare("update kasatanim set
		kasatanim_sil=:kasatanim_sil
	 where kasatanim_id=:id
		");
	$control=$delete->execute(array(
		"kasatanim_sil" => 1,
		"id" => $_GET["kasatanim_id"],
	));

	if($control){
		header("Location:../production/kasa-tanim?sil=ok");
		exit;
	}
	else
	{
		header("Location:../production/kasa-tanim?sil=no");
		exit;
	}
	// $delete=$db->prepare("delete from kasatanim where kasatanim_id=:id
	// 	");
	// $control=$delete->execute(array(
	// 	"id" => $_GET["kasatanim_id"],
	// ));

	// if($control){
	// 	header("Location:../production/kasa-tanim?sil=ok");
	// 	exit;
	// }
	// else
	// {
	// 	header("Location:../production/kasa-tanim?sil=no");
	// 	exit;
	// }
}



	//Kasa işlem silme
if ($_GET["kasa_sil"]=="ok") {
	$delete=$db->prepare("update kasaislem 
		set kasaislem_sil=:kasaislem_sil
		where kasaislem_id=:id
		");
	$control=$delete->execute(array(
		"kasaislem_sil" => 1,
		"id" => $_GET["kasa_id"],
	));

	if($control){
		header("Location:../production/kasa?sil=ok");
		exit;
	}
	else
	{
		header("Location:../production/kasa?sil=no");
		exit;
	}
	// $delete=$db->prepare("delete from kasaislem where kasaislem_id=:id
	// 	");
	// $control=$delete->execute(array(
	// 	"id" => $_GET["kasa_id"],
	// ));

	// if($control){
	// 	header("Location:../production/kasa?sil=ok");
	// 	exit;
	// }
	// else
	// {
	// 	header("Location:../production/kasa?sil=no");
	// 	exit;
	// }
}
?>