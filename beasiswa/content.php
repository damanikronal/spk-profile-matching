<?php
include "config/koneksi.php";
include "config/fungsi_indotgl.php";

// Bagian Home
if ($_GET[modul]=='beranda'){
  echo "<h2>Selamat Datang</h2>
          <p>Hai <b>$_SESSION[namauser]</b>, selamat datang di halaman ";
  if ($_SESSION[leveluser] == 'admin') { echo "<b>Administrator</b>"; }
  else if ($_SESSION[leveluser] == 'kepsek'){ echo "<b>Kepsek</b>"; }
  else if ($_SESSION[leveluser] == 'siswa'){ echo "<b>Siswa</b>"; }
  echo "  SPK Pemberian Beasiswa IPA Menengah Atas (SMA).<br>
		   Silahkan klik menu pilihan yang berada 
          di sebelah kiri untuk mengelola content website. </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p align=right>Login Hari ini: ";
  echo tgl_indo(date("Y m d")); 
  echo " | "; 
  echo date("H:i:s");
  echo "</p>";
}

//bagian siswa
elseif ($_GET[modul]=='siswa'){
  include "modul_admin/mod_siswa/siswa.php";
}

//bagian pengguna
elseif ($_GET[modul]=='pengguna'){
  include "modul_admin/mod_pengguna/pengguna.php";
}

//bagian jumlah penerima
elseif ($_GET[modul]=='seleksi'){
  include "modul_admin/mod_seleksi/seleksi.php";
}

// Bagian Aspek
elseif ($_GET[modul]=='aspek'){
  include "modul_admin/mod_aspek/aspek.php";
}

// Bagian Bobot Bobot Aspek
elseif ($_GET[modul]=='bobot_aspek'){
  include "modul_admin/mod_baspek/matrik.php";
}

// Bagian SubAspek
elseif ($_GET[modul]=='subaspek'){
  include "modul_admin/mod_subaspek/subaspek.php";
}

// Bagian Bobot SubAspek
elseif ($_GET[modul]=='bobot_subaspek'){
  include "modul_admin/mod_bsubaspek/matrik.php";
}

// Bagian Laporan Seleksi
elseif ($_GET[modul]=='laporan'){
  include "modul_admin/mod_laporan/laporan.php";
}

// Bagian Bantuan
elseif ($_GET[modul]=='bantuan'){
  include "bantuan.php";
}

// Bagian Tentang
elseif ($_GET[modul]=='tentang'){
  include "tentang.php";
}

// Apabila modul tidak ditemukan
else{
  echo "<p><b>MODUL BELUM ADA ATAU BELUM LENGKAP</b></p>";
}


?>