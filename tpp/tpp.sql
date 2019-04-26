-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.3.9-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for simrsmedicca
DROP DATABASE IF EXISTS `simrsmedicca`;
CREATE DATABASE IF NOT EXISTS `simrsmedicca` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `simrsmedicca`;

-- Dumping structure for table simrsmedicca.lokasalrujukan
CREATE TABLE IF NOT EXISTS `lokasalrujukan` (
  `Id_Rujukan` varchar(50) NOT NULL DEFAULT '',
  `Rujukan` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id_Rujukan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table simrsmedicca.lokasalrujukan: ~5 rows (approximately)
/*!40000 ALTER TABLE `lokasalrujukan` DISABLE KEYS */;
REPLACE INTO `lokasalrujukan` (`Id_Rujukan`, `Rujukan`) VALUES
	('{290320191250308A243FA9DF67A28BD1C5722022B148EE}', 'DATANG SENDIRI (PASIEN UMUM)'),
	('{290320191250318A243FA9DF67A28BD1C5722022B148EE}', 'RUJUKAN PUSKESMAS/DR KELUARGA'),
	('{290320191250328A243FA9DF67A28BD1C5722022B148EE}', 'RUJUKAN RS LAIN'),
	('{290320191250338A243FA9DF67A28BD1C5722022B148EE}', 'RUJUKAN FASKES LAIN'),
	('{290320191250348A243FA9DF67A28BD1C5722022B148EE}', 'RUJUKAN BALIK DITERIMA KEMBALI');
/*!40000 ALTER TABLE `lokasalrujukan` ENABLE KEYS */;

-- Dumping structure for table simrsmedicca.lokbiayadaftar
CREATE TABLE IF NOT EXISTS `lokbiayadaftar` (
  `Id_Biayadaftar` varchar(50) NOT NULL DEFAULT '',
  `Nama_Biaya` varchar(250) NOT NULL DEFAULT '',
  `Jasa_Dokter` decimal(17,0) NOT NULL DEFAULT 0,
  `Jasa_Layanan` decimal(17,0) NOT NULL DEFAULT 0,
  `Jasa_Sarana` decimal(17,0) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id_Biayadaftar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table simrsmedicca.lokbiayadaftar: ~8 rows (approximately)
/*!40000 ALTER TABLE `lokbiayadaftar` DISABLE KEYS */;
REPLACE INTO `lokbiayadaftar` (`Id_Biayadaftar`, `Nama_Biaya`, `Jasa_Dokter`, `Jasa_Layanan`, `Jasa_Sarana`) VALUES
	('{290320191250308A243FA9DF67A28BD1C5722022B148EE}', 'DOKTER UMUM, GIGI - POLIKLINIK', 4500, 2250, 6000),
	('{290320191250328A243FA9DF67A28BD1C5722022B148EE}', 'DOKTER SPESIALIS - POLIKLINIK', 13000, 4000, 7000),
	('{290320191250348A243FA9DF67A28BD1C5722022B148EE}', 'PEMBUATAN VISUM BIASA V E R', 15000, 4000, 17000),
	('{290320191250358A243FA9DF67A28BD1C5722022B148EE}', 'SURAT KET. SEHAT, SURAT KET. TIDAK BUTA WARNA', 4000, 2000, 6500),
	('{290320191250368A243FA9DF67A28BD1C5722022B148EE}', 'SURAT KET.SAKIT ATAU OPNAME', 4000, 2000, 6500),
	('{290320191250378A243FA9DF67A28BD1C5722022B148EE}', 'SURAT KET. KELAHIRAN', 4000, 2000, 6500);
/*!40000 ALTER TABLE `lokbiayadaftar` ENABLE KEYS */;

-- Dumping structure for table simrsmedicca.lokdaftar
CREATE TABLE IF NOT EXISTS `lokdaftar` (
  `Id_Daftar` varchar(50) NOT NULL DEFAULT '',
  `Tgl_Daftar` date NOT NULL DEFAULT '0000-00-00',
  `Waktu` time NOT NULL DEFAULT '00:00:00',
  `Id_Pasien` varchar(50) NOT NULL DEFAULT '',
  `Id_Poliklinik` varchar(50) NOT NULL DEFAULT '',
  `Id_Rujukan` varchar(50) NOT NULL DEFAULT '',
  `Id_JenisPasien` varchar(50) NOT NULL DEFAULT '',
  `Lama_Baru` varchar(50) NOT NULL DEFAULT '',
  `Id_BiayaDaftar` varchar(50) NOT NULL DEFAULT '',
  `Total_Biaya` decimal(17,0) NOT NULL DEFAULT 0,
  `Rawat` varchar(50) NOT NULL DEFAULT '',
  `Status` varchar(50) NOT NULL DEFAULT '',
  `Petugas` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id_Daftar`),
  KEY `FK_lokdaftar_lokpasien` (`Id_Pasien`),
  KEY `FK_lokdaftar_lokpoliklinik` (`Id_Poliklinik`),
  KEY `FK_lokdaftar_lokbiayadaftar` (`Id_BiayaDaftar`),
  CONSTRAINT `FK_lokdaftar_lokbiayadaftar` FOREIGN KEY (`Id_BiayaDaftar`) REFERENCES `lokbiayadaftar` (`Id_Biayadaftar`),
  CONSTRAINT `FK_lokdaftar_lokpasien` FOREIGN KEY (`Id_Pasien`) REFERENCES `lokpasien` (`Id_Pasien`),
  CONSTRAINT `FK_lokdaftar_lokpoliklinik` FOREIGN KEY (`Id_Poliklinik`) REFERENCES `lokpoliklinik` (`Id_Poliklinik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table simrsmedicca.lokdaftar: ~0 rows (approximately)
/*!40000 ALTER TABLE `lokdaftar` DISABLE KEYS */;
/*!40000 ALTER TABLE `lokdaftar` ENABLE KEYS */;

-- Dumping structure for table simrsmedicca.lokjenispasien
CREATE TABLE IF NOT EXISTS `lokjenispasien` (
  `Id_JenisPasien` varchar(50) NOT NULL DEFAULT '',
  `Jenis_Pasien` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id_JenisPasien`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table simrsmedicca.lokjenispasien: ~7 rows (approximately)
/*!40000 ALTER TABLE `lokjenispasien` DISABLE KEYS */;
REPLACE INTO `lokjenispasien` (`Id_JenisPasien`, `Jenis_Pasien`) VALUES
	('{290320191250308A243FA9DF67A28BD1C5722022B148EE}', 'PASIEN UMUM'),
	('{290320191250318A243FA9DF67A28BD1C5722022B148EE}', 'PASIEN BPJS MANDIRI'),
	('{290320191250328A243FA9DF67A28BD1C5722022B148EE}', 'PASIEN BPJS PNS'),
	('{290320191250338A243FA9DF67A28BD1C5722022B148EE}', 'PASIEN BPJS TNI/POLRI'),
	('{290320191250348A243FA9DF67A28BD1C5722022B148EE}', 'PASIEN BPJS KETENAGAKERJAAN'),
	('{290320191250358A243FA9DF67A28BD1C5722022B148EE}', 'PASIEN BPJS JAMKESMAS'),
	('{290320191250368A243FA9DF67A28BD1C5722022B148EE}', 'PASIEN JAMKESDA');
/*!40000 ALTER TABLE `lokjenispasien` ENABLE KEYS */;

-- Dumping structure for table simrsmedicca.lokkelurahan
CREATE TABLE IF NOT EXISTS `lokkelurahan` (
  `Id_Kelurahan` varchar(50) NOT NULL DEFAULT '',
  `Kelurahan` varchar(50) NOT NULL DEFAULT '',
  `Kecamatan` varchar(50) NOT NULL DEFAULT '',
  `Kabupaten` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id_Kelurahan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping structure for table simrsmedicca.lokpasien
CREATE TABLE IF NOT EXISTS `lokpasien` (
  `Id_Pasien` varchar(50) NOT NULL DEFAULT '',
  `No_RM` varchar(50) NOT NULL DEFAULT '0',
  `Nama_Pasien` varchar(50) NOT NULL DEFAULT '',
  `No_BPJS` varchar(50) DEFAULT '',
  `No_KTP` varchar(30) DEFAULT '',
  `Tempat_Lahir` varchar(50) NOT NULL DEFAULT '',
  `Tgl_Lahir` date NOT NULL DEFAULT '0000-00-00',
  `Jenis_Kelamin` varchar(50) NOT NULL DEFAULT '',
  `Alamat` varchar(250) NOT NULL DEFAULT '',
  `Id_Kelurahan` varchar(50) NOT NULL DEFAULT '',
  `Agama` varchar(50) NOT NULL DEFAULT '',
  `Lama_Baru` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id_Pasien`),
  UNIQUE KEY `No_RM` (`No_RM`),
  KEY `FK_lokpasien_lokkelurahan` (`Id_Kelurahan`),
  CONSTRAINT `FK_lokpasien_lokkelurahan` FOREIGN KEY (`Id_Kelurahan`) REFERENCES `lokkelurahan` (`Id_Kelurahan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table simrsmedicca.lokpasien: ~0 rows (approximately)
/*!40000 ALTER TABLE `lokpasien` DISABLE KEYS */;
/*!40000 ALTER TABLE `lokpasien` ENABLE KEYS */;

-- Dumping structure for table simrsmedicca.lokpegawai
CREATE TABLE IF NOT EXISTS `lokpegawai` (
  `Id_Pegawai` varchar(50) NOT NULL DEFAULT '',
  `Nama_Pegawai` varchar(50) NOT NULL DEFAULT '',
  `NIK` varchar(50) DEFAULT '',
  `Unit` varchar(50) NOT NULL DEFAULT '',
  `Jenis_Pegawai` varchar(50) NOT NULL DEFAULT '',
  `Username` varchar(50) NOT NULL DEFAULT '',
  `Password` varchar(50) NOT NULL DEFAULT '',
  `Userlevel` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id_Pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table simrsmedicca.lokpegawai: ~0 rows (approximately)
/*!40000 ALTER TABLE `lokpegawai` DISABLE KEYS */;
/*!40000 ALTER TABLE `lokpegawai` ENABLE KEYS */;

-- Dumping structure for table simrsmedicca.lokpoliklinik
CREATE TABLE IF NOT EXISTS `lokpoliklinik` (
  `Id_Poliklinik` varchar(50) NOT NULL DEFAULT '',
  `Nama_Poliklinik` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id_Poliklinik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table simrsmedicca.lokpoliklinik: ~8 rows (approximately)
/*!40000 ALTER TABLE `lokpoliklinik` DISABLE KEYS */;
REPLACE INTO `lokpoliklinik` (`Id_Poliklinik`, `Nama_Poliklinik`) VALUES
	('{290320191250308A243FA9DF67A28BD1C5722022B148EE}', 'UGD'),
	('{290320191250318A243FA9DF67A28BD1C5722022B148EE}', 'UMUM'),
	('{290320191250328A243FA9DF67A28BD1C5722022B148EE}', 'PENYAKIT DALAM'),
	('{290320191250338A243FA9DF67A28BD1C5722022B148EE}', 'GIGI'),
	('{290320191250348A243FA9DF67A28BD1C5722022B148EE}', 'MATA'),
	('{290320191250358A243FA9DF67A28BD1C5722022B148EE}', 'REHAB MEDIK'),
	('{290320191250368A243FA9DF67A28BD1C5722022B148EE}', 'KANDUNGAN'),
	('{290320191250378A243FA9DF67A28BD1C5722022B148EE}', 'ANAK');
/*!40000 ALTER TABLE `lokpoliklinik` ENABLE KEYS */;

-- Dumping structure for table simrsmedicca.lokuserlevelpermissions
CREATE TABLE IF NOT EXISTS `lokuserlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL,
  PRIMARY KEY (`userlevelid`,`tablename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table simrsmedicca.lokuserlevelpermissions: ~67 rows (approximately)
/*!40000 ALTER TABLE `lokuserlevelpermissions` DISABLE KEYS */;
REPLACE INTO `lokuserlevelpermissions` (`userlevelid`, `tablename`, `permission`) VALUES
	(-2, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokasalrujukan', 0),
	(-2, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokbiayadaftar', 0),
	(-2, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokdaftar', 0),
	(-2, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokjenispasien', 0),
	(-2, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokkelurahan', 0),
	(-2, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokpasien', 0),
	(-2, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokpoliklinik', 0),
	(-2, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}ugdbiayadaftar', 0),
	(-2, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}ugddaftar', 0),
	(-2, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}vlokpetugas', 0),
	(1, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokasalrujukan', 111),
	(1, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokbiayadaftar', 111),
	(1, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokdaftar', 111),
	(1, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokjenispasien', 111),
	(1, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokkelurahan', 111),
	(1, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokpasien', 111),
	(1, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokpoliklinik', 111),
	(1, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}ugdbiayadaftar', 111),
	(1, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}ugddaftar', 111),
	(1, '{888F026C-2D04-4F2F-A77C-CABDD56A9360}vlokpetugas', 127);
/*!40000 ALTER TABLE `lokuserlevelpermissions` ENABLE KEYS */;

-- Dumping structure for table simrsmedicca.lokuserlevels
CREATE TABLE IF NOT EXISTS `lokuserlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(80) NOT NULL,
  PRIMARY KEY (`userlevelid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table simrsmedicca.lokuserlevels: ~5 rows (approximately)
/*!40000 ALTER TABLE `lokuserlevels` DISABLE KEYS */;
REPLACE INTO `lokuserlevels` (`userlevelid`, `userlevelname`) VALUES
	(-2, 'Anonymous'),
	(-1, 'Administrator'),
	(0, 'Default'),
	(1, 'Admin Loket'),
	(2, 'Petugas Loket');
/*!40000 ALTER TABLE `lokuserlevels` ENABLE KEYS */;

-- Dumping structure for table simrsmedicca.ugdbiayadaftar
CREATE TABLE IF NOT EXISTS `ugdbiayadaftar` (
  `Id_Biayadaftar` varchar(50) NOT NULL DEFAULT '',
  `Nama_Biaya` varchar(250) NOT NULL DEFAULT '',
  `Jasa_Dokter` decimal(17,0) NOT NULL DEFAULT 0,
  `Jasa_Layanan` decimal(17,0) NOT NULL DEFAULT 0,
  `Jasa_Sarana` decimal(17,0) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id_Biayadaftar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table simrsmedicca.ugdbiayadaftar: ~2 rows (approximately)
/*!40000 ALTER TABLE `ugdbiayadaftar` DISABLE KEYS */;
REPLACE INTO `ugdbiayadaftar` (`Id_Biayadaftar`, `Nama_Biaya`, `Jasa_Dokter`, `Jasa_Layanan`, `Jasa_Sarana`) VALUES
	('9943353667', 'Dokter Umum, Gigi - Gawat Darurat', 7000, 3000, 6000),
	('9943355067', 'Dokter Spesialis - Gawat Darurat', 15000, 4500, 7000);
/*!40000 ALTER TABLE `ugdbiayadaftar` ENABLE KEYS */;

-- Dumping structure for view simrsmedicca.ugddaftar
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `ugddaftar` (
	`Id_Daftar` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`Tgl_Daftar` DATE NOT NULL,
	`Waktu` TIME NOT NULL,
	`Id_Pasien` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`Id_Poliklinik` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`Id_Rujukan` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`Id_JenisPasien` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`Lama_Baru` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`Id_BiayaDaftar` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`Total_Biaya` DECIMAL(17,0) NOT NULL,
	`Rawat` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`Status` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`Petugas` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view simrsmedicca.vlokpetugas
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vlokpetugas` (
	`Id_Petugas` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`Nama_Petugas` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`NIK` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`Unit` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`Username` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`Password` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`Userlevel` INT(11) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view simrsmedicca.ugddaftar
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `ugddaftar`;
CREATE ALGORITHM=UNDEFINED VIEW `ugddaftar` AS SELECT * FROM lokdaftar WHERE lokdaftar.Rawat<>'RAWAT JALAN POLIKLINIK' ;

-- Dumping structure for view simrsmedicca.vlokpetugas
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vlokpetugas`;
CREATE ALGORITHM=UNDEFINED VIEW `vlokpetugas` AS SELECT Id_pegawai as Id_Petugas, Nama_pegawai as Nama_Petugas, NIK, Unit, Username,  Password, Userlevel
FROM lokpegawai WHERE Unit = 'LOKET' ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
