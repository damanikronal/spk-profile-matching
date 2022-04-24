<?php
session_start();

if (empty($_SESSION[username]) AND empty($_SESSION[passuser])){
  echo "<link href='main.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
}
else{
?>
<?
include "config/setting.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo "$title"; ?></title>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>

<body>

   <!-- Begin Wrapper -->
   <div id="wrapper">
   
         <!-- Begin Header -->
         <div id="header">
		 	   <h1 align="center">
		       <? echo "$header"; ?>	 
			   </h1>
		 </div>
		 <!-- End Header -->
		 
		 <!-- Begin Left Column -->
		 <div id="leftcolumn">
			<div id="menu">		 
		       <ul>
				  <li><a href=?modul=beranda>&#187; Beranda</a></li>
				  <?php include "menu.php"; ?>
				  <li><a href=?modul=bantuan>&#187; Bantuan</a></li>
				  <li><a href=?modul=tentang>&#187; Tentang SPK</a></li>
				  <li><a href=logout.php>&#187; Logout</a></li>
			  </ul>
			</div>
		 
		 </div>
		 <!-- End Left Column -->
		 
		 <!-- Begin Right Column -->
		 <div id="rightcolumn">
		      
			  <?
			  	include "content.php";
			  ?> 
	          
		 </div>
		 <!-- End Right Column -->
		 
		 <!-- Begin Footer -->
		 <div id="footer">
		       <p align="center">
			   <? echo "$footer"; ?>	
			   </p> 
	     </div>
		 <!-- End Footer -->
		 
   </div>
   <!-- End Wrapper -->
   
</body>
</html>
<?php
}
?>

