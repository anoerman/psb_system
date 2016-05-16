/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.47-0ubuntu0.14.04.1 : Database - data_psb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`data_psb` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `data_psb`;

/*Table structure for table `psb_data_siswa` */

DROP TABLE IF EXISTS `psb_data_siswa`;

CREATE TABLE `psb_data_siswa` (
  `data_id` int(12) NOT NULL AUTO_INCREMENT COMMENT 'Incremental ID',
  `nama_orang_tua_wali` varchar(100) NOT NULL,
  `pekerjaan_orang_tua_wali` varchar(100) NOT NULL,
  `alamat_orang_tua_wali` text,
  `email_orang_tua_wali` varchar(100) DEFAULT NULL,
  `telepon_orang_tua_wali` varchar(100) NOT NULL,
  `nama_calon_siswa` varchar(100) NOT NULL,
  `asal_sekolah` varchar(100) NOT NULL,
  `tempat_lahir_calon_siswa` varchar(100) NOT NULL,
  `tanggal_lahir_calon_siswa` date NOT NULL,
  `ta_id` int(12) NOT NULL COMMENT 'Tahun ajaran (FK dari tabel psb_tahun_ajaran)',
  `status_penerimaan` enum('terima','tolak','pending') NOT NULL DEFAULT 'pending' COMMENT 'Standar statusnya pending',
  `checker` varchar(30) DEFAULT NULL COMMENT 'User yang melakukan pengecekan',
  `status_email` enum('terkirim','gagal_kirim','tidak_diketahui') NOT NULL DEFAULT 'tidak_diketahui' COMMENT 'Status pengiriman email ke user setelah proses input ke database',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `psb_data_siswa` */

/*Table structure for table `psb_email_info` */

DROP TABLE IF EXISTS `psb_email_info`;

CREATE TABLE `psb_email_info` (
  `info_id` int(12) NOT NULL AUTO_INCREMENT,
  `data_id` int(12) NOT NULL,
  `keterangan` text,
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `psb_email_info` */

/*Table structure for table `psb_tahun_ajaran` */

DROP TABLE IF EXISTS `psb_tahun_ajaran`;

CREATE TABLE `psb_tahun_ajaran` (
  `ta_id` int(12) NOT NULL AUTO_INCREMENT,
  `tahun_ajaran` varchar(30) NOT NULL COMMENT 'Contoh : 2016-2017',
  `aktif` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'Status tahun ajaran',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`ta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `psb_tahun_ajaran` */

insert  into `psb_tahun_ajaran`(`ta_id`,`tahun_ajaran`,`aktif`,`created_by`,`created_date`,`updated_by`,`updated_date`) values (1,'2016 - 2017','yes','admin','2016-03-14 17:52:10','admin','2016-03-14 17:52:10');

/*Table structure for table `psb_users` */

DROP TABLE IF EXISTS `psb_users`;

CREATE TABLE `psb_users` (
  `username` varchar(30) NOT NULL COMMENT 'Unique Username',
  `password` varchar(128) NOT NULL COMMENT 'SHA512',
  `salt` varchar(64) NOT NULL COMMENT 'Random String SHA256',
  `level` enum('admin','super_user') NOT NULL DEFAULT 'admin' COMMENT 'User Level',
  `aktif` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'User Active Status',
  `nama_depan` varchar(50) DEFAULT NULL,
  `nama_belakang` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL COMMENT 'Alamat Email',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revisi` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'Total Profile Changes/Revision',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `psb_users` */

insert  into `psb_users`(`username`,`password`,`salt`,`level`,`aktif`,`nama_depan`,`nama_belakang`,`email`,`created_by`,`created_date`,`updated_by`,`updated_date`,`revisi`) values ('admin','6e059a06efc704260c2fc5ee1bcc609b9e8bf6beb14b782a51bf2827763154d3943370fa8fcbfab5fdecb4d2a54c6a214267f8c843903198699bf82140bc9c71','947293a7c32dd0597484b4593edcd1c8c864eaec60f0f62d41e0ca5d31e95257','super_user','yes','Super','User','admin@smkpgri2cibinong.sch.id','admin','2015-12-02 11:26:49','admin','2016-03-14 17:42:20',3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
