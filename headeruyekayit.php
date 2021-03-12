<?php 
require_once ("netting/connection.php");



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
 

		<title>Yeni Kullanici Kaydi</title>

	<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="login_files/images/icons/stajdb.png"/>
	
	<!--===============================================================================================-->
	<!-- Bootstrap -->

	<link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!-- bootstrap-progressbar -->
	<link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
	<!-- JQVMap -->
	<link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
	<!-- bootstrap-daterangepicker -->
	<link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- Datatables -->
	<link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
	<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
	<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
	<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

	<!-- CK Editör -->
	<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
	<!-- Custom Theme Style -->
	<link href="build/css/custom.min.css" rel="stylesheet">

	<!-- SweetAlert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<!-- after login progress -->
	<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
	<style type="text/css">
		.loader-wrapper {
			width: 100%;
			height: 100%;
			position: absolute;
			top: 0;
			left: 0;
			background-color: #242f3f;
			display:flex;
			justify-content: center;
			align-items: center;
			z-index: 1;
		}
		.loader {
			display: inline-block;
			width: 30px;
			height: 30px;
			position: relative;
			border: 4px solid #Fff;
			animation: loader 2s infinite ease;
		}
		.loader-inner {
			vertical-align: top;
			display: inline-block;
			width: 100%;
			background-color: #fff;
			animation: loader-inner 2s infinite ease-in;
		}
		@keyframes loader {
			0% { transform: rotate(0deg);}
			25% { transform: rotate(180deg);}
			50% { transform: rotate(180deg);}
			75% { transform: rotate(360deg);}
			100% { transform: rotate(360deg);}
		}
		@keyframes loader-inner {
			0% { height: 0%;}
			25% { height: 0%;}
			50% { height: 100%;}
			75% { height: 100%;}
			100% { height: 0%;}
		}
	</style>
</head>


