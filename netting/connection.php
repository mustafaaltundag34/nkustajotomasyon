<?php

try{
	$db=new PDO("mysql:host=localhost;dbname=stajdb;charset=utf8","root","");
	// echo "başarılı";
	ob_start();
	session_set_cookie_params(0);
	session_start();
	
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

} catch(PDOException $e){
	echo $e->getMessage();
}

?>