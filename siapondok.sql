/*
SQLyog Professional v12.4.1 (64 bit)
MySQL - 5.7.14 : Database - siapondok
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`siapondok` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `siapondok`;

/*Table structure for table `kelas` */

DROP TABLE IF EXISTS `kelas`;

CREATE TABLE `kelas` (
  `id_kelas` int(6) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(50) NOT NULL,
  `kategori_sekolah` enum('mi','ma','mts') DEFAULT NULL,
  PRIMARY KEY (`id_kelas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `kelas` */

/*Table structure for table `krs` */

DROP TABLE IF EXISTS `krs`;

CREATE TABLE `krs` (
  `id_krs` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(10) NOT NULL,
  `id_kelas` int(5) NOT NULL,
  `id_mapel` int(6) NOT NULL,
  `id_ta` int(4) NOT NULL,
  PRIMARY KEY (`id_krs`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `krs` */

/*Table structure for table `mapel` */

DROP TABLE IF EXISTS `mapel`;

CREATE TABLE `mapel` (
  `id_mapel` int(6) NOT NULL AUTO_INCREMENT,
  `nama_mapel` varchar(50) NOT NULL,
  `kategori_mapel` int(2) DEFAULT NULL,
  `kategori_sekolah` enum('mi','ma','mts') DEFAULT NULL,
  PRIMARY KEY (`id_mapel`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `mapel` */

/*Table structure for table `nilai_ulangan` */

DROP TABLE IF EXISTS `nilai_ulangan`;

CREATE TABLE `nilai_ulangan` (
  `id_nu` int(6) NOT NULL AUTO_INCREMENT,
  `id_krs` int(11) NOT NULL,
  `id_sk` int(8) NOT NULL,
  `nilai` varchar(255) NOT NULL,
  PRIMARY KEY (`id_nu`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `nilai_ulangan` */

/*Table structure for table `standar_kompetensi` */

DROP TABLE IF EXISTS `standar_kompetensi`;

CREATE TABLE `standar_kompetensi` (
  `id_sk` int(8) NOT NULL AUTO_INCREMENT,
  `id_mapel` int(6) NOT NULL,
  `nama_sk` varchar(50) DEFAULT NULL,
  `kkm` int(3) DEFAULT NULL,
  PRIMARY KEY (`id_sk`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `standar_kompetensi` */

/*Table structure for table `tahunajaran` */

DROP TABLE IF EXISTS `tahunajaran`;

CREATE TABLE `tahunajaran` (
  `id_ta` int(4) NOT NULL,
  `tahun` year(4) DEFAULT NULL,
  `periode` enum('ganjil','genap') DEFAULT NULL,
  PRIMARY KEY (`id_ta`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tahunajaran` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
