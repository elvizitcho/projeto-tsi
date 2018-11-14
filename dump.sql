-- MySQL dump 10.16  Distrib 10.1.26-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: enove
-- ------------------------------------------------------
-- Server version	10.1.26-MariaDB-0+deb9u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comodos`
--

LOCK TABLES `comodos` WRITE;
/*!40000 ALTER TABLE `comodos` DISABLE KEYS */;
INSERT INTO `comodos` VALUES (1,'sala',0),(2,'Sala',1),(3,'Quarto',1),(4,'Cozinha',1),(5,'Subsolo',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispositivos`
--

LOCK TABLES `dispositivos` WRITE;
/*!40000 ALTER TABLE `dispositivos` DISABLE KEYS */;
INSERT INTO `dispositivos` VALUES (1,'Televisão 50\"',2,2,980.00,8,0,1),(2,'Cadeira Elétrica',5,2,720.00,666,0,1);
/*!40000 ALTER TABLE `dispositivos` ENABLE KEYS */;
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

-- Dump completed on 2018-11-14 20:15:01
