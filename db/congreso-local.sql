-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.18 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for congresoloc
CREATE DATABASE IF NOT EXISTS `congresoloc` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `congresoloc`;

-- Dumping structure for table congresoloc.evaluacion
CREATE TABLE IF NOT EXISTS `evaluacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `e_trabajo` int(11) NOT NULL,
  `e_listo` varchar(25) DEFAULT NULL,
  `e_create` datetime DEFAULT CURRENT_TIMESTAMP,
  `e_evaluador` varchar(255) NOT NULL,
  `e_comentario` varchar(255) DEFAULT NULL,
  `e_decision` varchar(50) DEFAULT NULL,
  `e_update` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `e_c1` char(50) DEFAULT NULL,
  `e_c2` char(50) DEFAULT NULL,
  `e_c3` char(50) DEFAULT NULL,
  `e_c4` char(50) DEFAULT NULL,
  `e_c5` char(50) DEFAULT NULL,
  `e_c6` char(50) DEFAULT NULL,
  `e_c7` char(50) DEFAULT NULL,
  `e_c8` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table congresoloc.trabajos
CREATE TABLE IF NOT EXISTS `trabajos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t_nombre` varchar(255) NOT NULL DEFAULT '0',
  `t_propietario` varchar(50) NOT NULL DEFAULT '0',
  `t_ubicacion` varchar(50) NOT NULL DEFAULT '0',
  `t_descripcion` varchar(255) DEFAULT NULL,
  `t_estado` varchar(50) DEFAULT NULL,
  `t_autores` varchar(50) DEFAULT NULL,
  `t_categoria` varchar(50) DEFAULT NULL,
  `t_tipo` varchar(50) DEFAULT NULL,
  `t_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `t_camera` varchar(50) DEFAULT NULL,
  `t_comprobante` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table congresoloc.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_create` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_tipo` varchar(50) DEFAULT NULL,
  `user_nombre` varchar(50) DEFAULT NULL,
  `user_apellido` varchar(50) DEFAULT NULL,
  `user_fecnac` datetime DEFAULT NULL,
  `user_ocup` varchar(50) DEFAULT NULL,
  `user_inst` varchar(50) DEFAULT NULL,
  `user_domr` varchar(50) DEFAULT NULL,
  `user_locr` varchar(50) DEFAULT NULL,
  `user_tel1` varchar(50) DEFAULT NULL,
  `user_tel2` varchar(50) DEFAULT NULL,
  `user_email1` varchar(50) DEFAULT NULL,
  `user_email2` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
