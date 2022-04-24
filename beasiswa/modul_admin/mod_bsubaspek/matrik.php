<?php
$aksi="modul_admin/mod_bsubaspek/aksi_matrik.php";
switch($_GET[act]){
  // Tampil Matrik Perbandingan aspek
  default:
  	$tampil1=mysql_query("SELECT jenis, bobot_subaspek FROM bobot_subaspek ORDER BY jenis ASC");
	$r1=mysql_num_rows($tampil1);
	if ($r1 > 0){
    	echo "<h2>bobot_subaspek</h2>";
		echo "
			<table>
          <tr><th>jenis</th><th>bobot_subaspek</th></tr>"; 
		$tampil2=mysql_query("SELECT jenis, bobot_subaspek FROM bobot_subaspek ORDER BY jenis ASC");
		while ($r2=mysql_fetch_array($tampil2)){
		   echo "<tr>
				<td>subaspek $r2[jenis] factor</td>
				 <td>$r2[bobot_subaspek]</td>
				 </tr>";
		}
		echo "</table>";
		echo "<br>";
		echo "<a href=$aksi?modul=bobot_subaspek&act=hitungulang>Hitung ulang normalisasi bobot_subaspek.</a>";
	}
	else{
		echo "Belum dilakukan normalisasi bobot_subaspek. 
		<br><a href=?modul=bobot_subaspek&act=normalisasi>Buat Normalisasi bobot_subaspek</a>";
	}
    break;
  
  // Matrik Perbandingan
  case "normalisasi":
    echo "<h2>Normalisasi bobot_subaspek</h2>";
    echo "<form method='post' action='$aksi?modul=bobot_subaspek&act=normalisasi'>
		  <table>
          <tr><th>id aspek</th><th>bobot_subaspek</th></tr>"; 
	echo "<tr><td>core factor</td><td><input type=text name='core'></td></tr>";
	echo "<tr><td>secondary factor</td><td><input type=text name='second'></td></tr>";
    echo "</table>
	<input type='submit' name='Submit' value='Submit'><input type=button value=Batal onclick=self.history.back()></form>";
	break;
}
?>