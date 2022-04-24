<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];

// Hapus subaspek
if ($modul=='subaspek' AND $act=='hapus'){
  mysql_query("DELETE FROM subaspek WHERE id_subaspek='$_GET[id]' AND id_aspek='$_GET[aspek]'");
  header('location:../../indexs.php?modul='.$modul);
}

// Input subaspek
elseif ($modul=='subaspek' AND $act=='input'){
  mysql_query("INSERT INTO subaspek(id_subaspek, nm_subaspek, pi, jenis,id_aspek) VALUES('$_POST[id_subaspek]', '$_POST[nm_subaspek]', '$_POST[pi]', '$_POST[jenis]','$_POST[id_aspek]')");
  header('location:../../indexs.php?modul='.$modul);
}

// Update subaspek
elseif ($modul=='subaspek' AND $act=='update'){
  mysql_query("UPDATE subaspek SET id_subaspek = '$_POST[id_subaspek]', nm_subaspek = '$_POST[nm_subaspek]', pi = '$_POST[pi]', jenis = '$_POST[jenis]',id_aspek = '$_POST[id_aspek]' WHERE id_subaspek = '$_POST[id]' AND id_aspek='$_POST[id_aspek]'");
  header('location:../../indexs.php?modul='.$modul);
}
?>
