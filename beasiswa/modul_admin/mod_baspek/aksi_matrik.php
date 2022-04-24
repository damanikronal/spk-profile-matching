<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];
$jlhaspek = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM aspek"),0); // Jumlah aspek
// Hitung Matrik Perbandingan
if ($modul=='bobot_aspek' AND $act=='normalisasi'){
	// FISRT STEP : NORMALISATION bobot_aspek SCALE
	$jumlah=0;
	for ($j=1;$j<=$jlhaspek;$j++){
		$w[$j] = $_POST['bobot_aspek'.$j];
		$jumlah += $w[$j];
	}
	for ($j=1;$j<=$jlhaspek;$j++){
		$w[$j] = $_POST['bobot_aspek'.$j];
		$wn[$j] = $w[$j]/$jumlah;
		mysql_query("INSERT INTO bobot_aspek(id_aspek,bobot_aspek) 
		VALUES('$j', '$wn[$j]')");
	}
  header('location:../../indexs.php?modul='.$modul);
}
elseif ($modul=='bobot_aspek' AND $act=='hitungulang'){
  mysql_query("DELETE FROM bobot_aspek");
  header('location:../../indexs.php?modul='.$modul);
}

?>

