<?php
require_once "connection.php"; //bağlantımızı gerçekleştiriyoruz




// *******************SİLME******************************************************************************



	//kullanıcı silme
if ($_GET["firmaaktif"]=="ok") {
	$delete=$db->prepare("update firmahavuzu set 
		firmaaktif=:firmaaktif
		where firmaid=:firmaid
		");
	$control=$delete->execute(array(
		"firmaaktif" => 0,
		"firmaid" => $_GET["firmaid"],
	));

	if($control){
	//echo "silbasarili2";

		header("Location:../production/firmahavuzu.php?sil=ok");
						
						//// log yazma

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarılı Firma Silme Islemi"
				));

		////
		exit;
	}
	else
	{
		header("Location:../production/firmahavuzu?sil=no");
		exit;
	}

}


// *******************SİLME******************************************************************************





// *******************GÜNCELLEME******************************************************************************
 	//Cari güncelleme.
if(isset($_POST["firmaguncelle"])){
	$firmaid=$_POST["firmaid"];
/////resim ekleme////
	if (strlen($_FILES['firmafoto']["name"])>0) {
	//resim boyutu 1mb'dan büyükse izin verme
		if ($_FILES['firmafoto']['size']>1048576) {
			Header("Location:../production/firma-duzenle?firmaid=$firmaid&durum=dosyabuyuk");
			exit;
		}
			//jpg yada png dışında resim ekletme
		$izinli_uzantilar=array('jpg','png');
		$ext=strtolower(substr($_FILES['firmafoto']["name"],strpos($_FILES['firmafoto']["name"],'.')+1));

		if (in_array($ext, $izinli_uzantilar) === false) {
			Header("Location:../production/firma-duzenle?firmaid=$firmaid&durum=formhata");
			exit;
		}

		$uploads_dir='firmafoto';

		@$tmp_name=$_FILES['firmafoto']['tmp_name'];
		@$name=$_FILES["firmafoto"]["name"];

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


	$query=$db->prepare("update firmahavuzu set 
			firmaadi=:firmaadi,
			firmasehir=:firmasehir,
			firmaadres=:firmaadres,
			firmasektor=:firmasektor,
			firmamail=:firmamail,
			firmatel=:firmatel,
			firmacalisansayisi=:firmacalisansayisi,
			firmayetkili=:firmayetkili,
			firmaaktif=:firmaaktif,
			firmafoto=:firmafoto
		where firmaid=:firmaid"

	);
	$update=$query->execute(array(
			"firmaadi" => $_POST["firmaadi"],
			"firmasehir" => $_POST["firmasehir"],
			"firmaadres" => $_POST["firmaadres"],
			"firmasektor" => $_POST["firmasektor"],
			"firmamail" => $_POST["firmamail"],
			"firmatel" => $_POST["firmatel"],
			"firmacalisansayisi" => $_POST["firmacalisansayisi"],
			"firmayetkili" => $_POST["firmayetkili"],
			"firmaaktif" => $_POST["firmaaktif"],
			"firmafoto" =>  $refimgyol,
		"firmaid" => $firmaid
	));
	if($update){
				//echo ("basarili 1");
				$resimsilunlink=$_POST["eski_yol"];
				if ($resimsilunlink!="dimg/user.png") {
					unlink("../production/$resimsilunlink"); //resmi klasörden silme
				}
		//echo "basarili1";
						//// log yazma

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarılı Firma Silme Islemi"
				));
		echo "<script type=\"text/javascript\" charset=\"utf-8\">window.self.close()</script>"; //sayfayı kapattırıyorum.
		exit;
	}
	else
	{
		//echo "basarisiz1";
		header("Location:../production/firma-duzenle?firmaid=$firmaid&durum=no");
		exit;
	}
} else
		{

			$query = $db->prepare("update firmahavuzu set
			firmaadi=:firmaadi,
			firmasehir=:firmasehir,
			firmaadres=:firmaadres,
			firmasektor=:firmasektor,
			firmamail=:firmamail,
			firmatel=:firmatel,
			firmacalisansayisi=:firmacalisansayisi,			
			firmayetkili=:firmayetkili,
			firmaaktif=:firmaaktif,
			firmafoto=:firmafoto
		where firmaid=:firmaid
		");
			$update = $query->execute(array(
			"firmaadi" => $_POST["firmaadi"],
			"firmasehir" => $_POST["firmasehir"],
			"firmaadres" => $_POST["firmaadres"],
			"firmasektor" => $_POST["firmasektor"],
			"firmamail" => $_POST["firmamail"],
			"firmatel" => $_POST["firmatel"],
			"firmacalisansayisi" => $_POST["firmacalisansayisi"],			
			"firmayetkili" => $_POST["firmayetkili"],
			"firmaaktif" => $_POST["firmaaktif"],
			"firmafoto" =>  substr($_POST["eski_yol"],5),
		"firmaid" => $firmaid


	));

			if ($update) {
			//echo ("basarili 2");

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarılı Firma Guncelleme Islemi"
				));

		////
			echo "<script type=\"text/javascript\" charset=\"utf-8\">window.self.close()</script>"; //sayfayı kapattırıyorum.
				exit;
			}
			else
			{
				//echo ("basarisiz 2");
				header("Location:../production/firma-duzenle?firmaid=$firmaid&durum=no");
				exit;
			}
		}
}
// *******************GÜNCELLEME******************************************************************************



// *******************EKLEME******************************************************************************

//Cari ekleme.
if(isset($_POST["firmaekle"])){
	//cari adsoyad önceden ekliyse hata verdirt.
	$query_adsoyad = $db->prepare("select * from firmahavuzu where firmaadi=:firmaadi");
	$query_adsoyad->execute(array(
		"firmaadi" => $_POST["firmaadi"]
	));
	$row_adsoyad = $query_adsoyad->rowCount();
	if ($row_adsoyad==1) {
		header("Location:../production/firma-ekle?durum=firmaadihata");
		exit;
	}
	else
	{	
		$query=$db->prepare("insert into firmahavuzu set 
			firmaadi=:firmaadi,
			firmasehir=:firmasehir,
			firmaadres=:firmaadres,
			firmasektor=:firmasektor,
			firmamail=:firmamail,
			firmatel=:firmatel,
			firmacalisansayisi=:firmacalisansayisi,			
			firmayetkili=:firmayetkili,
			firmaaktif=:firmaaktif
			");
		$update=$query->execute(array(
			"firmaadi" => $_POST["firmaadi"],
			"firmasehir" => $_POST["firmasehir"],
			"firmaadres" => $_POST["firmaadres"],
			"firmasektor" => $_POST["firmasektor"],
			"firmamail" => $_POST["firmamail"],
			"firmatel" => $_POST["firmatel"],
			"firmacalisansayisi" => $_POST["firmacalisansayisi"],			
			"firmayetkili" => $_POST["firmayetkili"],
			"firmaaktif" => $_POST["firmaaktif"]
		));
		if($update){

			//header("Location:../production/cari-ekle?durum=ok");

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarılı Firma Ekleme Islemi"
				));

		////
			echo "<script type=\"text/javascript\" charset=\"utf-8\">window.self.close()</script>"; //sayfayı kapattırıyorum.
			exit;
		}
		else
		{
			header("Location:../production/firma-ekle?durum=no");
			exit;
		}
	}
}


////////////////////







