<?php
require_once "connection.php"; //bağlantımızı gerçekleştiriyoruz
// *******************GÜNCELLEME******************************************************************************

 	//Stoktakini güncelleme
if (isset($_POST["stokguncelle"])) {
	$stoktanim_id=$_POST["stoktanim_id"];

	if (strlen($_FILES['stoktanim_resim']["name"])>0) {
	//resim boyutu 1mb'dan büyükse izin verme
		if ($_FILES['stoktanim_resim']['size']>1048576) {
			Header("Location:../production/stok-duzenle?stoktanim_id=$stoktanim_id&durum=dosyabuyuk");
			exit;
		}
			//jpg yada png dışında resim ekletme
		$izinli_uzantilar=array('jpg','png');
		$ext=strtolower(substr($_FILES['stoktanim_resim']["name"],strpos($_FILES['stoktanim_resim']["name"],'.')+1));

		if (in_array($ext, $izinli_uzantilar) === false) {
			Header("Location:../production/stok-duzenle?stoktanim_id=$stoktanim_id&durum=formhata");
			exit;
		}

		$uploads_dir='stoktanim_resim';

		@$tmp_name=$_FILES['stoktanim_resim']['tmp_name'];
		@$name=$_FILES["stoktanim_resim"]["name"];

			//İmage Resize İşlemleri
		include('SimpleImage.php');
		$image = new SimpleImage();
		$image->load($tmp_name);
		$image->resize(128,128);
		$image->save($tmp_name);


		$benzersizsayi4=rand(20000,32000);
		$refimgyol=$uploads_dir."/".$benzersizsayi4.$name;
		@move_uploaded_file($tmp_name, "../production/dimg/$uploads_dir/$benzersizsayi4$name");


		$query = $db->prepare("update stoktanim set
			stoktanim_birimi=:stoktanim_birimi,
			stoktanim_fiyat=:stoktanim_fiyat,
			stoktanim_aciklama=:stoktanim_aciklama,
			stoktanim_aktiflik=:stoktanim_aktiflik,
			stoktanim_resim=:stoktanim_resim
			where stoktanim_id=:id
			");
		$update = $query->execute(array(
			"stoktanim_birimi" => $_POST["stoktanim_birimi"],
			"stoktanim_fiyat" => $_POST["stoktanim_fiyat"],
			"stoktanim_aciklama" => $_POST["stoktanim_aciklama"],
			"stoktanim_aktiflik" => $_POST["stoktanim_aktiflik"],
			"stoktanim_resim" =>  $refimgyol,
			"id" => $stoktanim_id
		));

		if ($update) {
			$resimsilunlink=$_POST["eski_yol"];
			if ($resimsilunlink!="dimg/stokresimyok.png") {
					unlink("../production/$resimsilunlink"); //resmi klasörden silme
				}
				$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
				$log_query->execute(array(
					"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
					"email" => htmlspecialchars($_SESSION["kullanici_email"]),
					"aciklama" => "Stok Güncelledi",
					"ip" => $_SERVER["REMOTE_ADDR"]
				));
				header("Location:../production/stok-duzenle?stoktanim_id=$stoktanim_id&durum=ok");
				exit;
			}
			else
			{
				header("Location:../production/stok-duzenle?stoktanim_id=$stoktanim_id&durum=no");
				exit;
			}
		}
		else
		{

			$query = $db->prepare("update stoktanim set
				stoktanim_birimi=:stoktanim_birimi,
				stoktanim_fiyat=:stoktanim_fiyat,
				stoktanim_aciklama=:stoktanim_aciklama,
				stoktanim_aktiflik=:stoktanim_aktiflik,
				stoktanim_resim=:stoktanim_resim
				where stoktanim_id=:id
				");
			$update = $query->execute(array(
				"stoktanim_birimi" => $_POST["stoktanim_birimi"],
				"stoktanim_fiyat" => $_POST["stoktanim_fiyat"],
				"stoktanim_aciklama" => $_POST["stoktanim_aciklama"],
				"stoktanim_aktiflik" => $_POST["stoktanim_aktiflik"],
				"stoktanim_resim" =>  substr($_POST["eski_yol"],5),
				"id" => $stoktanim_id
			));

			if ($update) {
				$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
				$log_query->execute(array(
					"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
					"email" => htmlspecialchars($_SESSION["kullanici_email"]),
					"aciklama" => "Stok Güncelledi",
					"ip" => $_SERVER["REMOTE_ADDR"]
				));
				header("Location:../production/stok-duzenle?stoktanim_id=$stoktanim_id&durum=ok");
				exit;
			}
			else
			{
				header("Location:../production/stok-duzenle?stoktanim_id=$stoktanim_id&durum=no");
				exit;
			}
		}

	}




	//Stoktakini aktifi pasif yapma
	if (isset($_GET["stoktanim_aktif"]) && $_GET["stoktanim_aktif"]=="ok") {
		$active=$db->prepare("update stoktanim set stoktanim_aktiflik=:aktiflik where stoktanim_id=:stoktanim_id
			");
		$control=$active->execute(array(
			"aktiflik" => 0,
			"stoktanim_id" => $_GET["stoktanim_id"],
		));

		if($control){
			$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
			$log_query->execute(array(
				"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
				"email" => htmlspecialchars($_SESSION["kullanici_email"]),
				"aciklama" => "Stoktaki ürün pasif yapıldı",
				"ip" => $_SERVER["REMOTE_ADDR"]
			));
			header("Location:../production/stok-tanim?pasiflik=ok");
			exit;
		}
		else
		{
			header("Location:../production/stok-tanim?pasiflik=no");
			exit;
		}
	}

	//Stoktakini pasifi aktif yapma
	if ($_GET["stoktanim_pasif"]=="ok") {
		$passive=$db->prepare("update stoktanim set stoktanim_aktiflik=:aktiflik where stoktanim_id=:stoktanim_id
			");
		$control=$passive->execute(array(
			"aktiflik" => 1,
			"stoktanim_id" => $_GET["stoktanim_id"],
		));

		if($control){
			$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
			$log_query->execute(array(
				"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
				"email" => htmlspecialchars($_SESSION["kullanici_email"]),
				"aciklama" => "Sotaktaki ürün aktif yapıldı",
				"ip" => $_SERVER["REMOTE_ADDR"]
			));
			header("Location:../production/stok-tanim?aktiflik=ok");
			exit;
		}
		else
		{
			header("Location:../production/stok-tanim?aktiflik=no");
			exit;
		}
	}
















// *******************EKLEME******************************************************************************



 	//Stok Ekleme
	if (isset($_POST["stokekle"])) {

	 //barkod no kayıtlımı değilmi bakalıyoruz.
		$query_barkod = $db->prepare("select * from stoktanim where STOKTANIMBARKODU=:barkod");
		$query_barkod->execute(array(
			"barkod" => $_POST["STOKTANIMBARKODU"]
		));
		$row_barkod = $query_barkod->rowCount();
		if ($row_barkod==1) {
			header("Location:../production/stok-ekle?durum=barkodhata");
			exit;
		}
		else
		{	
		//stok ad kayıtlımı değilmi bakalıyoruz.
			$query_ad = $db->prepare("select * from stoktanim where stoktanim_adi=:ad");
			$query_ad->execute(array(
				"ad" => $_POST["stoktanim_adi"]
			));
			$row_ad = $query_ad->rowCount();
			if ($row_ad==1) {
				header("Location:../production/stok-ekle?durum=stokadhata");
				exit;
			}
			else
			{
				if (strlen($_FILES['stoktanim_resim']["name"])>0) {
				//resim boyutu 1mb'dan büyükse izin verme
					if ($_FILES['stoktanim_resim']['size']>1048576) {
						Header("Location:../production/stok-ekle?durum=dosyabuyuk");
						exit;
					}
			//jpg yada png dışında resim ekletme
					$izinli_uzantilar=array('jpg','png');
					$ext=strtolower(substr($_FILES['stoktanim_resim']["name"],strpos($_FILES['stoktanim_resim']["name"],'.')+1));

					if (in_array($ext, $izinli_uzantilar) === false) {
						Header("Location:../production/stok-ekle?durum=formhata");
						exit;
					}



					$uploads_dir='stoktanim_resim';

					@$tmp_name=$_FILES['stoktanim_resim']['tmp_name'];
					@$name=$_FILES["stoktanim_resim"]["name"];

			//İmage Resize İşlemleri
					include('SimpleImage.php');
					$image = new SimpleImage();
					$image->load($tmp_name);
					$image->resize(128,128);
					$image->save($tmp_name);


					$benzersizsayi4=rand(20000,32000);
					$refimgyol=$uploads_dir."/".$benzersizsayi4.$name;
					@move_uploaded_file($tmp_name, "../production/dimg/$uploads_dir/$benzersizsayi4$name");


					$query = $db->prepare("insert into stoktanim set
						STOKTANIMBARKODU=:STOKTANIMBARKODU,
						stoktanim_adi=:stoktanim_adi,
						stoktanim_birimi=:stoktanim_birimi,
						stoktanim_fiyat=:stoktanim_fiyat,
						stoktanim_aciklama=:stoktanim_aciklama,
						stoktanim_aktiflik=:stoktanim_aktiflik,
						stoktanim_resim=:stoktanim_resim
						");
					$update = $query->execute(array(
						"STOKTANIMBARKODU" => $_POST["STOKTANIMBARKODU"],
						"stoktanim_adi" => $_POST["stoktanim_adi"],
						"stoktanim_birimi" => $_POST["stoktanim_birimi"],
						"stoktanim_fiyat" => $_POST["stoktanim_fiyat"],
						"stoktanim_aciklama" => $_POST["stoktanim_aciklama"],
						"stoktanim_aktiflik" => $_POST["stoktanim_aktiflik"],
						"stoktanim_resim" =>  $refimgyol
					));

					if ($update) {
						$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
						$log_query->execute(array(
							"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
							"email" => htmlspecialchars($_SESSION["kullanici_email"]),
							"aciklama" => "Stok eklendi",
							"ip" => $_SERVER["REMOTE_ADDR"]
						));
						header("Location:../production/stok-ekle?durum=ok");
						exit;
					}
					else
					{
						header("Location:../production/stok-ekle?durum=no");
						exit;
					}
				}
				else
				{




					$query = $db->prepare("insert into stoktanim set
						STOKTANIMBARKODU=:STOKTANIMBARKODU,
						stoktanim_adi=:stoktanim_adi,
						stoktanim_birimi=:stoktanim_birimi,
						stoktanim_fiyat=:stoktanim_fiyat,
						stoktanim_aciklama=:stoktanim_aciklama,
						stoktanim_aktiflik=:stoktanim_aktiflik,
						stoktanim_resim=:stoktanim_resim
						");
					$update = $query->execute(array(
						"STOKTANIMBARKODU" => $_POST["STOKTANIMBARKODU"],
						"stoktanim_adi" => $_POST["stoktanim_adi"],
						"stoktanim_birimi" => $_POST["stoktanim_birimi"],
						"stoktanim_fiyat" => $_POST["stoktanim_fiyat"],
						"stoktanim_aciklama" => $_POST["stoktanim_aciklama"],
						"stoktanim_aktiflik" => $_POST["stoktanim_aktiflik"],
						"stoktanim_resim" =>  "stokresimyok.png"
					));

					if ($update) {
						$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
						$log_query->execute(array(
							"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
							"email" => htmlspecialchars($_SESSION["kullanici_email"]),
							"aciklama" => "Stok eklendi",
							"ip" => $_SERVER["REMOTE_ADDR"]
						));
						header("Location:../production/stok-ekle?durum=ok");
						exit;
					}
					else
					{
						header("Location:../production/stok-ekle?durum=no");
						exit;
					}
				}


			}

		}


	}














// *******************SİLME******************************************************************************

	//Stok silme
	if ($_GET["stoktanim_sil"]=="ok") {
			$delete=$db->prepare("update stoktanim 
				set stoktanim_sil=:stoktanim_sil
				where stoktanim_id=:id
			");
		$control=$delete->execute(array(
			"stoktanim_sil" => 1,
			"id" => $_GET["stoktanim_id"],
		));

		if($control){
			$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
			$log_query->execute(array(
				"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
				"email" => htmlspecialchars($_SESSION["kullanici_email"]),
				"aciklama" => "Stok silindi",
				"ip" => $_SERVER["REMOTE_ADDR"]
			));
			header("Location:../production/stok-tanim?sil=ok");
			exit;
		}
		else
		{
			header("Location:../production/stok-tanim?sil=no");
			exit;
		}

		// $delete=$db->prepare("delete from stoktanim where stoktanim_id=:id
		// 	");
		// $control=$delete->execute(array(
		// 	"id" => $_GET["stoktanim_id"],
		// ));

		// if($control){
		// 	$log_query = $db->prepare("insert into logtablosu set log_kullaniciadi=:kullaniciadi,log_kullaniciemail=:email,log_aciklama=:aciklama,log_kullaniciip=:ip");
		// 	$log_query->execute(array(
		// 		"kullaniciadi" => $_SESSION["kullanici_adsoyad"],
		// 		"email" => htmlspecialchars($_SESSION["kullanici_email"]),
		// 		"aciklama" => "Stok silindi",
		// 		"ip" => $_SERVER["REMOTE_ADDR"]
		// 	));
		// 	header("Location:../production/stok-tanim?sil=ok");
		// 	exit;
		// }
		// else
		// {
		// 	header("Location:../production/stok-tanim?sil=no");
		// 	exit;
		// }
	}
	?>