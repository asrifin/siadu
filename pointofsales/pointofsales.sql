-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 26 Mar 2015 pada 11.18
-- Versi Server: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pointofsales`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_customer`
--

DROP TABLE IF EXISTS `pos_customer`;
CREATE TABLE IF NOT EXISTS `pos_customer` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nis` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `pos_customer`
--

INSERT INTO `pos_customer` (`id`, `nis`, `nama`, `kelas`) VALUES
(1, '123', 'BRYANT', '1'),
(2, '234', 'ALEXANDER', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_jenisproduk`
--

DROP TABLE IF EXISTS `pos_jenisproduk`;
CREATE TABLE IF NOT EXISTS `pos_jenisproduk` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `pos_jenisproduk`
--

INSERT INTO `pos_jenisproduk` (`id`, `nama`) VALUES
(1, 'SERAGAM'),
(3, 'BUKU');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_jenjang`
--

DROP TABLE IF EXISTS `pos_jenjang`;
CREATE TABLE IF NOT EXISTS `pos_jenjang` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `pos_jenjang`
--

INSERT INTO `pos_jenjang` (`id`, `nama`) VALUES
(1, 'Playgroup'),
(2, 'Kindegarden'),
(3, 'Elementary'),
(4, 'Primary');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_kelas`
--

DROP TABLE IF EXISTS `pos_kelas`;
CREATE TABLE IF NOT EXISTS `pos_kelas` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `jenjang` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `pos_kelas`
--

INSERT INTO `pos_kelas` (`id`, `nama`, `jenjang`) VALUES
(1, 'A', '3'),
(2, 'B', '2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_pembelian`
--

DROP TABLE IF EXISTS `pos_pembelian`;
CREATE TABLE IF NOT EXISTS `pos_pembelian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noinvoice` varchar(50) NOT NULL,
  `tgl` varchar(10) NOT NULL,
  `kodesupplier` varchar(50) NOT NULL,
  `carabayar` enum('Tunai','Kredit') NOT NULL DEFAULT 'Tunai',
  `total` varchar(50) NOT NULL,
  `discount` varchar(50) NOT NULL,
  `netto` varchar(50) NOT NULL,
  `bayar` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data untuk tabel `pos_pembelian`
--

INSERT INTO `pos_pembelian` (`id`, `noinvoice`, `tgl`, `kodesupplier`, `carabayar`, `total`, `discount`, `netto`, `bayar`, `user`) VALUES
(7, 'INV2603150001', '2015-03-26', 'SUP111', 'Tunai', '490000', '0', '490000', '500000', 'admin'),
(8, 'INV2603150002', '2015-03-26', 'SUP0019', 'Tunai', '720000', '5000', '715000', '720000', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_pembeliandetail`
--

DROP TABLE IF EXISTS `pos_pembeliandetail`;
CREATE TABLE IF NOT EXISTS `pos_pembeliandetail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `noinvoice` varchar(50) NOT NULL,
  `kodebarang` varchar(50) NOT NULL,
  `jumlah` varchar(50) NOT NULL,
  `harga` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data untuk tabel `pos_pembeliandetail`
--

INSERT INTO `pos_pembeliandetail` (`id`, `noinvoice`, `kodebarang`, `jumlah`, `harga`) VALUES
(14, 'INV2603150001', 'KEMEJA PUTRA', '2', '120000'),
(15, 'INV2603150001', 'DASI', '5', '50000'),
(16, 'INV2603150002', 'KEMEJA PUTRA', '6', '120000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_pembelianretur`
--

DROP TABLE IF EXISTS `pos_pembelianretur`;
CREATE TABLE IF NOT EXISTS `pos_pembelianretur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noretur` varchar(50) NOT NULL,
  `tgl` varchar(10) NOT NULL,
  `kodesupplier` varchar(50) NOT NULL,
  `total` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `pos_pembelianretur`
--

INSERT INTO `pos_pembelianretur` (`id`, `noretur`, `tgl`, `kodesupplier`, `total`, `user`) VALUES
(3, 'RTB2603150002', '2015-03-26', 'SUP111', '375000', 'admin'),
(4, 'RTB2603150003', '2015-03-26', 'SUP111', '115000', 'admin'),
(5, 'RTB2603150004', '2015-03-26', 'SUP0019', '240000', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_pembelianreturdetail`
--

DROP TABLE IF EXISTS `pos_pembelianreturdetail`;
CREATE TABLE IF NOT EXISTS `pos_pembelianreturdetail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `noretur` varchar(50) NOT NULL,
  `kodebarang` varchar(50) NOT NULL,
  `jumlah` varchar(50) NOT NULL,
  `harga` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `pos_pembelianreturdetail`
--

INSERT INTO `pos_pembelianreturdetail` (`id`, `noretur`, `kodebarang`, `jumlah`, `harga`) VALUES
(3, 'RTB2603150002', 'BLOUSE PUTRI', '1', '115000'),
(4, 'RTB2603150002', 'JUMPER PUTRI', '2', '130000'),
(5, 'RTB2603150003', 'BLOUSE PUTRI', '1', '115000'),
(6, 'RTB2603150004', 'KEMEJA PUTRA', '2', '120000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_penjualan`
--

DROP TABLE IF EXISTS `pos_penjualan`;
CREATE TABLE IF NOT EXISTS `pos_penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nofaktur` varchar(50) NOT NULL,
  `tgl` varchar(10) NOT NULL,
  `kodecustomer` varchar(50) NOT NULL,
  `carabayar` enum('Tunai','Kredit') NOT NULL DEFAULT 'Tunai',
  `total` varchar(50) NOT NULL,
  `discount` varchar(50) NOT NULL,
  `netto` varchar(50) NOT NULL,
  `bayar` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `pos_penjualan`
--

INSERT INTO `pos_penjualan` (`id`, `nofaktur`, `tgl`, `kodecustomer`, `carabayar`, `total`, `discount`, `netto`, `bayar`, `user`) VALUES
(1, 'FAK2603150001', '2015-03-26', '123', 'Tunai', '125000', '0', '125000', '125000', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_penjualandetail`
--

DROP TABLE IF EXISTS `pos_penjualandetail`;
CREATE TABLE IF NOT EXISTS `pos_penjualandetail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nofaktur` varchar(50) NOT NULL,
  `kodebarang` varchar(50) NOT NULL,
  `jumlah` varchar(50) NOT NULL,
  `harga` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `pos_penjualandetail`
--

INSERT INTO `pos_penjualandetail` (`id`, `nofaktur`, `kodebarang`, `jumlah`, `harga`) VALUES
(1, 'FAK2603150001', 'CELANA PUTRA', '1', '125000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_penjualanretur`
--

DROP TABLE IF EXISTS `pos_penjualanretur`;
CREATE TABLE IF NOT EXISTS `pos_penjualanretur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noretur` varchar(50) NOT NULL,
  `tgl` varchar(10) NOT NULL,
  `kodecustomer` varchar(50) NOT NULL,
  `total` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `pos_penjualanretur`
--

INSERT INTO `pos_penjualanretur` (`id`, `noretur`, `tgl`, `kodecustomer`, `total`, `user`) VALUES
(2, 'RTJ2603150001', '2015-03-26', '123', '75000', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_penjualanreturdetail`
--

DROP TABLE IF EXISTS `pos_penjualanreturdetail`;
CREATE TABLE IF NOT EXISTS `pos_penjualanreturdetail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `noretur` varchar(50) NOT NULL,
  `kodebarang` varchar(50) NOT NULL,
  `jumlah` varchar(50) NOT NULL,
  `harga` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `pos_penjualanreturdetail`
--

INSERT INTO `pos_penjualanreturdetail` (`id`, `noretur`, `kodebarang`, `jumlah`, `harga`) VALUES
(2, 'RTJ2603150001', 'KAOS OR', '1', '75000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_produk`
--

DROP TABLE IF EXISTS `pos_produk`;
CREATE TABLE IF NOT EXISTS `pos_produk` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `jenis` int(5) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jumlah` varchar(50) NOT NULL,
  `hargabeli` varchar(50) NOT NULL,
  `hargajual` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data untuk tabel `pos_produk`
--

INSERT INTO `pos_produk` (`id`, `jenis`, `kode`, `nama`, `jumlah`, `hargabeli`, `hargajual`) VALUES
(15, 1, 'BLOUSE PUTRI', 'BLOUSE PUTRI ', '100', '115000', '115000'),
(16, 1, 'JUMPER PUTRI', 'JUMPER PUTRI', '126', '130000', '130000'),
(17, 1, 'KEMEJA PUTRA', 'KEMEJA PUTRA', '412', '120000', '120000'),
(18, 1, 'CELANA PUTRA', 'CELANA PUTRA', '334', '125000', '125000'),
(19, 1, 'DASI', 'DASI', '532', '50000', '50000'),
(20, 1, 'KAOS OR', 'KAOS OLAH RAGA', '786', '75000', '75000'),
(21, 1, 'CELANA OR', 'CELANA OLAH RAGA', '562', '75000', '75000'),
(22, 1, 'TOPI', 'TOPI', '402', '55000', '55000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_situs`
--

DROP TABLE IF EXISTS `pos_situs`;
CREATE TABLE IF NOT EXISTS `pos_situs` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `email_master` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `judul_situs` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `url_situs` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `slogan` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci NOT NULL,
  `keywords` text COLLATE latin1_general_ci NOT NULL,
  `maxkonten` int(2) NOT NULL DEFAULT '5',
  `maxadmindata` int(2) NOT NULL DEFAULT '5',
  `maxdata` int(2) NOT NULL DEFAULT '5',
  `maxgalleri` int(2) NOT NULL DEFAULT '4',
  `widgetshare` int(2) NOT NULL DEFAULT '0',
  `theme` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT 'tcms',
  `author` text COLLATE latin1_general_ci NOT NULL,
  `alamatkantor` text COLLATE latin1_general_ci NOT NULL,
  `publishwebsite` int(1) NOT NULL DEFAULT '1',
  `publishnews` int(2) NOT NULL,
  `maxgalleridata` int(11) NOT NULL,
  `widgetkomentar` int(2) NOT NULL DEFAULT '1',
  `widgetpenulis` int(2) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `pos_situs`
--

INSERT INTO `pos_situs` (`id`, `email_master`, `judul_situs`, `url_situs`, `slogan`, `description`, `keywords`, `maxkonten`, `maxadmindata`, `maxdata`, `maxgalleri`, `widgetshare`, `theme`, `author`, `alamatkantor`, `publishwebsite`, `publishnews`, `maxgalleridata`, `widgetkomentar`, `widgetpenulis`) VALUES
(1, 'rekysda@gmail.com', 'Student Service', 'http://localhost/pointofsales/', 'Point Of Sales', 'WebDesign dengan sistem Responsive', 'sisfohrd,surabaya,indonesia', 5, 50, 5, 4, 3, 'pos', 'Elyon Christian School', 'Surabaya', 1, 1, 12, 1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_supplier`
--

DROP TABLE IF EXISTS `pos_supplier`;
CREATE TABLE IF NOT EXISTS `pos_supplier` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `pos_supplier`
--

INSERT INTO `pos_supplier` (`id`, `kode`, `nama`, `alamat`, `telepon`) VALUES
(1, 'SUP0019', 'CV. MAJU BERKAH', 'JAKARTA', '0215469856'),
(2, 'SUP111', 'CV. ADIPERKASA', 'SIDOARJO', '0312568899'),
(3, '111', 'PT. ADI JAYA', 'SURABAYA', '0315689523');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_useraura`
--

DROP TABLE IF EXISTS `pos_useraura`;
CREATE TABLE IF NOT EXISTS `pos_useraura` (
  `UserId` int(15) NOT NULL AUTO_INCREMENT,
  `user` varchar(250) NOT NULL DEFAULT '',
  `password` text NOT NULL,
  `email` varchar(250) NOT NULL DEFAULT '',
  `avatar` varchar(250) NOT NULL DEFAULT '',
  `level` enum('Administrator','Payroll','HRD') NOT NULL DEFAULT 'Administrator',
  `tipe` varchar(250) NOT NULL DEFAULT '',
  `is_online` int(5) NOT NULL DEFAULT '0',
  `last_ping` text NOT NULL,
  `start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `exp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `biodata` text NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data untuk tabel `pos_useraura`
--

INSERT INTO `pos_useraura` (`UserId`, `user`, `password`, `email`, `avatar`, `level`, `tipe`, `is_online`, `last_ping`, `start`, `exp`, `biodata`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'reky@teamworks.co.id', 'af0675a9e843c6c8f78163a9118efc78.jpg', 'Administrator', 'aktif', 1, '2015-03-23 08:18:22', '2010-08-27 00:00:00', '2034-08-27 00:00:00', '<p><b>none</b></p>'),
(28, 'superadmin', 'b11d5ece6353d17f85c5ad30e0a02360', 'reky@teamworks.co.id', '', 'Administrator', 'aktif', 1, '2015-03-21 23:05:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
