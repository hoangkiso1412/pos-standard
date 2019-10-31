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
-- Table structure for table `geopos_purchase`
--

DROP TABLE IF EXISTS `geopos_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `geopos_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `shipping` decimal(16,2) DEFAULT '0.00',
  `ship_tax` decimal(16,2) DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') DEFAULT 'off',
  `discount` decimal(16,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `total` decimal(16,2) DEFAULT '0.00',
  `pmethod` varchar(14) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` enum('paid','due','canceled','partial') DEFAULT 'due',
  `csd` int(5) NOT NULL DEFAULT '0',
  `eid` int(4) NOT NULL,
  `pamnt` decimal(16,2) DEFAULT '0.00',
  `items` decimal(10,2) NOT NULL,
  `taxstatus` enum('yes','no','incl','cgst','igst') DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat','b_p','bflat') DEFAULT NULL,
  `refer` varchar(20) DEFAULT NULL,
  `term` int(3) NOT NULL,
  `loc` int(4) NOT NULL,
  `multi` int(11) DEFAULT NULL,
  `purchaser_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `invoice` (`tid`) USING BTREE,
  KEY `eid` (`eid`) USING BTREE,
  KEY `csd` (`csd`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `geopos_purchase`
--

LOCK TABLES `geopos_purchase` WRITE;
/*!40000 ALTER TABLE `geopos_purchase` DISABLE KEYS */;
INSERT INTO `geopos_purchase` VALUES (1,1001,'2019-10-27','2019-10-27',4225.50,0.00,0.00,'incl',0.00,200.50,4225.50,NULL,'','due',1,10,0.00,2.00,'yes',1,'%','',1,0,NULL,NULL),(2,1002,'2019-10-27','2019-10-27',2000.00,0.00,0.00,'incl',0.00,0.00,2000.00,NULL,'','due',1,10,0.00,1.00,'yes',1,'%','',1,0,NULL,NULL),(3,1003,'2019-10-27','2019-10-27',4104.50,0.00,0.00,'incl',110.50,200.00,4104.50,NULL,'','due',1,10,0.00,2.00,'yes',1,'%','',1,0,NULL,NULL),(5,1004,'2019-10-27','2019-10-27',4099.50,0.00,0.00,'incl',110.50,200.00,4099.50,NULL,'','due',1,10,0.00,2.00,'yes',1,'%','',1,0,NULL,NULL),(6,1005,'2019-10-31','2019-10-31',2000.00,0.00,0.00,'incl',0.00,0.00,2000.00,NULL,'','due',1,10,0.00,1.00,'yes',1,'%','',1,0,NULL,12),(7,1006,'2019-10-31','2019-10-31',2000.00,0.00,0.00,'incl',0.00,0.00,2000.00,NULL,'','due',1,10,1600.00,1.00,'yes',1,'%','',1,0,NULL,11);
/*!40000 ALTER TABLE `geopos_purchase` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-10-31 22:24:50
