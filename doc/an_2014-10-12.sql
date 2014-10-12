# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.15)
# Database: an
# Generation Time: 2014-10-12 15:25:43 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table co_income
# ------------------------------------------------------------

DROP TABLE IF EXISTS `co_income`;

CREATE TABLE `co_income` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `province_id` varchar(255) DEFAULT NULL,
  `sp_name` varchar(255) DEFAULT NULL,
  `sp_code` varchar(255) DEFAULT NULL,
  `buss_type` varchar(255) DEFAULT NULL,
  `province_income` varchar(255) DEFAULT NULL,
  `sp_income` varchar(255) DEFAULT NULL,
  `owe` varchar(255) DEFAULT NULL,
  `tuipei_cost` varchar(255) DEFAULT NULL,
  `imbalance_cost` varchar(255) DEFAULT NULL,
  `20_cost` varchar(255) DEFAULT NULL,
  `diaozhang_cost` varchar(255) DEFAULT NULL,
  `violate_cost` varchar(255) DEFAULT NULL,
  `custom_cost` varchar(255) DEFAULT NULL,
  `month` varchar(50) DEFAULT NULL,
  `mastsp_code` varchar(50) DEFAULT NULL,
  `mastsp_cost` varchar(50) DEFAULT NULL,
  `mastsp_sleave` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
