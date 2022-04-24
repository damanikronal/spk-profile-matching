<?php
$aksi="modul_admin/mod_siswa/aksi_siswa.php";
switch($_GET[act]){
  // Tampil siswa
  default:
    echo "<h2>Manajemen Data Siswa</h2>";
	if ($_SESSION[leveluser] == 'admin'){
    	echo "<input type=button value='Tambah Siswa' onclick=\"window.location.href='?modul=siswa&act=tambah';\">";
	}
    echo "<table>
          <tr><th>id_siswa</th><th>nama siswa</th><th>aksi</th></tr>"; 
	// Paging
  	$hal = $_GET[hal];
	if(!isset($_GET['hal'])){ 
		$page = 1; 
		$hal = 1;
	} else { 
		$page = $_GET['hal']; 
	}
	$jmlperhalaman = 10;  // jumlah record per halaman
	$offset = (($page * $jmlperhalaman) - $jmlperhalaman);
    $tampil=mysql_query("SELECT id_siswa,nm_siswa FROM siswa LIMIT $offset, $jmlperhalaman");
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr>
			 <td>$r[id_siswa]</td>
             <td>$r[nm_siswa]</td>
			 <td>";
		     //echo "<td><a href=?modul=siswa&act=edit&id=$r[nis]>Edit</a> | ";
?>
		<a href="modul_admin/mod_siswa/aksi_siswa.php?modul=siswa&act=hapus&id=<? echo "$r[id_siswa]"; ?>" target="_self" 
	 onClick="return confirm('Untuk edit data ini,Anda harus hapus data ini dahulu.' +  '\n'
							+ 'Apakah Anda yakin untuk hapus data ini ?' +  '\n'
							+ ' <?php echo "- Id Siswa  = $r[id_siswa]"; ?> ' +  '\n'
							+ ' <?php echo "- Nama Siswa = $r[nm_siswa]"; ?> ' +  '\n \n' 
						+ ' Jika YA silahkan klik OK, Jika TIDAK klik BATAL.')">Edit</a> |
	   <a href="modul_admin/mod_siswa/aksi_siswa.php?modul=siswa&act=hapus&id=<? echo "$r[id_siswa]"; ?>" target="_self" 
	 onClick="return confirm('Apakah Anda yakin menghapus data ini ?' +  '\n' 
							+ ' <?php echo "- Id Siswa  = $r[id_siswa]"; ?> ' +  '\n'
							+ ' <?php echo "- Nama Siswa = $r[nm_siswa]"; ?> ' +  '\n \n' 
						+ ' Jika YA silahkan klik OK, Jika TIDAK klik BATAL.')">Hapus</a></td>            
<?	   
	   echo "</tr>";
    }
    echo "</table>";
	// membuat nomor halaman
	if ($_SESSION[leveluser] == 'admin'){
		$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM siswa"),0);
	}
	else if ($_SESSION[leveluser] == 'siswa'){
		$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM siswa WHERE nis='$_SESSION[namauser]'"),0);
	}
	$total_halaman = ceil($total_record / $jmlperhalaman);
	echo "<center>Halaman :<br/>"; 
	$perhal=4;
	if($hal > 1){ 
		$prev = ($page - 1); 
		echo "<a href=indexs.php?modul=siswa&hal=$prev> << </a> "; 
	}
	if($total_halaman<=10){
	$hal1=1;
	$hal2=$total_halaman;
	}else{
	$hal1=$hal-$perhal;
	$hal2=$hal+$perhal;
	}
	if($hal<=5){
	$hal1=1;
	}
	if($hal<$total_halaman){
	$hal2=$hal+$perhal;
	}else{
	$hal2=$hal;
	}
	for($i = $hal1; $i <= $hal2; $i++){ 
		if(($hal) == $i){ 
			echo "[<b>$i</b>] "; 
			} else { 
		if($i<=$total_halaman){
				echo "<a href=indexs.php?modul=siswa&hal=$i>$i</a> "; 
		}
		} 
	}
	if($hal < $total_halaman){ 
		$next = ($page + 1); 
		echo "<a href=indexs.php?modul=siswa&hal=$next>>></a>"; 
	} 
	echo "</center><br/>";
    break;
  
  case "tambah":
  require_once "config/otomasi.php";
    echo "<h2>Tambah Siswa</h2>
          <form method=POST action='$aksi?modul=siswa&act=input'>
          <table>
          ";
	echo "<tr><td>id</td> <td> : <input readonly type=text name='id_siswa' size=30 value='$val_otosis'></td></tr>
		  <tr><td>nama siswa</td>   <td> : <input type=text name='nm_siswa' size=20></td>
		  </tr>";
	echo "<tr><td colspan='2' align='center'>Evaluasi Siswa</td></tr>";
	$jlhaspek = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM aspek"),0); // Jumlah aspek
	for ($i=1; $i<=$jlhaspek; $i++){
		$jlhsubaspek = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM subaspek WHERE id_aspek='$i'"),0); // Jumlah subaspek
		$queri1=mysql_query("SELECT * FROM aspek WHERE id_aspek='$i' ORDER BY id_aspek ASC");
		$r3=mysql_fetch_array($queri1);
		for ($j=1; $j<=$jlhsubaspek; $j++){
			$queri2=mysql_query("SELECT s.id_subaspek,s.id_aspek,s.nm_subaspek,a.nm_aspek 
			FROM subaspek s,aspek a WHERE s.id_subaspek='$j' AND s.id_aspek='$i' AND s.id_aspek=a.id_aspek
			ORDER BY id_aspek,id_subaspek ASC");
			$subaspek2=mysql_fetch_array($queri2);
			echo "<tr>";
			echo "<td>
			<input type=hidden name='id_subaspek".$i.$j."' value='$subaspek2[id_subaspek]'>$subaspek2[nm_subaspek]</td>
			<td> : ";
			echo "<select name='m".$i.$j."'>";
			if ($subaspek2[id_aspek] == '1'){
				  require "config/skala.html";
			}
			else if (($subaspek2[id_aspek] == '2') AND ($subaspek2[id_subaspek] == '1')){
				  require "config/skala_anak.html";
			}
			else if (($subaspek2[id_aspek] == '2') AND ($subaspek2[id_subaspek] == '2')){
				  require "config/skala_gaji.html";
			}
			else if (($subaspek2[id_aspek] == '2') AND ($subaspek2[id_subaspek] == '3')){
				  require "config/skala_tanggungan.html";
			}
			else if (($subaspek2[id_aspek] == '2') AND ($subaspek2[id_subaspek] == '4')){
				  require "config/skala_payah.html";
			}
			else if (($subaspek2[id_aspek] == '2') AND ($subaspek2[id_subaspek] == '5')){
				  require "config/skala_pibu.html";
			}
			echo "</select>**aspek $subaspek2[nm_aspek]";
			//echo "<input type=text name='m".$i.$j."'>**aspek $subaspek2[nm_aspek]";
			echo "</td></tr>";
		}
	}	  
	echo "<tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
    
}
?>
