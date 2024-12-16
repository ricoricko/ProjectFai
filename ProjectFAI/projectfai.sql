/*
SQLyog Community v13.2.1 (64 bit)
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
  `nota_pesanan` INT(11) NOT NULL,
  `id_produk` INT(11) DEFAULT NULL,
  `waktu` DATE DEFAULT NULL,
  `id_pelanggan` INT(11) DEFAULT NULL,
  `id_pegawai` INT(11) DEFAULT NULL,
  `status_nota` INT(11) DEFAULT NULL,
  PRIMARY KEY (`nota_pesanan`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `history` */

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id_kategori` INT(50) NOT NULL AUTO_INCREMENT,
  `nama_kategori` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kategori` */

/*Table structure for table `member` */

DROP TABLE IF EXISTS `member`;

CREATE TABLE `member` (
  `id_member` INT(50) NOT NULL AUTO_INCREMENT,
  `nama_member` VARCHAR(255) DEFAULT NULL,
  `potongan_member` INT(50) DEFAULT NULL,
  `minTrans_member` INT(50) DEFAULT NULL,
  PRIMARY KEY (`id_member`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `member` */

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id_menu` INT(50) NOT NULL AUTO_INCREMENT,
  `nama_menu` VARCHAR(255) DEFAULT NULL,
  `kategori_menu` INT(50) DEFAULT NULL,
  `harga_menu` INT(50) DEFAULT NULL,
  `image_menu` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id_menu`),
  KEY `kategori_menu` (`kategori_menu`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`kategori_menu`) REFERENCES `kategori` (`id_kategori`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `menu` */

/*Table structure for table `pegawai` */

DROP TABLE IF EXISTS `pegawai`;

CREATE TABLE `pegawai` (
  `id_pegawai` INT(50) NOT NULL AUTO_INCREMENT,
  `nama_pegawai` VARCHAR(255) DEFAULT NULL,
  `alamat_pegawai` VARCHAR(255) DEFAULT NULL,
  `status_pegawai` INT(50) DEFAULT NULL,
  `password_pegawai` VARCHAR(255) DEFAULT NULL,
  `gaji_pegawai` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`)
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pegawai` */

/*Table structure for table `pesanan` */

DROP TABLE IF EXISTS `pesanan`;

CREATE TABLE `pesanan` (
  `nota_pesanan` INT(11) NOT NULL,
  `id_produk` INT(11) DEFAULT NULL,
  `quantity` INT(11) DEFAULT NULL,
  PRIMARY KEY (`nota_pesanan`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pesanan` */

/*Table structure for table `produk` */

DROP TABLE IF EXISTS `produk`;

CREATE TABLE `produk` (
  `id_produk` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_produk` VARCHAR(255) DEFAULT NULL,
  `id_kategori` INT(11) DEFAULT NULL,
  `harga` VARCHAR(225) DEFAULT NULL,
  `stok` INT(11) DEFAULT NULL,
  `id_supplier` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `produk` */

/*Table structure for table `resep` */

DROP TABLE IF EXISTS `resep`;

CREATE TABLE `resep` (
  `id_resep` INT(11) DEFAULT NULL,
  `id_stok` INT(11) DEFAULT NULL,
  `jumlah_stok` INT(11) DEFAULT NULL,
  KEY `id_stok` (`id_stok`),
  CONSTRAINT `resep_ibfk_1` FOREIGN KEY (`id_stok`) REFERENCES `stok` (`id_stok`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `resep` */

/*Table structure for table `stok` */

DROP TABLE IF EXISTS `stok`;

CREATE TABLE `stok` (
  `id_stok` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_stok` VARCHAR(255) DEFAULT NULL,
  `jumlah_stok` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id_stok`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `stok` */

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `id_supplier` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_supplier` VARCHAR(255) DEFAULT NULL,
  `alamat` VARCHAR(255) DEFAULT NULL,
  `telp` VARCHAR(225) DEFAULT NULL,
  PRIMARY KEY (`id_supplier`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `supplier` */

/*Table structure for table `topping` */

DROP TABLE IF EXISTS `topping`;

CREATE TABLE `topping` (
  `id_topping` INT(50) NOT NULL AUTO_INCREMENT,
  `nama_topping` VARCHAR(255) DEFAULT NULL,
  `harga_topping` INT(50) DEFAULT NULL,
  `image_topping` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id_topping`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `topping` */

/*Table structure for table `transaksi` */

DROP TABLE IF EXISTS `transaksi`;

CREATE TABLE `transaksi` (
  `id_transaksi` INT(50) NOT NULL AUTO_INCREMENT,
  `id_user` INT(50) DEFAULT NULL,
  `id_menu` INT(50) DEFAULT NULL,
  `jumlah` INT(50) DEFAULT NULL,
  `tanggal` DATE DEFAULT NULL,
  `total_harga` INT(50) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `id_user` (`id_user`),
  KEY `id_menu` (`id_menu`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `transaksi` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id_user` INT(50) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) DEFAULT NULL,
  `nama` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `phone` VARBINARY(255) DEFAULT NULL,
  `id_member` INT(50) DEFAULT NULL,
  `img` VARCHAR(255) DEFAULT NULL,
  `status` VARCHAR(2) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_member` (`id_member`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`)
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
