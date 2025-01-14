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

/*Table structure for table `cart` */

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `id_cart` INT(50) NOT NULL AUTO_INCREMENT,
  `id_user` INT(50) NOT NULL,
  `id_menu` INT(50) NOT NULL,
  `jumlah` INT(50) NOT NULL,
  `status` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id_cart`),
  KEY `id_user` (`id_user`),
  KEY `id_menu` (`id_menu`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`)
) ENGINE=INNODB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `cart` */

INSERT  INTO `cart`(`id_cart`,`id_user`,`id_menu`,`jumlah`,`status`) VALUES 
(1,4,3,2,2),
(2,4,1,2,2),
(3,4,2,3,2),
(4,4,1,2,2),
(5,4,1,1,2),
(7,5,2,122,2),
(8,4,2,2,2),
(9,4,3,2,2),
(10,5,3,122,2),
(11,5,2,12,2),
(12,4,2,20,0),
(13,4,5,10,0),
(14,4,6,11,0),
(15,4,9,2,0),
(16,4,18,7,0),
(17,4,1,2,1);

/*Table structure for table `cash` */

DROP TABLE IF EXISTS `cash`;

CREATE TABLE `cash` (
  `id_cash` INT(255) NOT NULL AUTO_INCREMENT,
  `jumlah_cash` INT(255) DEFAULT NULL,
  `tanggal` DATE DEFAULT NULL,
  PRIMARY KEY (`id_cash`)
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `cash` */

INSERT  INTO `cash`(`id_cash`,`jumlah_cash`,`tanggal`) VALUES 
(1,50000000,'2025-01-10');

/*Table structure for table `cash_in` */

DROP TABLE IF EXISTS `cash_in`;

CREATE TABLE `cash_in` (
  `id_cashin` INT(255) NOT NULL AUTO_INCREMENT,
  `cash_in` INT(255) DEFAULT NULL,
  `tanggal` DATE DEFAULT NULL,
  `status` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id_cashin`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `cash_in` */

INSERT  INTO `cash_in`(`id_cashin`,`cash_in`,`tanggal`,`status`) VALUES 
(1,400000,'2025-01-10','top up'),
(2,10000,'2025-01-10','top up');

/*Table structure for table `cash_out` */

DROP TABLE IF EXISTS `cash_out`;

CREATE TABLE `cash_out` (
  `id_cashout` INT(255) NOT NULL AUTO_INCREMENT,
  `cash_out` INT(255) DEFAULT NULL,
  `tanggal` DATE DEFAULT NULL,
  `id_produk` INT(11) DEFAULT NULL,
  `jumlah` INT(11) DEFAULT NULL,
  `harga` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id_cashout`)
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `cash_out` */

INSERT  INTO `cash_out`(`id_cashout`,`cash_out`,`tanggal`,`id_produk`,`jumlah`,`harga`) VALUES 
(1,10000,'2025-01-10',1,1,10000),
(2,20000,'2025-01-10',1,2,10000),
(3,40000,'2025-01-10',23,2,20000);

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

/*Table structure for table `jenis_member` */

DROP TABLE IF EXISTS `jenis_member`;

CREATE TABLE `jenis_member` (
  `id_jenismember` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(255) NOT NULL,
  `minimum_transaksi` INT(11) NOT NULL,
  `potongan` DECIMAL(5,2) NOT NULL,
  PRIMARY KEY (`id_jenismember`)
) ENGINE=INNODB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `jenis_member` */

INSERT  INTO `jenis_member`(`id_jenismember`,`nama`,`minimum_transaksi`,`potongan`) VALUES 
(1,'Rakyat Kopinesia',300000,8.00),
(2,'Kesatria Latte',600000,10.00),
(3,'Pahlawan Espresso',900000,15.00),
(4,'Maharaja Mocha',1200000,20.00);

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id_kategori` INT(50) NOT NULL AUTO_INCREMENT,
  `nama_kategori` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=INNODB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kategori` */

INSERT  INTO `kategori`(`id_kategori`,`nama_kategori`) VALUES 
(1,'Minuman'),
(2,'Heavy Food'),
(3,'Snack'),
(4,'Add On');

/*Table structure for table `member` */

DROP TABLE IF EXISTS `member`;

CREATE TABLE `member` (
  `id_member` INT(50) NOT NULL AUTO_INCREMENT,
  `id_user` INT(50) NOT NULL,
  `id_jenismember` INT(50) NOT NULL,
  PRIMARY KEY (`id_member`),
  KEY `fk_member_jenismember` (`id_jenismember`),
  CONSTRAINT `fk_member_jenismember` FOREIGN KEY (`id_jenismember`) REFERENCES `jenis_member` (`id_jenismember`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `member` */

INSERT  INTO `member`(`id_member`,`id_user`,`id_jenismember`) VALUES 
(1,4,4);

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
) ENGINE=INNODB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `menu` */

INSERT  INTO `menu`(`id_menu`,`nama_menu`,`kategori_menu`,`harga_menu`,`image_menu`) VALUES 
(1,'Oat Latte',1,25000,'storage/menu/OatMilkLatte.jpg'),
(2,'Americano',1,20000,'storage/menu/americano.jpg'),
(3,'Cafe Latte',1,23000,'storage/menu/cafelatte.jpg'),
(4,'V60',1,27000,'storage/menu/v60.jpg'),
(5,'Cappuccino',1,24000,'storage/menu/capuccino.jpg'),
(6,'Matcha Latte',1,28000,'storage/menu/iced-matcha-latte.jpg'),
(7,'Matcha Coffee',1,30000,'storage/menu/matcha-coffee.jpg'),
(8,'Avocado Juice',1,22000,'storage/menu/jus-alpukat.jpg'),
(9,'Lemon Tea',1,15000,'storage/menu/lemontea.jpg'),
(10,'Ice Tea',1,10000,'storage/menu/icedtea.jpg'),
(11,'Ice Chocolate',1,18000,'storage/menu/icedchoco.jpg'),
(12,'Kentang Goreng',3,15000,'storage/menu/kentanggoreng.jpeg'),
(13,'Sosis Goreng',3,18000,'storage/menu/sosisgoreng.jpg'),
(14,'Pretzel',3,20000,'storage/menu/pretzel.jpg'),
(15,'Croissant',3,22000,'storage/menu/croisant.jpg'),
(16,'Baguette',3,25000,'storage/menu/baguete.jpg'),
(17,'Spaghetti Bolognese',2,40000,'storage/menu/bolognes.jpg'),
(18,'Fish and Chips',2,50000,'storage/menu/fishnchips.jpg'),
(19,'Fried Rice (Seafood)',2,35000,'storage/menu/nasgorseafood.jpg'),
(20,'Fried Rice (Special)',2,37000,'storage/menu/nasgorspecial.jpg'),
(21,'Chicken Cordon Bleu',2,55000,'storage/menu/cordonbleu.jpg'),
(22,'Carbonara',2,42000,'storage/menu/carbonara.jpg'),
(23,'Keju',4,5000,'storage/menu/keju.jpg'),
(24,'Nasi',4,7000,'storage/menu/nasi.jpg'),
(25,'Saus Tomat',4,3000,'storage/menu/saustomat.jpg'),
(26,'Saus Sambal',4,3000,'storage/menu/saus-sambal.jpg'),
(27,'Saus BBQ',4,3000,'storage/menu/bbqsauce.jpg'),
(28,'Saus Mayones',4,3000,'storage/menu/mayones.jpg'),
(29,'Saus Tartar',4,3000,'storage/menu/tartar.jpg'),
(30,'Saus Kecap',4,2000,'storage/menu/kecap.jpg');

/*Table structure for table `pegawai` */

DROP TABLE IF EXISTS `pegawai`;

CREATE TABLE `pegawai` (
  `id_pegawai` INT(50) NOT NULL AUTO_INCREMENT,
  `nama_pegawai` VARCHAR(255) DEFAULT NULL,
  `alamat_pegawai` VARCHAR(255) DEFAULT NULL,
  `status_pegawai` TINYINT(1) DEFAULT 0,
  `password_pegawai` VARCHAR(255) DEFAULT NULL,
  `gaji_pegawai` VARCHAR(255) DEFAULT NULL,
  `jumlah_confirm` INT(10) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`)
) ENGINE=INNODB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pegawai` */

INSERT  INTO `pegawai`(`id_pegawai`,`nama_pegawai`,`alamat_pegawai`,`status_pegawai`,`password_pegawai`,`gaji_pegawai`,`jumlah_confirm`) VALUES 
(2,'Jason','Jl Ngagel',1,'jason','20000',NULL),
(3,'rico','Jl Utara',0,'rico','20000',NULL),
(4,'dvg','dvg',0,'dvg','122',2);

/*Table structure for table `produk` */

DROP TABLE IF EXISTS `produk`;

CREATE TABLE `produk` (
  `id_produk` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_produk` VARCHAR(255) DEFAULT NULL,
  `id_kategori` INT(11) DEFAULT NULL,
  `harga` VARCHAR(225) DEFAULT NULL,
  `stok` INT(11) DEFAULT NULL,
  `id_supplier` INT(11) DEFAULT NULL,
  `status` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id_produk`)
) ENGINE=INNODB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `produk` */

INSERT  INTO `produk`(`id_produk`,`nama_produk`,`id_kategori`,`harga`,`stok`,`id_supplier`,`status`) VALUES 
(1,'Susu',1,'10000',1005,NULL,1),
(2,'Biji Kopi',1,'120000',50,NULL,1),
(3,'Cocoa Powder',1,'30000',80,NULL,1),
(4,'Daun Teh',1,'15000',70,NULL,1),
(5,'Air',1,'500',1000,NULL,1),
(6,'Es Batu',1,'2000',200,NULL,1),
(7,'Lemon',1,'5000',50,NULL,1),
(8,'Alpukat',1,'20000',30,NULL,1),
(9,'Es Krim',1,'10000',40,NULL,1),
(10,'Bubuk Matcha',1,'50000',25,NULL,1),
(11,'Kentang',3,'8000',100,NULL,1),
(12,'Garam',3,'1000',500,NULL,1),
(13,'Sosis',3,'12000',80,NULL,1),
(14,'Pretzel',3,'15000',40,NULL,1),
(15,'Croissant',3,'18000',30,NULL,1),
(16,'Baguette',3,'20000',20,NULL,1),
(17,'Tartar Sauce',3,'10000',50,NULL,1),
(18,'Tomato Sauce',3,'7000',60,NULL,1),
(19,'Chili Sauce',3,'6000',70,NULL,1),
(20,'Keju',4,'15000',50,NULL,1),
(21,'Nasi',4,'5000',100,NULL,1),
(22,'Sauce-saucean',4,'8000',70,NULL,1),
(23,'Coklat',NULL,'20000',2,NULL,1);

/*Table structure for table `resep` */

DROP TABLE IF EXISTS `resep`;

CREATE TABLE `resep` (
  `id_resep` INT(11) DEFAULT NULL,
  `id_stok` INT(11) DEFAULT NULL,
  KEY `id_stok` (`id_stok`),
  CONSTRAINT `resep_ibfk_1` FOREIGN KEY (`id_stok`) REFERENCES `stok` (`id_stok`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `resep` */

INSERT  INTO `resep`(`id_resep`,`id_stok`) VALUES 
(1,1),
(1,2),
(2,2),
(3,1),
(3,2),
(4,2),
(5,1),
(5,2),
(6,10),
(6,1),
(7,10),
(7,2),
(8,8),
(8,9),
(9,7),
(9,4),
(10,4),
(10,6),
(11,3),
(11,1),
(12,11),
(12,12),
(13,13),
(14,14),
(15,15),
(16,16),
(17,17),
(18,18),
(19,19),
(20,20),
(21,17),
(22,20),
(23,19),
(24,17);

/*Table structure for table `stok` */

DROP TABLE IF EXISTS `stok`;

CREATE TABLE `stok` (
  `id_stok` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_stok` VARCHAR(255) DEFAULT NULL,
  `jumlah_stok` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id_stok`)
) ENGINE=INNODB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `stok` */

INSERT  INTO `stok`(`id_stok`,`nama_stok`,`jumlah_stok`) VALUES 
(1,'Susu',100),
(2,'Biji Kopi',30),
(3,'Cocoa Powder',30),
(4,'Daun Teh',70),
(5,'Air',990),
(6,'Es Batu',189),
(7,'Lemon',50),
(8,'Alpukat',30),
(9,'Es Krim',38),
(10,'Bubuk Matcha',25),
(11,'Kentang',100),
(12,'Garam',500),
(13,'Sosis',80),
(14,'Pretzel',40),
(15,'Croissant',30),
(16,'Baguette',20),
(17,'Tartar Sauce',50),
(18,'Tomato Sauce',53),
(19,'Chili Sauce',70),
(20,'Keju',50),
(21,'Nasi',100),
(22,'Sauce-saucean',70);

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
) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `transaksi` */

INSERT  INTO `transaksi`(`id_transaksi`,`id_user`,`id_menu`,`jumlah`,`tanggal`,`total_harga`) VALUES 
(1,4,2,20,'2025-01-10',400000),
(2,4,5,10,'2025-01-10',240000),
(3,4,6,11,'2025-01-10',308000),
(4,4,9,2,'2025-01-10',30000),
(5,4,18,7,'2025-01-10',350000);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id_user` INT(50) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) DEFAULT NULL,
  `nama` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(15) DEFAULT NULL,
  `id_member` INT(50) DEFAULT NULL,
  `img` VARCHAR(255) DEFAULT NULL,
  `status` TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

INSERT  INTO `users`(`id_user`,`username`,`password`,`nama`,`email`,`phone`,`id_member`,`img`,`status`) VALUES 
(4,'qwe','qwe','qwe','qwe@example.com','1234567890',NULL,NULL,1),
(5,'asd','asd','asd','asd@example.com','0987654321',NULL,NULL,0);

CREATE TABLE `transaksi_pegawai` (
  `id_transaksi` INT(10) NOT NULL AUTO_INCREMENT,
  `id_cashout` INT(10) DEFAULT NULL,
  `id_pegawai` INT(10) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
