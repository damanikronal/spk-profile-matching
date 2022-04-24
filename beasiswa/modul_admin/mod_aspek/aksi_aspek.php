<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];

// Hapus aspek
if ($modul=='aspek' AND $act=='hapus'){
  mysql_query("DELETE FROM aspek WHERE id_aspek='$_GET[id]'");
  mysql_query("DELETE FROM bobot_aspek WHERE id_aspek='$_GET[id]'");
  mysql_query("DELETE FROM subaspek WHERE id_aspek='$_GET[id]'");
  header('location:../../indexs.php?modul='.$modul);
}

// Input aspek
elseif ($modul=='aspek' AND $act=='input'){
  mysql_query("INSERT INTO aspek(id_aspek, nm_aspek) VALUES('$_POST[id_aspek]', '$_POST[nm_aspek]')");
  header('location:../../indexs.php?modul='.$modul);
}

// Update aspek
elseif ($modul=='aspek' AND $act=='update'){
  mysql_query("UPDATE aspek SET id_aspek = '$_POST[id_aspek]', nm_aspek = '$_POST[nm_aspek]' WHERE id_aspek = '$_POST[id]'");
  header('location:../../indexs.php?modul='.$modul);
}
?>
