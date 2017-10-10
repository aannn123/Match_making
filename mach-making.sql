-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 03, 2017 at 09:11 AM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mach-making`
--

-- --------------------------------------------------------

--
-- Table structure for table `ciri_fisik`
--

CREATE TABLE `ciri_fisik` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tinggi` varchar(255) NOT NULL,
  `berat` varchar(255) NOT NULL,
  `warna_kulit` enum('sangat putih','putih','kuning langsat','kuning','sawo matang','coklat','gelap') NOT NULL,
  `suku` varchar(255) NOT NULL,
  `jenggot` enum('dicukur','tipis','sedang','panjang') DEFAULT NULL,
  `hijab` enum('sangat panjang','panjang','sedang','kecil','belum berhijab') DEFAULT NULL,
  `cadar` enum('ya','tidak','setelah menikah') DEFAULT NULL,
  `kaca_mata` enum('ya','tidak') NOT NULL,
  `status_kesehatan` enum('sehat','masalah kesehatan serius','cacat fisik ringan','cacat fisik serius') NOT NULL,
  `ciri_fisik_lain` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ciri_fisik`
--

INSERT INTO `ciri_fisik` (`id`, `user_id`, `tinggi`, `berat`, `warna_kulit`, `suku`, `jenggot`, `hijab`, `cadar`, `kaca_mata`, `status_kesehatan`, `ciri_fisik_lain`, `updated_at`, `created_at`) VALUES
(24, 12, '1111', '111', 'putih', 'sdasd', NULL, 'sedang', 'tidak', 'tidak', 'sehat', 'dsadsad', '2017-09-28 02:01:50', '2017-09-27 13:12:31'),
(25, 11, '170', '58', 'putih', 'Betawi', 'tipis', NULL, NULL, 'tidak', 'masalah kesehatan serius', 'sadsad', '2017-09-28 02:03:07', '2017-09-27 15:35:01'),
(26, 13, '160', '56', 'sangat putih', 'betawi', NULL, 'belum berhijab', 'ya', 'ya', 'sehat', 'ddasda', '2017-09-28 03:17:18', '2017-09-28 03:17:18'),
(27, 19, '178', '61', 'kuning langsat', 'Betawi', 'tipis', NULL, NULL, 'tidak', 'sehat', 'Bagus', '2017-09-29 06:15:44', '2017-09-29 06:15:44');

-- --------------------------------------------------------

--
-- Table structure for table `dipoligami`
--

CREATE TABLE `dipoligami` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kesiapan` enum('bersedia','kurang yakin','tidak bersedia') NOT NULL,
  `penjelasan_kesiapan` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dipoligami`
--

INSERT INTO `dipoligami` (`id`, `user_id`, `kesiapan`, `penjelasan_kesiapan`, `updated_at`, `created_at`) VALUES
(1, 12, 'kurang yakin', 'lolasda', '2017-09-28 01:49:32', '2017-09-27 13:12:39'),
(2, 13, 'bersedia', 'asdasdasd', '2017-09-28 03:17:23', '2017-09-28 03:17:23');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `images` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `user_id`, `images`, `created_at`, `updated_at`, `deleted`) VALUES
(46, 12, 'img-20170930-59cf922937f94.jpg', '2017-09-30 12:46:33', '2017-09-30 12:46:33', 0),
(47, 12, 'img-20170930-59cf922a3af88.jpg', '2017-09-30 12:46:34', '2017-09-30 12:46:34', 0),
(48, 12, 'img-20170930-59cf922ba835c.jpg', '2017-09-30 12:46:35', '2017-09-30 12:46:35', 0),
(49, 12, 'img-20170930-59cf9255960af.jpg', '2017-09-30 12:47:17', '2017-09-30 12:47:17', 0),
(50, 12, 'img-20170930-59cf92c4f309c.jpg', '2017-09-30 12:49:08', '2017-09-30 12:49:08', 0),
(51, 12, 'img-20170930-59cf92cb8b67a.jpg', '2017-09-30 12:49:15', '2017-09-30 12:49:15', 0),
(52, 12, 'img-20170930-59cf92d8a6154.jpg', '2017-09-30 12:49:28', '2017-09-30 12:49:28', 0),
(53, 12, 'img-20170930-59cf95629fa34.jpg', '2017-09-30 13:00:18', '2017-09-30 13:00:18', 0),
(54, 12, 'img-20170930-59cf9579231ec.jpg', '2017-09-30 13:00:41', '2017-09-30 13:00:41', 0),
(55, 12, 'img-20170930-59cf95a324aa2.jpg', '2017-09-30 13:01:23', '2017-09-30 13:01:23', 0),
(56, 12, 'img-20170930-59cf95ad9c21c.jpg', '2017-09-30 13:01:33', '2017-09-30 13:01:33', 0),
(57, 12, 'img-20170930-59cf95bc32a97.jpg', '2017-09-30 13:01:48', '2017-09-30 13:01:48', 0),
(58, 12, 'img-20170930-59cf95e7b12e8.jpg', '2017-09-30 13:02:31', '2017-09-30 13:02:31', 0),
(59, 11, 'img-20170930-59cf970be4776.jpg', '2017-09-30 13:07:23', '2017-09-30 13:07:23', 0),
(61, 11, 'img-20170930-59cf97b384748.png', '2017-09-30 13:10:11', '2017-09-30 13:10:11', 0),
(62, 11, 'img-20170930-59cf9a90857b4.jpg', '2017-09-30 13:22:24', '2017-09-30 13:22:24', 0),
(63, 13, 'img-20171001-59d0756a0ab12.jpg', '2017-10-01 04:56:10', '2017-10-01 04:56:10', 0),
(64, 13, 'img-20171001-59d07576cc841.png', '2017-10-01 04:56:22', '2017-10-01 04:56:22', 0),
(65, 13, 'img-20171001-59d0be071c585.jpg', '2017-10-01 10:05:59', '2017-10-01 10:05:59', 0),
(66, 12, 'img-20171001-59d0ea3c8e4ef.jpg', '2017-10-01 13:14:36', '2017-10-01 13:14:36', 0),
(67, 12, 'img-20171001-59d0f78c382ab.png', '2017-10-01 14:11:24', '2017-10-01 14:11:24', 0),
(68, 12, 'img-20171001-59d0f7c735ef8.jpg', '2017-10-01 14:12:23', '2017-10-01 14:12:23', 0),
(69, 11, 'img-20171001-59d0f8cd4cdde.jpg', '2017-10-01 14:16:45', '2017-10-01 14:16:45', 0);

-- --------------------------------------------------------

--
-- Table structure for table `keseharian`
--

CREATE TABLE `keseharian` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `merokok` enum('masih','tidak','pernah') NOT NULL,
  `status_pekerjaan` enum('full-time','part-time','rumah tangga','pensiun',' tidak bekerja','pelajar/mahasiswa','lainnya') NOT NULL,
  `penghasilan_per_bulan` enum('tidak bekerja','di bawah Rp 1 juta','Rp 1 juta - Rp 2,5 juta','Rp 2,5 juta - Rp 5 juta','Rp 5 juta - Rp 10 juta','Rp 10 juta - Rp 30 juta','di atas Rp 30 juta') NOT NULL,
  `status` enum('belum menikah','menikah 1 istri','menikah 2 istri','menikah 3 istri','menikah 4 istri','janda bercerai','janda karena meninggal','duda bercerai','duda karena meninggal') NOT NULL,
  `jumlah_anak` int(11) NOT NULL,
  `status_tinggal` enum('rumah sendiri','rumah sewa','bersama orang tua','bersama teman') NOT NULL,
  `memiliki_cicilan` enum('ya, syari','ya, riba','tidak') NOT NULL,
  `bersedia_pindah_tinggal` enum('ya','mungkin','tidak') NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keseharian`
--

INSERT INTO `keseharian` (`id`, `user_id`, `pekerjaan`, `merokok`, `status_pekerjaan`, `penghasilan_per_bulan`, `status`, `jumlah_anak`, `status_tinggal`, `memiliki_cicilan`, `bersedia_pindah_tinggal`, `updated_at`, `created_at`) VALUES
(1, 12, 'asddsa', 'tidak', 'part-time', 'tidak bekerja', 'belum menikah', 0, 'rumah sendiri', 'tidak', 'ya', '2017-09-28 02:13:33', '2017-09-27 12:44:32'),
(2, 11, 'yes', 'tidak', 'part-time', 'di bawah Rp 1 juta', 'menikah 1 istri', 0, 'rumah sewa', 'ya, riba', 'mungkin', '2017-09-28 02:14:22', '2017-09-27 15:34:45'),
(3, 13, 'asdsad', 'masih', 'part-time', 'di bawah Rp 1 juta', 'menikah 4 istri', 0, 'rumah sewa', 'ya, riba', 'mungkin', '2017-09-28 02:55:19', '2017-09-28 02:55:19'),
(4, 19, 'pemain bola', 'tidak', 'part-time', 'di atas Rp 30 juta', 'belum menikah', 0, 'rumah sendiri', 'tidak', 'ya', '2017-09-29 06:14:37', '2017-09-29 06:14:37');

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `id` int(11) NOT NULL,
  `id_provinsi` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id`, `id_provinsi`, `nama`) VALUES
(32, 1, 'Jakarta'),
(33, 2, 'Denpasar'),
(34, 2, 'Singaraja'),
(35, 2, 'Kuta, Badung'),
(36, 3, 'Bekasi'),
(37, 3, 'Bandung'),
(38, 3, 'Bogor'),
(39, 3, 'Depok'),
(40, 3, 'Tasikmalaya'),
(41, 4, 'Surabaya'),
(42, 4, 'Malang'),
(43, 4, 'Madiun'),
(44, 5, 'Semarang'),
(45, 5, 'Tegal'),
(46, 5, 'Magelang'),
(47, 6, 'Kota gede'),
(48, 6, 'Wates'),
(49, 6, 'Bantul'),
(50, 6, 'Sleman'),
(51, 7, 'Banda Aceh'),
(52, 7, 'Kota Sabang'),
(53, 7, 'Kota Langsa'),
(54, 8, 'Jayapura'),
(55, 9, 'Pringsewu'),
(56, 10, 'Serang'),
(57, 11, 'Pekanbaru'),
(58, 12, 'Samarinda'),
(59, 13, 'Medan'),
(60, 14, 'Kupang'),
(61, 15, 'Mataram'),
(62, 16, 'Kota'),
(63, 17, 'Ambon'),
(64, 18, 'Batam'),
(65, 19, 'Padang'),
(66, 20, 'Palembang'),
(67, 21, 'Pontianak'),
(68, 22, 'Banjarmasin'),
(69, 23, 'Jambi'),
(70, 24, 'Manado'),
(71, 25, 'Barito'),
(72, 26, 'Bengkulu'),
(73, 27, 'Pangkal Pinang'),
(74, 28, 'Kota Waisai,Raja Ampat'),
(75, 29, 'Kendari'),
(76, 30, 'Gorontalo'),
(77, 31, 'Makassar'),
(78, 31, 'Ternate');

-- --------------------------------------------------------

--
-- Table structure for table `latar-belakang`
--

CREATE TABLE `latar-belakang` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `latar_belakang`
--

CREATE TABLE `latar_belakang` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pendidikan` enum('sd','smp','sma','diploma 1','diploma 3','diploma 4','strata 1','magister','doktor','lainya') NOT NULL,
  `penjelasan_pendidikan` text NOT NULL,
  `agama` enum('ngaji sunnah','sedang hijrah','islam biasa') NOT NULL,
  `penjelasan_agama` text NOT NULL,
  `muallaf` enum('ya','tidak') DEFAULT NULL,
  `baca_quran` enum('setiap hari','minimal seminggu sekali','minimal sebulan sekali','sedang belajar') NOT NULL,
  `hafalan` enum('surat-surat pendek','1-3 juz','3-10 juz','10-20 juz','30 juz') NOT NULL,
  `keluarga` enum('sudah paham sunnah','sedang proses hijrah','islam biasa') NOT NULL,
  `penjelasan_keluarga` text NOT NULL,
  `shalat` enum('5 waktu di masjid','5 waktu tidak di masjid','belum 5 waktu','belum shalat') NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `latar_belakang`
--

INSERT INTO `latar_belakang` (`id`, `user_id`, `pendidikan`, `penjelasan_pendidikan`, `agama`, `penjelasan_agama`, `muallaf`, `baca_quran`, `hafalan`, `keluarga`, `penjelasan_keluarga`, `shalat`, `updated_at`, `create_at`) VALUES
(1, 12, 'smp', 'lol', 'islam biasa', 'sadads', 'tidak', 'setiap hari', '1-3 juz', 'islam biasa', 'sadsad', '5 waktu tidak di masjid', '2017-09-28 02:09:56', '2017-09-27 12:44:59'),
(2, 11, 'smp', 'lol', 'sedang hijrah', 'bismillah', 'tidak', 'minimal seminggu sekali', '1-3 juz', 'islam biasa', 'asdsad', '5 waktu tidak di masjid', '2017-09-28 02:10:12', '2017-09-27 15:34:54'),
(3, 13, 'smp', 'asdsad', 'islam biasa', 'lolololol', 'ya', 'setiap hari', '1-3 juz', 'sudah paham sunnah', 'lolololo', 'belum 5 waktu', '2017-09-28 03:12:31', '2017-09-28 03:12:31'),
(4, 19, 'magister', 'Bagus Bagsusad Bagsusad', 'sedang hijrah', 'Baus', 'ya', 'minimal seminggu sekali', 'surat-surat pendek', 'islam biasa', 'Bagus', '5 waktu tidak di masjid', '2017-09-29 06:15:18', '2017-09-29 06:15:18');

-- --------------------------------------------------------

--
-- Table structure for table `negara`
--

CREATE TABLE `negara` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `negara`
--

INSERT INTO `negara` (`id`, `nama`) VALUES
(1, 'Indonesia'),
(2, 'Malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phinxlog`
--

INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20170826051026, 'CreateUserTable', '2017-09-27 06:30:18', '2017-09-27 06:30:19', 0),
(20170826051100, 'CreateNegaraTable', '2017-09-27 06:30:19', '2017-09-27 06:30:20', 0),
(20170826051111, 'CreateProvinsiTable', '2017-09-27 06:30:20', '2017-09-27 06:30:20', 0),
(20170826051130, 'CreateKotaTable', '2017-09-27 06:30:20', '2017-09-27 06:30:21', 0),
(20170826051137, 'CreateProfilTable', '2017-09-27 06:30:21', '2017-09-27 06:30:21', 0),
(20170826051148, 'CreateCiriFisikTable', '2017-09-27 06:30:21', '2017-09-27 06:30:22', 0),
(20170826051200, 'CreateKeseharianTable', '2017-09-27 06:30:22', '2017-09-27 06:30:22', 0),
(20170826051209, 'CreateLatarBelakangTable', '2017-09-27 06:30:22', '2017-09-27 06:30:22', 0),
(20170826051221, 'CreatePoligamiTable', '2017-09-27 06:30:23', '2017-09-27 06:30:23', 0),
(20170826051226, 'CreateDipoligamiTable', '2017-09-27 06:30:23', '2017-09-27 06:30:23', 0),
(20170826051239, 'CreateRequestTaarufTable', '2017-09-27 06:30:23', '2017-09-27 06:30:24', 0),
(20170826051547, 'CreateNotificationTable', '2017-09-27 06:30:24', '2017-09-27 06:30:24', 0),
(20170826055057, 'CreateTokensTable', '2017-09-27 06:30:24', '2017-09-27 06:30:24', 0),
(20170828052626, 'CreateTableRegister', '2017-09-27 06:30:24', '2017-09-27 06:30:25', 0),
(20170929080848, 'CreateTableImages', '2017-09-30 08:11:57', '2017-09-30 08:11:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `poligami`
--

CREATE TABLE `poligami` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kesiapan` enum('siap','belum siap') NOT NULL,
  `penjelasan_kesiapan` text NOT NULL,
  `alasan_poligami` text,
  `kondisi_istri` enum('belum mengizinkan','sudah mengizinkan','mendukung dan membantu mencarikan','belum punya istri') DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `poligami`
--

INSERT INTO `poligami` (`id`, `user_id`, `kesiapan`, `penjelasan_kesiapan`, `alasan_poligami`, `kondisi_istri`, `updated_at`, `created_at`) VALUES
(1, 11, 'siap', 'yes', 'yes', 'sudah mengizinkan', '2017-09-28 01:53:10', '2017-09-27 15:35:05'),
(2, 12, 'siap', 'lolasda', 'lol', 'belum mengizinkan', '2017-09-28 01:51:50', '2017-09-28 01:34:59'),
(7, 13, 'siap', 'dsfsdfds', 'sadasdas', 'belum mengizinkan', '2017-09-29 06:19:38', '2017-09-29 06:19:38'),
(11, 7, 'siap', '\r\nasaSADS\r\n', NULL, NULL, '2017-09-29 06:23:19', '2017-09-29 06:23:19'),
(12, 19, 'siap', 'dsadasdsa', '', NULL, '2017-09-29 06:23:31', '2017-09-29 06:23:31');

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `umur` int(11) NOT NULL,
  `kota` int(11) NOT NULL,
  `provinsi` int(11) NOT NULL,
  `kewarganegaraan` int(11) NOT NULL,
  `target_menikah` date NOT NULL,
  `tentang_saya` text NOT NULL,
  `pasangan_harapan` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`id`, `user_id`, `nama_lengkap`, `tanggal_lahir`, `tempat_lahir`, `alamat`, `umur`, `kota`, `provinsi`, `kewarganegaraan`, `target_menikah`, `tentang_saya`, `pasangan_harapan`, `updated_at`, `created_at`) VALUES
(9, 3, 'Farhan Mustaqiem', '2001-01-26', 'Bekasi', 'Bekasi', 16, 32, 1, 1, '1025-10-01', 'Baik', 'Cantik', '2017-09-27 07:15:04', '2017-09-27 07:15:04'),
(10, 4, 'Yazid', '2001-01-26', 'Bekasi', 'Bekasi', 16, 32, 1, 1, '1025-10-01', 'Baik', 'Cantik', '2017-09-27 07:15:04', '2017-09-27 07:15:04'),
(11, 5, 'Farhan Mustaqiem', '2001-01-26', 'Bekasi', 'Bekasi', 16, 32, 1, 1, '1025-10-01', 'Baik', 'Cantik', '2017-09-27 07:15:04', '2017-09-27 07:15:04'),
(12, 6, 'Yazid', '2001-01-26', 'Bekasi', 'Bekasi', 16, 32, 1, 1, '1025-10-01', 'Baik', 'Cantik', '2017-09-27 07:15:04', '2017-09-27 07:15:04'),
(13, 7, 'Alya', '2001-01-26', 'Bekasi', 'Bekasi', 16, 32, 1, 1, '1025-10-01', 'Baik', 'Ganteng', '2017-09-27 07:15:04', '2017-09-27 07:15:04'),
(14, 8, 'Nadia', '2001-01-26', 'Bekasi', 'Bekasi', 16, 32, 1, 1, '1025-10-01', 'Baik', 'Ganteng', '2017-09-27 07:15:04', '2017-09-27 07:15:04'),
(15, 9, 'Alya ya', '2001-01-26', 'Bekasi', 'Bekasi', 16, 32, 1, 1, '1025-10-01', 'Baik', 'Ganteng', '2017-09-27 07:15:04', '2017-09-27 07:15:04'),
(16, 10, 'Nadia ya', '2001-01-26', 'Bekasi', 'Bekasi', 16, 32, 1, 1, '1025-10-01', 'Baik', 'Ganteng', '2017-09-27 07:15:04', '2017-09-27 07:15:04'),
(17, 12, 'Nadia', '2001-09-09', 'Bekasi', 'Bekasi', 16, 51, 1, 2, '2021-09-09', 'sdasd', 'asdsa', '2017-09-28 13:42:41', '2017-09-27 12:44:04'),
(18, 11, 'Farhan Mustaqim', '2017-09-18', 'asdasddsadsa', 'dasdas', 19, 51, 1, 1, '2017-09-28', 'sdasd', 'dsada', '2017-09-28 02:21:43', '2017-09-27 15:34:35'),
(19, 13, 'Nada Zaskia', '2017-09-11', 'Bandung', 'Bandung Jawa Barat', 21, 51, 2, 1, '2017-09-28', 'Bagus', 'Hanteng', '2017-09-28 02:47:15', '2017-09-28 02:47:15'),
(20, 19, 'Tsubasa', '2017-09-17', 'Bekasi', 'Bekasi', 19, 56, 10, 2, '2017-09-10', 'bafus', 'Cantik', '2017-09-29 06:14:13', '2017-09-29 06:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id` int(11) NOT NULL,
  `id_negara` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `provinsi`
--

INSERT INTO `provinsi` (`id`, `id_negara`, `nama`) VALUES
(1, 1, 'DKI Jakarta'),
(2, 1, 'Bali'),
(3, 1, 'Jawa Barat'),
(4, 1, 'Jawa Timur'),
(5, 1, 'Jawa Tengah'),
(6, 1, 'DIY Jogyakarta'),
(7, 1, 'Aceh'),
(8, 1, 'Papua'),
(9, 1, 'Lampung'),
(10, 1, 'Banten'),
(11, 1, 'Riau'),
(12, 1, 'Kalimantan Timur'),
(13, 1, 'Sumatera Utara'),
(14, 1, 'Nusa Tenggara Timur'),
(15, 1, 'Nusa Tenggara Barat'),
(16, 1, 'Maluku'),
(17, 1, 'Kepulauan Riau'),
(18, 1, 'Sulawesi Tengah'),
(19, 1, 'Sumatera Barat'),
(20, 1, 'Sumatera Selatan'),
(21, 1, 'Kalimantan Barat'),
(22, 1, 'Kalimantan Selatan'),
(23, 1, 'Jambi'),
(24, 1, 'Sulawesi Utara'),
(25, 1, 'Kalimantan Tengah'),
(26, 1, 'Bengkulu'),
(27, 1, 'Kepulauan Bangka Belitung'),
(28, 1, 'Papua Barat'),
(29, 1, 'Sulawesi Tenggara'),
(30, 1, 'Gorontalo'),
(31, 1, 'Sulawesi Barat'),
(32, 1, 'Maluku Utara');

-- --------------------------------------------------------

--
-- Table structure for table `registers`
--

CREATE TABLE `registers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expired_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `request_taaruf`
--

CREATE TABLE `request_taaruf` (
  `id` int(11) NOT NULL,
  `id_perequest` int(11) NOT NULL,
  `id_terequest` int(11) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '0',
  `blokir` int(1) NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `request_taaruf`
--

INSERT INTO `request_taaruf` (`id`, `id_perequest`, `id_terequest`, `status`, `blokir`, `updated_at`, `created_at`) VALUES
(102, 11, 7, 2, 0, '2017-10-02 13:12:30', '2017-10-02 13:10:05'),
(103, 2, 11, 2, 2, '2017-10-02 13:11:32', '2017-10-02 13:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `login_at` datetime NOT NULL,
  `expired_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `user_id`, `token`, `login_at`, `expired_date`) VALUES
(1, 11, '7eab636132b8b1f3b18f18086fb4cc54', '2017-10-02 20:35:06', '2017-10-02 20:35:06'),
(2, 7, '1201777bec656776a88ac9529896448f', '2017-09-27 14:22:24', '2017-09-27 14:22:24'),
(3, 12, 'cd0ed65027c9a5fa6d6d6a47dca63c89', '2017-10-01 21:41:49', '2017-10-01 21:41:49'),
(4, 13, '1ed7d12c02828cd1f30d706b20de982f', '2017-10-01 16:55:02', '2017-10-01 16:55:02'),
(5, 1, '57a4d1dbc717696db5724ae12bad177f', '2017-09-30 15:05:29', '2017-09-30 15:05:29'),
(6, 19, 'c87ea647375f5546d2e7e9d20650ed68', '2017-09-30 19:43:02', '2017-09-30 19:43:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `gender` enum('laki-laki','perempuan') NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `ktp` varchar(255) NOT NULL,
  `role` int(3) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT '0',
  `last_online` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `gender`, `email`, `phone`, `password`, `photo`, `ktp`, `role`, `status`, `last_online`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 'admin', 'laki-laki', 'admin111@gmail.com', '089604702886', '$2y$10$BavbfINxWu30EoBL/qf8Bu1tSgZZbXjsLnpNFKHzoGmMhe/wnsuBi', 'user.png', 'user.png', 1, '0', '2017-09-27 07:01:00', '2017-09-27 07:01:00', '2017-09-27 07:01:00', 0),
(2, 'moderator', 'laki-laki', 'moderator123@gmail.com', '089604702886', '$2y$10$Pd5rdi.mW4uBTl6DTcvomeiasVblvFxFnGTn5TVGc1OJc/SjgUgFC', 'avatar.png', 'avatar.png', 2, '2', '2017-09-27 07:17:51', '2017-09-27 07:01:00', '2017-09-27 07:17:51', 0),
(3, 'farhan', 'laki-laki', 'farhan.mustqm123@gmail.com', '089604702886', '$2y$10$KNYtVYa0TsZ4yv3TaVkuZOOLd65sahct9nnItZSs3d/lLewoEmhaW', 'avatar.png', 'avatar.png', 0, '2', '2017-09-27 07:17:46', '2017-09-27 07:01:00', '2017-09-27 07:17:46', 0),
(4, 'yazid', 'laki-laki', 'yazid123@gmail.com', '089604702886', '$2y$10$jpgSF0vy8ER0cbIzgiHuHOXguZK1G84PTugaR96lpZfK6aiq9TFg2', 'avatar.png', 'avatar.png', 0, '2', '2017-09-27 07:17:42', '2017-09-27 07:01:00', '2017-09-27 07:17:42', 0),
(5, 'farhan123', 'laki-laki', 'farhan.mustqm1234@gmail.com', '089604702886', '$2y$10$9yBrvh2SeOBlUb4Ky2zFWe0NAxnPMoTuITQm7R.C769mTzy1nZJES', 'avatar.png', 'avatar.png', 0, '2', '2017-09-27 07:17:36', '2017-09-27 07:01:00', '2017-09-27 07:17:36', 0),
(6, 'yazid123', 'laki-laki', 'yazid1234@gmail.com', '089604702886', '$2y$10$3CdXTdcxYS.du6Tm6hsOKeSWyzerLqPg4je53X2IT82Q6kS0LiGWq', 'avatar.png', 'avatar.png', 0, '2', '2017-09-27 07:17:31', '2017-09-27 07:01:00', '2017-09-27 07:17:31', 0),
(7, 'alya', 'perempuan', 'alya123@gmail.com', '089604702886', '$2y$10$WeWqlrxfUW3PN8wfFQN//eWI9u5cXHnNd3UulwlRR5pFhGceKclp.', 'avatar.png', 'avatar.png', 0, '2', '2017-09-27 07:21:44', '2017-09-27 07:01:00', '2017-09-27 07:21:44', 0),
(8, 'nadia', 'perempuan', 'nadia@gmail.com', '089604702886', '$2y$10$zM4VALOEtQ2cJDfgSQKSLOHSai5Gk5DU5SgkDIWk1PbTW/L5hZhrm', 'avatar.png', 'avatar.png', 0, '2', '2017-09-27 07:17:20', '2017-09-27 07:01:00', '2017-09-27 07:17:20', 0),
(9, 'alya123', 'perempuan', 'alya1234@gmail.com', '089604702886', '$2y$10$zU1xhD.M.rEwbRipF463L.LINSJdzz1003XiAAMbtXXOLFLwRwSWK', 'avatar.png', 'avatar.png', 0, '2', '2017-09-27 07:17:13', '2017-09-27 07:01:00', '2017-09-27 07:17:13', 0),
(10, 'nadia123', 'perempuan', 'nadia123@gmail.com', '089604702886', '$2y$10$ObJQmJ8MlpKXXUG/SKuZIOJs25GivxH.YpZtRhVL5u0NBQI4gVKPe', 'avatar.png', 'avatar.png', 0, '2', '2017-09-27 07:17:02', '2017-09-27 07:01:00', '2017-09-27 07:17:02', 0),
(11, 'farhan1243', 'laki-laki', 'farhan@gmail.com', '0899760975', '$2y$10$WeWqlrxfUW3PN8wfFQN//eWI9u5cXHnNd3UulwlRR5pFhGceKclp.', 'img-20171001-59d0f8cd4cdde.jpg', 'img-20170927-59cbc4f661523.jpg', 0, '2', '2017-10-01 14:16:53', '2017-09-27 07:10:08', '2017-10-01 14:16:53', 0),
(12, 'test123', 'perempuan', 'test@gmail.com', '0899760975', '$2y$10$OKJ6UXPuoEjTnaKEiBNJNOxncDcE9HjNY8iklmfSnop0H2Hh2IXAO', 'img-20171001-59d0ea3c8e4ef.jpg', 'img-20170927-59cb9ce3c1927.png', 0, '2', '2017-10-01 14:34:49', '2017-09-27 12:41:42', '2017-10-01 14:34:49', 0),
(13, 'nadaa', 'perempuan', 'nada@gmail.com', '0899760975', '$2y$10$OKJ6UXPuoEjTnaKEiBNJNOxncDcE9HjNY8iklmfSnop0H2Hh2IXAO', 'img-20171001-59d0be071c585.jpg', 'img-20170929-59cde3a794b73', 0, '2', '2017-10-01 10:05:59', '2017-09-28 02:41:40', '2017-10-01 10:05:59', 0),
(14, 'hjbjhbhj', 'perempuan', 'asdasdFarhansasuke123@yahoo.com', '242342342', '$2y$10$xiFTi1g6fEhnba6FOnF.FOxfXMYKvsrlYq/46BuW9npztl36e9vv6', 'avatar.png', 'avatar.png', 0, '1', '2017-09-28 06:27:00', '2017-09-28 06:26:26', '2017-09-28 06:27:00', 0),
(19, 'tsubasa', 'laki-laki', 'tsubasa123@gmail.com', '089998079675', '$2y$10$7fEC67EVL72c4fRuex6dRuCHLInDJX9GgVAf2om5igFKd6jiJ4SSy', 'img-20170929-59cde8142b1a9.jpg', 'img-20170929-59cde7599a2f9.png', 0, '2', '2017-09-29 06:28:36', '2017-09-29 06:10:47', '2017-09-29 06:28:36', 0),
(25, 'sakdasdksand', 'perempuan', 'dsadsa@jdnadjks.com', '324i2904u2390', '$2y$10$HmIMISgBMWPRkps18s4rne2QevFjrOGIpf4OB6q24cA9wV6fnya3e', 'avatar.png', 'avatar.png', 0, '0', '2017-09-30 06:13:10', '2017-09-30 06:13:10', '2017-09-30 06:13:10', 0),
(26, 'farhan111111', 'perempuan', 'farasdsahan.mustqm@gmail.com', '0899960759', '$2y$10$Ycx9WC6pPfU8kQ8reo5F8.4IbSQ6zCRVgLr4YUeYqukpmQ/PNS4eq', 'avatar.png', 'avatar.png', 0, '0', '2017-09-30 06:15:30', '2017-09-30 06:15:30', '2017-09-30 06:15:30', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ciri_fisik`
--
ALTER TABLE `ciri_fisik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `dipoligami`
--
ALTER TABLE `dipoligami`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `keseharian`
--
ALTER TABLE `keseharian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`),
  ADD KEY `id_provinsi` (`id_provinsi`);

--
-- Indexes for table `latar-belakang`
--
ALTER TABLE `latar-belakang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `latar_belakang`
--
ALTER TABLE `latar_belakang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `negara`
--
ALTER TABLE `negara`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `poligami`
--
ALTER TABLE `poligami`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `kota` (`kota`),
  ADD KEY `provinsi` (`provinsi`),
  ADD KEY `kewarganegaraan` (`kewarganegaraan`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`),
  ADD KEY `id_negara` (`id_negara`);

--
-- Indexes for table `registers`
--
ALTER TABLE `registers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `request_taaruf`
--
ALTER TABLE `request_taaruf`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_perequest` (`id_perequest`),
  ADD KEY `id_terequest` (`id_terequest`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`,`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ciri_fisik`
--
ALTER TABLE `ciri_fisik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `dipoligami`
--
ALTER TABLE `dipoligami`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `keseharian`
--
ALTER TABLE `keseharian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `kota`
--
ALTER TABLE `kota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `latar-belakang`
--
ALTER TABLE `latar-belakang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `latar_belakang`
--
ALTER TABLE `latar_belakang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `negara`
--
ALTER TABLE `negara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `poligami`
--
ALTER TABLE `poligami`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `provinsi`
--
ALTER TABLE `provinsi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `registers`
--
ALTER TABLE `registers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `request_taaruf`
--
ALTER TABLE `request_taaruf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ciri_fisik`
--
ALTER TABLE `ciri_fisik`
  ADD CONSTRAINT `ciri_fisik_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `dipoligami`
--
ALTER TABLE `dipoligami`
  ADD CONSTRAINT `dipoligami_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `keseharian`
--
ALTER TABLE `keseharian`
  ADD CONSTRAINT `keseharian_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `kota`
--
ALTER TABLE `kota`
  ADD CONSTRAINT `kota_ibfk_1` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsi` (`id`);

--
-- Constraints for table `latar_belakang`
--
ALTER TABLE `latar_belakang`
  ADD CONSTRAINT `latar_belakang_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `poligami`
--
ALTER TABLE `poligami`
  ADD CONSTRAINT `poligami_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `profil_ibfk_2` FOREIGN KEY (`kota`) REFERENCES `kota` (`id`),
  ADD CONSTRAINT `profil_ibfk_3` FOREIGN KEY (`provinsi`) REFERENCES `provinsi` (`id`),
  ADD CONSTRAINT `profil_ibfk_4` FOREIGN KEY (`kewarganegaraan`) REFERENCES `negara` (`id`);

--
-- Constraints for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD CONSTRAINT `provinsi_ibfk_1` FOREIGN KEY (`id_negara`) REFERENCES `negara` (`id`);

--
-- Constraints for table `registers`
--
ALTER TABLE `registers`
  ADD CONSTRAINT `registers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `request_taaruf`
--
ALTER TABLE `request_taaruf`
  ADD CONSTRAINT `request_taaruf_ibfk_1` FOREIGN KEY (`id_perequest`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `request_taaruf_ibfk_2` FOREIGN KEY (`id_terequest`) REFERENCES `users` (`id`);

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
