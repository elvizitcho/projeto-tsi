-- MySQL dump 10.13  Distrib 5.6.30, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: enove
-- ------------------------------------------------------
-- Server version	5.6.30-1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `enove`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `enove` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `enove`;

--
-- Table structure for table `comodos`
--

DROP TABLE IF EXISTS `comodos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comodos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(64) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 -> Ativo\n0 -> Inativo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comodos`
--

LOCK TABLES `comodos` WRITE;
/*!40000 ALTER TABLE `comodos` DISABLE KEYS */;
INSERT INTO `comodos` VALUES (1,'Sala',1),(2,'Quarto A',1),(3,'Banheiro A',1),(4,'Quarto B',1),(5,'Banheiro B',1),(6,'Escritório',1),(7,'Corredor',1),(8,'Churrasqueira',1),(9,'Cozinha',0);
/*!40000 ALTER TABLE `comodos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dispositivos`
--

DROP TABLE IF EXISTS `dispositivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dispositivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(64) NOT NULL,
  `comodo_id` int(11) NOT NULL,
  `tipo` int(11) NOT NULL DEFAULT '1' COMMENT '1 -> Lampada\n2 -> Eletrodoméstico',
  `potencia` decimal(10,2) NOT NULL COMMENT 'Potencia da lampada ou eletrodoméstico',
  `porta` int(11) NOT NULL,
  `ligado` int(11) NOT NULL DEFAULT '0' COMMENT '1 -> ligado\n0 -> desligado',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 -> Atvo\n0 -> Inativo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispositivos`
--

LOCK TABLES `dispositivos` WRITE;
/*!40000 ALTER TABLE `dispositivos` DISABLE KEYS */;
INSERT INTO `dispositivos` VALUES (1,'Lâmpada',1,1,15.00,3,1,1),(2,'Lâmpada',2,1,15.00,24,1,1),(3,'Lâmpada',3,1,15.00,28,1,1),(4,'Lâmpada',4,1,15.00,25,1,1),(5,'Lâmpada',5,1,15.00,31,1,1),(6,'Lâmpada',6,1,15.00,26,1,1),(7,'Lâmpada',7,1,15.00,27,1,1),(8,'Lâmpada',8,1,15.00,34,1,1);
/*!40000 ALTER TABLE `dispositivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historico`
--

DROP TABLE IF EXISTS `historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dispositivo_id` int(11) NOT NULL,
  `inicio` datetime NOT NULL,
  `fim` datetime DEFAULT NULL,
  `consumo` decimal(16,6) DEFAULT NULL COMMENT 'Consumo em kw/h',
  PRIMARY KEY (`id`),
  KEY `dispositivo_id` (`dispositivo_id`),
  CONSTRAINT `historico_ibfk_1` FOREIGN KEY (`dispositivo_id`) REFERENCES `dispositivos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico`
--

LOCK TABLES `historico` WRITE;
/*!40000 ALTER TABLE `historico` DISABLE KEYS */;
INSERT INTO `historico` VALUES (1,1,'2018-12-04 20:38:56','2018-12-04 20:39:10',NULL),(2,1,'2018-12-04 20:39:23','2018-12-04 20:42:31',NULL),(3,1,'2018-12-04 20:39:25','2018-12-04 20:42:31',NULL),(4,1,'2018-12-04 20:42:42','2018-12-04 21:10:53',NULL),(5,1,'2018-12-04 21:10:53','2018-12-04 21:10:54',NULL),(6,1,'2018-12-04 21:10:54','2018-12-04 21:10:54',NULL),(7,1,'2018-12-04 20:10:55','2018-12-04 21:11:08',NULL),(8,1,'2018-12-04 20:05:24','2018-12-04 21:11:33',NULL),(9,1,'2018-12-04 20:00:00','2018-12-04 21:12:46',1.190000),(10,1,'2018-12-04 20:00:00','2018-12-04 21:16:55',1.260000),(11,1,'2018-12-04 20:00:00','2018-12-04 21:19:44',1.302311),(12,1,'2018-12-04 21:54:01','2018-12-04 21:54:03',0.000544),(13,2,'2018-12-04 19:54:08','2018-12-04 21:54:19',1.442200),(14,3,'2018-12-10 18:09:49','2018-12-10 18:09:54',0.000013),(15,3,'2018-12-10 18:09:58','2018-12-10 18:10:16',0.000045),(16,3,'2018-12-10 18:10:21','2018-12-10 18:10:24',0.000008),(17,3,'2018-12-10 18:17:12','2018-12-10 18:17:27',0.000038),(18,3,'2018-12-10 18:17:30','2018-12-10 18:17:34',0.000010),(19,3,'2018-12-10 18:17:34','2018-12-10 18:17:34',0.000000),(20,3,'2018-12-10 18:17:34','2018-12-10 18:17:34',0.000000),(21,3,'2018-12-10 18:17:34','2018-12-10 18:17:35',0.000003),(22,3,'2018-12-10 18:17:35','2018-12-10 18:17:35',0.000000),(23,3,'2018-12-10 18:17:35','2018-12-10 18:17:35',0.000000),(24,3,'2018-12-10 18:17:36','2018-12-10 18:17:42',0.000015),(25,1,'2018-12-10 19:20:35','2018-12-10 19:22:06',0.000379),(26,2,'2018-12-10 19:20:45','2018-12-10 19:22:02',0.000321),(27,3,'2018-12-10 19:20:57','2018-12-10 19:21:56',0.000246),(28,4,'2018-12-10 19:21:05','2018-12-10 19:21:52',0.000196),(29,5,'2018-12-10 19:21:11','2018-12-10 19:21:47',0.000150),(30,6,'2018-12-10 19:21:16','2018-12-10 19:21:44',0.000117),(31,7,'2018-12-10 19:21:22','2018-12-10 19:21:43',0.000088),(32,8,'2018-12-10 19:21:26','2018-12-10 19:21:36',0.000042),(33,8,'2018-12-10 19:21:36','2018-12-10 19:21:36',0.000000),(34,6,'2018-12-10 19:22:22','2018-12-10 19:22:25',0.000013),(35,1,'2018-12-10 19:24:49',NULL,NULL),(36,2,'2018-12-10 19:24:50',NULL,NULL),(37,3,'2018-12-10 19:24:51',NULL,NULL),(38,4,'2018-12-10 19:24:52',NULL,NULL),(39,8,'2018-12-10 19:24:52',NULL,NULL),(40,7,'2018-12-10 19:25:17',NULL,NULL),(41,6,'2018-12-10 19:25:17',NULL,NULL),(42,5,'2018-12-10 19:25:17',NULL,NULL);
/*!40000 ALTER TABLE `historico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) DEFAULT NULL,
  `usuario` varchar(32) DEFAULT NULL,
  `senha` varchar(32) DEFAULT NULL,
  `token` varchar(8) DEFAULT NULL,
  `status` int(11) DEFAULT '1' COMMENT '1 -> Ativo\n0 -> Inativo',
  `permissao` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Administrador','admin','21232f297a57a5a743894a0e4a801fc3',NULL,1,'default');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-10 20:37:11
