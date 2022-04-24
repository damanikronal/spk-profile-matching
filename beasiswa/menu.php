<?php
include "config/koneksi.php";

if ($_SESSION[leveluser]=='admin'){
  $sql=mysql_query("select * from menu where aktif='y' and status='admin' order by urutan");
}
else if ($_SESSION[leveluser]=='superadmin'){
  $sql=mysql_query("select * from menu where status='superadmin' and aktif='y' or urutan='1' or urutan='7' or urutan='8' order by urutan"); 
}
while ($m=mysql_fetch_array($sql)){  
  echo "<li><a href='$m[link]'>&#187; $m[menu]</a></li>";
}
?>
