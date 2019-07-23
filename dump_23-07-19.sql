-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: iparts
-- ------------------------------------------------------
-- Server version	5.7.21-log

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
-- Table structure for table `alerts`
--

DROP TABLE IF EXISTS `alerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alerts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `recipients` varchar(500) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `message` text NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1. Days sinsce pct was created.\n2. A set''s status change to.',
  `supplies_sets_status_id` int(10) unsigned DEFAULT NULL,
  `elapsed_days` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_alert_supplies_sets_status1_idx` (`supplies_sets_status_id`),
  CONSTRAINT `fk_alert_supplies_sets_status1` FOREIGN KEY (`supplies_sets_status_id`) REFERENCES `supplies_sets_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alerts`
--

LOCK TABLES `alerts` WRITE;
/*!40000 ALTER TABLE `alerts` DISABLE KEYS */;
INSERT INTO `alerts` VALUES (2,'SecondAlert','giovanny@messoft.com','Subject','Message',2,2,NULL,'2019-05-07 22:15:14','2019-05-07 22:15:14'),(3,'ThirdAlert','giovanny@messoft.com,giovanny2@messoft.com','Subject','dasdadad',2,2,NULL,'2019-05-07 22:23:11','2019-05-07 22:23:11');
/*!40000 ALTER TABLE `alerts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `binnacles`
--

DROP TABLE IF EXISTS `binnacles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `binnacles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `documents_supplies_id` int(10) unsigned DEFAULT NULL,
  `entity` tinyint(1) NOT NULL COMMENT '1. document\n2. item',
  `comments` text,
  `employees_users_id` int(10) unsigned DEFAULT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1. Call\n\n(Only call is specified on mockups)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `documents_id` int(10) unsigned NOT NULL,
  `pct_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_documents_binnacle_documents_supplies1_idx` (`documents_supplies_id`),
  KEY `fk_documents_binnacle_employees1_idx` (`employees_users_id`),
  KEY `fk_binnacle_documents1_idx` (`documents_id`),
  CONSTRAINT `fk_binnacle_documents1` FOREIGN KEY (`documents_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_documents_binnacle_documents_supplies1` FOREIGN KEY (`documents_supplies_id`) REFERENCES `documents_supplies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_documents_binnacle_employees1` FOREIGN KEY (`employees_users_id`) REFERENCES `employees` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `binnacles`
--

LOCK TABLES `binnacles` WRITE;
/*!40000 ALTER TABLE `binnacles` DISABLE KEYS */;
INSERT INTO `binnacles` VALUES (148,1706,2,'Partida convertida a CTZ',8,2,'2019-07-11 22:19:23','2019-07-11 22:19:23',254,2),(149,1706,2,'Partida convertida a CTZ',8,2,'2019-07-11 22:21:41','2019-07-11 22:21:41',254,2),(150,1706,2,'Partida convertida a CTZ',8,2,'2019-07-11 22:23:48','2019-07-11 22:23:48',254,2),(151,NULL,1,'PCT convertida a CTZ',8,2,'2019-07-11 22:23:49','2019-07-11 22:23:49',254,3),(152,1706,2,'Partida convertida a CTZ',8,2,'2019-07-11 22:39:49','2019-07-11 22:39:49',254,2),(153,NULL,1,'PCT convertida a CTZ',8,2,'2019-07-11 22:39:49','2019-07-11 22:39:49',254,3),(155,1706,2,'Partida convertida a CTZ',8,2,'2019-07-12 22:02:36','2019-07-12 22:02:36',254,2),(156,NULL,1,'PCT convertida a CTZ',8,2,'2019-07-12 22:02:37','2019-07-12 22:02:37',254,3);
/*!40000 ALTER TABLE `binnacles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_days`
--

DROP TABLE IF EXISTS `business_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business_days` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `month` tinyint(4) NOT NULL,
  `amount` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `month_UNIQUE` (`month`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_days`
--

LOCK TABLES `business_days` WRITE;
/*!40000 ALTER TABLE `business_days` DISABLE KEYS */;
INSERT INTO `business_days` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,0),(5,5,1),(6,6,0),(7,7,0),(8,8,0),(9,9,1),(10,10,0),(11,11,1),(12,12,2);
/*!40000 ALTER TABLE `business_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checklist`
--

DROP TABLE IF EXISTS `checklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checklist` (
  `id` int(10) unsigned NOT NULL,
  `material_specifications` enum('','checked') DEFAULT '',
  `quoted_amounts` enum('','checked') DEFAULT '',
  `quotation_currency` enum('','checked') DEFAULT '',
  `unit_price` enum('','checked') DEFAULT '',
  `delivery_time` enum('','checked') DEFAULT '',
  `delivery_conditions` enum('','checked') DEFAULT '',
  `product_condition` enum('','checked') DEFAULT '',
  `entrance_shipment_costs` enum('','checked') DEFAULT '',
  `weight_calculation` enum('','checked') DEFAULT '',
  `material_origin` enum('','checked') DEFAULT '',
  `incoterm` enum('','checked') DEFAULT '',
  `minimum_purchase` enum('','checked') DEFAULT '',
  `extra_charges` enum('','checked') DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_checklist_documents_supplies1_idx` (`id`),
  CONSTRAINT `fk_checklist_documents_supplies1` FOREIGN KEY (`id`) REFERENCES `documents_supplies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checklist`
--

LOCK TABLES `checklist` WRITE;
/*!40000 ALTER TABLE `checklist` DISABLE KEYS */;
INSERT INTO `checklist` VALUES (1697,'','','','','','','','','','','','',''),(1698,'','','','','','','','','','','','',''),(1699,'','','','','','','','','','','','',''),(1700,'','','','','','','','','','','','',''),(1701,'','','','','','','','','','','','',''),(1702,'','','','','','','','','','','','',''),(1703,'','','','','','','','','','','','',''),(1704,'','','','','','','','','','','','',''),(1705,'','','','','','','','','','','','',''),(1706,'checked','checked','','','','','','','','','','',''),(1707,'','','','','','','','','','','','',''),(1708,'','','','','','','','','','','','',''),(1709,'','','','','','','','','','','','',''),(1710,'','','','','','','','','','','','',''),(1711,'','','','','','','','','','','','',''),(1712,'','','','','','','','','','','','',''),(1713,'','','','','','','','','','','','',''),(1714,'','','','','','','','','','','','',''),(1715,'','','','','','','','','','','','',''),(1716,'','','','','','','','','','','','',''),(1717,'','','','','','','','','','','','',''),(1718,'','','','','','','','','','','','',''),(1719,'','','','','','','','','','','','',''),(1720,'','','','','','','','','','','','',''),(1721,'','','','','','','','','','','','',''),(1722,'','','','','','','','','','','','',''),(1723,'','','','','','','','','','','','',''),(1724,'','','','','','','','','','','','',''),(1725,'','','','','','','','','','','','',''),(1726,'','','','','','','','','','','','',''),(1727,'','','','','','','','','','','','','');
/*!40000 ALTER TABLE `checklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `color_settings`
--

DROP TABLE IF EXISTS `color_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `color_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `color` varchar(9) NOT NULL,
  `days` tinyint(4) NOT NULL,
  `emails` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `color_settings`
--

LOCK TABLES `color_settings` WRITE;
/*!40000 ALTER TABLE `color_settings` DISABLE KEYS */;
INSERT INTO `color_settings` VALUES (1,'#33e656',5,'3224@gmail.com,dsad@gmail.com','2019-03-08 18:17:58','2019-03-08 22:59:50'),(2,'#ffbb33',10,'dsa@gmail.com','2019-03-08 18:17:58','2019-04-17 20:50:13'),(3,'#ff4444',15,NULL,'2019-03-08 18:17:58','2019-03-08 23:00:48'),(4,'#000000',20,NULL,'2019-03-08 18:17:58','2019-03-08 23:00:48');
/*!40000 ALTER TABLE `color_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conditions`
--

DROP TABLE IF EXISTS `conditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conditions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `previous_sale` varchar(255) NOT NULL,
  `valid_prices` varchar(255) NOT NULL,
  `replacement` varchar(255) NOT NULL,
  `factory_replacement` varchar(255) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `minimum_purchase` varchar(255) NOT NULL,
  `exworks` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conditions`
--

LOCK TABLES `conditions` WRITE;
/*!40000 ALTER TABLE `conditions` DISABLE KEYS */;
INSERT INTO `conditions` VALUES (1,'Salvo Previa venta','Precios válidos','Remplazo','Remplazo de fábrica','Condición: USADO','Mínimo de compra','Ex-Works International Parts');
/*!40000 ALTER TABLE `conditions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'México');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES (1,'MXN'),(2,'MONEDA');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sync_connections_id` int(10) unsigned NOT NULL,
  `code` varchar(12) NOT NULL,
  `trade_name` varchar(45) DEFAULT NULL,
  `business_name` varchar(135) DEFAULT NULL,
  `post_code` varchar(5) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0' COMMENT '0. MEANS NOTHING\n1. EX: Foreing customer. No IVA.\n2. PG: Publico en general. 16% IVA.\n3. PF: Persona física. 16% IVA.\n4. AA: UNKNOWN.\n5. PV: UNKNOWN.\n6. IN: UNKNOWN.\n7. AD: UNKNOWN.\n8. PE: UNKNOWN.\n9. PM: Persona moral. 16% IVA.\n',
  PRIMARY KEY (`id`,`sync_connections_id`),
  KEY `fk_customers_sync_connections1_idx` (`sync_connections_id`),
  CONSTRAINT `fk_customers_sync_connections1` FOREIGN KEY (`sync_connections_id`) REFERENCES `sync_connections` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,1,'CL020012    ','A VER                                   ','Envases Universales                                                                                                                    ','8200 ','SINALOA                  ','MEXICO              ','2019-05-03 01:42:55','2019-07-05 22:33:27',9),(2,1,'CL020015    ','Senoplast S.A. de C.V.                  ','Senoplast S.A. de C.V.                                                                                                                 ','76220','QUERETARO                ','MEXICO              ','2019-05-03 01:42:56','2019-07-05 22:33:28',9),(3,1,'CL060087    ','GRUPO GONDI                             ','GRUPO GONDI                                                                                                                            ','52000','MEXICO                   ','MEXICO              ','2019-05-03 01:42:56','2019-07-05 02:48:44',9),(4,1,'CL060168    ','NEXON TECHNOLOGIES                      ','NEXON TECHNOLOGIES                                                                                                                     ','76116','QUERETARO                ','MEXICO              ','2019-05-03 01:42:56','2019-07-05 02:48:45',9),(5,1,'CL060059    ','NEXON TECHNOLOGIES, S.A. DE C.V.        ','NEXON TECHNOLOGIES, S.A. DE C.V.                                                                                                       ','25260','COAHUILA                 ','MEXICO              ','2019-05-03 01:42:56','2019-07-05 02:48:45',9),(6,2,'CL060100    ','PAPELERA DE CHIHUAHUA                   ','PAPELERA DE CHIHUAHUA S.A. DE C.V.                                                                                                     ','31350','CHIHUAHUA                ','MEXICO              ','2019-05-03 01:42:57','2019-07-05 02:48:46',9),(7,2,'CL010002    ','Voltran S.A de C.V.                     ','Voltran S.A de C.V.                                                                                                                    ','43804','HIDALGO                  ','MEXICO              ','2019-05-03 01:42:57','2019-07-05 02:48:45',9),(8,2,'CL015008    ','HITACHI Líneas ECU                      ','Hitachi Automotive Systems San Juan del Río S.A. de C.V                                                                                ','76803','QUERETARO                ','MEXICO              ','2019-05-03 01:42:57','2019-07-05 02:48:46',9),(9,2,'CL035135    ','DIGICONTROL SA DE CV                    ','DIGICONTROL SA DE CV                                                                                                                   ','31203','CHIHUAHUA                ','MEXICO              ','2019-05-03 01:42:57','2019-07-05 02:48:46',9),(10,2,'CL010022    ','TAVEX                                   ','INDUSTRIAL TEXTIL DE PUEBLA SA DE CV                                                                                                   ','72225','PUEBLA                   ','MEXICO              ','2019-05-03 01:42:57','2019-07-05 02:48:46',9),(11,2,'CL015423    ','                                        ','JULIO GARNICA                                                                                                                          ','     ','                         ','MEXICO              ','2019-05-03 01:42:58','2019-07-05 02:48:47',2),(12,2,'CL060168    ','GRUPO COMERCIAL YAZBEK S.A DE C.V       ','GRUPO COMERCIAL YAZBEK S.A DE C.V                                                                                                      ','08400','DISTRITO FEDERAL         ','MEXICO              ','2019-05-03 01:42:58','2019-07-05 02:48:47',9),(13,2,'CL035266    ','HUMERTO GUZMAN LARA                     ','HUMBERTO GUZMAN LARA                                                                                                                   ','86500','TABASCO                  ','MEXICO              ','2019-05-03 01:42:58','2019-07-05 02:48:48',3),(14,2,'CL035630    ','ABASTECIMIENTOS INDUSTRIALES            ','ABASTECIMIENTOS INDUSTRIALES                                                                                                           ','72310','PUEBLA                   ','MEXICO              ','2019-05-03 01:42:58','2019-07-05 02:48:48',9),(15,2,'CL010174    ','Conductores Eléctricos QUINRO,  SA de CV','Conductores Eléctricos QUINRO,  SA de CV                                                                                               ','13200','MEXICO                   ','MEXICO              ','2019-05-03 01:42:58','2019-07-05 02:48:48',9);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Equals to comedoc (precotizations main table) table on siavcom system database.',
  `sync_connections_id` int(10) unsigned NOT NULL,
  `number` int(10) unsigned DEFAULT NULL COMMENT 'ndo_doc, document number',
  `type` varchar(3) DEFAULT NULL COMMENT 'I think the only document type we''re gonna need is PCT, pending to confirm.',
  `reference` varchar(60) DEFAULT NULL,
  `customer_code` varchar(12) DEFAULT NULL,
  `seller_number` int(11) DEFAULT NULL,
  `state` varchar(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1. New, 2. In process, 3. Done(Cotizada), 4.Archived',
  `mxn_currency_exchange_rate` decimal(9,4) DEFAULT NULL,
  `customer_requirement_number` varchar(40) DEFAULT NULL,
  `buyer_name` varchar(40) DEFAULT NULL,
  `buyer_number` varchar(3) DEFAULT NULL COMMENT 'Número de cotizador.',
  `customers_id` int(10) unsigned NOT NULL,
  `employees_users_id` int(10) unsigned NOT NULL,
  `currency_id` int(10) unsigned DEFAULT NULL,
  `completed_date` timestamp NULL DEFAULT NULL,
  `ctz_number` varchar(120) DEFAULT NULL COMMENT 'Once a pct is sent to siavcom, we''re going to get a this number.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `was_canceled` tinyint(1) DEFAULT '0' COMMENT 'Was it canceled once at least? 0 1',
  `is_canceled` tinyint(1) DEFAULT '0' COMMENT 'Is it currently canceled? 0 1',
  `cop_nom` varchar(45) DEFAULT NULL,
  `con_con` varchar(45) DEFAULT NULL,
  `fel_doc` varchar(45) DEFAULT NULL,
  `fec_doc` varchar(45) DEFAULT NULL,
  `im1_doc` varchar(45) DEFAULT NULL,
  `im2_doc` varchar(45) DEFAULT NULL,
  `im4_doc` varchar(45) DEFAULT NULL,
  `im5_doc` varchar(45) DEFAULT NULL,
  `com_doc` varchar(45) DEFAULT NULL,
  `vm4_doc` varchar(45) DEFAULT NULL,
  `vm5_doc` varchar(45) DEFAULT NULL,
  `sal_doc` varchar(45) DEFAULT NULL,
  `ob1_doc` varchar(45) DEFAULT NULL,
  `sau_doc` varchar(45) DEFAULT NULL,
  `fau_doc` varchar(45) DEFAULT NULL,
  `rut_rut` varchar(45) DEFAULT NULL,
  `num_pry` varchar(45) DEFAULT NULL,
  `che_doc` varchar(45) DEFAULT NULL,
  `usu_usu` varchar(45) DEFAULT NULL,
  `tor_doc` varchar(45) DEFAULT NULL,
  `nor_doc` varchar(45) DEFAULT NULL,
  `im0_doc` varchar(45) DEFAULT NULL,
  `mov_doc` varchar(45) DEFAULT NULL,
  `fip_doc` varchar(45) DEFAULT NULL,
  `tpa_doc` varchar(45) DEFAULT NULL,
  `rpa_doc` varchar(45) DEFAULT NULL,
  `tip_tdn` varchar(45) DEFAULT NULL,
  `npa_doc` varchar(45) DEFAULT NULL,
  `mpa_sat` varchar(45) DEFAULT NULL,
  `fpa_sat` varchar(45) DEFAULT NULL,
  `uso_sat` varchar(45) DEFAULT NULL,
  `ndr_doc` varchar(45) DEFAULT NULL,
  `dto_doc` varchar(45) DEFAULT NULL,
  `mon_doc` varchar(45) DEFAULT NULL,
  `vmo_doc` varchar(45) DEFAULT NULL,
  `vm2_doc` varchar(45) DEFAULT NULL,
  `vm3_doc` varchar(45) DEFAULT NULL,
  `siavcom_ctz` tinyint(1) DEFAULT '0' COMMENT 'Wheter or not the ctz has been created on siavcom',
  `siavcom_ctz_number` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_documents_customers1_idx` (`customers_id`),
  KEY `fk_documents_sync_connections1_idx` (`sync_connections_id`),
  KEY `fk_documents_employees1_idx` (`employees_users_id`),
  KEY `fk_documents_currencies1_idx` (`currency_id`),
  CONSTRAINT `fk_documents_currencies1` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documents_customers1` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documents_employees1` FOREIGN KEY (`employees_users_id`) REFERENCES `employees` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documents_sync_connections1` FOREIGN KEY (`sync_connections_id`) REFERENCES `sync_connections` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (248,1,201,'PCT','JG0611                                                      ','CL020012    ',2,'I',1,1.0000,'                                        ','CRISTINA CASILLAS                       ','3  ',1,11,1,NULL,NULL,'2019-07-11 22:15:48','2019-07-11 22:15:48',0,0,'C','0','2017-08-02 00:00:00','2017-08-02 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','                                        ','D','1900-01-01 00:00:00','0','0','0                                       ','0','RQ2','210','0.00000',NULL,NULL,' ','1',NULL,'1',NULL,NULL,NULL,'1','0.00000','1','1.0000','17.8646','20.9596',0,NULL),(249,1,1068,'PCT','JG0631                                                      ','CL020015    ',2,'I',1,1.0000,'                                        ','ABRIL SARDA                             ','2  ',2,9,1,NULL,NULL,'2019-07-11 22:15:48','2019-07-11 22:15:48',0,0,'C','0','2018-03-12 00:00:00','2018-03-12 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','                                        ','D','1900-01-01 00:00:00','0','0','0                                       ','14','RQ2','622','0.00000','0','2018-03-12 00:00:00','M','1','PM','1','PPD','99','G01','0','0.00000','1','1.0000','18.7148','23.1661',0,NULL),(250,1,1082,'PCT','MM0438                                                      ','CL060087    ',6,'I',1,1.0000,'                                        ','ABRIL SARDA                             ','2  ',3,9,1,NULL,NULL,'2019-07-11 22:15:49','2019-07-11 22:15:49',0,0,'C','0','2018-03-13 00:00:00','2018-03-13 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','                                        ','D','1900-01-01 00:00:00','0','0','0                                       ','14','RQ6','438','0.00000','0','2018-03-13 00:00:00','M','1','PM','1','PPD','99','G01','0','0.00000','1','1.0000','18.5812','22.8539',0,NULL),(251,1,2096,'PCT','MM0898                                                      ','CL060168    ',6,'I',1,1.0000,'                                        ','DIANA SANCHEZ                           ','4  ',4,11,1,NULL,NULL,'2019-07-11 22:15:49','2019-07-11 22:15:49',0,0,'C','0','2018-09-11 00:00:00','2018-09-11 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','                                        ','D','1900-01-01 00:00:00','0','0','0                                       ','26','RQ6','898','0.00000','0','2018-09-11 00:00:00','M','1','PM','1','PPD','99','G01','0','0.00000','1','1.0000','19.2394','22.3687',0,NULL),(252,1,2468,'PCT','MM1106                                                      ','CL060059    ',6,'P',1,20.4977,'                                        ','ABRAHAM MAYORAL                         ','5  ',5,11,2,NULL,NULL,'2019-07-11 22:15:49','2019-07-11 22:15:49',0,0,'C','0','2018-11-29 16:07:50','2018-11-29 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','                                        ','D','1900-01-01 00:00:00','0','0','0                                       ','30','RQ6','1106','0.00000','0','2018-11-29 00:00:00','M','1','PM','1','PUE','03','G01','0','0.00000','2','20.4977','20.4977','23.2044',0,NULL),(253,2,201,'PCT','EE739                                                       ','CL060100    ',6,'I',1,17.3880,'86825                                   ','Elena Estudillo                         ','   ',6,11,2,NULL,NULL,'2019-07-11 22:15:49','2019-07-11 22:15:49',0,0,'C','0','2016-04-15 00:00:00','2016-04-15 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','86825                                   ','D','1900-01-01 00:00:00','0','0','0                                       ','20','RFQ','236','0.00000',NULL,NULL,' ','1',NULL,'1',NULL,NULL,NULL,'1','0.00000','2','17.3880','17.3880','19.5789',0,NULL),(254,2,1068,'PCT','FR1483                                                      ','CL010002    ',1,'I',3,1.0000,'11727594                                ','DANIEL TORRES                           ','1  ',7,8,2,'2019-07-12 22:02:37',NULL,'2019-07-11 22:15:49','2019-07-12 22:02:37',0,0,'C','0','2016-08-01 00:00:00','2016-08-01 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','11727594                                ','D','1900-01-01 00:00:00','0','0','0                                       ','13','RF1','1483','0.00000',NULL,NULL,' ','1',NULL,'1',NULL,NULL,NULL,'1','0.00000','2','1.0000','1.0000','20.8724',1,'9422'),(255,2,1082,'PCT','FR1488                                                      ','CL015008    ',1,'I',1,1.0000,'                                        ','DANIEL TORRES                           ','1  ',8,8,1,NULL,NULL,'2019-07-11 22:15:49','2019-07-11 22:15:49',0,0,'C','0','2016-08-02 00:00:00','2016-08-02 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','                                        ','D','1900-01-01 00:00:00','0','0','0                                       ','13','RF1','1488','0.00000',NULL,NULL,' ','1',NULL,'1',NULL,NULL,NULL,'1','0.00000','1','1.0000','18.8504','21.0446',0,NULL),(256,2,2096,'PCT','LBA-0240                                                    ','CL035135    ',3,'I',1,18.6481,'                                        ','EDSON NUÑEZ                             ','2  ',9,9,2,NULL,NULL,'2019-07-11 22:15:49','2019-07-11 22:15:49',0,0,'C','0','2016-10-25 00:00:00','2016-10-25 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','                                        ','D','1900-01-01 00:00:00','0','0','0                                       ','0','RQ3','240','0.00000',NULL,NULL,' ','1',NULL,'1',NULL,NULL,NULL,'1','0.00000','2','18.6481','18.6481','20.3096',0,NULL),(257,2,2468,'PCT','FR1939                                                      ','CL010022    ',1,'I',1,20.7051,'                                        ','DANIEL TORRES                           ','1  ',10,8,2,NULL,NULL,'2019-07-11 22:15:50','2019-07-11 22:15:50',0,0,'C','0','2016-11-26 00:00:00','2016-11-26 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','                                        ','D','1900-01-01 00:00:00','0','0','0                                       ','0','RF1','1939','0.00000',NULL,NULL,' ','1',NULL,'1',NULL,NULL,NULL,'1','0.00000','2','20.7051','20.7051','21.9930',0,NULL),(258,2,2865,'PCT','FR2161                                                      ','CL015423    ',1,'I',1,1.0000,'                                        ','Daniel Torres                           ','1  ',11,8,2,NULL,NULL,'2019-07-11 22:15:50','2019-07-11 22:15:50',0,0,'C','0','2017-01-12 00:00:00','2017-01-12 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','                                        ','D','1900-01-01 00:00:00','0','0','0                                       ','0','RF1','2161','0.00000',NULL,NULL,' ','1',NULL,'1',NULL,NULL,NULL,'1','0.00000','2','1.0000','1.0000','22.8565',0,NULL),(259,2,3370,'PCT','LB-0506                                                     ','CL060168    ',3,'I',1,20.4059,'                                        ','GERMAN SOTO                             ','4  ',12,11,2,NULL,NULL,'2019-07-11 22:15:50','2019-07-11 22:15:50',0,0,'C','0','2017-02-22 00:00:00','2017-02-22 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','                                        ','D','1900-01-01 00:00:00','0','0','0                                       ','0','RQ3','506','0.00000',NULL,NULL,' ','1',NULL,'1',NULL,NULL,NULL,'1','0.00000','2','20.4059','20.4059','21.6813',0,NULL),(260,2,3389,'PCT','LBA-0512                                                    ','CL035266    ',3,'I',1,1.0000,'                                        ','ANDREA ALVAREZ                          ','4  ',13,11,1,NULL,NULL,'2019-07-11 22:15:50','2019-07-11 22:15:50',0,0,'C','0','2017-02-24 00:00:00','2017-02-24 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','                                        ','D','1900-01-01 00:00:00','0','0','0                                       ','0','RQ3','512','0.00000',NULL,NULL,' ','1',NULL,'1',NULL,NULL,NULL,'1','0.00000','1','1.0000','19.9127','20.9053',0,NULL),(261,2,5233,'PCT','LBA-1235                                                    ','CL035630    ',3,'I',1,17.7331,'                                        ','GERMAN SOTO                             ','4  ',14,11,2,NULL,NULL,'2019-07-11 22:15:50','2019-07-11 22:15:50',0,0,'C','0','2017-09-12 00:00:00','2017-09-12 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','                                        ','D','1900-01-01 00:00:00','0','0','0                                       ','0','RQ3','1235','0.00000',NULL,NULL,' ','1',NULL,'1',NULL,NULL,NULL,'1','0.00000','2','17.7331','17.7331','21.4012',0,NULL),(262,2,5399,'PCT','CL-1402                                                     ','CL010174    ',7,'P',1,1.0000,'                                        ','ABRIL SARDA                             ','1  ',15,8,2,NULL,NULL,'2019-07-11 22:15:50','2019-07-11 22:15:50',0,0,'C','0','2017-10-03 00:00:00','2017-10-03 00:00:00','0.00000','0.00000','0.00000','0.00000','0.0','1.0000','1.0000','0.00000','                                        ','D','1900-01-01 00:00:00','0','0','0                                       ','0','RQ7','1402','0.00000',NULL,NULL,' ','1',NULL,'1',NULL,NULL,NULL,'1','0.00000','2','1.0000','1.0000','21.4521',0,NULL);
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents_supplies`
--

DROP TABLE IF EXISTS `documents_supplies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_supplies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Partida',
  `documents_id` int(10) unsigned NOT NULL,
  `supplies_id` int(10) unsigned NOT NULL,
  `set` smallint(6) DEFAULT NULL COMMENT 'Set number',
  `product_description` text,
  `products_amount` decimal(12,5) DEFAULT NULL,
  `measurement_unit_code` smallint(6) DEFAULT NULL,
  `sale_unit_cost` decimal(16,6) DEFAULT '0.000000',
  `type` varchar(3) DEFAULT NULL,
  `currencies_id` int(10) unsigned DEFAULT NULL,
  `importation_cost` decimal(8,2) DEFAULT '0.00',
  `warehouse_shipment_cost` decimal(8,2) DEFAULT '0.00',
  `customer_shipment_cost` decimal(8,2) DEFAULT '0.00',
  `extra_charges` decimal(8,2) DEFAULT '0.00',
  `documents_suppliescol` varchar(45) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `source_country_id` int(10) unsigned DEFAULT NULL,
  `utility_percentages_id` int(10) unsigned DEFAULT NULL,
  `custom_utility_percentage` decimal(5,2) DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1. No solicitado.\n2. Solicitado automáticamente. (automático, cuando el sistema haya enviado por correo al menos un correo de petición de cotización)\n3. Solicitado manualmente. (automático, cuando al menos haya un correo enviado por el cotizador)\n4. Confirmado por el proveedor (manual)\n5. Presupuesto capturado. (manual)\n6. En Autorización. (manual)\n7. Rechazado. (manual)\n8. Autorizado. (manual)\n9. Convertido a CTZ.\n',
  `completed_date` timestamp NULL DEFAULT NULL,
  `rejected_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `suppliers_id` int(10) unsigned DEFAULT NULL,
  `ens_mov` varchar(45) DEFAULT NULL,
  `inv_tdo` varchar(45) DEFAULT NULL,
  `dga_pro` varchar(45) DEFAULT NULL,
  `de1_mov` varchar(45) DEFAULT NULL,
  `de2_mov` varchar(45) DEFAULT NULL,
  `de3_mov` varchar(45) DEFAULT NULL,
  `de4_mov` varchar(45) DEFAULT NULL,
  `de5_mov` varchar(45) DEFAULT NULL,
  `im1_mov` varchar(45) DEFAULT NULL,
  `im2_mov` varchar(45) DEFAULT NULL,
  `im4_mov` varchar(45) DEFAULT NULL,
  `im5_mov` varchar(45) DEFAULT NULL,
  `adv_tar` varchar(45) DEFAULT NULL,
  `cuo_tar` varchar(45) DEFAULT NULL,
  `npe_mov` varchar(45) DEFAULT NULL,
  `mpe_mov` varchar(45) DEFAULT NULL,
  `cen_mov` varchar(45) DEFAULT NULL,
  `est_mov` varchar(45) DEFAULT NULL,
  `im0_mov` varchar(45) DEFAULT NULL,
  `usu_usu` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_documents_supplies_documents1_idx` (`documents_id`),
  KEY `fk_documents_supplies_supplies1_idx` (`supplies_id`),
  KEY `fk_documents_supplies_currencies1_idx` (`currencies_id`),
  KEY `fk_documents_supplies_countries1_idx` (`source_country_id`),
  KEY `fk_documents_supplies_utility_percentages1_idx` (`utility_percentages_id`),
  KEY `fk_documents_supplies_suppliers1_idx` (`suppliers_id`),
  CONSTRAINT `fk_documents_supplies_countries1` FOREIGN KEY (`source_country_id`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documents_supplies_currencies1` FOREIGN KEY (`currencies_id`) REFERENCES `currencies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documents_supplies_documents1` FOREIGN KEY (`documents_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_documents_supplies_suppliers1` FOREIGN KEY (`suppliers_id`) REFERENCES `suppliers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documents_supplies_supplies1` FOREIGN KEY (`supplies_id`) REFERENCES `supplies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documents_supplies_utility_percentages1` FOREIGN KEY (`utility_percentages_id`) REFERENCES `utility_percentages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1728 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents_supplies`
--

LOCK TABLES `documents_supplies` WRITE;
/*!40000 ALTER TABLE `documents_supplies` DISABLE KEYS */;
INSERT INTO `documents_supplies` VALUES (1697,248,363,1,'Festo DSBC Standard Cylinder 32mm Diameter Self-Adjusting',1.00000,1,4530.000000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1698,249,371,2,'MODELO: MR 16\r\nDESCRIPCION: LAMPARA HALOGENA GU5.3 38 20W 12V 3000HRS\r\n\r\nTiempo de Entrega: 5 a 7 dias habiles',4.00000,1,699.000000,'PCT',1,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','20'),(1699,250,380,1,'Mod. : F17 T8    \r\nMarca : PHILIPS\r\nDescripcion : F17 T8 LAMPARAS DE LUZ DE DIA D50 TEMPERATURA DE COLOR 4100k POTENCIA 17W',6.00000,1,499.000000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','20'),(1700,250,381,2,'Mod. :  IM05-0B8NS-ZW1\r\nMarca : SICK\r\nDescripcion : SENSOR INDUCTIVO  IM05-0B8NS-ZW1\r\n\r\nTiempo de Entrega: 3 a 5 semanas',1.00000,1,3014.880000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','14'),(1701,251,386,2,'SIMATIC DP I/O Module Digital I/P 1 Digital O/P SIEMENS  6ES7136-6RA00-0BF0\r\n\r\nTIEMPO DE ENTREGA: 10 A 11 SEMANAS',2.00000,1,4150.000000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','26'),(1702,251,387,1,'SIMATIC DP, ELECTRON. MODULE F. ET 200SP, F-DI 8X24VDC HF, 15 MM WIDTH, UP TO PL E (ISO 13849-1)/ SIL3 (IEC 61508) SIEMENS  6ES7136-6BA00-0CA0\r\n\r\nTIEMPO DE ENTREGA: 10 A 11 SEMANAS',2.00000,1,7699.000000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','26'),(1703,252,389,1,'Numero de Parte : LE20-2611            \r\nDescripcion : SICK LE20-2611 Aparato de maniobra de seguridad                \r\nFabricante : SICK\r\n\r\n***TIEMPO DE ENTREGA 3 A 5 SEMANAS***\r\n***SALVO PREVIA VENTA***',1.00000,1,1699.000000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','40'),(1704,253,395,1,'Abanico 220 V 50 HZ .9AMP 2700R/MIN 7.5 KG PARA TRASMISION DE PRENSAS M-7, MARCA WOODS  Folio 86825\r\n',2.00000,1,5999.000000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','20'),(1705,253,396,2,'Abanico 220VAC,60HZ 3.0 AMP 3300 R/MIN TYPE 9.5KG/60HZ, PARA MULTIDRY RODILLO DE RETORNO,  MARCA WOODS,  Folio 86825.\r\n',2.00000,1,9999.000000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','20'),(1706,254,408,1,'Class H fuse block\r\nTE 8-9  semanas, salvo previa venta\r\n',10.00000,1,25.800000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,9,NULL,NULL,NULL,'2019-07-12 22:02:35',NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','13'),(1707,255,423,1,'FLUORESCENT 4 PINS(IN A SQUARE) 5000K\r\nTE 2-5 semanas, salvo previa venta , sujeto a diponibilidad\r\n',6.00000,1,94.200000,'PCT',1,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','13'),(1708,256,449,3,'RELEVADOR DE SOBRECARGA 2E RELAY 7AT  RC810 HP 1YU  MARCA TOSHIBA\r\nTiempo de entrega: 1 semana \r\nCotización salvo previa venta',1.00000,1,349.000000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1709,256,450,2,' 400 AMPS, 50/60 HZ,  CAP. INTERRUPTIVA 350 MVA, VOLTAJE DE CONTROL 115-120, VAC. MARCA TOSHIBA.\r\n',1.00000,1,6104.000000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1710,256,451,1,'CURRENT TRANSFORMER-HIGH VOLTAGE, 6.9 KV, 50/60 HZ,\r\nRELACIÓN 500/5 AMPS, BURDEN 40 VA, EXACTITUD CLASE 1.0,\r\nMONTAJE INTERIOR, MOLDEADA EN RESINA RESISTENTE AL\r\nPOLVO Y LA ABRASIÓN, MODELO AEL6, CATALOGO AL6-500, \r\nMCA TOSHIBA.',3.00000,1,0.000000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1711,257,459,3,'Headers & Wire Housings 4P Panel Mt Recept Strain Relief Hood Souriau',25.00000,1,8.070000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1712,257,460,4,'Headers & Wire Housings 4P Cable Plug Strain Relief Hood Souriau\r\n\r\nTE 7-15 dias habiles, salvo previa venta\r\nPrecio valido en la compra de todos los items',25.00000,1,8.280000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1713,257,461,1,'Headers & Wire Housings 6P Receptacle Sz 16 Panel Mount Souriau',50.00000,1,1.750000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1714,257,462,2,'Headers & Wire Housings 6P Cable Plug Sz 16 Souriau',50.00000,1,1.700000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1715,258,468,1,'Lütze Datatrans \r\nLUTZE Variocompact CTS-V24/V11pt-3-0206  12-30 VDC\r\n\r\nTE 2-6 semanas, salvo previa venta\r\ncondicion usado.\r\n3 pzas en stock',1.00000,1,942.430000,'PCT',1,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1716,259,470,4,'POLEA AMETRIC\r\nMOD. 12L100\r\nPULLEY, 12T 982A\r\n\r\n2-3 SEMANAS \r\n*SALVO PREVIA VENTA* \r\n*SUJETO A DISPONIBILIDAD*\r\n',1.00000,1,383.100000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1717,259,471,3,'Allen Bradley - PhotoSwitch\r\nMOD. 42MTB-5000\r\nVoltaje: 102-132VAC\r\n\r\n2-3 SEMANAS \r\n*SALVO PREVIA VENTA* \r\n*SUJETO A DISPONIBILIDAD*\r\n',1.00000,1,475.800000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1718,259,472,5,'STOP MOTION LAMP ASSEMBLY ARROW\r\nMOD. ARROW 20017\r\n\r\n2-4 SEMANAS \r\n*SALVO PREVIA VENTA* \r\n*SUJETO A DISPONIBILIDAD*\r\n',1.00000,1,608.300000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1719,259,473,9,'CILINDRO NEUMATICO SMC\r\nMOD. NCDME056-0400\r\n\r\n4-6 SEMANAS \r\n*SALVO PREVIA VENTA* \r\n* SUJETO A DISPONIBILIDAD*\r\n',1.00000,1,612.000000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1720,259,474,7,'FUENTE DE PODER MEAN WELL\r\nMOD. CLG-100-24\r\n\r\n2-4 SEMANAS \r\n*SALVO PREVIA VENTA* \r\n*SUJETO A DISPONIBILIDAD* \r\n* 3 PZAS. MOQ*\r\n',3.00000,1,199.900000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1721,259,475,11,'Sensor de Proximidad Inductivo, Serie PR, Cilíndrico, Cable, 8mm, NPN, 10 V a 30 V\r\n\r\n10-15 DÍAS HÁBILES \r\n*SALVO PREVIA VENTA* \r\n*SUJETO A DISPONIBILIDAD*\r\n',1.00000,1,89.200000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1722,259,476,10,'RODAMIENTO FIN DE CAMINO AURORA\r\nMOD.  AW5Z\r\nBEARING, ROAD END, FEMALE 5/16-24, 5/16 BORE\r\n\r\n2-4 SEMANAS \r\n*SALVO PREVIA VENTA* \r\n*SUJETO A DISPONIBILIDAD*\r\n\r\n\r\n',1.00000,1,307.100000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1723,259,477,13,'SENSOR FOTOELECTRICO BANNER\r\nMOD. OTBVN6\r\nSWITCH,  OPTO-TOUCH,  0-30VDC W/CABLE\r\n\r\n10-15 DÍAS HÁBILES \r\n*SALVO PREVIA VENTA* \r\n*SUJETO A DISPONIBILIDAD*\r\n',1.00000,1,268.900000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1724,259,478,12,'SENSOR BANNER\r\nMOD. SM312LV-46172\r\nEYE,  ELECTRIC, 72 IN CORD FFSM312LV W/PLUG\r\n\r\n5-7 SEMANAS \r\n*SALVO PREVIA VENTA* \r\n*SUJETO A DISPONIBILIDAD*\r\n',1.00000,1,224.400000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1725,260,480,1,'VENTILADOR DE PISO 3 VELOCIDADES 20\" BIRTMAN\r\n\r\n2-5 SEMANAS \r\n*SALVO PREVIA VENTA* \r\n*SUJETO A DISPONIBILIDAD*\r\n\r\n\r\n',500.00000,1,1682.800000,'PCT',1,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1726,261,485,1,'Mod: XS7D1A1DAL2\r\nDescrip: Sensor de proximidad Size D DC XS7 cable 2 m\r\nMca: TELEMECANIQUE\r\n\r\nTE 2 - 4 Semanas \r\nSalvo previa venta',2.00000,1,519.530000,'PCT',2,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0'),(1727,262,486,1,'WTV3',1.00000,1,1328.570000,'PCT',1,0.00,0.00,0.00,0.00,NULL,NULL,NULL,NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,'0','N','0','0.00','0.00','0.00','0.00','0.00','0.00000','0.00000','0.00000','0.00000','0.0000','0.00','0','0','0.00000','A','0.00000','0');
/*!40000 ALTER TABLE `documents_supplies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents_supplies_conditions`
--

DROP TABLE IF EXISTS `documents_supplies_conditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_supplies_conditions` (
  `id` int(10) unsigned NOT NULL,
  `previous_sale` varchar(255) DEFAULT NULL,
  `valid_prices` varchar(255) DEFAULT NULL,
  `replacement` varchar(255) DEFAULT NULL,
  `factory_replacement` varchar(255) DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `minimum_purchase` varchar(255) DEFAULT NULL,
  `exworks` varchar(255) DEFAULT NULL,
  `description` text,
  KEY `fk_documents_supplies_conditions_documents_supplies1_idx` (`id`),
  CONSTRAINT `fk_documents_supplies_conditions_documents_supplies1` FOREIGN KEY (`id`) REFERENCES `documents_supplies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents_supplies_conditions`
--

LOCK TABLES `documents_supplies_conditions` WRITE;
/*!40000 ALTER TABLE `documents_supplies_conditions` DISABLE KEYS */;
INSERT INTO `documents_supplies_conditions` VALUES (1697,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1698,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1699,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1700,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1701,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1702,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1703,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1704,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1705,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1706,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1707,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1708,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1709,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1710,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1711,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1712,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1713,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1714,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1715,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1716,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1717,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1718,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1719,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1720,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1721,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1722,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1723,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1724,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1725,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1726,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1727,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `documents_supplies_conditions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `users_id` int(10) unsigned NOT NULL,
  `number` varchar(45) NOT NULL,
  `buyer_number` varchar(45) NOT NULL,
  `seller_number` varchar(45) DEFAULT NULL,
  `ext` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`users_id`),
  UNIQUE KEY `buyer_number_UNIQUE` (`buyer_number`),
  CONSTRAINT `fk_employee_info_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (8,'123','1','123','123','2019-03-21 04:56:12','2019-03-21 04:56:12'),(9,'345','2','345','345','2019-04-15 19:59:49','2019-04-15 19:59:49'),(11,'999999','999999',NULL,NULL,'2019-04-15 20:43:21','2019-04-15 20:43:21');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(500) DEFAULT NULL,
  `supplier` varchar(250) NOT NULL,
  `url` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '1. Quotation\n2. DataSheet',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (25,'storage/supplies_files/hYzDalUjgquYoArxYfP1MbE9JY7hdFmEcoe3Yu9s.jpeg','AbrasctSkull',NULL,'2019-07-02 01:38:52','2019-07-02 01:38:52',1),(26,'storage/supplies_files/Exmm9L9Ujwr2M5Veg428elqLPbuX3ortri2Yz2jl.png','DeadPool',NULL,'2019-07-02 01:40:44','2019-07-02 01:40:44',2);
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'Español'),(2,'Inglés'),(3,'Portugués');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manufacturers`
--

DROP TABLE IF EXISTS `manufacturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manufacturers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Manufacturers are brands, a supplier can sell many brands.\n\nWe''re gonan use key_xmd from siavcom as pk.',
  `name` varchar(45) DEFAULT NULL,
  `document_type` text COMMENT 'xml_xmd',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `siavcom_key_xmd` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=495 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manufacturers`
--

LOCK TABLES `manufacturers` WRITE;
/*!40000 ALTER TABLE `manufacturers` DISABLE KEYS */;
INSERT INTO `manufacturers` VALUES (47,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-05-03 01:42:57','2019-07-11 21:06:19',5094),(59,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" ODELO=\"SIEMENS\" /></VFPData>','2019-05-03 01:42:57','2019-07-11 21:06:23',23421),(372,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:51','2019-07-11 21:06:17',15596),(373,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:51','2019-07-11 22:15:48',15623),(374,'LIFT-TECH','<VFPData><data FABRICANTE=\"LIFT-TECH\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:52','2019-07-11 21:06:17',15683),(375,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:52','2019-07-11 21:06:18',16860),(376,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:52','2019-07-11 21:06:18',16031),(377,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:52','2019-07-11 21:06:18',18191),(378,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:52','2019-07-11 21:06:18',15029),(379,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:52','2019-07-11 21:06:18',15030),(380,'marathon','<VFPData><data FABRICANTE=\"marathon\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:52','2019-07-11 21:06:18',21851),(381,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 22:15:48',18103),(382,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:18',18451),(383,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:18',18456),(384,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:18',18577),(385,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:18',18441),(386,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:18',18446),(387,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:18',18449),(388,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:18',20646),(389,'FUJI ELECTRIC','<VFPData><data FABRICANTE=\"FUJI ELECTRIC\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:18',21879),(390,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 22:15:49',18112),(391,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 22:15:49',18113),(392,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:19',18622),(393,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:19',20703),(394,'SUN HYDRAULICS','<VFPData><data FABRICANTE=\"SUN HYDRAULICS\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:19',21914),(395,'SUN HYDRAULICS','<VFPData><data FABRICANTE=\"SUN HYDRAULICS\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:19',21915),(396,'SIEMENS','<VFPData><data FABRICANTE=\"SIEMENS\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 22:15:49',21208),(397,'SIEMENS','<VFPData><data FABRICANTE=\"SIEMENS\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 22:15:49',21207),(398,'Mitutoyo','<VFPData><data FABRICANTE=\"Mitutoyo\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:19',21803),(399,'SICK','<VFPData><data FABRICANTE=\"SICK\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 22:15:49',22057),(400,'TELEMECANIQUE','<VFPData><data FABRICANTE=\"TELEMECANIQUE\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:19',21967),(401,'SIGNET','<VFPData><data FABRICANTE=\"SIGNET\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:19',21968),(402,'EBM-PAPST','<VFPData><data FABRICANTE=\"EBM-PAPST\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:53','2019-07-11 21:06:19',21969),(403,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 21:06:19',2549),(404,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 21:06:19',2550),(405,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 22:15:49',2611),(406,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 22:15:49',2613),(407,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 21:06:19',2206),(408,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 21:06:19',8076),(409,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 21:06:19',9522),(410,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 21:06:19',4545),(411,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 21:06:19',2684),(412,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 21:06:19',11482),(413,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 21:06:19',9379),(414,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 21:06:19',15993),(415,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 21:06:19',15994),(416,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 21:06:19',15995),(417,'marathon','<VFPData><data FABRICANTE=\"marathon\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:57','2019-07-11 21:06:19',24187),(418,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 22:15:49',5528),(419,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 21:06:23',13515),(420,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 21:06:23',13516),(421,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 21:06:23',13517),(422,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 21:06:23',13518),(423,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 21:06:23',12233),(424,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 21:06:23',13512),(425,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 21:06:23',13513),(426,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 21:06:23',13514),(427,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 21:06:23',15950),(428,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 21:06:23',15951),(429,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 21:06:26',3196),(430,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 21:06:26',24699),(431,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 21:06:26',24700),(432,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:58','2019-07-11 22:15:49',5537),(433,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',15784),(434,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',15785),(435,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',15786),(436,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',16085),(437,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',15076),(438,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',9788),(439,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',9787),(440,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',10305),(441,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',5375),(442,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',5047),(443,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',3654),(444,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',3645),(445,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',3646),(446,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',5046),(447,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',5287),(448,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',5288),(449,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',5289),(450,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',3649),(451,'Mastech','<VFPData><data FABRICANTE=\"Mastech\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',3650),(452,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',3696),(453,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',23726),(454,'JRC','<VFPData><data FABRICANTE=\"JRC\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',24097),(455,'VISHAY','<VFPData><data FABRICANTE=\"VISHAY\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',24098),(456,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',24845),(457,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',24780),(458,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 22:15:49',9315),(459,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 22:15:49',2204),(460,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',11172),(461,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',20806),(462,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',20807),(463,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',20808),(464,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',20848),(465,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',20849),(466,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:55:59','2019-07-11 21:06:26',20850),(467,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',10579),(468,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',10580),(469,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',10577),(470,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',10578),(471,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 21:06:26',12237),(472,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 21:06:26',12238),(473,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 21:06:26',7750),(474,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 21:06:26',21985),(475,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 21:06:26',10343),(476,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',4284),(477,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 21:06:27',18375),(478,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',12945),(479,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',12943),(480,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',12946),(481,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',12950),(482,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',12948),(483,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',8458),(484,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',12952),(485,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',12954),(486,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',12953),(487,'BALDOR','<VFPData><data FABRICANTE=\"BALDOR\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 21:06:27',21113),(488,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 22:15:50',13057),(489,'WESTLOCK','<VFPData><data FABRICANTE=\"WESTLOCK\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 21:06:27',24623),(490,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 21:06:27',24625),(491,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:00','2019-07-11 21:06:27',24624),(492,'SUNON','<VFPData><data FABRICANTE=\"SUNON\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:01','2019-07-11 21:06:27',24622),(493,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:01','2019-07-11 22:15:50',16909),(494,'Fabricante','<VFPData><data FABRICANTE=\"Fabricante\" PRECOMP=\"0.0\" TIEENT=\"0 dias\" ORIGEN=\"NACIONAL\" /></VFPData>','2019-06-28 21:56:01','2019-07-11 22:15:50',17257);
/*!40000 ALTER TABLE `manufacturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measurements`
--

DROP TABLE IF EXISTS `measurements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `measurements` (
  `id` int(10) unsigned NOT NULL,
  `cm1` decimal(6,2) DEFAULT NULL,
  `cm2` decimal(6,2) DEFAULT NULL,
  `cm3` decimal(6,2) DEFAULT NULL,
  `in1` decimal(6,2) DEFAULT NULL,
  `in2` decimal(6,2) DEFAULT NULL,
  `in3` decimal(6,2) DEFAULT NULL,
  `kgs` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_measurements_documents_supplies1_idx` (`id`),
  CONSTRAINT `fk_measurements_documents_supplies1` FOREIGN KEY (`id`) REFERENCES `documents_supplies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measurements`
--

LOCK TABLES `measurements` WRITE;
/*!40000 ALTER TABLE `measurements` DISABLE KEYS */;
INSERT INTO `measurements` VALUES (1697,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1698,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1699,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1700,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1701,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1702,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1703,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1704,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1705,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1706,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1707,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1708,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1709,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1710,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1711,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1712,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1713,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1714,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1715,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1716,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1717,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1718,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1719,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1720,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1721,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1722,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1723,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1724,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1725,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1726,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1727,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `measurements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (2,'2019-03-13 21:31:31','2019-03-13 21:31:31'),(3,'2019-03-13 21:54:47','2019-03-13 21:54:47');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages_languages`
--

DROP TABLE IF EXISTS `messages_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages_languages` (
  `messages_id` int(10) unsigned NOT NULL,
  `languages_id` int(10) unsigned NOT NULL,
  `title` varchar(60) NOT NULL,
  `subject` varchar(60) NOT NULL,
  `body` text,
  PRIMARY KEY (`messages_id`,`languages_id`),
  KEY `fk_messages_languages_languages1_idx` (`languages_id`),
  CONSTRAINT `fk_messages_languages_languages1` FOREIGN KEY (`languages_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_languages_messages1` FOREIGN KEY (`messages_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages_languages`
--

LOCK TABLES `messages_languages` WRITE;
/*!40000 ALTER TABLE `messages_languages` DISABLE KEYS */;
INSERT INTO `messages_languages` VALUES (2,1,'Solicitud básica','Solicitud básica','<h1 class=\"ql-align-center\"><span style=\"color: rgb(230, 0, 0);\">SPANISH</span></h1>'),(2,2,'Basic request','Basic request','<h2 class=\"ql-align-center\"><strong style=\"color: rgb(255, 194, 102);\">ENGLISH HOMS</strong></h2>'),(2,3,'wtv','wtv','<h2 class=\"ql-align-center\"><strong style=\"color: rgb(0, 102, 204);\"><em>DO BRAZIL</em></strong></h2>'),(3,1,'Solicitud detallada','Solicitud detallada','<p><br></p>'),(3,2,'Detailed request','Detailed request','<p>aaaa</p>'),(3,3,'wtv','wtv','<p><br></p>');
/*!40000 ALTER TABLE `messages_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'IParts\\User',2),(2,'IParts\\User',8),(2,'IParts\\User',9),(2,'IParts\\User',11);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `observations`
--

DROP TABLE IF EXISTS `observations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `observations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supplies_id` int(10) unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_replacements_supplies1_idx` (`supplies_id`),
  CONSTRAINT `fk_replacements_supplies10` FOREIGN KEY (`supplies_id`) REFERENCES `supplies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `observations`
--

LOCK TABLES `observations` WRITE;
/*!40000 ALTER TABLE `observations` DISABLE KEYS */;
INSERT INTO `observations` VALUES (1,419,'Observation',NULL,NULL);
/*!40000 ALTER TABLE `observations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('giovanny@messoft.com','$2y$10$Zdm80stKhy1LDRBSrd70ouMVpo9HFqUKKNCWtEuaqA1of/ywhLZkG','2019-03-26 03:42:53');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'dashboard','web','2019-03-07 16:04:48','2019-03-07 16:04:48'),(2,'supplier-index','web','2019-03-07 16:04:48','2019-03-07 16:04:48'),(3,'supplier-create','web','2019-03-07 16:04:48','2019-03-07 16:04:48'),(4,'supplier-edit','web','2019-03-07 16:04:48','2019-03-07 16:04:48'),(5,'supplier-get-list','web','2019-03-07 16:04:48','2019-03-07 16:04:48'),(6,'supplier-create-brand','web',NULL,NULL),(7,'supplier-sync-brands','web',NULL,NULL),(8,'user-get-list','web','2019-03-11 17:29:00','2019-03-11 17:29:00'),(9,'user-index','web','2019-03-11 17:29:00','2019-03-11 17:29:00'),(10,'user-create','web','2019-03-11 17:29:00','2019-03-11 17:29:00'),(11,'user-edit','web','2019-03-11 17:29:00','2019-03-11 17:29:00'),(12,'color-settings-edit','web','2019-03-11 17:29:00','2019-03-11 17:29:00'),(13,'message-get-list','web','2019-03-11 17:29:00','2019-03-11 17:29:00'),(14,'message-index','web','2019-03-11 17:29:00','2019-03-11 17:29:00'),(15,'message-create','web','2019-03-11 17:29:00','2019-03-11 17:29:00'),(16,'message-edit','web','2019-03-11 17:29:00','2019-03-11 17:29:00');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotation_notifications`
--

DROP TABLE IF EXISTS `quotation_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotation_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `color` varchar(9) NOT NULL COMMENT 'hexadecimal',
  `elapsed_days` tinyint(4) NOT NULL COMMENT 'Elapsed days since quote was created.',
  `emails` text NOT NULL COMMENT 'emails to be notified as csv.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Elapsed days since quote was generated and emails which are going to be notified once a quote reach the amount of days of every record on this table.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotation_notifications`
--

LOCK TABLES `quotation_notifications` WRITE;
/*!40000 ALTER TABLE `quotation_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `quotation_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rejection_reasons`
--

DROP TABLE IF EXISTS `rejection_reasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rejection_reasons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rejection_reasons`
--

LOCK TABLES `rejection_reasons` WRITE;
/*!40000 ALTER TABLE `rejection_reasons` DISABLE KEYS */;
INSERT INTO `rejection_reasons` VALUES (1,'Razón 1',NULL,NULL);
/*!40000 ALTER TABLE `rejection_reasons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rejections`
--

DROP TABLE IF EXISTS `rejections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rejections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comments` text,
  `documents_supplies_id` int(10) unsigned NOT NULL,
  `rejection_reasons_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rejection_documents_supplies1_idx` (`documents_supplies_id`),
  KEY `fk_rejections_rejection_reasons1_idx` (`rejection_reasons_id`),
  CONSTRAINT `fk_rejection_documents_supplies1` FOREIGN KEY (`documents_supplies_id`) REFERENCES `documents_supplies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_rejections_rejection_reasons1` FOREIGN KEY (`rejection_reasons_id`) REFERENCES `rejection_reasons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rejections`
--

LOCK TABLES `rejections` WRITE;
/*!40000 ALTER TABLE `rejections` DISABLE KEYS */;
/*!40000 ALTER TABLE `rejections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `replacements`
--

DROP TABLE IF EXISTS `replacements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `replacements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supplies_id` int(10) unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_replacements_supplies1_idx` (`supplies_id`),
  CONSTRAINT `fk_replacements_supplies1` FOREIGN KEY (`supplies_id`) REFERENCES `supplies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `replacements`
--

LOCK TABLES `replacements` WRITE;
/*!40000 ALTER TABLE `replacements` DISABLE KEYS */;
INSERT INTO `replacements` VALUES (1,419,'Replacement',NULL,NULL),(3,419,'Replacement 2','2019-07-03 00:47:30','2019-07-03 00:47:30'),(4,419,'Replacement 3','2019-07-03 00:49:51','2019-07-03 00:49:51');
/*!40000 ALTER TABLE `replacements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador','web','2019-02-28 20:22:18','2019-02-28 20:22:18'),(2,'Cotizador','web','2019-03-07 16:04:48','2019-03-07 16:04:48');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Only méxico states for fiscal data.',
  `name` varchar(60) NOT NULL,
  `countries_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_states_countries1_idx` (`countries_id`),
  CONSTRAINT `fk_states_countries1` FOREIGN KEY (`countries_id`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,'Jalisco',1);
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `trade_name` varchar(120) NOT NULL,
  `email` varchar(45) NOT NULL,
  `landline` varchar(15) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `marketplace` tinyint(1) unsigned NOT NULL COMMENT 'Supplier has online sale?',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `business_name` varchar(120) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `street` varchar(45) DEFAULT NULL,
  `street_number` varchar(45) DEFAULT NULL,
  `unit_number` varchar(45) DEFAULT NULL COMMENT 'Address unit number.',
  `suburb` varchar(45) DEFAULT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT '1. Physical person\n2. Moral person\n3. Foreign',
  `rfc` varchar(13) DEFAULT NULL,
  `post_code` varchar(5) NOT NULL,
  `contact_name` varchar(60) DEFAULT NULL,
  `credit_days` tinyint(3) unsigned DEFAULT NULL,
  `credit_amount` decimal(10,2) unsigned DEFAULT NULL,
  `countries_id` int(10) unsigned NOT NULL,
  `languages_id` int(10) unsigned NOT NULL,
  `currencies_id` int(10) unsigned DEFAULT NULL,
  `states_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rfc_UNIQUE` (`rfc`),
  KEY `fk_suppliers_countries1_idx` (`countries_id`),
  KEY `fk_suppliers_languages1_idx` (`languages_id`),
  KEY `fk_suppliers_currencies1_idx` (`currencies_id`),
  KEY `fk_suppliers_states1_idx` (`states_id`),
  CONSTRAINT `fk_suppliers_countries1` FOREIGN KEY (`countries_id`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_suppliers_currencies1` FOREIGN KEY (`currencies_id`) REFERENCES `currencies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_suppliers_languages1` FOREIGN KEY (`languages_id`) REFERENCES `languages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_suppliers_states1` FOREIGN KEY (`states_id`) REFERENCES `states` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (2,'Proveedor 1','giovanny@messoft.com','3327382930','(11) 1111-1111',1,'2019-03-01 20:43:04','2019-03-05 17:24:06','AAAAAAAAAA','Guadalajara','Calle','1','2','dasd',1,'PGFJ372834JHJ','21323','aaaaaaaContact',23,23232.00,1,1,1,NULL),(3,'Proveedor2','p2@gmail.com','(33) 8232-3892','(33) 2378-8297',0,'2019-06-28 22:31:19','2019-06-28 22:31:19',NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,'32323',NULL,NULL,NULL,1,1,1,NULL);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers_manufacturers`
--

DROP TABLE IF EXISTS `suppliers_manufacturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers_manufacturers` (
  `suppliers_id` int(10) unsigned NOT NULL,
  `manufacturers_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`suppliers_id`,`manufacturers_id`),
  KEY `fk_suppliers_manufacturers_manufacturers1_idx` (`manufacturers_id`),
  CONSTRAINT `fk_suppliers_manufacturers_manufacturers1` FOREIGN KEY (`manufacturers_id`) REFERENCES `manufacturers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_suppliers_manufacturers_suppliers1` FOREIGN KEY (`suppliers_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers_manufacturers`
--

LOCK TABLES `suppliers_manufacturers` WRITE;
/*!40000 ALTER TABLE `suppliers_manufacturers` DISABLE KEYS */;
INSERT INTO `suppliers_manufacturers` VALUES (2,47),(2,59),(3,59);
/*!40000 ALTER TABLE `suppliers_manufacturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplies`
--

DROP TABLE IF EXISTS `supplies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(45) DEFAULT NULL COMMENT 'part number.',
  `manufacturers_id` int(10) unsigned DEFAULT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `large_description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tax` tinyint(1) DEFAULT '2' COMMENT '0. No tax (0%)\n1. tax (16%)\n2. For those empty or null values on siavcom.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `number_UNIQUE` (`number`),
  KEY `fk_supplies_manufacturers1_idx` (`manufacturers_id`),
  CONSTRAINT `fk_supplies_manufacturers1` FOREIGN KEY (`manufacturers_id`) REFERENCES `manufacturers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=487 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplies`
--

LOCK TABLES `supplies` WRITE;
/*!40000 ALTER TABLE `supplies` DISABLE KEYS */;
INSERT INTO `supplies` VALUES (362,'5KCP39JGH899                  ',372,'MOTOR ELECTRICO GE 1/2HP                                              ','MOTOR ELECTRICO GE Mod. 5KCP39JGH899 1/2 HP, 115V, 1 PH, 6.30A, 60Hz','2019-06-28 21:55:51','2019-07-05 22:34:48',1),(363,'DSBC-32-250-PPSA-N3           ',373,'Festo DSBC Standard Cylinder 32mm Diameter Self-Adjusting             ','Festo DSBC Standard Cylinder 32mm Diameter Self-Adjusting','2019-06-28 21:55:51','2019-07-05 22:34:48',1),(364,'229190-01                     ',374,'DC BRAKE CONTROL MODULE 115V-AC MCA LIFT-TECH                         ','Mod. : 229190-01\r\nMarca : LIFT-TECH\r\nDescripcion : DC BRAKE CONTROL MODULE 115V-AC MCA LIFT-TECH','2019-06-28 21:55:52','2019-07-05 22:34:48',1),(365,'1686-B CONTRAPESO             ',375,'CONTRAPESO SAIRWAY 1686-B                                             ','Mod. : 1686-B\r\nMarca : SAIRWAY\r\nDescripcion : CONTRAPESO SAIRWAY 1686-B                  ','2019-06-28 21:55:52','2019-07-05 22:34:48',1),(366,'SCOTCH 600 DE 24X65           ',376,'Cinta Scotch Transparente 600 de 24X65                                ','NUMERO DE PARTE: SCOTCH 600 DE 24X65  \r\nDESCRIPCION: Cinta Scotch Transparente 600 de 24X65        \r\nFABRICANTE: Scotch   3M\r\n','2019-06-28 21:55:52','2019-07-05 22:34:48',1),(367,'BOMBA OSC 15000-116           ',377,'BOMBA OSCILANTE GORMAN-RUPP INDUSTRIES 15000-116, 230V, 12 AMP,       ','Mod. : BOMBA OSCILANTE 15000-116\r\nMarca : GORMAN-RUPP INDUSTRIES\r\nDescripcion : BOMBA OSCILANTE PARA RECIRCULACIÓN DE GOMA\r\nMARCA GORMAN-RUPP INDUSTRIES\r\nCÓDIGO 15000-116, 230V, .12 amp, cust # 0201X002101','2019-06-28 21:55:52','2019-07-05 22:34:48',1),(368,'CABLE CAL 20 CAFE             ',378,'CABLE CALIBRE 20 COLOR CAFE                                           ','','2019-06-28 21:55:52','2019-07-05 22:34:48',1),(369,'CABLE CAL 20 ROJO             ',379,'CABLE CALIBRE 20 ROJO                                                 ','','2019-06-28 21:55:52','2019-07-05 22:34:48',1),(370,'056T17D11049                  ',417,'Motor marathon electric NP 056T17D11049                               ','Numero de Parte : 056T17D11049                 \r\nDescripcion : Motor marathon electric NP 056T17D11049                               \r\nFabricante : marathon','2019-06-28 21:55:52','2019-07-11 21:06:19',1),(371,'MR 16                         ',381,'MR 16                                                                 ','MODELO: MR 16\r\nDESCRIPCION: LAMPARA HALOGENA GU5.3 38 20W 12V 3000HRS','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(372,'TM-T88V-084                   ',382,'Impresora de ticket Epson TM-T88V-084                                 ','Impresora de ticket Epson TM-T88V-084','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(373,'C168H/PCI                     ',383,'Tarjeta multipuerto Moxa C168H/PCI                                    ','Tarjeta multipuerto Moxa C168H/PCI','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(374,'V_LTC921500                   ',384,'V_LTC921500                                                           ','V_LTC921500\r\nBRAZO PARA MONTAJE EN PARED / COMPATIBLE CON GABINETES BOSCH SERIES UHO / HSG / LTC / HSG / 948X / 9583','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(375,'CABLE PARALELO                ',385,'Cable paralelo p/impresora de via                                     ','Cable paralelo p/impresora de via','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(376,'HAUPPAUGE 558                 ',386,'Tarjeta de video Hauppauge 558                                        ','Tarjeta de video Hauppauge 558','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(377,'CONECTOR RJ45 CAT 6           ',387,'CONECTOR RJ45 CAT 6                                                   ','CONECTOR RJ45 CAT 6','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(378,'CFS-S SIL GG                  ',388,'SELLADOR CORTAFUEGO MCA. HILTI CFS-S SIL GG                           ','SELLADOR CORTAFUEGO MCA. HILTI CFS-S SIL GG','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(379,'VFC200P-5T                    ',389,'0.37 Ventilador Regenerativo 1 Fase, Voltaje 115/230, Entrada de 1 \"  ','Numero de Parte : VFC200P-5T      \r\nDescripcion : 0.37 Ventilador Regenerativo 1 Fase, Voltaje 115/230, Entrada de 1 \"(F) NPT Tamaño de Entrada\r\nFabricante : FUJI ELECTRIC','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(380,'F17 T8                        ',390,'LAMPARAS DE LUZ DE DIA D50 TEMPERATURA DE COLOR 5000KL POTENCIA 17W   ','Mod. : F17 T8    \r\nMarca : \r\nDescripcion : F17 T8 LAMPARAS DE LUZ DE DIA D50 TEMPERATURA DE COLOR 5000KL POTENCIA 17W','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(381,'IM05-0B8NS-ZW1                ',391,'SENSOR INDUCTIVO  IM05-0B8NS-ZW1                                      ','Mod. :  IM05-0B8NS-ZW1\r\nMarca : \r\nDescripcion : SENSOR INDUCTIVO  IM05-0B8NS-ZW1','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(382,'BFB1012M-A                    ',392,'BFB1012M-A                                                            ','Modelo: BFB1012M-A\r\nMarca: Delta\r\nDescripcion: Sopladores Blower, 97x94x33mm 12VDC','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(383,'GAVETA 24.5CMX4.5CM           ',393,'Separadores para este tipo de gaveta 24.5 cm x 4.5 cm                 ','Separadores para este tipo de gaveta 24.5 cm x 4.5 cm','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(384,'NFCCLCN                       ',394,'Cartucho No. NFCCLCN (valvula) MCA.SUN                                ','Numero de Parte : NFCCLCN  \r\nDescripcion : Cartucho No. NFCCLCN (valvula) (Cartucho regulador de flujo,5000 psi, T-13A) MCA.SUN\r\nVÁLVULA DE CARTUCHO DE CONTROL DE FLUJO NFCC-LCN DE SUN HYDRAULICS \r\nFabricante : SUN HYDRAULICS','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(385,'RDDALAN                       ',395,'Cartucho No. RDDALAN (valvula) (Cartucho de alivio accion directa 25 G','Numero de Parte : RDDALAN\r\nDescripcion : (Cartucho de alivio accion directa 25 GPM 5000 psi, T-10A MCA.\r\nSUN\r\nFabricante : SUN HYDRAULICS \r\n','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(386,'6ES7136-6RA00-0BF0            ',396,'SIMATIC DP I/O Module Digital I/P 1 Digital O/P                       ','SIMATIC DP I/O Module Digital I/P 1 Digital O/P SIEMENS  6ES7136-6RA00-0BF0','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(387,'6ES7136-6BA00-0CA0            ',397,'SIMATIC DP, ELECTRON. MODULE F. ET 200SP, F-DI 8X24VDC HF, 15 MM WIDTH','SIMATIC DP, ELECTRON. MODULE F. ET 200SP, F-DI 8X24VDC HF, 15 MM WIDTH, UP TO PL E (ISO 13849-1)/ SIL3 (IEC 61508) SIEMENS  6ES7136-6BA00-0CA0','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(388,'547-217S                      ',398,'Medidor de prof. mod.547-217S mitutoyo                                ','Numero de Parte : Medidor de prof.mod.547-217S mitutoyo         \r\nDescripcion : Digimatic Depth Gauge, 0-8\" Mitutoyo 547-217S\r\nFabricante : Mitutoyo','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(389,'LE20-2611                     ',399,'SICK LE20-2611 Aparato de maniobra de seguridad                       ','Numero de Parte : LE20-2611            \r\nDescripcion : SICK LE20-2611 Aparato de maniobra de seguridad                \r\nFabricante : SICK','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(390,'ZB2BJ2                        ',400,'SELECTOR DOS POSICIONES MODELO ZB2BJ2 ARO BAJO COTA FIJACION 30.5MM, M','NUMERO DE PARTE: ZB2BJ2  \r\nDESCRIPCION: SELECTOR DOS POSICIONES MODELO ZB2BJ2 ARO BAJO COTA FIJACION 30.5MM, MARCA TELEMECANIQUE\r\nFABRICANTE: TELEMECANIQUE','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(391,'8750-3 PH/ORP                 ',401,'SENSORES MARCA SIGNET PARA TRANSMISORES DE P.H. MODELO 8750-3 PH/ORP T','NUMERO DE PARTE: 8750-3 PH/ORP   \r\nDESCRIPCION. SENSORES MARCA SIGNET PARA TRANSMISORES DE P.H. MODELO 8750-3 PH/ORP TRANSMITTER\r\nFABRICANTE: SIGNET','2019-06-28 21:55:53','2019-07-05 22:34:48',1),(392,'W2E142-BB05-01                ',402,'ABANICO 120. 60HZ (MODELO W2E142-BB05-01) PARA CONVERTIDOR EMERSON    ','NUMERO DE PARTE: W2E142-BB05-01 \r\nDESCRIPCION: ABANICO 120. 60HZ (MODELO W2E142-BB05-01) PARA CONVERTIDOR EMERSON\r\nFABRICANTE:  EBM-PAPST','2019-06-28 21:55:53','2019-07-05 22:34:49',1),(393,'GP40NB40                      ',403,'REPRODUCTOR Y GRABADOR DE DVD ULTRA SLIM. EXTERNO MARCA LG            ','','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(394,'SATDOCK2REU3                  ',404,'DOCKING STATION CLONADOR DE DISCOS DUROS HDD MARCA STARTECH           ','','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(395,'09858113                      ',405,'Abanico                                                               ','Abanico 220 V 50 HZ .9AMP 2700R/MIN 7.5 KG PARA TRASMISION DE PRENSAS M-7, MARCA WOODS  Folio 86825\r\n','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(396,'09858181                      ',406,'Abanico                                                               ','Abanico 220VAC,60HZ 3.0 AMP 3300 R/MIN TYPE 9.5KG/60HZ, PARA MULTIDRY RODILLO DE RETORNO,  MARCA WOODS,  Folio 86825.\r\n','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(397,'3135                          ',407,'ventilador oscilante industrial de 30\" Fabricante: Lasko              ','','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(398,'TI2-SU1Z RIW                  ',408,'Liimit Switch BERNSTEIN AG                                            ','Limiti Switch\r\nMarca: BERNSTEIN AG\r\nMod. Ti2-SU1Z Riw  608.8167.008\r\nIP65 10AMP, 250VAC','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(399,'HNYW-41511008                 ',409,'GENESIS FIRE ALARM                                                    ','HNYW GENESIS FIRE ALARM UNSHIELDED FPL 2COND 16AWG DIRECT BURIAL','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(400,'782XBXM4L-110D                ',410,'RELE AUXILIAR 110/125 VCC 2NA+2NC 782                                 ','RELE AUXILIAR 110 125 VCC 2NA2NC 782   \r\nTENSION NOMINAL BOBINA110/125 VCC CONTACTOS 2NA2NC CAPACIDAD CONTACTOS15A\r\n125VCC MONTAJE/FIJACION ENCHUFABLE EN LA BASE MODELO 782 CODIGO 782XBXM4L110D FABRICANTE MAGNECRAFT.\r\n','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(401,'ENVIO                         ',411,'Envio a nuestras instalaciones                                        ','','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(402,'GABMDPA                       ',412,'Soplador GADNER DENVER rpm:3600                                       ','Soplador marca: GARDNER DENVER   (Sutorbilt)  modelo: GABMDPA  rpm:3600    ','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(403,'SILIKOTE DESMOLDANT           ',413,'SILIKOTE DESMOLDANTE                                                  ','Mod: Silikote Desmoldant\r\nMARCA:SILIKOTE Lumobras \r\nDesc: DESAMOLDANTE ESPECIAL EN SPRAY 33% DE SILICONA Color: Transparente Viscosidad a 20ªC. 350cSt. Peso especifico: 0.971 g/mL En presentación de 440cm3 33% DE SILICONA\r\nColor: Transparente\r\nViscosidad a 20ªC.  350cSt.\r\nPeso especifico: 0.971 g/mL\r\nEn presentación de 440cm3','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(404,'INTERRUPTOR 2X30              ',414,'Tablero                                                               ','TABLERO TRIFASICO PARA USO EN INTERPERIE  (GABINETE NEMA 3R O IP-65) , 220 VOLTIOS CON INTERRUPTOR PRINCIPAL DE 150 AMP.  PARA 30  CIRCUITOS DERIVADOS CON LOS SIGUIENTES INTERRUPTORES. \r\n**2x30**','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(405,'INTERRUPTOR 2X40              ',415,'Tablero                                                               ','TABLERO TRIFASICO PARA USO EN INTERPERIE  (GABINETE NEMA 3R O IP-65) , 220 VOLTIOS CON INTERRUPTOR PRINCIPAL DE 150 AMP.  PARA 30  CIRCUITOS DERIVADOS CON LOS SIGUIENTES INTERRUPTORES. \r\n**2x40**','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(406,'INTERRUPTOR 2X50              ',416,'Tablero                                                               ','TABLERO TRIFASICO PARA USO EN INTERPERIE  (GABINETE NEMA 3R O IP-65) , 220 VOLTIOS CON INTERRUPTOR PRINCIPAL DE 150 AMP.  PARA 30  CIRCUITOS DERIVADOS CON LOS SIGUIENTES INTERRUPTORES. \r\n**2x50**','2019-06-28 21:55:57','2019-07-05 22:34:49',1),(407,'B-1C                          ',47,'controlador de temperatura                                            ','Controlador de temperatura Modelo Burling B1-C serie 951543 rango 600 a 1200. ','2019-06-28 21:55:58','2019-07-05 22:34:50',1),(408,'HM25030-1SR                   ',418,'Class H fuse block                                                    ','','2019-06-28 21:55:58','2019-07-05 22:34:50',1),(409,'DPI611-13G QUICKFIT           ',419,'\"JUEGO DECONECTORES RAPIDOS QUICK FIT\"                                ','','2019-06-28 21:55:58','2019-07-05 22:34:50',1),(410,'DPI611-13G-IDOS USB           ',420,'convertidor IDOS a USB                                                ','','2019-06-28 21:55:58','2019-07-05 22:34:50',1),(411,'DPI611-13G-MANGUERA           ',421,'\"MANGUERANEUMATICA DE ALTA PRESION\"                                   ','','2019-06-28 21:55:58','2019-07-05 22:34:50',1),(412,'DPI611-13G-USBCABLE           ',422,'CABLE USB                                                             ','','2019-06-28 21:55:58','2019-07-05 22:34:50',1),(413,'DPI611-13G                    ',423,'Druck DPI611-13G Pressure Calibrator 20bar Gauge, Model DPI 611       ','Druck DPI611-13G Pressure Calibrator 20bar Gauge,\r\nModel DPI 611\r\n\r\nINCLUYE: ESTUCHE PROTECTOR, JUEGO DE\r\nCONECTORES RAPIDOS QUICK FIT, BATERIAS AA\r\nRECARGABLES, ADAPTADORES DE RED, CABLE\r\nUSB, CONVERSOR DE IDOS A USB, PURGADOR\r\nDE HUMEDAD Y SUCIEDAD, MANGUERA\r\nNEUMATICA DE ALTA PRESION (2) QUE CUBRA\r\nLOS RANGOS DE PRESION MANOMETRICA DE\r\n0-1000PSI\r\n','2019-06-28 21:55:58','2019-07-05 22:34:50',1),(414,'DPI611-13G-BATERIA            ',424,'MODULO DE BATERÍA RECARGABLE, CARGADOR DE BATERÍA Y ADAPTADOR PARA MOD','MODULO DE BATERÍA RECARGABLE, CARGADOR DE BATERÍA Y ADAPTADOR PARA MODULO DE BATERÍA.','2019-06-28 21:55:58','2019-07-05 22:34:50',1),(415,'DPI611-13G-PURGADOR           ',425,'TRAMPA DE POLVOS Y LÍQUIDOS.                                          ','','2019-06-28 21:55:58','2019-07-05 22:34:50',1),(416,'DPI611-13G FUNDA              ',426,'FUNDA DE PROTECCIÓN Y ACARREO                                         ','','2019-06-28 21:55:58','2019-07-05 22:34:51',1),(417,'CONTENEDOR ROJO               ',427,'CONTENEDOR ROJO 73x42x42 cm                                           ','CONTENEDOR ROJO 73x42x42 cm ','2019-06-28 21:55:58','2019-07-05 22:34:51',1),(418,'CONTENEDOR AMARILLO           ',428,'CONTENEDOR AMARILLO 73x42x26 cm                                       ','CONTENEDOR AMARILLO 73x42x26 cm   ','2019-06-28 21:55:58','2019-07-05 22:34:51',1),(419,'3UG06421AN30                  ',59,'RELEVADOR DE FALLAS SIEMENS                                           ','Modelo: 3UG06421AN30\r\nDescripción: Relevador Monitor,Fallas Fas,180/260VCA\r\nMarca: SIEMENS','2019-06-28 21:55:58','2019-07-05 22:34:53',1),(420,'MC000048                      ',429,'TERMINAL BLOCK, WIRE TO BRD, 2POS, 12AWG                              ','(64T3406) MULTICOMP MC000048 TERMINAL BLOCK, WIRE TO BRD, 2POS, 12AWG','2019-06-28 21:55:58','2019-07-05 22:34:53',1),(421,'CABLE CAL 20 YELLOW           ',430,'CABLE CAL 20 YELLOW                                                   ','CABLE CALIBRE 20 AMARILLO','2019-06-28 21:55:58','2019-07-05 22:34:53',1),(422,'CABLE CAL 20 NARANJ           ',431,'CABLE CAL 20 NARANJA                                                  ','','2019-06-28 21:55:58','2019-07-05 22:34:53',1),(423,'FPL9EX-N                      ',432,'FLUORESCENT 4 PINS(IN A SQUARE) 5000K                                 ','','2019-06-28 21:55:58','2019-07-05 22:34:53',1),(424,'9065SF220                     ',433,'Reelevador de sobrecarga 9065SF220 Square D                           ','Mod: 9065SF220  \r\nMarca: Square D \r\nDesc: Reelevador de sobrecarga','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(425,'9065SF320                     ',434,'Reelevador de sobrecarga Motor Logic 9065SF320 Square D               ','Mod: 9065SF320 \r\nMarca: Square D\r\nDesc: Reelevador de sobrecarga Motor Logic','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(426,'9065SF420                     ',435,'Reelevador de sobrecarga Motor Logic 9065SF420 Square D               ','Mod: 9065SF420 \r\nMarca: Square D \r\nDesc: Reelevador de sobrecarga Motor Logic','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(427,'405-10-22QC                   ',436,'45° CUELLO DE CISNE TREGASKISS                                        ','Mod: 405-10-22QC\r\nDescrip: 45° cuello de cisne para pistola TOUGH GUN\r\nMca: TREGASKISS','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(428,'8196 MTC                      ',437,'Moto-bomba                                                            ','Mod. 8196 MTC\r\n**Moto-bomba COMPLETA**\r\nN. de serie: fc-16193\r\nN. de contrato: 218\r\nTamaño: 3x2 - 8 A 60','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(429,'284-T                         ',438,'MOTOR ELECTRO HORIZONTAL                                              ','MOTOR ELECTRICO HORIZONTAL USO GENERAL MARCA “TECO WESTINGHOUSE”\r\nDE 25 HP, 3550 RPM, 2 POLOS, 3 FASES, 60 CICLOS, DISEÑO B, AISLAMIENTO CLASE F, 230/460\r\nVOLTS, ARM.284-T, TCCVE. EFICIENCIA NEMA. “PREMIUM','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(430,'ACOPLAMIENTO BASE A           ',439,'ACOPLAMIENTO (BASE DE ACERO, COPLE FLEXIBLE Y GUARDA                  ','DEL ACOPLAMIENTO (BASE DE ACERO, COPLE FLEXIBLE Y GUARDA COPLE) ','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(431,'9PK-750N                      ',440,'Aluminum Frame Tool Case Proskit                                      ','','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(432,'13656158                      ',441,'MALETIN PROSKITT MONOFASICO                                           ','MALETIN DE ALUMINIO MONOFASICO\r\nANCHO INT - 458MM PROF INT -150MM ALT INT FONDO - 33MM ALT INT TAPA - 330MM ESPESOR PARED MALETA - CONTRA CHAPA VIROLINA 4.00MM - GOMA RETRACTIL CERRADURA MALETA - IMESCA CANDADO  CLAVE - BIQUEIRA - RENTE ABERTUTA TAPA MALETA 100 2.5 - DIBUJO 10004344660 MARCA MALETA - PROSKIT CANTONERA - POLIAMIDA LIMITADOR APERTURA TAPA - DOS METALICOS PUERTA DOCS BOLSO TAPA - SIN REVESTIMIENTO INTERNO - TAMPA/FONDO - VELUDEL LISO NEGRO REVESTIMIENTO EXT - ALUMINIO MARTILLADO - MONOFASICO','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(433,'CWB9.11                       ',442,'CONTACTOR BOBINA 110 VAC 60 Hz WEG                                    ','','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(434,'MDW-C4-2                      ',443,'MINI-INTERRUPTOR FABRICANTE:WEG                                       ','','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(435,'DT4602                        ',444,'TERMINAL OJILLO AISL 5mm 12-10 AWG                                    ','TERMINAL OJILLO AISL 5mm 12-10 AWG','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(436,'DT4592                        ',445,'TERMINAL OJILLO AISL 5mm 16-14 AWG AISLADA AMP                        ','TERMINAL OJILLO AISL 5mm 16-14 AWG AISLADA AMP','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(437,'PE-CA-9                       ',446,'PINZA PELACABLES 9 7 MEDIDAS 4 MORDAZAS TRUPER                        ','','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(438,'FOY141705                     ',447,'Puntas dadso y dest JG 34 pzas                                        ','','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(439,'FOY140408                     ',448,'llave ajustable cormada 8\" foy tools                                  ','','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(440,'SURF4452A                     ',449,'MATRACA 1/4 REV CABEZA REDONDA SURTEK                                 ','','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(441,'LCD TU-D98                    ',450,'12 - 240 V W / pantalla LCD TU-D98 multifuncional Digital AC / DC Test','12 - 240 V W / pantalla LCD TU-D98 multifuncional Digital AC / DC Tester Pen continuidad Tester Volt Meter medidor Detector\r\nFabricante: OEM ','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(442,'MS8212A                       ',451,'Pen multímetro Digital / multimetros voltaje actual probador de diodo ','Pen multímetro Digital / multimetros voltaje actual probador de diodo continuidad multiprobador medidor dijital multimetr\r\nFabricante: Mastech','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(443,'14-409 3055-1538/14           ',452,'MEASURING RANGE: 0.0015-0.025, 0.038-0.635\" MM                        ','','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(444,'OPTIBELTZR 150XL              ',453,'OPTIBELTZR 150XL                                                      ','Modelo: OPTIBELTZR 150XL    \r\nDescripcion: banda 150XL037 \r\nMarca Optibel','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(445,'NJM324D                       ',454,'CIircuito integrado amplificador                                      ','Numero de parte:NJM324D\r\nDescripcion:circuito integrado amplificador\r\nFabricante:JRC','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(446,'CNY17                         ',455,'circuito integrado opto acoplador. salida de fotransistor             ','numero de parte:CNY17\r\ndescripcion:circuito integrado opto acoplador. salida de fotransistor \r\nfabricante:VISHAY','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(447,'PT06A-10-6S-SR                ',456,'PT06A-10-6S-SR                                                        ','Numero de parte: PT06A-10-6S-SR\r\nDescripción: CONN PLUG FMALE 6POS TAZA DE SOLDADURA\r\nFabricante: AMPHENOL INDUSTRIAL','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(448,'MOC3041M                      ',457,'MOC3041M                                                              ','Numero de parte: MOC3041M\r\nDescripcion: circuito integrado opto acopiador 6 pin foto triac\r\nFabricante : Fairchild','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(449,'RC810 HP 1YU                  ',458,'RELEVADOR DE SOBRECARGA 2E RELAY 7AT  RC810 HP 1YU  MARCA TOSHIBA     ','','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(450,'HCV-5HA                       ',459,'VACUUM CONTACTOR TYPE-FORM                                            ',' 400 AMPS, 50/60 HZ,  CAP. INTERRUPTIVA 350 MVA, VOLTAJE DE CONTROL 115-120, VAC. MARCA TOSHIBA.\r\n','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(451,'AL6-500                       ',NULL,'TRANSFORMADOR DE CORRIENTE                                            ','CURRENT TRANSFORMER-HIGH VOLTAGE, 6.9 KV, 50/60 HZ,\r\nRELACIÓN 500/5 AMPS, BURDEN 40 VA, EXACTITUD CLASE 1.0,\r\nMONTAJE INTERIOR, MOLDEADA EN RESINA RESISTENTE AL\r\nPOLVO Y LA ABRASIÓN, MODELO AEL6, CATALOGO AL6-500, \r\nMCA TOSHIBA.','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(452,'YT204001-CN/4                 ',460,'PROCESSOR CIRCUIT BOARD (3D6),ASEA YPP-105B                           ','','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(453,'S48W11104                     ',461,'Empaque en \"V\" de termoplástico blanco aprobado FDA, Thin Lip de 48\" S','Mod: S48W11104 \r\nDesc: Empaque en \"V\" de termoplástico blanco aprobado FDA, Thin Lip de 48\" S','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(454,'S48K00980                     ',462,'Ensamble de ajuste de sujeción sin herramienta S48K00980              ','Mod: S48K00980 \r\nDesc: Ensamble de ajuste de sujeción sin herramienta','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(455,'S48K41017                     ',463,'Deslizador de nylon p/charola de autolimpieza                         ','Mod: S48K41017\r\nDesc: Deslizador de nylon p/charola de autolimpieza.(1) Juego de deslizadores para separador vibratorio de 48\" de diámetro','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(456,'5687E4C2A35A924A              ',464,'RADIO DE DOS VIAS DE DOBLE BANDA RETEVIS                              ','Modelo: 5687E4C2A35A924A\r\nDescripción: Radio De Dos Vías De Doble Banda 5w 128ch Vhf\r\nMarca: RETEVIS','2019-06-28 21:55:59','2019-07-05 22:34:53',1),(457,'BOTIQUÍN MERET                ',465,'Botiquín Meret M.U.L.E                                                ','Botiquín Meret M.U.L.E. (Multi Use Large Equipment) Response Bag, TS-Ready, Infection Control. \r\nDimensiones de 15\" x 24.5\" x 10.5\"\r\nPeso 10 lbs. 3 Oz.','2019-06-28 21:55:59','2019-07-05 22:34:54',1),(458,'MEUSBLUE                      ',466,'MEGAFONO MS                                                           ','Modelo: MEUSBLUE\r\nDescripción: MEGÁFONO CON BLUETOOTH USB SD RECARGABLE 50W CON MICROFONO 800M DE ALCANCE\r\nMarca: MS','2019-06-28 21:55:59','2019-07-05 22:34:54',1),(459,'SMS4RDH1                      ',467,'Headers & Wire Housings 4P Panel Mt Recept Strain Relief Hood Souriau ','','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(460,'SMS4PDH1                      ',468,'Headers & Wire Housings 4P Cable Plug Strain Relief Hood Souriau      ','','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(461,'SMS6R1                        ',469,'Headers & Wire Housings 6P Receptacle Sz 16 Panel Mount Souriau       ','','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(462,'SMS6P1                        ',470,'Headers & Wire Housings 6P Cable Plug Sz 16 Souriau                   ','','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(463,'HGH 25CA                      ',471,'RODAMIENTO LINEAL HGH25CA                                             ','RODAMIENTO LINEAL HGH 25CA','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(464,'HGH 25HA                      ',472,'RODAMIENTO LINEAL HAH24HA                                             ','RODAMIENTO LINEAL HAH24HA    ','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(465,'DSPC 170                      ',473,'Tarjeta Electronica.                                                  ','Tarjeta Electronica,  CPU del Master Piece 200,  Mca. ABB,  Sol  510018305.','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(466,'PD765-6R2-10                  ',474,'PD765-6R2-10                                                          ','Modelo: PD765-6R2-10\r\nDescripcion:  Trident Process & Temperature Medidor de panel digital','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(467,'4000380C08CB                  ',475,'38 kV Bay-O-Net fuse link Cooper Fusible autoprotegifo 4000380C08CB   ','Numero de parte: 4000380C08CB\r\nMarca: Cooper \r\nDescripcion: 38 kV Bay-O-Net fuse link  Fusible Autoprotegido','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(468,'CTS-V24/V11PT3-0206           ',476,'LUTZE DATATRANS                                                       ','Lütze Datatrans \r\nMod. CTS-V24/V11pt-3-0206','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(469,'QT-53-050R                    ',477,'Bomba                                                                 ','Numero de parte:  QT-53-050R   \r\nMarca: Truninger\r\nDescripcion: Bomba hidraulica\r\n','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(470,'12L100                        ',478,'POLEA AMETRIC                                                         ','POLEA AMETRIC\r\nMOD. 12L100\r\nPULLEY, 12T 982A','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(471,'42MTB-5000                    ',479,'Allen Bradley - PhotoSwitch                                           ','Allen Bradley - PhotoSwitch\r\nMOD. 42MTB-5000\r\nVoltaje: 102-132VAC','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(472,'ARROW 20017                   ',480,'STOP MOTION LAMP ASSEMBLY ARROW                                       ','STOP MOTION LAMP ASSEMBLY ARROW\r\nMOD. ARROW 20017','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(473,'NCDME056-0400                 ',481,'CILINDRO NEUMATICO SMC                                                ','CILINDRO NEUMATICO SMC\r\nMOD. NCDME056-0400','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(474,'CLG-100-24                    ',482,'FUENTE DE PODER MEAN WELL                                             ','FUENTE DE PODER MEAN WELL\r\nMOD. CLG-100-24','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(475,'PR18-8DN                      ',483,'Sensor de Proximidad Inductivo                                        ','Sensor de Proximidad Inductivo, Serie PR, Cilíndrico, Cable, 8mm, NPN, 10 V a 30 V','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(476,'AW5Z                          ',484,'RADAMIENTO AURORA                                                     ','RODAMIENTO FIN DE CAMINO AURORA\r\nMOD.  AW5Z\r\nBEARING, ROAD END, FEMALE 5/16-24, 5/16 BORE','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(477,'OTBVN6                        ',485,'SENSOR FOTOELECTRICO BANNER                                           ','SENSOR FOTOELECTRICO BANNER\r\nMOD. OTBVN6\r\nSWITCH,  OPTO-TOUCH,  0-30VDC W/CABLE','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(478,'SM312LV-46172                 ',486,'SENSOR BANNER                                                         ','SENSOR BANNER\r\nMOD. SM312LV-46172\r\nEYE,  ELECTRIC, 72 IN CORD FFSM312LV W/PLUG','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(479,'907FK0101                     ',487,'Kit de realimentación de velocidad                                    ','Modelo: 907FK0101\r\nDescripción: Kit de realimentación de velocidad \r\nMarca: BALDOR','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(480,'BVP-20                        ',488,'VENTILADOR DE PISO 3 VELOCIDADES 20\" BIRTMAN                          ','','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(481,'BM2-Y                         ',489,'INDICADOR VISUAL (FARO) AMARILLO WESTLOCK                             ','Numero de parte: BM2-Y \r\nDescripción: Indicador visual (faro) amarillo \r\nFabricante: WESTLOCK','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(482,'SEGURO PARA CADENA            ',490,'CANDADO PARA CADENA DE TRANSMISION 20B-3                              ','CANDADO PARA CADENA DE TRANSMISION 20B-3','2019-06-28 21:56:00','2019-07-05 22:34:54',1),(483,'20B-3                         ',491,'CADENA DE TRANSMISION DIN 8187                                        ','Numero de parte: 20B-3\r\nDescripción: Cadena de transmisión DIN 8187 / PASO: 31.75MM / ANCHO INTERIOR: 19.56MM / DIAM. RODILLO: 19.05MM \r\nFabricante: NA','2019-06-28 21:56:01','2019-07-05 22:34:54',1),(484,'KDE2408PTV2                   ',492,'VENTILADOR AXIAL SUNON                                                ','Numero de parte: KDE2408PTV2\r\nDescripción: Ventilador axial, 80 x 80 x 25 mm, 62m³ / h, 1.4W, 24 VCC\r\nFabricante: SUNON','2019-06-28 21:56:01','2019-07-05 22:34:54',1),(485,'XS7D1A1DAL2                   ',493,'SENSOR DE PROXIMIDAD TELEMECANIQUE                                    ','Mod: XS7D1A1DAL2\r\nDescrip: Sensor de proximidad Size D DC XS7 cable 2 m\r\nMca: TELEMECANIQUE','2019-06-28 21:56:01','2019-07-05 22:34:54',1),(486,'63901-2670                    ',494,'Fine Adjust Applicator 63901-2670  Molex                              ','Mod: 63901-2670  \r\nMarca: Molex             \r\nDesc: Fine Adjust Applicator ','2019-06-28 21:56:01','2019-07-05 22:34:54',1);
/*!40000 ALTER TABLE `supplies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplies_files`
--

DROP TABLE IF EXISTS `supplies_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplies_files` (
  `supplies_id` int(10) unsigned NOT NULL,
  `files_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`supplies_id`,`files_id`),
  KEY `fk_supplies_files_files1_idx` (`files_id`),
  CONSTRAINT `fk_supplies_files_files1` FOREIGN KEY (`files_id`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_supplies_files_supplies1` FOREIGN KEY (`supplies_id`) REFERENCES `supplies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplies_files`
--

LOCK TABLES `supplies_files` WRITE;
/*!40000 ALTER TABLE `supplies_files` DISABLE KEYS */;
INSERT INTO `supplies_files` VALUES (431,25),(431,26);
/*!40000 ALTER TABLE `supplies_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplies_sets_status`
--

DROP TABLE IF EXISTS `supplies_sets_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplies_sets_status` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplies_sets_status`
--

LOCK TABLES `supplies_sets_status` WRITE;
/*!40000 ALTER TABLE `supplies_sets_status` DISABLE KEYS */;
INSERT INTO `supplies_sets_status` VALUES (1,'No solicitado'),(2,'Solicitado automáticamente'),(3,'Solicitado manualmente'),(4,'Confirmado por el proveedor'),(5,'Presupuesto capturado'),(6,'En Autorización'),(7,'Rechazado.');
/*!40000 ALTER TABLE `supplies_sets_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sync_connections`
--

DROP TABLE IF EXISTS `sync_connections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sync_connections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Since we''re gonna get records from three different postgres connections with the same db structure, we need to know which db the record belongs.',
  `name` varchar(20) NOT NULL,
  `display_name` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sync_connections`
--

LOCK TABLES `sync_connections` WRITE;
/*!40000 ALTER TABLE `sync_connections` DISABLE KEYS */;
INSERT INTO `sync_connections` VALUES (1,'pgsql_mxmro','Mxmro'),(2,'pgsql_pavan','Pavan'),(3,'pgsql_zukaely','Zukaely');
/*!40000 ALTER TABLE `sync_connections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Admin','giovanny@messoft.com',NULL,'$2y$10$irpdjkgKtJXN7MPMzHhGWebI1neGx./8UAYKRukrXkAGqGfpenaSy','mGd4a6EQCS6j20mKCGHdkXQzKOcXJyGrNDM7dJr57OXYAHBHwd3jI2MjLKir','2019-02-28 20:23:48','2019-02-28 20:23:48'),(8,'Pancho Perezz','user1@gmail.com',NULL,'$2y$10$n9WJ/4GzdOwWGUXyziJEG./jv2sISnIZ5zRfpmhp/obPQTt7QUqsG','LFSmt4mh7C3OsKnYDPCNXOg1rsWjLzWpWnQhMf3YjHrogVLjSafzQ2Wp37vK','2019-03-21 04:56:12','2019-07-18 22:34:11'),(9,'El comprador','comprador@gmail.com',NULL,'$2y$10$8.pdrEgsIdSuub7P0M3SS.DJHPxaLCZ6fUfh5u5kH.EPkouhJQk4m','6aQ0FG5Z8Z7VhoQ32ZNAFs4GlBzbtqSmCO2WPXfxD3Nh7OMXt9AiKpNfdDkz','2019-04-15 19:59:49','2019-04-15 19:59:49'),(11,'Cotizador genérico','cotizador_gral@siavcom.com',NULL,'$2y$10$n9WJ/4GzdOwWGUXyziJEG./jv2sISnIZ5zRfpmhp/obPQTt7QUqsG',NULL,'2019-04-15 20:43:21','2019-04-15 20:43:21');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utility_percentages`
--

DROP TABLE IF EXISTS `utility_percentages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utility_percentages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utility_percentages`
--

LOCK TABLES `utility_percentages` WRITE;
/*!40000 ALTER TABLE `utility_percentages` DISABLE KEYS */;
INSERT INTO `utility_percentages` VALUES (1,'Nacional',5.00),(2,'Internacional',10.00),(3,'Remplazo',15.00),(4,'Pieza usada',20.00);
/*!40000 ALTER TABLE `utility_percentages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-23 15:30:18
