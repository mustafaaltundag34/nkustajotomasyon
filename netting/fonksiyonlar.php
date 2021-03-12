<?php

function adminkontrol($kullanicituru){
	if ($kullanicituru!="Ogruyesi") {
		//header("Location:main");
		header("Location:../production/main?durum=yetkinizyok");
		exit;
	}
}


?>