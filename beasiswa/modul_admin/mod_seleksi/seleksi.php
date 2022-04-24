<?php
$aksi="modul_admin/mod_seleksi/aksi_seleksi.php";
switch($_GET[act]){
  // Tampil jlh_penerima
  default:
    echo "<h2>Seleksi jumlah penerima beasiswa IPA SMA</h2>";
		
    echo "<table>
          <tr><th>jumlah penerima beasiswa ipa</th><th>aksi</th></tr>"; 
    $tampil=mysql_query("SELECT * FROM jlh_penerima");
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$r[jlh_penerima] orang</td>
             <td><a href=?modul=seleksi&act=edit&id=$r[jlh_penerima]>Edit</a>"; 
	               ?>
<?
	   echo "</td></tr>";
    }
    echo "</table>";
  break;
	
  // Form Edit Kategori  
  case "edit":
    $edit=mysql_query("SELECT * FROM jlh_penerima WHERE jlh_penerima='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit jlh_penerima beasiswa</h2>
          <form method=POST action=$aksi?modul=seleksi&act=update>
          <table>
 
		  <tr><td>jlh_penerima</td><td> : <input type=text name='jlh_penerima' value='$r[jlh_penerima]'></td></tr>";
	echo "<tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
?>

