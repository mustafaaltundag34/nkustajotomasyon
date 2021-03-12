<?php
require_once "connection.php"; //bağlantımızı gerçekleştiriyoruz

if ($_GET["cikis"]=="ok") {
	session_destroy();


		//// giris log yazma

				$log_query = $db->prepare("insert into log set logkullaniciadi=:kullaniciadisoyadi,logislem=:logislem");
				$log_query->execute(array(
					"kullaniciadisoyadi" => $_SESSION["kullaniciadisoyadi"],
					"logislem" => "Başarılı Logout Islemi"
				));

		////
	header("Location:../index?durum=exit");
	exit;
}

?>