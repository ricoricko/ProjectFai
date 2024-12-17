/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 10.4.32-MariaDB : Database - projectfai
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`projectfai` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `projectfai`;

/*Table structure for table `history` */

DROP TABLE IF EXISTS `history`;

CREATE TABLE `history` (
  `nota_pesanan` int(11) NOT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `waktu` date DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `status_nota` int(11) DEFAULT NULL,
  PRIMARY KEY (`nota_pesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `history` */

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id_kategori` int(50) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kategori` */

/*Table structure for table `member` */

DROP TABLE IF EXISTS `member`;

CREATE TABLE `member` (
  `id_member` int(50) NOT NULL AUTO_INCREMENT,
  `nama_member` varchar(255) DEFAULT NULL,
  `potongan_member` int(50) DEFAULT NULL,
  `minTrans_member` int(50) DEFAULT NULL,
  PRIMARY KEY (`id_member`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `member` */

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id_menu` int(50) NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(255) DEFAULT NULL,
  `kategori_menu` int(50) DEFAULT NULL,
  `harga_menu` int(50) DEFAULT NULL,
  `image_menu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_menu`),
  KEY `kategori_menu` (`kategori_menu`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`kategori_menu`) REFERENCES `kategori` (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `menu` */

/*Table structure for table `pegawai` */

DROP TABLE IF EXISTS `pegawai`;

CREATE TABLE `pegawai` (
  `id_pegawai` int(50) NOT NULL AUTO_INCREMENT,
  `nama_pegawai` varchar(255) DEFAULT NULL,
  `alamat_pegawai` varchar(255) DEFAULT NULL,
  `status_pegawai` tinyint(1) DEFAULT 0,
  `password_pegawai` varchar(255) DEFAULT NULL,
  `gaji_pegawai` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pegawai` */

insert  into `pegawai`(`id_pegawai`,`nama_pegawai`,`alamat_pegawai`,`status_pegawai`,`password_pegawai`,`gaji_pegawai`) values 
(2,'Jason','Jl Ngagel',1,'jason','20000'),
(3,'rico','Jl Utara',0,'rico','20000');

/*Table structure for table `pesanan` */

DROP TABLE IF EXISTS `pesanan`;

CREATE TABLE `pesanan` (
  `nota_pesanan` int(11) NOT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`nota_pesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pesanan` */

/*Table structure for table `produk` */

DROP TABLE IF EXISTS `produk`;

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `harga` varchar(225) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `produk` */

insert  into `produk`(`id_produk`,`nama_produk`,`id_kategori`,`harga`,`stok`,`id_supplier`,`status`) values 
(1,'Daun Jeruk',NULL,'20000',520000,NULL,1),
(2,'Jahe',NULL,'29000',210000,NULL,1),
(3,'Kunyit',NULL,'26000',50010,NULL,1);

/*Table structure for table `resep` */

DROP TABLE IF EXISTS `resep`;

CREATE TABLE `resep` (
  `id_resep` int(11) DEFAULT NULL,
  `id_stok` int(11) DEFAULT NULL,
  `jumlah_stok` int(11) DEFAULT NULL,
  KEY `id_stok` (`id_stok`),
  CONSTRAINT `resep_ibfk_1` FOREIGN KEY (`id_stok`) REFERENCES `stok` (`id_stok`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `resep` */

/*Table structure for table `stok` */

DROP TABLE IF EXISTS `stok`;

CREATE TABLE `stok` (
  `id_stok` int(11) NOT NULL AUTO_INCREMENT,
  `nama_stok` varchar(255) DEFAULT NULL,
  `jumlah_stok` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_stok`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `stok` */

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telp` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `supplier` */

/*Table structure for table `topping` */

DROP TABLE IF EXISTS `topping`;

CREATE TABLE `topping` (
  `id_topping` int(50) NOT NULL AUTO_INCREMENT,
  `nama_topping` varchar(255) DEFAULT NULL,
  `harga_topping` int(50) DEFAULT NULL,
  `image_topping` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_topping`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `topping` */

/*Table structure for table `transaksi` */

DROP TABLE IF EXISTS `transaksi`;

CREATE TABLE `transaksi` (
  `id_transaksi` int(50) NOT NULL AUTO_INCREMENT,
  `id_user` int(50) DEFAULT NULL,
  `id_menu` int(50) DEFAULT NULL,
  `jumlah` int(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `total_harga` int(50) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `id_user` (`id_user`),
  KEY `id_menu` (`id_menu`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `transaksi` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id_user` int(50) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varbinary(255) DEFAULT NULL,
  `id_member` int(50) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id_user`),
  KEY `id_member` (`id_member`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id_user`,`username`,`password`,`nama`,`email`,`phone`,`id_member`,`img`,`status`) values 
(4,'qwe','qwe','qwe','qwe@gmail.com','22',NULL,NULL,1),
(5,'zxc','zxc','zxc','zxc@gmail.com','222',NULL,NULL,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
