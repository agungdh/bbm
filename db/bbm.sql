-- Adminer 4.5.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomorinvoice` varchar(100) DEFAULT NULL,
  `id_spp` int(11) DEFAULT NULL,
  `tanggalinvoice` date DEFAULT NULL,
  `jatuhtempo` date DEFAULT NULL,
  `totaltagihan` decimal(15,2) DEFAULT '0.00',
  `statusbayar` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_spp` (`id_spp`),
  CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`id_spp`) REFERENCES `spp` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `invoice` (`id`, `nomorinvoice`, `id_spp`, `tanggalinvoice`, `jatuhtempo`, `totaltagihan`, `statusbayar`) VALUES
(20,  '112233', 14, '2018-01-31', '2018-02-05', 40250000.00,  0);

DROP TABLE IF EXISTS `isi_invoice`;
CREATE TABLE `isi_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_invoice` int(11) DEFAULT NULL,
  `id_spp` int(11) DEFAULT NULL,
  `hargainvoice` decimal(15,2) DEFAULT '0.00',
  `hargadasar` decimal(15,2) DEFAULT '0.00',
  `ppn` decimal(15,2) DEFAULT '0.00',
  `transport` decimal(15,2) DEFAULT '0.00',
  `pbbkb` decimal(15,2) DEFAULT '0.00',
  `totalharga` decimal(15,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `id_invoice` (`id_invoice`),
  KEY `id_spp` (`id_spp`),
  CONSTRAINT `isi_invoice_ibfk_1` FOREIGN KEY (`id_invoice`) REFERENCES `invoice` (`id`),
  CONSTRAINT `isi_invoice_ibfk_2` FOREIGN KEY (`id_spp`) REFERENCES `spp` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `isi_invoice` (`id`, `id_invoice`, `id_spp`, `hargainvoice`, `hargadasar`, `ppn`, `transport`, `pbbkb`, `totalharga`) VALUES
(17,  20, 14, 6500.00,  8050.00,  3250000.00, 2060000.00, 2440000.00, 40250000.00);

DROP TABLE IF EXISTS `kendaraan`;
CREATE TABLE `kendaraan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomorkendaraan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `kendaraan` (`id`, `nomorkendaraan`) VALUES
(1, 'BE 9432 FG'),
(2, 'BE 9463 FH');

DROP TABLE IF EXISTS `mutasiproduk`;
CREATE TABLE `mutasiproduk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_spp` int(11) DEFAULT NULL,
  `masuk` int(11) DEFAULT '0',
  `keluar` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_spp` (`id_spp`),
  CONSTRAINT `mutasiproduk_ibfk_2` FOREIGN KEY (`id_spp`) REFERENCES `spp` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `namapelanggan` varchar(100) DEFAULT NULL,
  `alamatpelanggan` varchar(200) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `npwp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pelanggan` (`id`, `namapelanggan`, `alamatpelanggan`, `kota`, `npwp`) VALUES
(1, 'PT. ADHITAMA SUKSES MAKMUR', 'Desa Mandah, Kecamatan Natar, Lampung Selatan',  'LAMPUNG SELATAN',  '74.858.026.3-331.000'),
(2, 'PT. ANUGRAH AGUNG SENTOSA',  'Asphalt Mixing Plant, Tiyuh Cahyou, Kec. Pagar Dewa, Tulang Bawang Barat', 'TULANG BAWANG',  '76.497.593.4-323.000');

DROP TABLE IF EXISTS `penawaran`;
CREATE TABLE `penawaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` int(11) DEFAULT NULL,
  `alamatkirim` varchar(200) DEFAULT NULL,
  `ppn` decimal(15,2) DEFAULT '0.00',
  `pbbkb` decimal(15,2) DEFAULT '0.00',
  `hargainvoice` decimal(15,2) DEFAULT '0.00',
  `transport` decimal(15,2) DEFAULT '0.00',
  `hargadasar` decimal(15,2) DEFAULT '0.00',
  `masaberlaku` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pelanggan` (`id_pelanggan`),
  CONSTRAINT `penawaran_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `penawaran` (`id`, `id_pelanggan`, `alamatkirim`, `ppn`, `pbbkb`, `hargainvoice`, `transport`, `hargadasar`, `masaberlaku`) VALUES
(5, 1,  'Nunggalrejo',  650.00, 488.00, 6500.00,  412.00, 8050.00,  '2018-02-15');

DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `namaproduk` varchar(50) DEFAULT NULL,
  `stok` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `produk` (`id`, `namaproduk`, `stok`) VALUES
(1, 'SOLAR HSD',  92037.00);

DROP TABLE IF EXISTS `sopir`;
CREATE TABLE `sopir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `namasopir` varchar(50) DEFAULT NULL,
  `namakenek` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `sopir` (`id`, `namasopir`, `namakenek`) VALUES
(1, 'NARDI',  'YANTO'),
(2, 'EKO',  'MISGYANTO');

DROP TABLE IF EXISTS `spp`;
CREATE TABLE `spp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penawaran` int(11) DEFAULT NULL,
  `id_kendaraan` int(11) DEFAULT NULL,
  `id_sopir` int(11) DEFAULT NULL,
  `nomorspp` varchar(100) DEFAULT NULL,
  `tanggalspp` date DEFAULT NULL,
  `nopo` varchar(100) DEFAULT NULL,
  `tanggalpo` date DEFAULT NULL,
  `kwantitas` int(11) DEFAULT NULL,
  `segelatas` varchar(50) DEFAULT NULL,
  `segelbawah` varchar(50) DEFAULT NULL,
  `beratjenis` varchar(20) DEFAULT NULL,
  `temperatur` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_kendaraan` (`id_kendaraan`),
  KEY `id_sopir` (`id_sopir`),
  KEY `id_penawaran` (`id_penawaran`),
  CONSTRAINT `spp_ibfk_2` FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan` (`id`),
  CONSTRAINT `spp_ibfk_3` FOREIGN KEY (`id_sopir`) REFERENCES `sopir` (`id`),
  CONSTRAINT `spp_ibfk_4` FOREIGN KEY (`id_penawaran`) REFERENCES `penawaran` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `spp` (`id`, `id_penawaran`, `id_kendaraan`, `id_sopir`, `nomorspp`, `tanggalspp`, `nopo`, `tanggalpo`, `kwantitas`, `segelatas`, `segelbawah`, `beratjenis`, `temperatur`, `status`) VALUES
(14,  5,  1,  1,  '12345',  '2018-01-31', '4321', '2018-01-31', 5000, '12345',  '12346',  '22', '32', 1),
(15,  5,  2,  1,  '5566', '2018-01-31', '6655', '2018-01-31', 8000, '11, 12', '13', '22', '32', 0);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` int(11) DEFAULT '1',
  `avatar` varchar(20) DEFAULT 'avatar1.png',
  `telpon` varchar(20) DEFAULT '0811',
  `email` varchar(50) DEFAULT 'guest@listrik.com',
  `nama` varchar(50) DEFAULT 'User',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

INSERT INTO `users` (`id`, `username`, `password`, `level`, `avatar`, `telpon`, `email`, `nama`) VALUES
(1, 'admin',  '21232f297a57a5a743894a0e4a801fc3', 0,  'avatar1.png',  '0811xxxxxxxx', 'admin@minyak.com', 'Administrator'),
(2, 'kasir',  'c7911af3adbd12a035b289556d96470a', 1,  'avatar2.png',  '0811', 'guest@minyak.com', 'User'),
(3, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 1,  'avatar2.png',  '0811', 'guest@minyak.com', 'User');

-- 2018-02-01 11:03:28
