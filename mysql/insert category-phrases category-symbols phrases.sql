CREATE DATABASE  IF NOT EXISTS `Igitur` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `Igitur`;
-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (i686)
--
-- Host: 127.0.0.1    Database: Igitur
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.10.1

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
-- Table structure for table `LogicalConnectiveCategory_has_LogicalConnectiveSymbol`
--

DROP TABLE IF EXISTS `LogicalConnectiveCategory_has_LogicalConnectiveSymbol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LogicalConnectiveCategory_has_LogicalConnectiveSymbol` (
  `LogicalConnectiveCategory_idLogicalConnectiveCategory` int(11) NOT NULL AUTO_INCREMENT,
  `LogicalConnectiveSymbol_idLogicalConnectiveSymbol` int(11) NOT NULL,
  PRIMARY KEY (`LogicalConnectiveCategory_idLogicalConnectiveCategory`,`LogicalConnectiveSymbol_idLogicalConnectiveSymbol`),
  KEY `fk_LogicalConnectiveCategory_has_LogicalConnectiveSymbol_Lo_idx` (`LogicalConnectiveSymbol_idLogicalConnectiveSymbol`),
  KEY `fk_LogicalConnectiveCategory_has_LogicalConnectiveSymbol_Lo_idx1` (`LogicalConnectiveCategory_idLogicalConnectiveCategory`),
  CONSTRAINT `fk_LogicalConnectiveCategory_has_LogicalConnectiveSymbol_Logi1` FOREIGN KEY (`LogicalConnectiveCategory_idLogicalConnectiveCategory`) REFERENCES `LogicalConnectiveCategory` (`idLogicalConnectiveCategory`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_LogicalConnectiveCategory_has_LogicalConnectiveSymbol_Logi2` FOREIGN KEY (`LogicalConnectiveSymbol_idLogicalConnectiveSymbol`) REFERENCES `LogicalConnectiveSymbol` (`idLogicalConnectiveSymbol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LogicalConnectiveCategory_has_LogicalConnectiveSymbol`
--

LOCK TABLES `LogicalConnectiveCategory_has_LogicalConnectiveSymbol` WRITE;
/*!40000 ALTER TABLE `LogicalConnectiveCategory_has_LogicalConnectiveSymbol` DISABLE KEYS */;
INSERT INTO `LogicalConnectiveCategory_has_LogicalConnectiveSymbol` VALUES (1,1),(1,2),(2,3),(2,4),(12,4),(2,5),(3,6),(3,7),(3,8),(4,9),(4,10),(4,11),(5,12),(5,13),(5,14),(6,15),(6,16),(7,17),(7,18),(8,19),(8,20),(9,21),(10,22),(11,23),(12,24),(12,25),(14,26),(15,27);
/*!40000 ALTER TABLE `LogicalConnectiveCategory_has_LogicalConnectiveSymbol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LogicalConnectiveCategory_has_LogicalConnectivePhrase`
--

DROP TABLE IF EXISTS `LogicalConnectiveCategory_has_LogicalConnectivePhrase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LogicalConnectiveCategory_has_LogicalConnectivePhrase` (
  `LogicalConnectiveCategory_idLogicalConnectiveCategory` int(11) NOT NULL AUTO_INCREMENT,
  `LogicalConnectivePhrase_idLogicalConnectivePhrase` int(11) NOT NULL,
  PRIMARY KEY (`LogicalConnectiveCategory_idLogicalConnectiveCategory`,`LogicalConnectivePhrase_idLogicalConnectivePhrase`),
  KEY `fk_LogicalConnectiveCategory_has_LogicalConnectivePhrase_Lo_idx` (`LogicalConnectivePhrase_idLogicalConnectivePhrase`),
  KEY `fk_LogicalConnectiveCategory_has_LogicalConnectivePhrase_Lo_idx1` (`LogicalConnectiveCategory_idLogicalConnectiveCategory`),
  CONSTRAINT `fk_LogicalConnectiveCategory_has_LogicalConnectivePhrase_Logi1` FOREIGN KEY (`LogicalConnectiveCategory_idLogicalConnectiveCategory`) REFERENCES `LogicalConnectiveCategory` (`idLogicalConnectiveCategory`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_LogicalConnectiveCategory_has_LogicalConnectivePhrase_Logi2` FOREIGN KEY (`LogicalConnectivePhrase_idLogicalConnectivePhrase`) REFERENCES `LogicalConnectivePhrase` (`idLogicalConnectivePhrase`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LogicalConnectiveCategory_has_LogicalConnectivePhrase`
--

LOCK TABLES `LogicalConnectiveCategory_has_LogicalConnectivePhrase` WRITE;
/*!40000 ALTER TABLE `LogicalConnectiveCategory_has_LogicalConnectivePhrase` DISABLE KEYS */;
INSERT INTO `LogicalConnectiveCategory_has_LogicalConnectivePhrase` VALUES (1,1),(1,2),(2,3),(2,4),(3,5),(4,8),(5,9),(6,10),(7,11),(8,13),(8,14),(9,15),(9,16),(9,17),(10,18),(11,19),(14,20),(15,21),(5,22),(6,23),(12,24);
/*!40000 ALTER TABLE `LogicalConnectiveCategory_has_LogicalConnectivePhrase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LogicalConnectivePhrase`
--

DROP TABLE IF EXISTS `LogicalConnectivePhrase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LogicalConnectivePhrase` (
  `idLogicalConnectivePhrase` int(11) NOT NULL AUTO_INCREMENT,
  `logicalConnectivePhrase` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idLogicalConnectivePhrase`),
  UNIQUE KEY `logicalConnectivePhrase_UNIQUE` (`logicalConnectivePhrase`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LogicalConnectivePhrase`
--

LOCK TABLES `LogicalConnectivePhrase` WRITE;
/*!40000 ALTER TABLE `LogicalConnectivePhrase` DISABLE KEYS */;
INSERT INTO `LogicalConnectivePhrase` VALUES (8,'and'),(13,'bottom'),(21,'entails'),(10,'exclusive or'),(14,'falsum'),(15,'for all'),(16,'for any'),(17,'for each'),(3,'if and only if'),(4,'iff'),(1,'ifthen'),(2,'implies'),(22,'inclusive or'),(24,'is defined as'),(7,'negates'),(6,'negation'),(5,'not'),(9,'or'),(20,'provable'),(18,'there exists'),(19,'there exists exactly one'),(11,'top'),(12,'verum'),(23,'xor');
/*!40000 ALTER TABLE `LogicalConnectivePhrase` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-11-25  3:12:19