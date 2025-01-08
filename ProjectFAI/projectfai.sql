/*!40101 SET NAMES utf8 */;
/*!40101 SET SQL_MODE=''*/;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`projectfai` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `projectfai`;

/* 1. Table `kategori` */
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
  `id_kategori` INT(50) NOT NULL AUTO_INCREMENT,
  `nama_kategori` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `kategori` (id_kategori, nama_kategori) VALUES
(1, 'Minuman'),
(2, 'Heavy Food'),
(3, 'Snack'),
(4, 'Add On');

/* 2. Table `menu` */
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
-- Insert data ke tabel `menu` dilakukan setelah seluruh tabel selesai.

/* 3. Table `stok` */
DROP TABLE IF EXISTS `stok`;
CREATE TABLE `stok` (
  `id_stok` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_stok` VARCHAR(255) DEFAULT NULL,
  `jumlah_stok` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id_stok`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/* 4. Table `resep` */
DROP TABLE IF EXISTS `resep`;
CREATE TABLE `resep` (
  `id_resep` INT(11) DEFAULT NULL,
  `id_stok` INT(11) DEFAULT NULL,
  KEY `id_stok` (`id_stok`),
  CONSTRAINT `resep_ibfk_1` FOREIGN KEY (`id_stok`) REFERENCES `stok` (`id_stok`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/* 5. Table `member` */
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id_member` INT(50) NOT NULL AUTO_INCREMENT,
  `nama_member` VARCHAR(255) DEFAULT NULL,
  `potongan_member` INT(50) DEFAULT NULL,
  `minTrans_member` INT(50) DEFAULT NULL,
  PRIMARY KEY (`id_member`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/* 6. Table `pegawai` */
DROP TABLE IF EXISTS `pegawai`;
CREATE TABLE `pegawai` (
  `id_pegawai` INT(50) NOT NULL AUTO_INCREMENT,
  `nama_pegawai` VARCHAR(255) DEFAULT NULL,
  `alamat_pegawai` VARCHAR(255) DEFAULT NULL,
  `status_pegawai` TINYINT(1) DEFAULT 0,
  `password_pegawai` VARCHAR(255) DEFAULT NULL,
  `gaji_pegawai` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/* 7. Table `users` */
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
  `status` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id_user`),
  KEY `id_member` (`id_member`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/* 8. Table `produk` */
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
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


/* 10. Table `history` */
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

/* 11. Table `topping` */

/* 12. Table `transaksi` */
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


/*Data for the table `pegawai` */

INSERT  INTO `pegawai`(`id_pegawai`,`nama_pegawai`,`alamat_pegawai`,`status_pegawai`,`password_pegawai`,`gaji_pegawai`) VALUES 
(2,'Jason','Jl Ngagel',1,'jason','20000'),
(3,'rico','Jl Utara',0,'rico','20000');

/*Table structure for table `pesanan` */




/*Data for the table `pesanan` */

/*Table structure for table `produk` */



/*Table structure for table `resep` */

DROP TABLE IF EXISTS `resep`;

CREATE TABLE `resep` (
  `id_resep` INT(11) DEFAULT NULL,
  `id_stok` INT(11) DEFAULT NULL,

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
INSERT INTO `stok` (`nama_stok`, `jumlah_stok`) VALUES
('Susu', 100),
('Biji Kopi', 50),
('Cocoa Powder', 30),
('Daun Teh', 70),
('Air', 1000),
('Es Batu', 200),
('Lemon', 50),
('Alpukat', 30),
('Es Krim', 40),
('Bubuk Matcha', 25),
('Kentang', 100),
('Garam', 500),
('Sosis', 80),
('Pretzel', 40),
('Croissant', 30),
('Baguette', 20),
('Tartar Sauce', 50),
('Tomato Sauce', 60),
('Chili Sauce', 70),
('Keju', 50),
('Nasi', 100),
('Sauce-saucean', 70);
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
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id_cart` INT(50) NOT NULL AUTO_INCREMENT,
  `id_user` INT(50) NOT NULL,
  `id_menu` INT(50) NOT NULL,
  `jumlah` INT(50) NOT NULL,
  `status` TINYINT(1) DEFAULT 1, -- 1 untuk aktif, 0 untuk dibatalkan
  PRIMARY KEY (`id_cart`),
  KEY `id_user` (`id_user`),
  KEY `id_menu` (`id_menu`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
  `status` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id_user`),
  KEY `id_member` (`id_member`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`)
) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

INSERT INTO `produk` (`nama_produk`, `id_kategori`, `harga`, `stok`, `id_supplier`, `status`) VALUES
-- Bahan Minuman
('Susu', 1, '10000', 100, NULL, 1),
('Biji Kopi', 1, '120000', 50, NULL, 1),
('Cocoa Powder', 1, '30000', 80, NULL, 1),
('Daun Teh', 1, '15000', 70, NULL, 1),
('Air', 1, '500', 1000, NULL, 1),
('Es Batu', 1, '2000', 200, NULL, 1),
('Lemon', 1, '5000', 50, NULL, 1),
('Alpukat', 1, '20000', 30, NULL, 1),
('Es Krim', 1, '10000', 40, NULL, 1),
('Bubuk Matcha', 1, '50000', 25, NULL, 1),

-- Bahan Snack
('Kentang', 3, '8000', 100, NULL, 1),
('Garam', 3, '1000', 500, NULL, 1),
('Sosis', 3, '12000', 80, NULL, 1),
('Pretzel', 3, '15000', 40, NULL, 1),
('Croissant', 3, '18000', 30, NULL, 1),
('Baguette', 3, '20000', 20, NULL, 1),
('Tartar Sauce', 3, '10000', 50, NULL, 1),
('Tomato Sauce', 3, '7000', 60, NULL, 1),
('Chili Sauce', 3, '6000', 70, NULL, 1),

-- Bahan Heavy Food
('Keju', 4, '15000', 50, NULL, 1),
('Nasi', 4, '5000', 100, NULL, 1),
('Sauce-saucean', 4, '8000', 70, NULL, 1);


INSERT INTO `resep` (`id_resep`, `id_stok`) VALUES 
(1, 1), 
(1, 2), 
(2, 2), 
(3, 1), 
(3, 2), 
(4, 2), 
(5, 1), 
(5, 2), 
(6, 10), 
(6, 1), 
(7, 10), 
(7, 2), 
(8, 8), 
(8, 9), 
(9, 7), 
(9, 4), 
(10, 4), 
(10, 6), 
(11, 3), 
(11, 1), 
(12, 11), 
(12, 12), 
(13, 13), 
(14, 14), 
(15, 15), 
(16, 16), 
(17, 17), 
(18, 18), 
(19, 19), 
(20, 20), 
(21, 17), 
(22, 20), 
(23, 19), 
(24, 17);
INSERT  INTO `users`(`id_user`,`username`,`password`,`nama`,`email`,`phone`,`id_member`,`img`,`status`) VALUES 
(4,'qwe','qwe','qwe','qwe@gmail.com','22',NULL,NULL,1),
(5,'zxc','zxc','zxc','zxc@gmail.com','222',NULL,NULL,1);
-- Insert data into `menu` with image paths
-- Insert data into `menu` with image paths
INSERT INTO `menu` (`nama_menu`, `kategori_menu`, `harga_menu`, `image_menu`) VALUES
-- Minuman
('Oat Latte', 1, 25000, 'storage/menu/OatMilkLatte.jpg'),
('Americano', 1, 20000, 'storage/menu/americano.jpg'),
('Cafe Latte', 1, 23000, 'storage/menu/cafelatte.jpg'),
('V60', 1, 27000, 'storage/menu/v60.jpg'),
('Cappuccino', 1, 24000, 'storage/menu/capuccino.jpg'),
('Matcha Latte', 1, 28000, 'storage/menu/iced-matcha-latte.jpg'),
('Matcha Coffee', 1, 30000, 'storage/menu/matcha-coffee.jpg'),
('Avocado Juice', 1, 22000, 'storage/menu/jus-alpukat.jpg'),
('Lemon Tea', 1, 15000, 'storage/menu/lemontea.jpg'),
('Ice Tea', 1, 10000, 'storage/menu/icedtea.jpg'),
('Ice Chocolate', 1, 18000, 'storage/menu/icedchoco.jpg'),

-- Snack
('Kentang Goreng', 3, 15000, 'storage/menu/kentanggoreng.jpeg'),
('Sosis Goreng', 3, 18000, 'storage/menu/sosisgoreng.jpg'),
('Pretzel', 3, 20000, 'storage/menu/pretzel.jpg'),
('Croissant', 3, 22000, 'storage/menu/croisant.jpg'),
('Baguette', 3, 25000, 'storage/menu/baguete.jpg'),

-- Heavy Food
('Spaghetti Bolognese', 2, 40000, 'storage/menu/bolognes.jpg'),
('Fish and Chips', 2, 50000, 'storage/menu/fishnchips.jpg'),
('Fried Rice (Seafood)', 2, 35000, 'storage/menu/nasgorseafood.jpg'),
('Fried Rice (Special)', 2, 37000, 'storage/menu/nasgorspecial.jpg'),
('Chicken Cordon Bleu', 2, 55000, 'storage/menu/cordonbleu.jpg'),
('Carbonara', 2, 42000, 'storage/menu/carbonara.jpg'),

-- Add On (Topping)
('Keju', 4, 5000, 'storage/menu/keju.jpg'),
('Nasi', 4, 7000, 'storage/menu/nasi.jpg'),
('Saus Tomat', 4, 3000, 'storage/menu/saustomat.jpg'),
('Saus Sambal', 4, 3000, 'storage/menu/saus-sambal.jpg'),
('Saus BBQ', 4, 3000, 'storage/menu/bbqsauce.jpg'),
('Saus Mayones', 4, 3000, 'storage/menu/mayones.jpg'),
('Saus Tartar', 4, 3000, 'storage/menu/tartar.jpg'),
('Saus Kecap', 4, 2000, 'storage/menu/kecap.jpg');
-- Insert data into `topping` with image paths


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
