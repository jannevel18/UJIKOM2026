/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.4.32-MariaDB : Database - dbp
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbp` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */;

USE `dbp`;

/*Table structure for table `anggota` */

DROP TABLE IF EXISTS `anggota`;

CREATE TABLE `anggota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `anggota` */

insert  into `anggota`(`id`,`user_id`,`nis`,`kelas`,`alamat`,`status`) values (1,1,'232410202','X','Jl.konglo wembe, Jomokerto','aktif');

/*Table structure for table `buku` */

DROP TABLE IF EXISTS `buku`;

CREATE TABLE `buku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_buku` varchar(255) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `pengarang` varchar(255) DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `tahun` varchar(20) DEFAULT NULL,
  `stok` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `buku` */

insert  into `buku`(`id`,`kode_buku`,`judul`,`pengarang`,`penerbit`,`tahun`,`stok`) values (1,'BK-000001','Buku Resep Khas Ngawi','Mas Fuad','Jomokerto Production','1800','20'),(2,'BK-000002','Buku Malam Kelam Jumat Di Ohio','Mas Rizal','Jomokerto Production','1800','20'),(3,'BK-000003','Buku Jurnal Edisi Mondstat','-','-','','20');

/*Table structure for table `peminjaman` */

DROP TABLE IF EXISTS `peminjaman`;

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_peminjaman` varchar(50) DEFAULT NULL,
  `anggota_id` int(11) DEFAULT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `peminjaman` */

insert  into `peminjaman`(`id`,`no_peminjaman`,`anggota_id`,`tgl_pinjam`,`tgl_kembali`,`status`,`created_at`) values (1,'PJ-20260226021213600',1,'2026-02-17','2026-02-18','dikembalikan','2026-02-26 08:12:21'),(2,'PJ-20260226024200602',1,'2026-02-26','2026-03-05','dikembalikan','2026-02-26 08:43:41');

/*Table structure for table `peminjaman_detail` */

DROP TABLE IF EXISTS `peminjaman_detail`;

CREATE TABLE `peminjaman_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `peminjaman_id` int(11) DEFAULT NULL,
  `buku_id` int(11) DEFAULT NULL,
  `qty` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `peminjaman_detail` */

insert  into `peminjaman_detail`(`id`,`peminjaman_id`,`buku_id`,`qty`) values (1,1,3,'2'),(2,2,3,'2'),(3,2,1,'3'),(4,2,2,'1');

/*Table structure for table `pengembalian` */

DROP TABLE IF EXISTS `pengembalian`;

CREATE TABLE `pengembalian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `peminjaman_id` int(11) DEFAULT NULL,
  `tgl_pengembalian` date DEFAULT NULL,
  `denda` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `pengembalian` */

insert  into `pengembalian`(`id`,`peminjaman_id`,`tgl_pengembalian`,`denda`) values (1,1,'2026-02-26','16000'),(2,2,'2026-02-26','0');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`nama`,`username`,`password`,`role`,`created_at`) values (1,'rusdi buaya','Rusdi12','123','siswa','2026-02-26 07:51:06'),(2,'admin','admin','#123','admin','2026-02-26 07:53:10');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
