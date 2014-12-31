-- MySQL dump 10.13  Distrib 5.6.22, for Linux (x86_64)
--
-- Host: localhost    Database: delegations
-- ------------------------------------------------------
-- Server version	5.6.22

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
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `number` varchar(15) DEFAULT NULL,
  `zip_code` varchar(15) DEFAULT NULL,
  `locality` varchar(255) DEFAULT NULL,
  `country` int(11) unsigned DEFAULT NULL,
  `nip` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country` (`country`),
  CONSTRAINT `company_ibfk_1` FOREIGN KEY (`country`) REFERENCES `countries` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,'Usługi Informatyczne TER-ART Wojciech Terpiłowski','Dekoracyjna','3','65-155','Zielona Góra',174,'9730454764');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (7,'AD'),(225,'AE'),(3,'AF'),(11,'AG'),(9,'AI'),(4,'AL'),(13,'AM'),(155,'AN'),(8,'AO'),(10,'AQ'),(12,'AR'),(6,'AS'),(16,'AT'),(15,'AU'),(14,'AW'),(17,'AZ'),(29,'BA'),(21,'BB'),(20,'BD'),(23,'BE'),(36,'BF'),(35,'BG'),(19,'BH'),(37,'BI'),(25,'BJ'),(26,'BM'),(34,'BN'),(28,'BO'),(32,'BR'),(18,'BS'),(27,'BT'),(31,'BV'),(30,'BW'),(22,'BY'),(24,'BZ'),(40,'CA'),(48,'CC'),(52,'CD'),(43,'CF'),(51,'CG'),(208,'CH'),(55,'CI'),(53,'CK'),(45,'CL'),(39,'CM'),(46,'CN'),(49,'CO'),(54,'CR'),(57,'CU'),(41,'CV'),(47,'CX'),(58,'CY'),(59,'CZ'),(84,'DE'),(61,'DJ'),(60,'DK'),(62,'DM'),(63,'DO'),(5,'DZ'),(65,'EC'),(70,'EE'),(66,'EG'),(235,'EH'),(69,'ER'),(199,'ES'),(71,'ET'),(75,'FI'),(74,'FJ'),(72,'FK'),(143,'FM'),(73,'FO'),(76,'FR'),(77,'FX'),(81,'GA'),(1,'GB'),(89,'GD'),(83,'GE'),(78,'GF'),(85,'GH'),(86,'GI'),(88,'GL'),(82,'GM'),(93,'GN'),(90,'GP'),(68,'GQ'),(87,'GR'),(198,'GS'),(92,'GT'),(91,'GU'),(94,'GW'),(95,'GY'),(100,'HK'),(97,'HM'),(99,'HN'),(56,'HR'),(96,'HT'),(101,'HU'),(104,'ID'),(107,'IE'),(108,'IL'),(103,'IN'),(33,'IO'),(106,'IQ'),(105,'IR'),(102,'IS'),(109,'IT'),(110,'JM'),(112,'JO'),(111,'JP'),(114,'KE'),(119,'KG'),(38,'KH'),(115,'KI'),(50,'KM'),(182,'KN'),(116,'KP'),(117,'KR'),(118,'KW'),(42,'KY'),(113,'KZ'),(120,'LA'),(122,'LB'),(183,'LC'),(126,'LI'),(200,'LK'),(124,'LR'),(123,'LS'),(127,'LT'),(128,'LU'),(121,'LV'),(125,'LY'),(148,'MA'),(145,'MC'),(144,'MD'),(131,'MG'),(137,'MH'),(130,'MK'),(135,'ML'),(150,'MM'),(146,'MN'),(129,'MO'),(163,'MP'),(138,'MQ'),(139,'MR'),(147,'MS'),(136,'MT'),(140,'MU'),(134,'MV'),(132,'MW'),(142,'MX'),(133,'MY'),(149,'MZ'),(151,'NA'),(156,'NC'),(159,'NE'),(162,'NF'),(160,'NG'),(158,'NI'),(154,'NL'),(164,'NO'),(153,'NP'),(152,'NR'),(161,'NU'),(157,'NZ'),(165,'OM'),(168,'PA'),(171,'PE'),(79,'PF'),(169,'PG'),(172,'PH'),(166,'PK'),(174,'PL'),(202,'PM'),(173,'PN'),(176,'PR'),(175,'PT'),(167,'PW'),(170,'PY'),(177,'QA'),(178,'RE'),(179,'RO'),(180,'RU'),(181,'RW'),(188,'SA'),(195,'SB'),(190,'SC'),(203,'SD'),(207,'SE'),(192,'SG'),(201,'SH'),(194,'SI'),(205,'SJ'),(193,'SK'),(191,'SL'),(186,'SM'),(189,'SN'),(196,'SO'),(204,'SR'),(187,'ST'),(67,'SV'),(209,'SY'),(206,'SZ'),(221,'TC'),(44,'TD'),(80,'TF'),(214,'TG'),(213,'TH'),(211,'TJ'),(215,'TK'),(220,'TM'),(218,'TN'),(216,'TO'),(64,'TP'),(219,'TR'),(217,'TT'),(222,'TV'),(210,'TW'),(212,'TZ'),(224,'UA'),(223,'UG'),(226,'UM'),(2,'US'),(227,'UY'),(228,'UZ'),(98,'VA'),(184,'VC'),(230,'VE'),(232,'VG'),(233,'VI'),(231,'VN'),(229,'VU'),(234,'WF'),(185,'WS'),(236,'YE'),(141,'YT'),(237,'YU'),(197,'ZA'),(238,'ZM'),(239,'ZW');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delegation_km_group`
--

DROP TABLE IF EXISTS `delegation_km_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delegation_km_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `delegation_id` int(11) unsigned DEFAULT NULL,
  `settlement_km_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `delegation_group` (`delegation_id`,`settlement_km_id`),
  KEY `delegation_id` (`delegation_id`),
  KEY `settlement_km_id` (`settlement_km_id`),
  CONSTRAINT `delegation_km_group_ibfk_3` FOREIGN KEY (`delegation_id`) REFERENCES `delegations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `delegation_km_group_ibfk_4` FOREIGN KEY (`settlement_km_id`) REFERENCES `settlement_km` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delegation_km_group`
--

LOCK TABLES `delegation_km_group` WRITE;
/*!40000 ALTER TABLE `delegation_km_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `delegation_km_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delegation_other_costs`
--

DROP TABLE IF EXISTS `delegation_other_costs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delegation_other_costs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `delegation_id` int(11) unsigned NOT NULL,
  `settlement_of_other_cost_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `delegation_group_other_costs` (`delegation_id`,`settlement_of_other_cost_id`),
  KEY `settlement_of_other_cost_id` (`settlement_of_other_cost_id`),
  KEY `delegation_id` (`delegation_id`),
  CONSTRAINT `delegation_other_costs_ibfk_3` FOREIGN KEY (`delegation_id`) REFERENCES `delegations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `delegation_other_costs_ibfk_4` FOREIGN KEY (`settlement_of_other_cost_id`) REFERENCES `settlement_of_other_costs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delegation_other_costs`
--

LOCK TABLES `delegation_other_costs` WRITE;
/*!40000 ALTER TABLE `delegation_other_costs` DISABLE KEYS */;
/*!40000 ALTER TABLE `delegation_other_costs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delegation_type`
--

DROP TABLE IF EXISTS `delegation_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delegation_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hash_key` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hash_key` (`hash_key`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delegation_type`
--

LOCK TABLES `delegation_type` WRITE;
/*!40000 ALTER TABLE `delegation_type` DISABLE KEYS */;
INSERT INTO `delegation_type` VALUES (15,'15n9bo1e3nyvz'),(13,'45xbweag4lpd'),(39,'463zfkhk5fma');
/*!40000 ALTER TABLE `delegation_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delegations`
--

DROP TABLE IF EXISTS `delegations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delegations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nr_delegation` varchar(255) NOT NULL,
  `place_a_cost` text NOT NULL,
  `type` int(11) unsigned NOT NULL,
  `target_country_type` int(11) unsigned NOT NULL,
  `target_country` int(11) unsigned DEFAULT NULL,
  `destination` text NOT NULL,
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `purpose_of_trip` text NOT NULL,
  `is_private_car` tinyint(1) unsigned NOT NULL,
  `address` text,
  `car_number` varchar(50) DEFAULT NULL,
  `engine_capacity` tinyint(1) unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `advance` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `user_id` (`user_id`),
  KEY `target_country` (`target_country`),
  KEY `target_country_type` (`target_country_type`),
  CONSTRAINT `delegations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `delegations_ibfk_3` FOREIGN KEY (`target_country_type`) REFERENCES `target_country_type` (`id`),
  CONSTRAINT `delegations_ibfk_5` FOREIGN KEY (`target_country`) REFERENCES `countries` (`id`),
  CONSTRAINT `delegations_ibfk_7` FOREIGN KEY (`type`) REFERENCES `delegation_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delegations`
--

LOCK TABLES `delegations` WRITE;
/*!40000 ALTER TABLE `delegations` DISABLE KEYS */;
/*!40000 ALTER TABLE `delegations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20141125095302');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settlement_km`
--

DROP TABLE IF EXISTS `settlement_km`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settlement_km` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_of_departure` datetime NOT NULL,
  `_from` varchar(255) NOT NULL,
  `_to` varchar(255) NOT NULL,
  `driven_km` int(11) unsigned NOT NULL,
  `rate_per_km` decimal(10,4) NOT NULL,
  `value` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settlement_km`
--

LOCK TABLES `settlement_km` WRITE;
/*!40000 ALTER TABLE `settlement_km` DISABLE KEYS */;
/*!40000 ALTER TABLE `settlement_km` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settlement_of_other_costs`
--

DROP TABLE IF EXISTS `settlement_of_other_costs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settlement_of_other_costs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `original_amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `is_exchange_rate` tinyint(1) unsigned NOT NULL,
  `exchange_rate` decimal(10,4) DEFAULT NULL,
  `conversion_amount` decimal(10,2) NOT NULL,
  `type_of_expenditure_id` int(11) unsigned NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `type_of_expenditure_id` (`type_of_expenditure_id`),
  CONSTRAINT `settlement_of_other_costs_ibfk_1` FOREIGN KEY (`type_of_expenditure_id`) REFERENCES `type_of_expenditure` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settlement_of_other_costs`
--

LOCK TABLES `settlement_of_other_costs` WRITE;
/*!40000 ALTER TABLE `settlement_of_other_costs` DISABLE KEYS */;
/*!40000 ALTER TABLE `settlement_of_other_costs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `target_country_type`
--

DROP TABLE IF EXISTS `target_country_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `target_country_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `target_country_type`
--

LOCK TABLES `target_country_type` WRITE;
/*!40000 ALTER TABLE `target_country_type` DISABLE KEYS */;
INSERT INTO `target_country_type` VALUES (1,'translations.National'),(2,'translations.Foreign');
/*!40000 ALTER TABLE `target_country_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `locale` varchar(2) CHARACTER SET armscii8 NOT NULL,
  `hash_key` varchar(255) NOT NULL,
  `trans` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `key_locale` (`hash_key`,`locale`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translations`
--

LOCK TABLES `translations` WRITE;
/*!40000 ALTER TABLE `translations` DISABLE KEYS */;
INSERT INTO `translations` VALUES (1,'en','translations.Accommodation','Accommodation'),(2,'en','translations.Consumption','Consumption'),(3,'en','translations.Passage','Passage'),(4,'en','translations.Representation','Representation'),(5,'en','translations.Others','Others'),(6,'pl','translations.Accommodation','Nocleg'),(7,'pl','translations.Consumption','Konsumpcja'),(8,'pl','translations.Passage','Przejazd'),(9,'pl','translations.Representation','Reprezentacja'),(10,'pl','translations.Others','Inne'),(21,'pl','1i0dlwqu6d6','Nocleg'),(22,'en','1i0dlwqu6d6','Accommodation'),(23,'pl','45xbweag4lpd','Spotkanie'),(24,'en','45xbweag4lpd','Meeting'),(25,'en','15n9bo1e3nyvz','Conference'),(26,'pl','15n9bo1e3nyvz','Konferencja'),(27,'pl','463zfkhk5fma','Szkolenie'),(28,'en','463zfkhk5fma','Training');
/*!40000 ALTER TABLE `translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_of_expenditure`
--

DROP TABLE IF EXISTS `type_of_expenditure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_of_expenditure` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `expenditure` varchar(255) NOT NULL,
  `shortcut` varchar(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `expenditure` (`expenditure`),
  UNIQUE KEY `shortcut` (`shortcut`),
  CONSTRAINT `type_of_expenditure_ibfk_1` FOREIGN KEY (`expenditure`) REFERENCES `translations` (`hash_key`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_of_expenditure`
--

LOCK TABLES `type_of_expenditure` WRITE;
/*!40000 ALTER TABLE `type_of_expenditure` DISABLE KEYS */;
INSERT INTO `type_of_expenditure` VALUES (2,'translations.Consumption','CONS'),(3,'translations.Passage','PASS'),(4,'translations.Representation','REPR'),(5,'translations.Others','OTHE'),(12,'1i0dlwqu6d6','ACCO');
/*!40000 ALTER TABLE `type_of_expenditure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `company` int(11) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `company` (`company`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`company`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'administrator','administrator',1,'admin','3621e8f9001e26bd61e5f87121e67b51b6941a259cfdaff3f774c41d35cc3090472d86681c9bd23c54c2ea89de586d0a2820fef38f10f988fd9d34ad26fe9e9a','terart@terart.pl','147628475953317b485a871',1,'2014-11-18 00:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-31 13:51:23
