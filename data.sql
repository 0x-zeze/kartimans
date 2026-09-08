/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 10.4.28-MariaDB : Database - kartimans
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kartimans` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `kartimans`;

/*Table structure for table `harga` */

DROP TABLE IF EXISTS `harga`;

CREATE TABLE `harga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `harga` varchar(255) DEFAULT NULL,
  `data_harga` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `harga` */

insert  into `harga`(`id`,`jenis`,`label`,`harga`,`data_harga`) values 
(1,'Haircut','Haircut (Keramas, Hair Tonic, Styling, Hot Towel)','Rp 25.000',25000),
(2,'Basic Coloring','Basic Coloring','Rp 75.000',75000),
(3,'Bleaching','Bleaching','Rp 75.000',75000),
(4,'Shaving','Shaving','Rp 25.000',25000);

/*Table structure for table `jasa` */

DROP TABLE IF EXISTS `jasa`;

CREATE TABLE `jasa` (
  `kode` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `jenis` varchar(255) DEFAULT NULL,
  `tanggal` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `waktu_booking` text DEFAULT NULL,
  `tanggal_pesan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `jasa` */

insert  into `jasa`(`kode`,`nama`,`time`,`jenis`,`tanggal`,`status`,`harga`,`waktu_booking`,`tanggal_pesan`) values 
('5nMJvv','cobaan','2024-03-26 13:13:53','123','2024-03-26','BERHASIL',100000,NULL,'2024-04-24'),
('259mxg','cobaan','2024-03-26 13:18:01','321','2024-07-26','BERHASIL',100000,NULL,NULL),
('nTuU5K','suka suka','2024-03-26 13:19:14','321','2024-03-26','Langsung',100000,NULL,'2024-04-15'),
('waNEOE','dadax','2024-04-08 15:45:27','Bleaching,Shaving','2024-04-08','BERHASIL',100000,NULL,NULL),
('pPjPwA','suka suka','2024-04-21 13:15:21','Basic','2024-01-08','BERHASIL',100000,'xaxaxa','2023-12-13'),
(NULL,NULL,'2024-05-06 13:08:17',NULL,'2024-04-08',NULL,NULL,NULL,NULL);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `no_wa` varchar(255) DEFAULT NULL,
  `level_user` int(11) DEFAULT NULL,
  KEY `id` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user` */

insert  into `user`(`id_user`,`username`,`password`,`nama`,`email`,`status`,`no_wa`,`level_user`) values 
(2,'admin','123','dada','da@a','Pemilik',NULL,1),
(3,'asd','asd','asd','asd@gmail.com','dasdasdadadadadadada','123',4),
(5,'adm','123','dada','da@ds','Admin',NULL,2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
