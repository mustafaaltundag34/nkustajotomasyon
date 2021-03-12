<?php
require_once "connection.php"; //bağlantımızı gerçekleştiriyoruz




// *******************staj SİLME******************************************************************************



	//kullanıcı silme
if (isset($_GET["stajsil"]) && $_GET["stajsil"]=="ok") {
if ($_GET["stajaktif"]=="ok") {
	$delete=$db->prepare("update stajhavuzu set 
		stajaktif=:stajaktif
		where stajid=:stajid
		");
	$control=$delete->execute(array(
		"stajaktif" => 0,
		"stajid" => $_GET["stajid"],
	));

	if($control){
	//echo "silbasarili2";

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarılı Staj Silme Islemi"
				));

		////
		header("Location:../production/stajhavuzu.php?sil=ok");
		exit;
	}
	else
	{

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarsız Staj Silme Islemi"
				));

		////
		header("Location:../production/stajhavuzu?sil=no");
		exit;
	}

}
}

// *******************staj SİLME******************************************************************************

// *******************GÜNCELLEME******************************************************************************
 	//Cari güncelleme.
if(isset($_POST["stajguncelle"])){
	$stajid=$_POST["stajid"];

	$query=$db->prepare("update stajhavuzu set 
			stajbolum=:stajbolum,
			stajtarihi=:stajtarihi,
			stajtipisuresi=:stajtipisuresi,
			yapilanprojeis=:yapilanprojeis,
			stajhocasi=:stajhocasi,
			stajpuani=:stajpuani,
			yorumlar=:yorumlar,
			stajonay=:stajonay,
			stajaktif=:stajaktif
		where stajid=:stajid"

	);
	$update=$query->execute(array(
			"stajbolum"=>$_POST["stajbolum"],
			"stajtarihi"=>$_POST["stajtarihi"],
			"stajtipisuresi"=>$_POST["stajtipisuresi"],
			"yapilanprojeis"=>$_POST["yapilanprojeis"],
			"stajhocasi"=>$_POST["stajhocasi"],
			"stajpuani"=>$_POST["stajpuani"],
			"yorumlar"=>$_POST["yorumlar"],
			"stajonay"=>$_POST["stajonay"],
			"stajaktif"=>$_POST["stajaktif"],
			"stajid" => $stajid
	));
	if($update){
				//echo ("basarili 1");

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarılı Staj Guncelleme Islemi"
				));

		////
		echo "<script type=\"text/javascript\" charset=\"utf-8\">window.self.close()</script>"; //sayfayı kapattırıyorum.
		exit;
	}
	else
	{
		//echo "basarisiz1";
		header("Location:../production/firma-duzenle?firmaid=$firmaid&durum=no");
		exit;
	}
} 
// *******************GÜNCELLEME******************************************************************************

// *******************STAJ EKLEME******************************************************************************

//Cari ekleme.
//$firmaadi=$_POST["stajfirma"];
if(isset($_POST["stajekle"])){
	//cari adsoyad önceden ekliyse hata verdirt.
	$query_logo2 = $db->prepare("select * from firmahavuzu where firmaadi=:firmaadi");
	$query_logo2->execute(array(
	"firmaadi" => $_POST["stajfirma"]
	));
	$firmahavuzu=$query_logo2->fetch(PDO::FETCH_ASSOC);
	$stajfirmalogo=$firmahavuzu["firmafoto"];
	{	
		$query=$db->prepare("insert into stajhavuzu set 
			stajogradisoyadi=:stajogradisoyadi,
			stajfirma=:stajfirma,
			stajfirmalogo=:stajfirmalogo,
			stajbolum=:stajbolum,
			stajtarihi=:stajtarihi,
			stajtipisuresi=:stajtipisuresi,
			yapilanprojeis=:yapilanprojeis,
			stajhocasi=:stajhocasi,
			stajpuani=:stajpuani,
			yorumlar=:yorumlar,			
			stajonay=:stajonay,
			stajaktif=:stajaktif
			");
		$update=$query->execute(array(
			"stajogradisoyadi" => $_POST["stajogradisoyadi"],
			"stajfirma" => $_POST["stajfirma"],
			"stajfirmalogo" => $stajfirmalogo,			
			"stajbolum" => $_POST["stajbolum"],
			"stajtarihi" => $_POST["stajtarihi"],
			"stajtipisuresi" => $_POST["stajtipisuresi"],
			"yapilanprojeis" => $_POST["yapilanprojeis"],
			"stajhocasi" => $_POST["stajhocasi"],
			"stajpuani" => $_POST["stajpuani"],
			"yorumlar"=>$_POST["yorumlar"],			
			"stajonay" => $_POST["stajonay"],
			"stajaktif" => $_POST["stajaktif"]
		));
		if($update){

			//header("Location:../production/cari-ekle?durum=ok");
									//// log yazma

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarılı Staj Ekleme Islemi"
				));
			echo "<script type=\"text/javascript\" charset=\"utf-8\">window.self.close()</script>"; //sayfayı kapattırıyorum.
			exit;
		}
		else
		{
			header("Location:../production/staj-ekle?durum=no");
			exit;
		}
	}
}


////////////////////




?>








