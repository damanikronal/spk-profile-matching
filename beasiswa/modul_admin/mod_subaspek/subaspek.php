<?php
$aksi="modul_admin/mod_subaspek/aksi_subaspek.php";
switch($_GET[act]){
  // Tampil subaspek
  default:
    echo "<h2>Manajemen Data subaspek Penilaian</h2>
		<form method=POST action='?modul=subaspek&act=tambah'>";
	$edit3=mysql_query("SELECT * FROM aspek ORDER BY id_aspek ASC");
	$jum=mysql_num_rows($edit3);
	if ($jum>=1){
		echo "<tr><td>aspek</td><td> : <select name='id_aspek'>";
		while ($r3=mysql_fetch_array($edit3)){
			echo "<option value='$r3[id_aspek]'>$r3[nm_aspek]</option>";
		}
		echo "</select>
		<input type=submit value='Tambah subaspek'>";
	echo "	
		</form>
          <table>
          <tr><th>id</th><th>subaspek</th><th>profil ideal</th><th>jenis subaspek</th><th>aspek</th><th>aksi</th></tr>"; 
	// Paging
  	$hal = $_GET[hal];
	if(!isset($_GET['hal'])){ 
		$page = 1; 
		$hal = 1;
	} else { 
		$page = $_GET['hal']; 
	}
	$jmlperhalaman = 12;  // jumlah record per halaman
	$offset = (($page * $jmlperhalaman) - $jmlperhalaman);
    $tampil=mysql_query("SELECT s.id_subaspek,s.nm_subaspek,a.nm_aspek,s.id_aspek,s.jenis,s.pi
	FROM subaspek s,aspek a 
	WHERE s.id_aspek=a.id_aspek
	ORDER BY s.id_aspek,s.id_subaspek ASC LIMIT $offset, $jmlperhalaman");
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$r[id_subaspek]</td>
             <td>$r[nm_subaspek]</td>
			 <td>$r[pi]</td>
			 <td>$r[jenis] factor</td>
			 <td>$r[nm_aspek]</td>
             <td><a href=?modul=subaspek&act=edit&id=$r[id_subaspek]&aspek=$r[id_aspek]>Edit</a> |"; 
	               ?>
	<?php
		$besar1=mysql_query("SELECT s.id_subaspek FROM subaspek s,aspek a WHERE s.id_aspek=a.id_aspek AND s.id_aspek='1' ORDER BY s.id_subaspek DESC");
		$besar2=mysql_query("SELECT s.id_subaspek FROM subaspek s,aspek a WHERE s.id_aspek=a.id_aspek AND s.id_aspek='2' ORDER BY s.id_subaspek DESC");
		$cek_besar1=mysql_fetch_row($besar1);
		$cek_besar2=mysql_fetch_row($besar2);
		if ($r[id_aspek] == '1'){
			if ($r[id_subaspek] == $cek_besar1[0]){
	?>
			   <a href="modul_admin/mod_subaspek/aksi_subaspek.php?modul=subaspek&act=hapus&id=<? echo "$r[id_subaspek]"; ?>&aspek=<? echo "$r[id_aspek]"; ?>" target="_self" 
			 onClick="return confirm('Apakah Anda yakin menghapus data ini ?' +  '\n' 
									+ ' <?php echo "- Kode subaspek  = $r[id_subaspek]"; ?> ' +  '\n' 
									+ ' <?php echo "- subaspek = $r[nm_subaspek]"; ?> ' +  '\n \n'
								+ ' Jika YA silahkan klik OK, Jika TIDAK klik BATAL.')">Hapus</a></td>
	<?php
			}else{
	?>
				<a href="#"  
					 onClick="return confirm('Anda tidak bisa hapus data ini' +  '\n' 
											+ ' <?php echo "- Kode subaspek  = $r[id_subaspek]"; ?> ' +  '\n' 
											+ ' <?php echo "- subaspek = $r[nm_subaspek]"; ?> ' +  '\n \n'
										+ ' Untuk menghapus,harus dari id yang terbesar.')">Hapus</a></td>
	<?php
			}
		}
		else if ($r[id_aspek] == '2'){
			if ($r[id_subaspek] == $cek_besar2[0]){
	?>
				<a href="modul_admin/mod_subaspek/aksi_subaspek.php?modul=subaspek&act=hapus&id=<? echo "$r[id_subaspek]"; ?>&aspek=<? echo "$r[id_aspek]"; ?>" target="_self" 
						 onClick="return confirm('Apakah Anda yakin menghapus data ini ?' +  '\n' 
												+ ' <?php echo "- Kode subaspek  = $r[id_subaspek]"; ?> ' +  '\n' 
												+ ' <?php echo "- subaspek = $r[nm_subaspek]"; ?> ' +  '\n \n'
											+ ' Jika YA silahkan klik OK, Jika TIDAK klik BATAL.')">Hapus</a></td>
	<?php
			}else{
	?>
				<a href="#"  
						 onClick="return confirm('Anda tidak bisa hapus data ini' +  '\n' 
												+ ' <?php echo "- Kode subaspek  = $r[id_subaspek]"; ?> ' +  '\n' 
												+ ' <?php echo "- subaspek = $r[nm_subaspek]"; ?> ' +  '\n \n'
											+ ' Untuk menghapus,harus dari id yang terbesar.')">Hapus</a></td>
	<?php
			}
		}
	?>
<?php
	   echo "</td></tr>";
    }
    echo "</table>";
	// membuat nomor halaman
	$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM subaspek"),0);
	$total_halaman = ceil($total_record / $jmlperhalaman);
	echo "<center>Halaman :<br/>"; 
	$perhal=4;
	if($hal > 1){ 
		$prev = ($page - 1); 
		echo "<a href=indexs.php?modul=subaspek&hal=$prev> << </a> "; 
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
				echo "<a href=indexs.php?modul=subaspek&hal=$i>$i</a> "; 
		}
		} 
	}
	if($hal < $total_halaman){ 
		$next = ($page + 1); 
		echo "<a href=indexs.php?modul=subaspek&hal=$next>>></a>"; 
	} 
	echo "</center><br/>";
	}
	else { echo "Belum ada aspek. Buat aspek dahulu"; }
    break;
  
  // Form Tambah Subaspek
  case "tambah":
	include "config/otomasi.php";
		echo "<h2>Tambah subaspek</h2>
			  <form method=POST action='$aksi?modul=subaspek&act=input'>
			  <table>";
			  if ($_POST['id_aspek']=='1'){
				echo "<tr><td>Id</td><td> : <input readonly type=text name='id_subaspek' value='$val_otosub1'></td></tr>";
			  }else if ($_POST['id_aspek']=='2'){
				echo "<tr><td>Id</td><td> : <input readonly type=text name='id_subaspek' value='$val_otosub2'></td></tr>";
			  }
		echo "<tr><td>subaspek</td><td> : <input type=text name='nm_subaspek'></td></tr>";
		echo "<tr><td>nilai PI (profil ideal)</td><td> : <select name='pi'>";
				  require_once "config/skala.html";
		echo "</select></td></tr>";
		echo "<tr><td>jenis subaspek</td><td> : <select name='jenis'>
				  <option value='core'>Core Factor</option>
				  <option value='second'>Secondary Factor</option>
			   </select></td></tr>";
			$edit2=mysql_query("SELECT * FROM aspek ORDER BY id_aspek ASC");
				echo "<tr><td>aspek</td><td> : <select name='id_aspek'>";
				while ($r2=mysql_fetch_array($edit2)){
					if ($r2[id_aspek]==$_POST['id_aspek']){
						echo "<option value='$r2[id_aspek]' selected>$r2[nm_aspek]</option>";
					}
				}
		echo "</select></td></tr>  
			  <tr><td colspan=2><input type=submit name=submit value=Simpan>
								<input type=button value=Batal onclick=self.history.back()></td></tr>
			  </table></form>";
     break;
  
  // Form Edit Subaspek  
  case "edit":
    $edit=mysql_query("SELECT s.id_subaspek,s.nm_subaspek,s.jenis,a.nm_aspek,s.id_subaspek ,s.id_aspek
	FROM subaspek s,aspek a
	WHERE s.id_subaspek='$_GET[id]' AND s.id_aspek='$_GET[aspek]' AND s.id_aspek=a.id_aspek");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit subaspek</h2>
          <form method=POST action=$aksi?modul=subaspek&act=update>
          <input type=hidden name=id value='$r[id_subaspek]'>
          <table>
          <tr><td>Id</td><td> : <input type=text readonly name='id_subaspek' value='$r[id_subaspek]'></td></tr>
		  <tr><td>subaspek</td><td> : <input type=text name='nm_subaspek' value='$r[nm_subaspek]'></td></tr>";
	echo "<tr><td>nilai PI (profil ideal)</td><td> : <select name='pi'>";
				  require_once "config/skala.html";
		echo "</select></td></tr>";
	echo "<tr><td>jenis subaspek</td><td> : <select name='jenis'>";
		if ($r[jenis]=='core'){
		      echo "<option value='core' selected>Core Factor</option>
			  <option value='second'>Secondary Factor</option>";
		}
		else if ($r[jenis]=='second'){
		      echo "<option value='core'>Core Factor</option>
			  <option value='second' selected>Secondary Factor</option>";
		}
	echo "</select></td></tr>";
	$edit2=mysql_query("SELECT * FROM aspek ORDER BY id_aspek ASC");
			echo "<tr><td>aspek</td><td> : <select name='id_aspek'>";
			while ($r2=mysql_fetch_array($edit2)){
				if ($r2[id_aspek]==$r[id_aspek]){
					echo "<option value='$r2[id_aspek]' selected>$r2[nm_aspek]</option>";
				}
			}
	echo "</select></td></tr>";
	echo "<tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
?>

