<?php
$queri=mysql_query("SELECT * FROM hasil");
$hasil=mysql_num_rows($queri);
if ($hasil){
    echo "<h2>Laporan Hasil Seleksi Pemberian Beasiswa Dengan Metode Profile Matching</h2>
          <table>
          <tr><th>id_siswa</th><th>nm_siswa</th><th>bobot</th></tr>"; 
	$tampil1=mysql_query("SELECT * FROM jlh_penerima");
	$r1=mysql_fetch_array($tampil1);
	$tampil=mysql_query("SELECT s.id_siswa,s.nm_siswa,h.bobot_siswa 
							 FROM siswa s, hasil h
							 WHERE s.id_siswa=h.id_siswa
							 ORDER BY h.bobot_siswa DESC LIMIT $r1[jlh_penerima]");
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr>
             <td>$r[id_siswa]</td>
             <td>$r[nm_siswa]</td>
			 <td>$r[bobot_siswa]</td>
			 </tr>";
    }
    echo "</table>";
	echo "<br/>";
		
	echo "<h2>Cetak Laporan Dalam PDF</h2>
          <form method='POST' action='config/cetak.php'>
          <table>
		  ";
	echo "
		  <tr><td colspan=2><input type=submit name=submit value=Cetak ></td></tr>
          </table></form>"; 
}
else {
	echo "Belum ada laporan";
}

?>
