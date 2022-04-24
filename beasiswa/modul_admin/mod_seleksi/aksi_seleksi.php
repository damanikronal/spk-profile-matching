<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];


// Update jlh_penerima
if ($modul=='seleksi' AND $act=='update'){
  mysql_query("UPDATE jlh_penerima SET jlh_penerima = '$_POST[jlh_penerima]'");
  header('location:../../indexs.php?modul='.$modul);
}
?>
