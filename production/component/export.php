<?php
require_once "../../netting/connection.php";

$ad=$_GET["ad"];
$output = '';

if($ad=="kullanici"){
	$query = $db->prepare("select * from kullanici");
	$show = $query->execute();
	if ($show) {
		$output .= '
		<table class="table">
		
		<tr>
		<th></th>  
		<th>Email</th>
		<th>Ad Soyad</th>
		<th>Turu</th>
		<th>Aktiflik</th>
		</tr>
		';
		$sira=1; 
		while($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			$output .= '
			<tr>  
			<td>'.$sira++.'</td>  
			<td>'.$row["kullanicimail"].'</td>  
			<td>'.$row["kullaniciadisoyadi"].'</td>  
			<td>'.$row["kullanicituru"].'</td>  
			<td>'.$row["kullaniciaktif"].'</td>  
			</tr>
			';
		}
		$output .= '</table>';
		 //$output = mb_convert_encoding($output, "SJIS","UTF-8");
		header('Content-Type: application/xls');
		 //header("Content-Transfer-Encoding: binary"); 
		header('Content-Disposition: attachment; filename='.$ad.'.xls');
		echo chr(255).chr(254).iconv("UTF-8", "UTF-16LE//IGNORE", $output); //türkçe karakter sorununu çözdü
		 //echo $output;
	}
	else
	{

		//header("Location:".$_SERVER['HTTP_REFERER']."?durum=exporthata");
		exit;
	}
} 


?>