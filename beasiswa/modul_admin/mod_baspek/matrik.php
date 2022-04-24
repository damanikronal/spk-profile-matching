<?php
$aksi="modul_admin/mod_baspek/aksi_matrik.php";
switch($_GET[act]){
  // Tampil Matrik Perbandingan aspek
  default:
  	$tampil1=mysql_query("SELECT id_aspek, bobot_aspek FROM bobot_aspek ORDER BY id_aspek");
	$r1=mysql_num_rows($tampil1);
	if ($r1 > 0){
    	echo "<h2>bobot_aspek</h2>";
		echo "
			<table>
          <tr><th>aspek</th><th>bobot_aspek</th></tr>"; 
		$tampil2=mysql_query("SELECT a.nm_aspek, b.bobot_aspek, b.id_aspek
		 FROM aspek a, bobot_aspek b
		 WHERE b.id_aspek=a.id_aspek
		 ORDER BY b.id_aspek,a.id_aspek ASC");
		while ($r2=mysql_fetch_array($tampil2)){
		   echo "<tr>
				<td>$r2[nm_aspek]</td>
				 <td>$r2[bobot_aspek]</td>
				 </tr>";
		}
		echo "</table>";
		echo "<br>";
		echo "<a href=$aksi?modul=bobot_aspek&act=hitungulang>Hitung ulang normalisasi bobot_aspek.</a>";
	}
	else{
		echo "Belum dilakukan normalisasi bobot_aspek. 
		<br><a href=?modul=bobot_aspek&act=normalisasi>Buat Normalisasi bobot_aspek</a>";
	}
    break;
  
  // Matrik Perbandingan
  case "normalisasi":
    echo "<h2>Normalisasi bobot_aspek</h2>";
    echo "<form method='post' action='$aksi?modul=bobot_aspek&act=normalisasi'>
		  <table>
          <tr><th>id aspek</th><th>bobot_aspek</th></tr>"; 
    $jlhaspek = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM aspek"),0); // Jumlah aspek
	for ($j=1; $j<=$jlhaspek; $j++){
		$queri2=mysql_query("SELECT * FROM aspek WHERE id_aspek='$j' ORDER BY id_aspek ASC");
		$aspek2=mysql_fetch_array($queri2);
		echo "<tr>";
		echo "
		<td>$aspek2[nm_aspek]<input type=hidden name='id_aspek".$j."' value='$aspek2[id_aspek]'></td>
		<td><input type=text name='bobot_aspek".$j."'></td>
			 ";
		echo "</tr>";
	}
	
    echo "</table>
	<input type='submit' name='Submit' value='Submit'><input type=button value=Batal onclick=self.history.back()></form>";
	break;
}
?>