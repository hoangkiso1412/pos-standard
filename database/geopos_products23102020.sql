-- MySQL dump 10.13  Distrib 8.0.16, for macos10.14 (x86_64)
--
-- Host: localhost    Database: standard-pos
-- ------------------------------------------------------
-- Server version	5.7.25

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `geopos_products`
--

DROP TABLE IF EXISTS `geopos_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `geopos_products` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pcat` int(3) NOT NULL DEFAULT '1',
  `warehouse` int(11) NOT NULL DEFAULT '1',
  `product_name` varchar(80) NOT NULL,
  `product_code` varchar(30) DEFAULT NULL,
  `product_price` decimal(16,2) DEFAULT '0.00',
  `fproduct_price` decimal(16,2) DEFAULT '0.00',
  `taxrate` decimal(16,2) DEFAULT '0.00',
  `disrate` decimal(16,2) DEFAULT '0.00',
  `qty` decimal(10,2) DEFAULT NULL,
  `product_des` text,
  `alert` int(11) DEFAULT NULL,
  `unit` varchar(4) DEFAULT NULL,
  `image` varchar(120) DEFAULT 'default.png',
  `barcode` varchar(16) DEFAULT NULL,
  `merge` int(2) NOT NULL,
  `sub` int(11) NOT NULL,
  `vb` int(11) NOT NULL,
  `expiry` date DEFAULT NULL,
  `code_type` varchar(8) DEFAULT 'EAN13',
  `sub_id` int(11) DEFAULT '0',
  `b_id` int(11) DEFAULT '0',
  `color` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pid`) USING BTREE,
  KEY `pcat` (`pcat`) USING BTREE,
  KEY `warehouse` (`warehouse`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `geopos_products`
--

LOCK TABLES `geopos_products` WRITE;
/*!40000 ALTER TABLE `geopos_products` DISABLE KEYS */;
INSERT INTO `geopos_products` VALUES (6,3,1,'Honda Dream','112233',2500.00,2000.00,0.00,0.00,5.00,'Test',0,'','168320DREAM125-2019.png','835143775283',0,0,0,NULL,'EAN13',4,NULL,NULL,NULL),(7,3,1,'Honda Dream','334444',2500.00,2000.00,0.00,0.00,0.00,'',0,'','657689Honda-Dream-red.png','327662637026',0,0,0,NULL,'EAN13',4,0,NULL,NULL),(8,3,1,'Honda Dream','3344457756',2500.00,2000.00,0.00,0.00,1.00,'',0,'','998400DREAM125-2019.png','808381671946',0,0,0,NULL,'        ',4,NULL,NULL,NULL),(9,3,1,'Suzuki Viva','34443',2300.00,2000.00,0.00,0.00,1.00,'',0,'','54241118987941m.jpg','787376061283',0,0,0,NULL,'  EAN13',6,NULL,'លឿង','2022'),(10,3,1,'Honda Click','6633447774',2800.00,2000.00,0.00,0.00,0.00,'',1,'','465028CLICK125IRed.png','421475148680',0,0,0,NULL,'      EA',4,NULL,NULL,NULL),(11,3,1,'Honda Click','43593',2800.00,2000.00,0.00,0.00,0.00,'',0,'','696992CLICK125I.png','862539986499',0,0,0,NULL,'  EAN13',4,NULL,NULL,NULL);
/*!40000 ALTER TABLE `geopos_products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-10-23 19:56:07
