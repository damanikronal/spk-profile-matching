-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 20. Maret 2013 jam 05:17
-- Versi Server: 5.0.67
-- Versi PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `profil_beasiswa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `aspek`
--

CREATE TABLE IF NOT EXISTS `aspek` (
  `id_aspek` int(3) NOT NULL,
  `nm_aspek` varchar(100) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id_aspek`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `aspek`
--

INSERT INTO `aspek` (`id_aspek`, `nm_aspek`) VALUES
(1, 'akademik'),
(2, 'ekonomi keluarga');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bobot_aspek`
--

CREATE TABLE IF NOT EXISTS `bobot_aspek` (
  `id_aspek` int(3) NOT NULL,
  `bobot_aspek` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `bobot_aspek`
--

INSERT INTO `bobot_aspek` (`id_aspek`, `bobot_aspek`) VALUES
(2, 0.55),
(1, 0.45);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bobot_subaspek`
--

CREATE TABLE IF NOT EXISTS `bobot_subaspek` (
  `jenis` enum('core','second') collate latin1_general_ci NOT NULL,
  `bobot_subaspek` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `bobot_subaspek`
--

INSERT INTO `bobot_subaspek` (`jenis`, `bobot_subaspek`) VALUES
('core', 0.6),
('second', 0.4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE IF NOT EXISTS `hasil` (
  `id_siswa` int(3) NOT NULL,
  `bobot_siswa` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`id_siswa`, `bobot_siswa`) VALUES
(1, 3.31708),
(2, 3.52167),
(3, 3.40542);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jlh_penerima`
--

CREATE TABLE IF NOT EXISTS `jlh_penerima` (
  `jlh_penerima` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `jlh_penerima`
--

INSERT INTO `jlh_penerima` (`jlh_penerima`) VALUES
(2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu` varchar(30) collate latin1_general_ci NOT NULL,
  `link` varchar(50) collate latin1_general_ci NOT NULL,
  `status` enum('admin','superadmin') collate latin1_general_ci NOT NULL,
  `aktif` enum('y','n') collate latin1_general_ci NOT NULL,
  `urutan` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`menu`, `link`, `status`, `aktif`, `urutan`) VALUES
('Aspek', '?modul=aspek', 'superadmin', 'y', 2),
('Sub Aspek', '?modul=subaspek', 'superadmin', 'y', 4),
('Bobot subaspek', '?modul=bobot_subaspek', 'superadmin', 'y', 5),
('Bobot aspek', '?modul=bobot_aspek', 'superadmin', 'y', 3),
('Siswa', '?modul=siswa', 'admin', 'y', 6),
('Laporan', '?modul=laporan', 'admin', 'y', 7),
('Jumlah Penerima ', '?modul=seleksi', 'admin', 'y', 1),
('Pengguna', '?modul=pengguna', 'admin', 'y', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE IF NOT EXISTS `pengguna` (
  `username` varchar(30) collate latin1_general_ci NOT NULL,
  `password` varchar(32) collate latin1_general_ci NOT NULL,
  `level` enum('admin','superadmin') collate latin1_general_ci NOT NULL default 'admin',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`username`, `password`, `level`) VALUES
('karen', 'ba952731f97fb058035aa399b1cb3d5c', 'admin'),
('super', '1b3231655cebb7a1f783eddf27d254ca', 'superadmin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_bobot`
--

CREATE TABLE IF NOT EXISTS `profil_bobot` (
  `id_siswa` int(3) NOT NULL,
  `id_aspek` int(3) NOT NULL,
  `cf` float NOT NULL,
  `sf` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `profil_bobot`
--

INSERT INTO `profil_bobot` (`id_siswa`, `id_aspek`, `cf`, `sf`) VALUES
(1, 2, 3.25, 3.33333),
(1, 1, 3.375, 3.33333),
(2, 2, 3.5, 3.66667),
(2, 1, 3, 4.16667),
(3, 1, 3.625, 3.5),
(3, 2, 3, 3.66667);

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_siswa`
--

CREATE TABLE IF NOT EXISTS `profil_siswa` (
  `id_siswa` int(3) NOT NULL,
  `id_aspek` int(3) NOT NULL,
  `id_subaspek` int(3) NOT NULL,
  `nilai_ps` float NOT NULL,
  `jenis` enum('core','second') collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `profil_siswa`
--

INSERT INTO `profil_siswa` (`id_siswa`, `id_aspek`, `id_subaspek`, `nilai_ps`, `jenis`) VALUES
(1, 2, 5, 3.5, 'second'),
(1, 2, 4, 3.5, 'second'),
(1, 2, 3, 3, 'second'),
(1, 2, 2, 3.5, 'core'),
(1, 2, 1, 3, 'core'),
(1, 1, 7, 3, 'second'),
(1, 1, 6, 4, 'second'),
(1, 1, 5, 3, 'core'),
(1, 1, 4, 4, 'core'),
(1, 1, 3, 3.5, 'core'),
(1, 1, 2, 3, 'core'),
(1, 1, 1, 3, 'second'),
(2, 2, 5, 4.5, 'second'),
(2, 2, 4, 4, 'second'),
(2, 2, 3, 2.5, 'second'),
(2, 2, 2, 3.5, 'core'),
(2, 2, 1, 3.5, 'core'),
(2, 1, 7, 4, 'second'),
(2, 1, 6, 4.5, 'second'),
(2, 1, 5, 2.5, 'core'),
(2, 1, 4, 3.5, 'core'),
(2, 1, 3, 3, 'core'),
(2, 1, 2, 3, 'core'),
(2, 1, 1, 4, 'second'),
(3, 1, 1, 3.5, 'second'),
(3, 1, 2, 4, 'core'),
(3, 1, 3, 3.5, 'core'),
(3, 1, 4, 4, 'core'),
(3, 1, 5, 3, 'core'),
(3, 1, 6, 4, 'second'),
(3, 1, 7, 3, 'second'),
(3, 2, 1, 3, 'core'),
(3, 2, 2, 3, 'core'),
(3, 2, 3, 3, 'second'),
(3, 2, 4, 4, 'second'),
(3, 2, 5, 4, 'second');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_total`
--

CREATE TABLE IF NOT EXISTS `profil_total` (
  `id_siswa` varchar(3) collate latin1_general_ci NOT NULL,
  `id_aspek` int(3) NOT NULL,
  `total` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `profil_total`
--

INSERT INTO `profil_total` (`id_siswa`, `id_aspek`, `total`) VALUES
('2', 1, 3.46667),
('1', 1, 3.35833),
('1', 2, 3.28333),
('2', 2, 3.56667),
('3', 1, 3.575),
('3', 2, 3.26667);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE IF NOT EXISTS `siswa` (
  `id_siswa` int(3) NOT NULL,
  `nm_siswa` varchar(100) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id_siswa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nm_siswa`) VALUES
(1, 'Andi'),
(2, 'Susi'),
(3, 'Nita');

-- --------------------------------------------------------

--
-- Struktur dari tabel `subaspek`
--

CREATE TABLE IF NOT EXISTS `subaspek` (
  `id_subaspek` int(3) NOT NULL,
  `nm_subaspek` text collate latin1_general_ci NOT NULL,
  `pi` int(3) NOT NULL,
  `id_aspek` int(3) NOT NULL,
  `jenis` enum('core','second') collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `subaspek`
--

INSERT INTO `subaspek` (`id_subaspek`, `nm_subaspek`, `pi`, `id_aspek`, `jenis`) VALUES
(1, 'nilai agama', 7, 1, 'second'),
(2, 'nilai matematika', 8, 1, 'core'),
(3, 'nilai kimia', 8, 1, 'core'),
(4, 'nilai fisika', 8, 1, 'core'),
(5, 'nilai biologi', 8, 1, 'core'),
(6, 'nilai bahasa inggris', 7, 1, 'second'),
(7, 'nilai bahasa indonesia', 7, 1, 'second'),
(1, 'status anak', 8, 2, 'core'),
(2, 'gaji rata2 ortu/bln', 8, 2, 'core'),
(3, 'jumlah tanggungan ortu', 7, 2, 'second'),
(4, 'pekerjaan ayah', 7, 2, 'second'),
(5, 'pekerjaan ibu', 7, 2, 'second');
