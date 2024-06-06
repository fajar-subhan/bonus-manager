-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.13-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6263
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for testing
CREATE DATABASE IF NOT EXISTS `testing` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `testing`;

-- Dumping structure for table testing.log_user_activity
CREATE TABLE IF NOT EXISTS `log_user_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_activity_module` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_activity_name` varchar(100) DEFAULT NULL,
  `user_activity_desc` varchar(100) DEFAULT NULL,
  `user_activity_address` varchar(100) DEFAULT NULL,
  `user_activity_browser` varchar(100) DEFAULT NULL,
  `user_activity_os` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table testing.log_user_activity: ~0 rows (approximately)
/*!40000 ALTER TABLE `log_user_activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_user_activity` ENABLE KEYS */;

-- Dumping structure for table testing.mst_bonus
CREATE TABLE IF NOT EXISTS `mst_bonus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total_bonus` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_uid` int(11) DEFAULT NULL COMMENT 'ref_user.id',
  `updated_uid` int(11) DEFAULT NULL COMMENT 'ref_user.id',
  PRIMARY KEY (`id`),
  KEY `created_uid` (`created_uid`),
  KEY `updated_uid` (`updated_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table untuk menginput data payment bonus nya';

-- Dumping data for table testing.mst_bonus: ~0 rows (approximately)
/*!40000 ALTER TABLE `mst_bonus` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_bonus` ENABLE KEYS */;

-- Dumping structure for table testing.mst_bonus_distribution
CREATE TABLE IF NOT EXISTS `mst_bonus_distribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bonus_id` bigint(20) unsigned NOT NULL COMMENT 'mst_bonus.id',
  `name` varchar(50) DEFAULT NULL,
  `percentase` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_uid` int(11) DEFAULT NULL COMMENT 'ref_user.id',
  `updated_uid` int(11) DEFAULT NULL COMMENT 'ref_user.id',
  PRIMARY KEY (`id`),
  KEY `bonus_id` (`bonus_id`),
  KEY `created_uid` (`created_uid`),
  KEY `updated_uid` (`updated_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Berguna untuk pembagian bonus kepada setiap buruh yang ada';

-- Dumping data for table testing.mst_bonus_distribution: ~0 rows (approximately)
/*!40000 ALTER TABLE `mst_bonus_distribution` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_bonus_distribution` ENABLE KEYS */;

-- Dumping structure for table testing.mst_roles
CREATE TABLE IF NOT EXISTS `mst_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table testing.mst_roles: ~2 rows (approximately)
/*!40000 ALTER TABLE `mst_roles` DISABLE KEYS */;
INSERT INTO `mst_roles` (`id`, `name`, `order`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 1, '2024-06-05 19:46:18', NULL),
	(2, 'Regular User', 2, '2024-06-05 19:46:27', NULL);
/*!40000 ALTER TABLE `mst_roles` ENABLE KEYS */;

-- Dumping structure for table testing.ref_user
CREATE TABLE IF NOT EXISTS `ref_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `login` int(11) NOT NULL COMMENT '0 = Login,1 = Tidak Login',
  `role_id` int(11) NOT NULL COMMENT 'mst_roles.id',
  `active` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Aktif,0 = Tidak Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_uid` int(11) DEFAULT NULL,
  `updated_uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table testing.ref_user: ~2 rows (approximately)
/*!40000 ALTER TABLE `ref_user` DISABLE KEYS */;
INSERT INTO `ref_user` (`id`, `username`, `password`, `fullname`, `login`, `role_id`, `active`, `created_at`, `updated_at`, `created_uid`, `updated_uid`) VALUES
	(1, 'Administrator', '$2y$10$wOFsF/EeFvbVzZSmYgPLWu2IO7qsu5X8MDQ172nbSct27CRdvhFWK', 'Fajar Subhan', 0, 1, 1, '2024-06-05 19:47:45', NULL, 1, NULL),
	(2, 'user1', '$2y$10$wOFsF/EeFvbVzZSmYgPLWu2IO7qsu5X8MDQ172nbSct27CRdvhFWK', 'User 1', 0, 2, 1, '2024-06-07 06:30:16', NULL, 1, NULL);
/*!40000 ALTER TABLE `ref_user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
