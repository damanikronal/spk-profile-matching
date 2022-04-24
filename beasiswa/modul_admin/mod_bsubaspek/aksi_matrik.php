<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];
// Hitung Matrik Perbandingan
if ($modul=='bobot_subaspek' AND $act=='normalisasi'){
	// FISRT STEP : NORMALISATION bobot_subaspek SCALE
	$core=$_POST[core];
	$second=$_POST[second];
	$jumlah=$core+$second;
	$core1=$core/$jumlah;
	$second1=$second/$jumlah;
	mysql_query("INSERT INTO bobot_subaspek(jenis,bobot_subaspek) 
		VALUES('core', '$core1')");
	mysql_query("INSERT INTO bobot_subaspek(jenis,bobot_subaspek) 
		VALUES('second', '$second1')");
  header('location:../../indexs.php?modul='.$modul);
}
elseif ($modul=='bobot_subaspek' AND $act=='hitungulang'){
  mysql_query("DELETE FROM bobot_subaspek");
  header('location:../../indexs.php?modul='.$modul);
}

?>

