<?php
require_once "connection.php"; //bağlantımızı gerçekleştiriyoruz
//seçilen stoktaki ürüne tabloya ekleme

if (isset($_POST["sepetEkle"])) {
	
	$id=$_POST['id'];
	$durum=$_POST['durum'];

	if (isset($_SESSION['cart'][$id])) {
		$_SESSION['cart'][$id]['quantity'] = $_SESSION['cart'][$id]['quantity']+$_POST["adet"];
		header("Location:../production/fatura-islem?durum=$durum");
		exit;
	}
	else
	{
		$query=$db->prepare("select * from stoktanim where stoktanim_id=:stoktanim_id");
		$query->execute(array(
			"stoktanim_id" => $id
		));
		$row=$query->fetch(PDO::FETCH_ASSOC);

		$_SESSION['cart'][$row['stoktanim_id']]=array(
			"quantity" => $_POST["adet"],
			"price" => $row["stoktanim_fiyat"]
		);

		header("Location:../production/fatura-islem?durum=$durum");
		exit;
	}

}

//seçilen tablodaki ürünü tablodan silme
if (isset($_GET["sepetSil"])) {
	$id=$_GET['id'];
	$durum=$_GET['durum'];
	unset($_SESSION["cart"][$id]);
	header("Location:../production/fatura-islem?durum=$durum");
	exit;

}

//fatura bilgilerinin kayıt olması
if (isset($_POST["faturakaydet"])) {
	if (!empty($_SESSION["cart"])) {

		$durum=$_POST["durum"];
		if ($durum=="satisfatura") {
			$CARIISLEMTURU="SATISFATURASI";
			$STOKISLEMTURU="STOKCIKIS";
		}
		elseif($durum=="alisfatura")
		{
			$CARIISLEMTURU="ALISFATURASI";
			$STOKISLEMTURU="STOKGIRIS";
		}


		$query=$db->prepare("insert into faturatanim set
			faturatanim_belgeno=:faturatanim_belgeno,
			CARIISLEMTURU=:CARIISLEMTURU,
			STOKISLEMTURU=:STOKISLEMTURU,
			CARIADISOYADI=:CARIADISOYADI,
			ISLEMTARIHI=:ISLEMTARIHI,
			faturatanim_adres=:faturatanim_adres,
			TUTAR=:TUTAR,
			faturatanim_aciklama=:faturatanim_aciklama
			");
		$insert = $query->execute(array(
			"faturatanim_belgeno" => $_POST["faturatanim_belgeno"],
			"CARIISLEMTURU" => $CARIISLEMTURU,
			"STOKISLEMTURU" => $STOKISLEMTURU,
			"CARIADISOYADI" => $_POST["CARIADISOYADI"],
			"ISLEMTARIHI" => $_POST["ISLEMTARIHI"],
			"faturatanim_adres" => $_POST["faturatanim_adres"],
			"TUTAR" => $_POST["TUTAR"],
			"faturatanim_aciklama" => $_POST["faturatanim_aciklama"]
		));
		if ($insert) {
			$son_id=$db->lastInsertId(); //son eklenen id'yi alıyoruz
			$faturatanimhareket=$db->prepare("insert into faturatanimhareket set
				faturatanim_id=:faturatanim_id,
				STOKISLEMTURU=:STOKISLEMTURU,
				ISLEMTARIHI=:ISLEMTARIHI,
				STOKTANIMBARKODU=:STOKTANIMBARKODU,
				fthareket_stokadi=:fthareket_stokadi,
				fthareket_birim=:fthareket_birim,
				fthareket_fiyat=:fthareket_fiyat,
				fthareket_aciklama=:fthareket_aciklama,
				ADET=:ADET,
				fthareket_tutar=:fthareket_tutar
				");

			$sql = "select * from stoktanim where stoktanim_id IN (";
			foreach ($_SESSION["cart"] as $id => $value) {
				$sql .=$id.",";
			}
			$sql = substr($sql,0,-1).")";

			$query_session = $db->prepare($sql);
			$query_session->execute();
			$toplam=0;
			while ($data=$query_session->fetch(PDO::FETCH_ASSOC)) 
			{	
				$faturatanimhareket->execute(array(
					"faturatanim_id" => $son_id,
					"STOKISLEMTURU" => $STOKISLEMTURU,
					"ISLEMTARIHI" => $_POST["ISLEMTARIHI"],
					"STOKTANIMBARKODU" => $data["STOKTANIMBARKODU"],
					"fthareket_stokadi" => $data["stoktanim_adi"],
					"fthareket_birim" =>  $data["stoktanim_birimi"],
					"fthareket_fiyat" =>  $data["stoktanim_fiyat"],
					"fthareket_aciklama" =>  $data["stoktanim_aciklama"],
					"ADET" => $_SESSION["cart"][$data["stoktanim_id"]]["quantity"],
					"fthareket_tutar" => $_SESSION["cart"][$data["stoktanim_id"]]["quantity"]*$data["stoktanim_fiyat"]


				));
			}


			unset($_SESSION["cart"]);
			$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
			$log_query->execute(array(
				"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
				"email" => htmlspecialchars($_SESSION["kullanici_email"]),
				"aciklama" => "Fatura Kesildi",
				"ip" => $_SERVER["REMOTE_ADDR"]
			));
			echo "<script type=\"text/javascript\" charset=\"utf-8\">window.self.close()</script>"; //sayfayı kapattırıyorum.
			// header("Location:../production/fatura-islem?durum=$durum&durum=ok");
			exit;
		}
		else{
			header("Location:../production/fatura-islem?durum=$durum&durum=no");
			exit;
		}
	}
	else
	{
		header("Location:../production/fatura-islem?durum=$durum&durum=bos");
		exit;
	}
}


// *******************Sonradan Faturaya ürün ekleme******************************************************************************
if (isset($_POST["fatura-urunEkle"])) {
	$urun_id=$_POST["id"];
	$fatura_id=$_POST["fatura_id"];
	 $fatura_durum=$_POST["fatura_durum"]; // ALISFATURASI ise STOKGIRIS, SATISFATURASI ise STOKCIKIS olucak
	 $adet=$_POST["adet"];
	 $fatura_sontutar=$_POST["fatura_sontutar"];
	 $durum="";
	 if ($fatura_durum=="ALISFATURASI") {
	 	$durum="STOKGIRIS";
	 }
	 else
	 {
	 	$durum="STOKCIKIS";
	 }
	 $islemtarihi=date("Y-m-d H:i:s");

	 //ürün hakkında bilgiler var
	 $query_urun=$db->prepare("select * from stoktanim where stoktanim_id=:id");
	 $query_urun->execute(array(
	 	"id" => $urun_id
	 ));
	 $urun_data=$query_urun->fetch(PDO::FETCH_ASSOC);

	 $urun_fiyat = $adet*$urun_data["stoktanim_fiyat"];


	 //ürün zaten ekliyse ekleme yapma ve adet yükselt sadece
	 $query_control=$db->prepare("select * from faturatanimhareket where faturatanim_id=:faturatanim_id and STOKTANIMBARKODU=:STOKTANIMBARKODU and fthareket_sil=:fthareket_sil");
	 $query_control->execute(array(
	 	"fthareket_sil" => 0,
	 	"faturatanim_id" => $fatura_id,
	 	"STOKTANIMBARKODU" => $urun_data["STOKTANIMBARKODU"]
	 ));
	 $row = $query_control->rowCount();
	 $urun_query_control=$query_control->fetch(PDO::FETCH_ASSOC);
	 if ($row==1) {
	 	$update=$db->prepare("update faturatanimhareket set 
	 		ADET=:ADET, 
	 		fthareket_tutar=:fthareket_tutar 
	 		where faturatanim_id=:id and STOKTANIMBARKODU=:STOKTANIMBARKODU");
	 	$update_control = $update->execute(array(
	 		"ADET" => $urun_query_control["ADET"]+$adet,
	 		"fthareket_tutar" => $urun_query_control["fthareket_tutar"]+$urun_fiyat,
	 		"id" => $fatura_id,
	 		"STOKTANIMBARKODU" => $urun_data["STOKTANIMBARKODU"]
	 	));
	 	if ($update_control) {
	 		$faturaupdate=$db->prepare("update faturatanim set 
	 			TUTAR=:tutar 
	 			where faturatanim_id=:id");
	 		$faturaupdate_control = $faturaupdate->execute(array(
	 			"tutar" => $fatura_sontutar+$urun_fiyat,
	 			"id" => $fatura_id
	 		));
	 		if ($faturaupdate_control) {
	 			$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
	 			$log_query->execute(array(
	 				"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
	 				"email" => htmlspecialchars($_SESSION["kullanici_email"]),
	 				"aciklama" => "Faturaya sonradan ürün eklendi",
	 				"ip" => $_SERVER["REMOTE_ADDR"]
	 			));
	 			header("Location:../production/fatura-detay?id=$fatura_id&durum=ok");
	 			exit;
	 		}
	 		else
	 		{
	 			header("Location:../production/fatura-detay?id=$fatura_id&durum=hata");
	 			exit;
	 		}
	 	}
	 	else
	 	{
	 		echo "hata";exit;
	 	}
	 }
	 else
	 {
	 	$query=$db->prepare("insert into faturatanimhareket set 
	 		faturatanim_id=:faturatanim_id,
	 		STOKISLEMTURU=:STOKISLEMTURU,
	 		ISLEMTARIHI=:ISLEMTARIHI,
	 		STOKTANIMBARKODU=:STOKTANIMBARKODU,
	 		fthareket_stokadi=:fthareket_stokadi,
	 		ADET=:ADET,
	 		fthareket_birim=:fthareket_birim,
	 		fthareket_fiyat=:fthareket_fiyat,
	 		fthareket_tutar=:fthareket_tutar,
	 		fthareket_aciklama=:fthareket_aciklama
	 		");
	 	$control=$query->execute(array(
	 		"faturatanim_id" => $fatura_id,
	 		"STOKISLEMTURU" =>  $durum,
	 		"ISLEMTARIHI" =>  $islemtarihi,
	 		"STOKTANIMBARKODU" => $urun_data["STOKTANIMBARKODU"],
	 		"fthareket_stokadi" => $urun_data["stoktanim_adi"],
	 		"ADET" => $adet,
	 		"fthareket_birim" => $urun_data["stoktanim_birimi"],
	 		"fthareket_fiyat" => $urun_data["stoktanim_fiyat"],
	 		"fthareket_tutar" => $urun_fiyat,
	 		"fthareket_aciklama" => $urun_data["stoktanim_aciklama"]
	 	));
	 	if ($control) {
	 		$update=$db->prepare("update faturatanim set 
	 			TUTAR=:tutar 
	 			where faturatanim_id=:id");
	 		$update_control = $update->execute(array(
	 			"tutar" => $fatura_sontutar+$urun_fiyat,
	 			"id" => $fatura_id
	 		));
	 		if ($update_control) {
	 			$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
	 			$log_query->execute(array(
	 				"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
	 				"email" => htmlspecialchars($_SESSION["kullanici_email"]),
	 				"aciklama" => "Faturaya sonradan ürün eklendi",
	 				"ip" => $_SERVER["REMOTE_ADDR"]
	 			));
	 			header("Location:../production/fatura-detay?id=$fatura_id&durum=ok");
	 			exit;
	 		}
	 		else
	 		{
	 			header("Location:../production/fatura-detay?id=$fatura_id&durum=hata");
	 			exit;
	 		}
	 	}
	 	else
	 	{
	 		header("Location:../production/fatura-detay?id=$fatura_id&durum=hata");
	 		exit;
	 	}
	 }

	}





// *******************SİLME******************************************************************************

	 //Faturatanim silme
	if (isset($_GET["faturatanim_sil"]) && $_GET["faturatanim_sil"]=="ok") {
		$delete=$db->prepare("update faturatanim
			set faturatanim_sil=:faturatanim_sil
		 where faturatanim_id=:id
			");
		$control=$delete->execute(array(
			"faturatanim_sil" => 1,
			"id" => $_GET["faturatanim_id"]
		));

		if($control){
			$delete_urunler=$db->prepare("update faturatanimhareket
				set fthareket_sil=:fthareket_sil
			 where faturatanim_id=:id");
			$control_urunler=$delete_urunler->execute(array(
				"fthareket_sil" => 1,
				"id" => $_GET["faturatanim_id"]
			));
			$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
			$log_query->execute(array(
				"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
				"email" => htmlspecialchars($_SESSION["kullanici_email"]),
				"aciklama" => "Fatura silindi",
				"ip" => $_SERVER["REMOTE_ADDR"]
			));
			header("Location:../production/fatura?sil=ok");
			exit;
		}
		else
		{
			header("Location:../production/fatura?sil=no");
			exit;
		}
		// $delete=$db->prepare("delete from faturatanim where faturatanim_id=:id
		// 	");
		// $control=$delete->execute(array(
		// 	"id" => $_GET["faturatanim_id"]
		// ));

		// if($control){
		// 	$delete_urunler=$db->prepare("delete from faturatanimhareket where faturatanim_id=:id");
		// 	$control_urunler=$delete_urunler->execute(array(
		// 		"id" => $_GET["faturatanim_id"]
		// 	));
		// 	$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		// 	$log_query->execute(array(
		// 		"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
		// 		"email" => htmlspecialchars($_SESSION["kullanici_email"]),
		// 		"aciklama" => "Fatura silindi",
		// 		"ip" => $_SERVER["REMOTE_ADDR"]
		// 	));
		// 	header("Location:../production/fatura?sil=ok");
		// 	exit;
		// }
		// else
		// {
		// 	header("Location:../production/fatura?sil=no");
		// 	exit;
		// }
	}


	 //Faturatanimhareket silme
	if ($_GET["faturatanimhareket_sil"]=="ok") {
		$id=$_GET["faturatanim_id"];
		$fthareket_tutar=$_GET["fthareket_tutar"];


		$goster=$db->prepare("select * from faturatanim where faturatanim_id=:id
			");
		$goster->execute(array(
			"id" => $id
		));
		$goster_tutar=$goster->fetch(PDO::FETCH_ASSOC);

		$delete=$db->prepare("update faturatanimhareket
			set fthareket_sil=:fthareket_sil
		 where fthareket_id=:id
			");
		$control=$delete->execute(array(
			"fthareket_sil" => 1,
			"id" => $_GET["faturatanimhareket_id"]
		));

		if($control){

			$update=$db->prepare("update faturatanim set 
				TUTAR=:tutar 
				where faturatanim_id=:id");
			$update->execute(array(
				"tutar" => $goster_tutar["TUTAR"]-$fthareket_tutar,
				"id" => $_GET["faturatanim_id"]
			));

			$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
			$log_query->execute(array(
				"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
				"email" => htmlspecialchars($_SESSION["kullanici_email"]),
				"aciklama" => "Faturadan ürün silindi",
				"ip" => $_SERVER["REMOTE_ADDR"]
			));
			header("Location:../production/fatura-detay?id=$id&sil=ok");
			exit;
		}
		else
		{
			header("Location:../production/fatura-detay?id=$id&sil=no");
			exit;
		}
		// $id=$_GET["faturatanim_id"];
		// $fthareket_tutar=$_GET["fthareket_tutar"];


		// $goster=$db->prepare("select * from faturatanim where faturatanim_id=:id
		// 	");
		// $goster->execute(array(
		// 	"id" => $id
		// ));
		// $goster_tutar=$goster->fetch(PDO::FETCH_ASSOC);

		// $delete=$db->prepare("delete from faturatanimhareket where fthareket_id=:id
		// 	");
		// $control=$delete->execute(array(
		// 	"id" => $_GET["faturatanimhareket_id"]
		// ));

		// if($control){

		// 	$update=$db->prepare("update faturatanim set 
		// 		TUTAR=:tutar 
		// 		where faturatanim_id=:id");
		// 	$update->execute(array(
		// 		"tutar" => $goster_tutar["TUTAR"]-$fthareket_tutar,
		// 		"id" => $_GET["faturatanim_id"]
		// 	));

		// 	$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		// 	$log_query->execute(array(
		// 		"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
		// 		"email" => htmlspecialchars($_SESSION["kullanici_email"]),
		// 		"aciklama" => "Faturadan ürün silindi",
		// 		"ip" => $_SERVER["REMOTE_ADDR"]
		// 	));
		// 	header("Location:../production/fatura-detay?id=$id&sil=ok");
		// 	exit;
		// }
		// else
		// {
		// 	header("Location:../production/fatura-detay?id=$id&sil=no");
		// 	exit;
		// }
	}
	?>