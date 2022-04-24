<?php
$aksi="modul_admin/mod_aspek/aksi_aspek.php";
switch($_GET[act]){
  // Tampil Aspek
  default:
    echo "<h2>Manajemen Data Aspek Penilaian</h2>";
	$edit3=mysql_query("SELECT * FROM aspek ORDER BY id_aspek ASC");
	$jum=mysql_num_rows($edit3);
	if ($jum<2){
		echo "<input type=button value='Tambah aspek' 
          onclick=\"window.location.href='?modul=aspek&act=tambah';\">";
	}else if ($jum==2){  }
    echo "<table>
          <tr><th>id</th><th>aspek</th><th>aksi</th></tr>"; 
	// Paging
  	$hal = $_GET[hal];
	if(!isset($_GET['hal'])){ 
		$page = 1; 
		$hal = 1;
	} else { 
		$page = $_GET['hal']; 
	}
	$jmlperhalaman = 5;  // jumlah record per halaman
	$offset = (($page * $jmlperhalaman) - $jmlperhalaman);
    $tampil=mysql_query("SELECT * FROM aspek ORDER BY id_aspek ASC LIMIT $offset, $jmlperhalaman");
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$r[id_aspek]</td>
             <td>$r[nm_aspek]</td>
             <td><a href=?modul=aspek&act=edit&id=$r[id_aspek]>Edit</a> |"; 
	               ?>
	   <a href="modul_admin/mod_aspek/aksi_aspek.php?modul=aspek&act=hapus&id=<? echo "$r[id_aspek]"; ?>" target="_self" 
	 onClick="return confirm('Apakah Anda yakin menghapus data ini ?' +  '\n' 
							+ ' <?php echo "- Kode aspek  = $r[id_aspek]"; ?> ' +  '\n' 
							+ ' <?php echo "- aspek = $r[nm_aspek]"; ?> ' +  '\n \n'
						+ ' Jika YA silahkan klik OK, Jika TIDAK klik BATAL.')">Hapus</a></td>
<?
	   echo "</td></tr>";
    }
    echo "</table>";
	// membuat nomor halaman
	$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM aspek"),0);
	$total_halaman = ceil($total_record / $jmlperhalaman);
	echo "<center>Halaman :<br/>"; 
	$perhal=4;
	if($hal > 1){ 
		$prev = ($page - 1); 
		echo "<a href=indexs.php?modul=aspek&hal=$prev> << </a> "; 
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
				echo "<a href=indexs.php?modul=aspek&hal=$i>$i</a> "; 
		}
		} 
	}
	if($hal < $total_halaman){ 
		$next = ($page + 1); 
		echo "<a href=indexs.php?modul=aspek&hal=$next>>></a>"; 
	} 
	echo "</center><br/>";
    break;
  
  // Form Tambah Kategori
  case "tambah":
    include "config/otomasi.php";
    echo "<h2>Tambah aspek</h2>
          <form method=POST action='$aksi?modul=aspek&act=input'>
          <table>
          <tr><td>Id</td><td> : <input readonly type=text name='id_aspek' value='$val_otocri'></td></tr>
		  <tr><td>aspek</td><td> : <input type=text name='nm_aspek'></td></tr>
          <tr><td colspan=2><input type=submit name=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit Kategori  
  case "edit":
    $edit=mysql_query("SELECT * FROM aspek WHERE id_aspek='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit aspek</h2>
          <form method=POST action=$aksi?modul=aspek&act=update>
          <input type=hidden name=id value='$r[id_aspek]'>
          <table>
          <tr><td>Id</td><td> : <input type=text readonly name='id_aspek' value='$r[id_aspek]'></td></tr>
		  <tr><td>aspek</td><td> : <input type=text name='nm_aspek' value='$r[nm_aspek]'></td></tr>";
	echo "<tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
?>

