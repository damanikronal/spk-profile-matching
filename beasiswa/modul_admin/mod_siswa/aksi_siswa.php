<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];

// Hapus Karyawan
if ($modul=='siswa' AND $act=='hapus'){
  mysql_query("DELETE FROM siswa WHERE id_siswa='$_GET[id]'");
  mysql_query("DELETE FROM profil_siswa WHERE id_siswa='$_GET[id]'");
  mysql_query("DELETE FROM profil_bobot WHERE id_siswa='$_GET[id]'");
  mysql_query("DELETE FROM profil_total WHERE id_siswa='$_GET[id]'");
  mysql_query("DELETE FROM hasil WHERE id_siswa='$_GET[id]'");
  header('location:../../indexs.php?modul='.$modul);
}

// Input Siswa
elseif ($modul=='siswa' AND $act=='input'){
  //isi ke tabel siswa
  mysql_query("INSERT INTO siswa(id_siswa,nm_siswa) VALUES('$_POST[id_siswa]','$_POST[nm_siswa]')");
  
  //isi ke tabel profil siswa
  $jlhaspek = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM aspek"),0); // Jumlah aspek
  for ($i=1;$i<=$jlhaspek;$i++){ // aspek
  $jlhsubaspek = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM subaspek WHERE id_aspek='$i'"),0); // Jumlah subaspek
	for ($j=1;$j<=$jlhsubaspek;$j++){ // subaspek
		$subaspek = mysql_query("SELECT s.pi,s.jenis 
			FROM subaspek s,aspek a WHERE s.id_subaspek='$j' AND s.id_aspek='$i' AND s.id_aspek=a.id_aspek
			ORDER BY s.id_aspek,s.id_subaspek ASC");
		$npi=mysql_fetch_array($subaspek);
		$m[$i][$j] = $_POST['m'.$i.$j];
		$nps[$i][$j] = $m[$i][$j] - $npi[pi]; // nilai profil siswa - nilai profil ideal
		//konversi gap ke dalam bentuk bobot
		if ($nps[$i][$j] == 0){
			$tem[$i][$j]=3.5;
		}
		else if ($nps[$i][$j] == 1){
			$tem[$i][$j]=4;
		}
		else if ($nps[$i][$j] == -1){
			$tem[$i][$j]=3;
		}
		else if ($nps[$i][$j] == 2){
			$tem[$i][$j]=4.5;
		}
		else if ($nps[$i][$j] == -2){
			$tem[$i][$j]=2.5;
		}
		else if ($nps[$i][$j] == 3){
			$tem[$i][$j]=5;
		}
		else if ($nps[$i][$j] == -3){
			$tem[$i][$j]=2;
		}
		$n = $tem[$i][$j];
		mysql_query("INSERT INTO profil_siswa(id_siswa, id_aspek, id_subaspek, nilai_ps, jenis) VALUES('$_POST[id_siswa]', '$i', '$j', '$n', '$npi[jenis]')");
	}
	mysql_query("INSERT INTO profil_bobot(id_siswa, id_aspek) VALUES('$_POST[id_siswa]', '$i')");
  }
  
  //hitung nilai CF dan SF
  $siswa=$_POST[id_siswa];
  $jlhaspek1 = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM aspek"),0); // Jumlah aspek
  for ($i=1;$i<=$jlhaspek;$i++){ // hitung nilai CF
	$jlhcf = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM subaspek WHERE id_aspek='$i' AND jenis='core'"),0); // Jumlah cf
	for ($k=$siswa;$k<=$siswa;$k++){
		$sum_core=mysql_query("SELECT sum( p.nilai_ps ) AS core
		FROM profil_siswa p, subaspek s, aspek a
		WHERE p.id_subaspek = s.id_subaspek
		AND p.id_aspek = s.id_aspek
		AND a.id_aspek = s.id_aspek
		AND p.id_aspek = '$i'
		AND p.id_siswa = '$siswa'
		AND s.jenis = 'core'"); 
		$sumcore=mysql_fetch_array($sum_core);
		$tem_cf[$i][$k]=$sumcore[core]/$jlhcf;
		$cf=$tem_cf[$i][$k];
		mysql_query("UPDATE profil_bobot SET cf = '$cf' WHERE  id_siswa = '$siswa' AND id_aspek='$i'");
	}
  }
  $jlhaspek2 = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM aspek"),0); // Jumlah aspek
  for ($i=1;$i<=$jlhaspek2;$i++){ // hitung nilai SF
	$jlhsf = mysql_result(mysql_query("SELECT COUNT( * ) AS Num
			FROM subaspek
			WHERE id_aspek = '$i'
			AND jenis = 'second'"),0); // Jumlah sf
	for ($k=$siswa;$k<=$siswa;$k++){
		$sum_second=mysql_query("SELECT sum( p.nilai_ps ) AS secon
		FROM profil_siswa p, subaspek s, aspek a
		WHERE p.id_subaspek = s.id_subaspek
		AND p.id_aspek = s.id_aspek
		AND a.id_aspek = s.id_aspek
		AND p.id_aspek = '$i'
		AND p.id_siswa = '$siswa'
		AND s.jenis = 'second'");
		$sumsecond=mysql_fetch_array($sum_second);
		$tem_sf[$i][$k]=$sumsecond[secon]/$jlhsf;
		$sf=$tem_sf[$i][$k];
		mysql_query("UPDATE profil_bobot SET sf = '$sf' WHERE id_siswa = '$siswa' AND id_aspek='$i'");
	}
  }
  
  //Hitung nilai total CF dan SF
  $b_core = mysql_query("SELECT bobot_subaspek,jenis FROM bobot_subaspek WHERE jenis='core'");
  $bcore = mysql_fetch_array($b_core);
  $b_second = mysql_query("SELECT bobot_subaspek,jenis FROM bobot_subaspek WHERE jenis='second'");
  $bsecond = mysql_fetch_array($b_second);
  for ($i=1;$i<=$jlhaspek2;$i++){ 
	$n_total=mysql_query("SELECT cf,sf
		FROM profil_bobot
		WHERE id_aspek = '$i'
		AND id_siswa = '$siswa'");
	$ntotal = mysql_fetch_array($n_total);
	$ntotal_core=$ntotal[cf] * $bcore[bobot_subaspek];
	$ntotal_second=$ntotal[sf] * $bsecond[bobot_subaspek];
	$nototal=$ntotal_core + $ntotal_second;
	mysql_query("INSERT INTO profil_total(id_siswa, id_aspek, total) VALUES('$_POST[id_siswa]', '$i', '$nototal')");
  }
  
  //hitung perankingan
  $mototal=0;
  for ($i=1;$i<=$jlhaspek2;$i++){
	$m_core = mysql_query("SELECT bobot_aspek FROM bobot_aspek WHERE id_aspek='$i'");
	$mcore = mysql_fetch_array($m_core);
	$m_total=mysql_query("SELECT total
		FROM profil_total
		WHERE id_aspek = '$i'
		AND id_siswa = '$siswa'");
	$mtotal = mysql_fetch_array($m_total);
	$mtotal_core=$mtotal[total] * $mcore[bobot_aspek];
	$mototal+=$mtotal_core;
  }
  mysql_query("INSERT INTO hasil(id_siswa, bobot_siswa) VALUES('$_POST[id_siswa]', '$mototal')");
  
  header('location:../../indexs.php?modul='.$modul);
}

?>

