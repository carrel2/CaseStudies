-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: project
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `Animals`
--

DROP TABLE IF EXISTS `Animals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Animals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Animals`
--

LOCK TABLES `Animals` WRITE;
/*!40000 ALTER TABLE `Animals` DISABLE KEYS */;
INSERT INTO `Animals` VALUES (2,'Standardbred gelding','0e229fe9361dde199a0a552d30de9d46.jpeg'),(3,'American Saddlebred','6b84f7bdd6679873bff003f6ba9df012.jpeg'),(8,'A Koala','df423712e59c0ee85aa594ac76bd6713.jpeg');
/*!40000 ALTER TABLE `Animals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Cases`
--

DROP TABLE IF EXISTS `Cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `animal_id` int(11) DEFAULT NULL,
  `title` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DDDA2C8F8E962C16` (`animal_id`),
  CONSTRAINT `FK_DDDA2C8F8E962C16` FOREIGN KEY (`animal_id`) REFERENCES `Animals` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cases`
--

LOCK TABLES `Cases` WRITE;
/*!40000 ALTER TABLE `Cases` DISABLE KEYS */;
INSERT INTO `Cases` VALUES (2,2,'Case 12','On March 8th, you examine a 5-year-old bay Standardbred gelding with a nose bleed. He raced 4 days ago and developed a slight bloody nose during the race. The epistaxis seemed to abate after the race. The horse seemed normal the day after the race. However, the epistaxis recurred 2 days after racing. The horse subsequently developed anorexia, a fever, and a cough. The fever seemed to decrease after the trainer administered Tribressen to the horse but the epistaxis and cough have persisted. The last dose of Tribressen was 24 hours ago.'),(3,3,'Case 13','<p>You are asked to examine a 4-year-old American Saddlebred filly for a skin mass of 4 weeks duration on the left front fetlock. The client has been spraying &quot;blue solution&quot; on it since it began but the mass has continued to increase gradually in size.</p>\r\n\r\n<p><strong>The client wants a cosmetic solution to the problem because the filly is a show horse.</strong></p>'),(5,8,'A test case','This is a test case to play around with.');
/*!40000 ALTER TABLE `Cases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Days`
--

DROP TABLE IF EXISTS `Days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Days` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `case_study_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4BD6535870CD7994` (`case_study_id`),
  CONSTRAINT `FK_4BD6535870CD7994` FOREIGN KEY (`case_study_id`) REFERENCES `Cases` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Days`
--

LOCK TABLES `Days` WRITE;
/*!40000 ALTER TABLE `Days` DISABLE KEYS */;
INSERT INTO `Days` VALUES (2,2),(3,3),(10,5),(11,5),(12,5);
/*!40000 ALTER TABLE `Days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `HotSpots`
--

DROP TABLE IF EXISTS `HotSpots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HotSpots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `animal_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `x1` int(11) NOT NULL,
  `x2` int(11) NOT NULL,
  `y1` int(11) NOT NULL,
  `y2` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A74F70048E962C16` (`animal_id`),
  CONSTRAINT `FK_A74F70048E962C16` FOREIGN KEY (`animal_id`) REFERENCES `Animals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `HotSpots`
--

LOCK TABLES `HotSpots` WRITE;
/*!40000 ALTER TABLE `HotSpots` DISABLE KEYS */;
INSERT INTO `HotSpots` VALUES (21,2,'Nostrils',182,215,181,218),(22,2,'Ears',232,298,44,98),(23,2,'Lungs',437,608,223,291),(24,2,'Heart',371,436,223,315),(25,2,'Rectum',757,792,213,345),(26,3,'Front left fetlock',346,376,458,501),(27,8,'Nose',317,436,302,462),(28,8,'Eye',477,548,303,372),(29,8,'Ear',62,393,10,265);
/*!40000 ALTER TABLE `HotSpots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `HotSpotsInfo`
--

DROP TABLE IF EXISTS `HotSpotsInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HotSpotsInfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day_id` int(11) DEFAULT NULL,
  `user_day_id` int(11) DEFAULT NULL,
  `hotspot_id` int(11) DEFAULT NULL,
  `info` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8F7B04EF9C24126` (`day_id`),
  KEY `IDX_8F7B04EF6C905A1B` (`user_day_id`),
  KEY `IDX_8F7B04EF3AE7F1EF` (`hotspot_id`),
  CONSTRAINT `FK_8F7B04EF3AE7F1EF` FOREIGN KEY (`hotspot_id`) REFERENCES `HotSpots` (`id`),
  CONSTRAINT `FK_8F7B04EF6C905A1B` FOREIGN KEY (`user_day_id`) REFERENCES `UserDays` (`id`) ON DELETE SET NULL,
  CONSTRAINT `FK_8F7B04EF9C24126` FOREIGN KEY (`day_id`) REFERENCES `Days` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `HotSpotsInfo`
--

LOCK TABLES `HotSpotsInfo` WRITE;
/*!40000 ALTER TABLE `HotSpotsInfo` DISABLE KEYS */;
INSERT INTO `HotSpotsInfo` VALUES (14,2,NULL,21,'Serosanguinous nasal discharge'),(15,2,NULL,23,'20/min'),(16,2,NULL,25,'102.4&deg;'),(17,2,NULL,24,'48/min'),(18,3,NULL,26,'<ol>\r\n	<li>3cm in diameter on the dorsolateral aspect</li>\r\n	<li>Elevated above the skin level ~1cm at its highest point</li>\r\n	<li>Surface is reddened and easily hemorrhages when excoriated</li>\r\n</ol>'),(29,10,NULL,27,'Info'),(30,11,NULL,29,'Ear info'),(31,12,NULL,28,'Eye info');
/*!40000 ALTER TABLE `HotSpotsInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MedicationResults`
--

DROP TABLE IF EXISTS `MedicationResults`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MedicationResults` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day_id` int(11) DEFAULT NULL,
  `user_day_id` int(11) DEFAULT NULL,
  `medication_id` int(11) DEFAULT NULL,
  `results` longtext COLLATE utf8_unicode_ci NOT NULL,
  `wait_time` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C7C851159C24126` (`day_id`),
  KEY `IDX_C7C851156C905A1B` (`user_day_id`),
  KEY `IDX_C7C851152C4DE6DA` (`medication_id`),
  CONSTRAINT `FK_C7C851152C4DE6DA` FOREIGN KEY (`medication_id`) REFERENCES `Medications` (`id`),
  CONSTRAINT `FK_C7C851156C905A1B` FOREIGN KEY (`user_day_id`) REFERENCES `UserDays` (`id`) ON DELETE SET NULL,
  CONSTRAINT `FK_C7C851159C24126` FOREIGN KEY (`day_id`) REFERENCES `Days` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MedicationResults`
--

LOCK TABLES `MedicationResults` WRITE;
/*!40000 ALTER TABLE `MedicationResults` DISABLE KEYS */;
/*!40000 ALTER TABLE `MedicationResults` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Medications`
--

DROP TABLE IF EXISTS `Medications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Medications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `cost` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `t_group` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wait_time` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=315 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Medications`
--

LOCK TABLES `Medications` WRITE;
/*!40000 ALTER TABLE `Medications` DISABLE KEYS */;
INSERT INTO `Medications` VALUES (1,'Na penicillin G IV','0',NULL,'1'),(2,'K penicillin G IV','0','',''),(3,'Carbenicillin subconjunct','0','',''),(4,'Erythromycin IM','0','',''),(5,'Amikacin IV','0','',''),(6,'Prednisone PO','0','',''),(7,'Albuterol PO','0','',''),(8,'Procaine penicillin G IM','0','','0'),(9,'Benzathine penicillin IM','0','','0'),(10,'Ampicillin Na IV','0','','0'),(11,'Ampicillin Na IM','0','','0'),(12,'Amoxicillin PO','0','','0'),(13,'Amoxicillin/clavulanic acid PO','0','','0'),(14,'Cloxacillin IV','0','','0'),(15,'Cloxacillin IM','0','','0'),(16,'Carbenicillin IV','0','','0'),(17,'Oxacillin IV','0','','0'),(18,'Oxacillin IM','0','','0'),(19,'Ticarcillin IV','0','','0'),(20,'Ticarcillin IM','0','','0'),(21,'Ticarcillin/clavulanic acid IV','0','','0'),(22,'Cefazolin IV','0','','0'),(23,'Cefazolin IM','0','','0'),(24,'Ceftazidime IV','0','','0'),(25,'Ceftiofur IV','0','','0'),(26,'Ceftiofur IM','0','','0'),(27,'Ceftriaxone IV','0','','0'),(28,'Ceftriaxone IM','0','','0'),(29,'Cephalexin PO','0','','0'),(30,'Cephalothin IV','0','','0'),(31,'Cephalothin IM','0','','0'),(32,'Cephotaxime IV','0','','0'),(33,'Moxalactam IV','0','','0'),(34,'Trimethoprim-sulfa IV','0','','0'),(35,'Trimethoprim-sulfa IM','0','','0'),(36,'Trimethoprim-sulfa PO','0','','0'),(37,'Erythromycin IV','0','','0'),(38,'Erythromycin PO','0','','0'),(39,'Azithromycin PO','0','','0'),(40,'Clarithromycin PO','0','','0'),(41,'Amikacin IM','0','','0'),(42,'Amikacin IA','0','','0'),(43,'Gentamicin IV','0','','0'),(44,'Gentamicin IM','0','','0'),(45,'Kanamycin IV','0','','0'),(46,'Kanamycin IM','0','','0'),(47,'Neomycin PO','0','','0'),(48,'Vancomycin IV','0','','0'),(49,'Chloramphenicol IV','0','','0'),(50,'Chloramphenicol IM','0','','0'),(51,'Chloramphenicol PO','0','','0'),(52,'Oxytetracycline IV','0','','0'),(53,'Oxytetracycline IM','0','','0'),(54,'Doxycycline PO','0','','0'),(55,'Minocycline PO','0','','0'),(56,'Ciprofloxacin PO','0','','0'),(57,'Enrofloxacin IV','0','','0'),(58,'Enrofloxacin PO','0','','0'),(59,'Marbofloxacin IV','0','','0'),(60,'Marbofloxacin PO','0','','0'),(61,'Rifampicin PO','0','','0'),(62,'Amphotericin B IV','0','','0'),(63,'Imipenem-cilastatin','0','','0'),(64,'Metronidazole PO','0','','0'),(65,'Metronidazole IV','0','','0'),(66,'Metronidazole per rectum','0','','0'),(67,'Griseofulvin PO','0','','0'),(68,'Fluconazole IV','0','','0'),(69,'Itraconazole topical','0','','0'),(70,'Ketoconazole PO','0','','0'),(71,'Voriconazole PO','0','','0'),(72,'Imidocarb IM','0','','0'),(73,'Lufenuron PO','0','','0'),(74,'Na iodide IV','0','','0'),(75,'Na iodide PO','0','','0'),(76,'Terbinafine PO','0','','0'),(77,'Iodochlorhydroxyquin PO','0','','0'),(78,'Pyrimethamine PO','0','','0'),(79,'Isoniazid PO','0','','0'),(80,'Acyclovir IV','0','','0'),(81,'Acyclovir PO','0','','0'),(82,'Valcyclovir PO','0','','0'),(83,'Rimantadine IV','0','','0'),(84,'Rimantadine PO','0','','0'),(85,'Lysine PO','0','','0'),(86,'Butorphanol tartrate IV','0','','0'),(87,'Butorphanol tartrate IM','0','','0'),(88,'Fentanyl topical','0','','0'),(89,'Ketamine IV','0','','0'),(90,'Meperidine IM','0','','0'),(91,'Morphine IM','0','','0'),(92,'Morphine epidural','0','','0'),(93,'Naloxone IV','0','','0'),(94,'Pentazocine IV','0','','0'),(95,'Gabapentin PO','0','','0'),(96,'Acetaminophen/paracetamol PO','0','','0'),(97,'Aspirin PO','0','','0'),(98,'Aspirin per rectum','0','','0'),(99,'Dipyrone IV','0','','0'),(100,'Firocoxib IV','0','','0'),(101,'Firocoxib PO','0','','0'),(102,'Flunixin meglumine IV','0','','0'),(103,'Flunixin meglumine IM','0','','0'),(104,'Flunixin meglumine PO','0','','0'),(105,'Meclofenamic acid PO','0','','0'),(106,'Naproxen Na PO','0','','0'),(107,'Phenylbutazone IV','0','','0'),(108,'Phenylbutazone PO','0','','0'),(109,'Phenylbutazone IM','0','','0'),(110,'Carprofen PO','0','','0'),(111,'Ketoprofen IV','0','','0'),(112,'Ketoprofen IM','0','','0'),(113,'Ibuprofen PO','0','','0'),(114,'Etodolac IV','0','','0'),(115,'Etodolac PO','0','','0'),(116,'Piroxicam PO','0','','0'),(117,'Na heparin IV','0','','0'),(118,'Na heparin SQ','0','','0'),(119,'Na heparin IM','0','','0'),(120,'Warfarin PO','0','','0'),(121,'Streptokinase locally','0','','0'),(122,'Atropine IV','0','','0'),(123,'Atropine IM','0','','0'),(124,'Atropine SQ','0','','0'),(125,'CaCl IV','0','','0'),(126,'Digoxin IV','0','','0'),(127,'Digoxin PO','0','','0'),(128,'Dobutamine IV','0','','0'),(129,'Dopamine IV','0','','0'),(130,'Enalapril IV','0','','0'),(131,'Ephedrine IV','0','','0'),(132,'Epinephrine IV','0','','0'),(133,'Epinephrine SQ','0','','0'),(134,'Erythropoietin SQ','0','','0'),(135,'Hydralazine PO','0','','0'),(136,'Isoproterenol IV','0','','0'),(137,'Lidocaine IV','0','','0'),(138,'Mg sulfate IV','0','','0'),(139,'Phenylephrine IV','0','','0'),(140,'Procainamine IV','0','','0'),(141,'Propanolol IV','0','','0'),(142,'Propanolol PO','0','','0'),(143,'Quinidine sulfate IV','0','','0'),(144,'Quinidine sulfate PO','0','','0'),(145,'Sidenafil PO','0','','0'),(146,'Levamisole PO','0','','0'),(147,'Propionobacterium acnes IV','0','','0'),(148,'Mycobacterium spp. IV','0','','0'),(149,'Inactivated Parapox ovis IM','0','','0'),(150,'BCG intralesional','0','','0'),(151,'Cisplatin intralesional','0','','0'),(152,'5-fluorouracil topical','0','','0'),(153,'Aurothioglucose IM','0','','0'),(154,'Diphenhydramine IV','0','','0'),(155,'Tripelennamine IM','0','','0'),(156,'Hydroxyzine PO','0','','0'),(157,'Furosemide IV','0','','0'),(158,'Furosemide IM','0','','0'),(159,'Furosemide PO','0','','0'),(160,'Acetazolamide PO','0','','0'),(161,'0.9% NaCl IV','0','','0'),(162,'1.8% NaCl IV','0','','0'),(163,'7.0% NaCl IV','0','','0'),(164,'0.45% NaCl and 2.5% glucose IV','0','','0'),(165,'5% glucose IV','0','','0'),(166,'10% glucose IV','0','','0'),(167,'Lactated Ringers solution IV','0','','0'),(168,'Ringers solution IV','0','','0'),(169,'NaHCO3 IV','0','','0'),(170,'KCl IV','0','','0'),(171,'Ca gluconate IV','0','','0'),(172,'Dextran IV','0','','0'),(173,'Hetastarch IV','0','','0'),(174,'Plasma IV','0','','0'),(175,'Endoserum® IV','0','','0'),(176,'Whole blood IV','0','','0'),(177,'Ca EDTA','0','','0'),(178,'Polymixin B IV','0','','0'),(179,'DMSO IV','0','','0'),(180,'DMSO PO','0','','0'),(181,'DMSO topically','0','','0'),(182,'Mannitol IV','0','','0'),(183,'Ivermectin IM','0','','0'),(184,'Ivermectin PO','0','','0'),(185,'Ivermectin IV','0','','0'),(186,'Moxidectin PO','0','','0'),(187,'Praziquantel PO','0','','0'),(188,'Pyrantel PO','0','','0'),(189,'Pyrantel 2X PO','0','','0'),(190,'Fenbendazole PO','0','','0'),(191,'Fenbendazole 10X PO','0','','0'),(192,'Thiabendazole PO','0','','0'),(193,'Cambendazole PO','0','','0'),(194,'Albendazole PO','0','','0'),(195,'Trichlorfon PO','0','','0'),(196,'Piperazine PO','0','','0'),(197,'Febantel PO','0','','0'),(198,'Dichlorvos PO','0','','0'),(199,'Sulfa/pyrimethamine PO','0','','0'),(200,'Folic acid PO','0','','0'),(201,'Dicalzuril PO','0','','0'),(202,'Ponazuril PO','0','','0'),(203,'Bethanecol IV','0','','0'),(204,'Bethanecol SQ','0','','0'),(205,'Metoclopramide IV','0','','0'),(206,'Metoclopramide PO','0','','0'),(207,'Neostigmine SQ','0','','0'),(208,'Probanthine IV','0','','0'),(209,'Mineral oil PO','0','','0'),(210,'DSS PO','0','','0'),(211,'Metamucil PO','0','','0'),(212,'Activated charcoal PO','0','','0'),(213,'Barium sulfate PO','0','','0'),(214,'Biosponge PO','0','','0'),(215,'Bismuth subsalicylate PO','0','','0'),(216,'Lactulose PO','0','','0'),(217,'Magnesium sulfate PO','0','','0'),(218,'Balanced electrolyte solution PO','0','','0'),(219,'Cimetidine IV','0','','0'),(220,'Cimetidine PO','0','','0'),(221,'Ranitidine PO','0','','0'),(222,'Famotidine PO','0','','0'),(223,'Omeprazole PO','0','','0'),(224,'Sucralfate PO','0','','0'),(225,'Misoprostol PO','0','','0'),(226,'Dantrolene Na IV','0','','0'),(227,'Dantrolene Na PO','0','','0'),(228,'Methocarbamol IV','0','','0'),(229,'Methocarbamol PO','0','','0'),(230,'Phenytoin PO','0','','0'),(231,'Butylscopolamine IV','0','','0'),(232,'Hyaluronic acid topically','0','','0'),(233,'Hyaluronic acid IA','0','','0'),(234,'Hyaluronate sodium IV (Legend® only)','0','','0'),(235,'Methylprednisolone acetate IV','0','','0'),(236,'Methylprednisolone acetate IM','0','','0'),(237,'Methylprednisolone acetate IA','0','','0'),(238,'Polysulfated GAG IM (Adequan®)','0','','0'),(239,'Triamcinolone IA','0','','0'),(240,'Platelet rich plasma intralesional','0','','0'),(241,'Stem cells IA','0','','0'),(242,'Stem cells intralesional','0','','0'),(243,'IRAP IA','0','','0'),(244,'IRAP intralesional','0','','0'),(245,'Aminocaproic acid IV','0','','0'),(246,'Isoxsuprine HCl PO','0','','0'),(247,'Nitroglycerine topical','0','','0'),(248,'Pentoxifylline IV','0','','0'),(249,'Pentoxifylline PO','0','','0'),(250,'Phenoxybezamine PO','0','','0'),(251,'Vasopressin IV','0','','0'),(252,'Biotin PO','0','','0'),(253,'Methionine PO','0','','0'),(254,'Yunan baiyao PO','0','','0'),(255,'Albuterol MDI','0','','0'),(256,'Aminophylline IV','0','','0'),(257,'Aminophylline PO','0','','0'),(258,'Beclomethasone MDI','0','','0'),(259,'Clenbuterol PO','0','','0'),(260,'Fluticasone MDI','0','','0'),(261,'Glycopyrrolate IV','0','','0'),(262,'Glycopyrrolate IM','0','','0'),(263,'Glycopyrrolate SQ','0','','0'),(264,'Terbutaline PO','0','','0'),(265,'Guafenensin PO','0','','0'),(266,'Cromolyn Na insufflation','0','','0'),(267,'Acetylcysteine nebulization','0','','0'),(268,'Doxapram IV','0','','0'),(269,'Caffeine IV','0','','0'),(270,'Caffeine PO','0','','0'),(271,'Caffeine per rectum','0','','0'),(272,'Diethycarbamazine PO','0','','0'),(273,'Altrenogest PO','0','','0'),(274,'Deslorelin IM','0','','0'),(275,'Deslorelin implant','0','','0'),(276,'Estradiol IM','0','','0'),(277,'Estrogen IV','0','','0'),(278,'GNRH IV','0','','0'),(279,'GNRH IM','0','','0'),(280,'HCG IM','0','','0'),(281,'Oxytocin IV','0','','0'),(282,'Oxytocin IM','0','','0'),(283,'PGF2α IM','0','','0'),(284,'Acepromazine IV','0','','0'),(285,'Acepromazine IM','0','','0'),(286,'Chloral hydrate IV','0','','0'),(287,'Detomidine IV','0','','0'),(288,'Detomidine IM','0','','0'),(289,'Diazepam IV','0','','0'),(290,'Fluphenazine IM','0','','0'),(291,'Midazolam IV','0','','0'),(292,'Phenobarbital IV','0','','0'),(293,'Phenobarbital PO','0','','0'),(294,'Potassium bromide PO','0','','0'),(295,'Romifidine IV','0','','0'),(296,'Xylazine IV','0','','0'),(297,'Xylazine IM','0','','0'),(298,'Dexamethasone IV','0','','0'),(299,'Dexamethasone IM','0','','0'),(300,'Dexamethasone PO','0','','0'),(301,'Flumethasone IV','0','','0'),(302,'Flumethasone IM','0','','0'),(303,'Prednisolone PO','0','','0'),(304,'Levothyroxine PO','0','','0'),(305,'Cyproheptadine PO','0','','0'),(306,'Pergolide PO','0','','0'),(307,'Imipramine PO','0','','0'),(308,'Trilostane PO','0','','0'),(309,'Cisapride IM','0','','0'),(310,'Cisapride per rectum','0','','0'),(311,'Domperidone PO','0','','0'),(312,'Reserpine PO','0','','0'),(313,'Methylene blue IV','0','','0'),(314,'Penicillamine PO','0','','0');
/*!40000 ALTER TABLE `Medications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Results`
--

DROP TABLE IF EXISTS `Results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `case_study` longtext COLLATE utf8_unicode_ci NOT NULL,
  `results` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `diagnosis` longtext COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_501EDD88A76ED395` (`user_id`),
  CONSTRAINT `FK_501EDD88A76ED395` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Results`
--

LOCK TABLES `Results` WRITE;
/*!40000 ALTER TABLE `Results` DISABLE KEYS */;
/*!40000 ALTER TABLE `Results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TestResults`
--

DROP TABLE IF EXISTS `TestResults`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TestResults` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day_id` int(11) DEFAULT NULL,
  `user_day_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL,
  `results` longtext COLLATE utf8_unicode_ci NOT NULL,
  `wait_time` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B868B2F29C24126` (`day_id`),
  KEY `IDX_B868B2F26C905A1B` (`user_day_id`),
  KEY `IDX_B868B2F21E5D0459` (`test_id`),
  CONSTRAINT `FK_B868B2F21E5D0459` FOREIGN KEY (`test_id`) REFERENCES `Tests` (`id`),
  CONSTRAINT `FK_B868B2F26C905A1B` FOREIGN KEY (`user_day_id`) REFERENCES `UserDays` (`id`) ON DELETE SET NULL,
  CONSTRAINT `FK_B868B2F29C24126` FOREIGN KEY (`day_id`) REFERENCES `Days` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TestResults`
--

LOCK TABLES `TestResults` WRITE;
/*!40000 ALTER TABLE `TestResults` DISABLE KEYS */;
INSERT INTO `TestResults` VALUES (3,2,NULL,541,'No fluid reflux. Some small amount of gas released from stomach. No fluid obtained after siphoning from stomach tube.',NULL),(4,2,NULL,542,'No abnormalities found',NULL),(5,2,NULL,564,'290,000 /ul',NULL),(11,10,NULL,539,'Results','1'),(12,11,NULL,611,'Same day results','0');
/*!40000 ALTER TABLE `TestResults` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tests`
--

DROP TABLE IF EXISTS `Tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `d_group` longtext COLLATE utf8_unicode_ci,
  `wait_time` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=808 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tests`
--

LOCK TABLES `Tests` WRITE;
/*!40000 ALTER TABLE `Tests` DISABLE KEYS */;
INSERT INTO `Tests` VALUES (539,'Ophthalmic examination','0','Diagnostic Procedures','1'),(540,'Neurologic examination','0','Diagnostic Procedures','0'),(541,'Nasogastric intubation','0','Diagnostic Procedures','0'),(542,'Rectal examination','0','Diagnostic Procedures','0'),(543,'Hoof tester examination','0','Diagnostic Procedures','0'),(544,'Lameness examination','0','Diagnostic Procedures','0'),(545,'ECG','0','Diagnostic Procedures','0'),(546,'EEG','0','Diagnostic Procedures','0'),(547,'EMG','0','Diagnostic Procedures','0'),(548,'Abdominocentesis','0','Diagnostic Procedures','0'),(549,'Thoracocentesis','0','Diagnostic Procedures','0'),(550,'Pericardiocentesis','0','Diagnostic Procedures','0'),(551,'Arthrocentesis','0','Diagnostic Procedures','0'),(552,'Transtracheal wash','0','Diagnostic Procedures','0'),(553,'Bronchoalveolar lavage','0','Diagnostic Procedures','0'),(554,'Lumbosacral CSF','0','Diagnostic Procedures','0'),(555,'Atlantooccipital CSF','0','Diagnostic Procedures','0'),(556,'Gastric lavage','0','Diagnostic Procedures','0'),(557,'Exploratory celiotomy','0','Diagnostic Procedures','0'),(558,'Thoracotomy','0','Diagnostic Procedures','0'),(559,'Refer to another hospital','0','Diagnostic Procedures','0'),(560,'Necropsy','0','Diagnostic Procedures','0'),(561,'PCV/TP','0','Clinical Pathology','0'),(562,'CBC','0','Clinical Pathology','0'),(563,'Reticulocyte count','0','Clinical Pathology','0'),(564,'Platelet count','0','Clinical Pathology','0'),(565,'Fibrinogen','0','Clinical Pathology','0'),(566,'Serum amyloid A','0','Clinical Pathology','0'),(567,'PT, PTT','0','Clinical Pathology','0'),(568,'ACT','0','Clinical Pathology','0'),(569,'Bleeding time','0','Clinical Pathology','0'),(570,'FDP','0','Clinical Pathology','0'),(571,'D-dimers','0','Clinical Pathology','0'),(572,'Buffy coat smear','0','Clinical Pathology','0'),(573,'RBC fragility test','0','Clinical Pathology','0'),(574,'Serum iron, TIBC, % sat','0','Clinical Pathology','0'),(575,'Blood glucose (portable meter)','0','Clinical Pathology','0'),(576,'Blood glucose (chemistry analyzer)','0','Clinical Pathology','0'),(577,'BUN and creatinine','0','Clinical Pathology','0'),(578,'Peritoneal fluid creatinine','0','Clinical Pathology','0'),(579,'Serum protein and albumin','0','Clinical Pathology','0'),(580,'SDH, LDH, GLDH','0','Clinical Pathology','0'),(581,'GGT, ALP','0','Clinical Pathology','0'),(582,'CK, AST','0','Clinical Pathology','0'),(583,'Amylase and lipase','0','Clinical Pathology','0'),(584,'Cholesterol','0','Clinical Pathology','0'),(585,'Venous blood gas','0','Clinical Pathology','0'),(586,'Arterial blood gas','0','Clinical Pathology','0'),(587,'Serum Na, K, Cl','0','Clinical Pathology','0'),(588,'Serum osmalility','0','Clinical Pathology','0'),(589,'Serum Ca, Mg, P','0','Clinical Pathology','0'),(590,'Serum ionized Ca','0','Clinical Pathology','0'),(591,'Bilirubin, direct and indirect','0','Clinical Pathology','0'),(592,'Serum electrophoresis','0','Clinical Pathology','0'),(593,'Plasma lactate (portable meter)','0','Clinical Pathology','0'),(594,'Plasma lactate (chemistry analyzer)','0','Clinical Pathology','0'),(595,'Cardiac troponin','0','Clinical Pathology','0'),(596,'UA (voided)','0','Clinical Pathology','0'),(597,'UA (catheterized)','0','Clinical Pathology','0'),(598,'Urine osmolality','0','Clinical Pathology','0'),(599,'Urine urea nitrogen and creatinine','0','Clinical Pathology','0'),(600,'Fractional clearance of Na, K, P','0','Clinical Pathology','0'),(601,'Na sulfanilate excretion','0','Clinical Pathology','0'),(602,'Water deprivation test','0','Clinical Pathology','0'),(603,'Urine GGT/ creatinine ratio','0','Clinical Pathology','0'),(604,'Urine myoglobin','0','Clinical Pathology','0'),(605,'BSP (Bromsulphthalein)','0','Clinical Pathology','0'),(606,'Serum bile acids','0','Clinical Pathology','0'),(607,'Blood ammonia','0','Clinical Pathology','0'),(608,'Plasma viscosity','0','Clinical Pathology','0'),(609,'Serum triglycerides','0','Clinical Pathology','0'),(610,'Factor VIII','0','Clinical Pathology','0'),(611,'Bronchoscopy','0','Diagnostic Endoscopy/Imaging','0'),(612,'Cystoscopy','0','Diagnostic Endoscopy/Imaging','0'),(613,'Gastroscopy','0','Diagnostic Endoscopy/Imaging','0'),(614,'Laparoscopy','0','Diagnostic Endoscopy/Imaging','0'),(615,'Rhinopharyngoscopy','0','Diagnostic Endoscopy/Imaging','0'),(616,'Thoracoscopy','0','Diagnostic Endoscopy/Imaging','0'),(617,'Treadmill/dynamic endoscopy','0','Diagnostic Endoscopy/Imaging','0'),(618,'Thoracic radiography','0','Diagnostic Endoscopy/Imaging','0'),(619,'Abdominal radiography','0','Diagnostic Endoscopy/Imaging','0'),(620,'Skull radiography','0','Diagnostic Endoscopy/Imaging','0'),(621,'Cervical radiography','0','Diagnostic Endoscopy/Imaging','0'),(622,'Myelogram','0','Diagnostic Endoscopy/Imaging','0'),(623,'Limb/digit radiography','0','Diagnostic Endoscopy/Imaging','0'),(624,'Barium swallow ','0','Diagnostic Endoscopy/Imaging','0'),(625,'Contrast cystography','0','Diagnostic Endoscopy/Imaging','0'),(626,'Scintigraphy: miscellaneous','0','Diagnostic Endoscopy/Imaging','0'),(627,'MRI: miscellaneous','0','Diagnostic Endoscopy/Imaging','0'),(628,'CT: miscellaneous','0','Diagnostic Endoscopy/Imaging','0'),(629,'Fluoroscopy: miscellaneous','0','Diagnostic Endoscopy/Imaging','0'),(630,'Echocardiography','0','Diagnostic Endoscopy/Imaging','0'),(631,'Thoracic US','0','Diagnostic Endoscopy/Imaging','0'),(632,'Liver US','0','Diagnostic Endoscopy/Imaging','0'),(633,'Kidney US','0','Diagnostic Endoscopy/Imaging','0'),(634,'Spleen US','0','Diagnostic Endoscopy/Imaging','0'),(635,'Urogenital US','0','Diagnostic Endoscopy/Imaging','0'),(636,'Mass US','0','Diagnostic Endoscopy/Imaging','0'),(637,'Limb US','0','Diagnostic Endoscopy/Imaging','0'),(638,'Blood smear','0','Cytology/Histology/Pathology','0'),(639,'Peritoneal fluid','0','Cytology/Histology/Pathology','0'),(640,'Pleural fluid','0','Cytology/Histology/Pathology','0'),(641,'Pericardial fluid','0','Cytology/Histology/Pathology','0'),(642,'Synovial fluid','0','Cytology/Histology/Pathology','0'),(643,'Transtracheal wash','0','Cytology/Histology/Pathology','0'),(644,'CSF','0','Cytology/Histology/Pathology','0'),(645,'Fecal smear','0','Cytology/Histology/Pathology','0'),(646,'Urine ','0','Cytology/Histology/Pathology','0'),(647,'Bone marrow aspirate','0','Cytology/Histology/Pathology','0'),(648,'Lymph node aspirate','0','Cytology/Histology/Pathology','0'),(649,'Mass aspirate','0','Cytology/Histology/Pathology','0'),(650,'Corneal swab','0','Cytology/Histology/Pathology','0'),(651,'Nasal swab','0','Cytology/Histology/Pathology','0'),(652,'Pharyngeal swab','0','Cytology/Histology/Pathology','0'),(653,'Guttural pouch swab','0','Cytology/Histology/Pathology','0'),(654,'Vaginal swab','0','Cytology/Histology/Pathology','0'),(655,'Cervical swab','0','Cytology/Histology/Pathology','0'),(656,'Uterine swab','0','Cytology/Histology/Pathology','0'),(657,'Penile swab','0','Cytology/Histology/Pathology','0'),(658,'Kidney biopsy','0','Cytology/Histology/Pathology','0'),(659,'Liver biopsy','0','Cytology/Histology/Pathology','0'),(660,'Rectal mucosal biopsy','0','Cytology/Histology/Pathology','0'),(661,'Muscle biopsy','0','Cytology/Histology/Pathology','0'),(662,'Skin scraping','0','Cytology/Histology/Pathology','0'),(663,'Skin biopsy','0','Cytology/Histology/Pathology','0'),(664,'Intestinal biopsy','0','Cytology/Histology/Pathology','0'),(665,'Uterine biopsy','0','Cytology/Histology/Pathology','0'),(666,'Aerobic culture','0','Microbiology','0'),(667,'Anaerobic culture','0','Microbiology','0'),(668,'Blood C/S','0','Microbiology','0'),(669,'Peritoneal fluid C/S','0','Microbiology','0'),(670,'Pleural fluid C/S','0','Microbiology','0'),(671,'Pericardial fluid C/S','0','Microbiology','0'),(672,'Synovial fluid C/S','0','Microbiology','0'),(673,'Transtracheal wash C/S','0','Microbiology','0'),(674,'CSF C/S','0','Microbiology','0'),(675,'Liver biopsy C/S','0','Microbiology','0'),(676,'Skin biopsy C/S','0','Microbiology','0'),(677,'Uterine C/S','0','Microbiology','0'),(678,'Fecal C/S','0','Microbiology','0'),(679,'Urine C/S','0','Microbiology','0'),(680,'Urine Leptospira darkfield examination','0','Microbiology','0'),(681,'Feed culture','0','Microbiology','0'),(682,'Corneal swab C/S','0','Microbiology','0'),(683,'Nasal swab C/S','0','Microbiology','0'),(684,'Pharyngeal swab C/S','0','Microbiology','0'),(685,'Guttural pouch swab C/S','0','Microbiology','0'),(686,'Vaginal swab C/S','0','Microbiology','0'),(687,'Cervical swab C/S','0','Microbiology','0'),(688,'Uterine swab C/S','0','Microbiology','0'),(689,'Penile swab C/S','0','Microbiology','0'),(690,'Uterine biopsy C/S','0','Microbiology','0'),(691,'Rectal mucosal biopsy C/S','0','Microbiology','0'),(692,'African horse sickness','0','Serology','0'),(693,'Equine coronavirus','0','Serology','0'),(694,'Equine rotavirus','0','Serology','0'),(695,'EEE, WEE','0','Serology','0'),(696,'EIA AGID','0','Serology','0'),(697,'EIA ELISA','0','Serology','0'),(698,'EHV-1 FA','0','Serology','0'),(699,'EHV-1 PCR','0','Serology','0'),(700,'EHV-1 SN titer','0','Serology','0'),(701,'EHV-4 FA','0','Serology','0'),(702,'EHV-4 PCR','0','Serology','0'),(703,'EHV-4 SN titer','0','Serology','0'),(704,'EHV-5 FA','0','Serology','0'),(705,'EHV-5 PCR','0','Serology','0'),(706,'EHV-5 SN titer','0','Serology','0'),(707,'Equine adenovirus FA','0','Serology','0'),(708,'EVA PCR','0','Serology','0'),(709,'Influenza A PCR','0','Serology','0'),(710,'WNV','0','Serology','0'),(711,'WNV capture IgM ELISA','0','Serology','0'),(712,'VS','0','Serology','0'),(713,'Anaplasma phagocytophilum (Ehrlichia equi) PCR','0','Serology','0'),(714,'Babesia caballi PCR','0','Serology','0'),(715,'Borellia burgdorgeri PCR','0','Serology','0'),(716,'Neorickettsia risticii (Ehrlichia risticii) PCR','0','Serology','0'),(717,'Theileria equi PCR','0','Serology','0'),(718,'Rickettsia rickettsii PCR','0','Serology','0'),(719,'Brucella titers','0','Serology','0'),(720,'Campylobacter PCR','0','Serology','0'),(721,'Clostridium difficile ELISA','0','Serology','0'),(722,'Clostridium perfringens toxin typing','0','Serology','0'),(723,'Lawsonia PCR','0','Serology','0'),(724,'Leptospira PCR','0','Serology','0'),(725,'Leptospira titers','0','Serology','0'),(726,'Listeria PCR','0','Serology','0'),(727,'Mycobacterium PCR','0','Serology','0'),(728,'Mycoplasma PCR','0','Serology','0'),(729,'Pasteurella PCR','0','Serology','0'),(730,'Rhodococcus equi PCR','0','Serology','0'),(731,'Salmonella PCR (3 sequential tests)','0','Serology','0'),(732,'Streptococcus equi PCR','0','Serology','0'),(733,'Aspergillus ELISA','0','Serology','0'),(734,'Blastomyces','0','Serology','0'),(735,'Cryptococcus','0','Serology','0'),(736,'Coccidioides','0','Serology','0'),(737,'Histoplasma','0','Serology','0'),(738,'Toxoplasma IFA','0','Serology','0'),(739,'EPM IFAT on CSF','0','Serology','0'),(740,'EPM IFAT on serum','0','Serology','0'),(741,'EPM western blot on CSF','0','Serology','0'),(742,'EPM PCR on CSF','0','Serology','0'),(743,'EPM SAG 2, 3, 4 on CSF','0','Serology','0'),(744,'EPM SAG 2, 3, 4 on serum','0','Serology','0'),(745,'EPM CSF:serum ratio','0','Serology','0'),(746,'EHV-1 on CSF','0','Serology','0'),(747,'CK activity in CSF','0','Serology','0'),(748,'Nasal mucosal VI','0','Serology','0'),(749,'Nasal mucosal VI','0','Serology','0'),(750,'Pharyngeal VI','0','Serology','0'),(751,'Fecal VI','0','Serology','0'),(752,'Buffy coat VI','0','Serology','0'),(753,'Tissue VI','0','Serology','0'),(754,'Nasal scraping FA','0','Serology','0'),(755,'Tissues FA','0','Serology','0'),(756,'Rotavirus fecal ELISA','0','Serology','0'),(757,'Salmonella fecal PCR','0','Serology','0'),(758,'Direct fecal examination','0','Parasitology','0'),(759,'Fecal flotation','0','Parasitology','0'),(760,'Baermann concentration','0','Parasitology','0'),(761,'Fecal occult blood','0','Parasitology','0'),(762,'Fecal cytology','0','Parasitology','0'),(763,'Fecal EM','0','Parasitology','0'),(764,'Cellophane (Scotch®) tape test','0','Parasitology','0'),(765,'SNAP® IgG test','0','Immunology ','0'),(766,'Immunoturbidometric IgG test','0','Immunology ','0'),(767,'Zinc sulfate test','0','Immunology ','0'),(768,'IgG, IgM, IgA, IgG (T) RID','0','Immunology ','0'),(769,'PHA skin test','0','Immunology ','0'),(770,'Coomb’s test','0','Immunology ','0'),(771,'Blood typing','0','Immunology ','0'),(772,'Major crossmatch','0','Immunology ','0'),(773,'Minor crossmatch','0','Immunology ','0'),(774,'Oral xylose absorption','0','Endocrinology','0'),(775,'Oral glucose absorption','0','Endocrinology','0'),(776,'IV glucose tolerance','0','Endocrinology','0'),(777,'Insulin tolerance','0','Endocrinology','0'),(778,'TSH stimulation test','0','Endocrinology','0'),(779,'TRH stimulation test','0','Endocrinology','0'),(780,'Insulin','0','Endocrinology','0'),(781,'Cortisol, baseline','0','Endocrinology','0'),(782,'Cortisol, post ACTH','0','Endocrinology','0'),(783,'Cortisol, post low dose dexamethasone','0','Endocrinology','0'),(784,'Cortisol, post high dose dexamethasone','0','Endocrinology','0'),(785,'HCG stimulation','0','Endocrinology','0'),(786,'Aflatoxin','0','Toxicology','0'),(787,'Arsenic, feed','0','Toxicology','0'),(788,'Blood copper','0','Toxicology','0'),(789,'Blood lead','0','Toxicology','0'),(790,'Blood selenium','0','Toxicology','0'),(791,'Urine cantharidin','0','Toxicology','0'),(792,'Cyanide screen','0','Toxicology','0'),(793,'Glutathione peroxidase','0','Toxicology','0'),(794,'Tissue/urine Hg/arsenic','0','Toxicology','0'),(795,'Monensin, feed','0','Toxicology','0'),(796,'Mycotoxins, feed','0','Toxicology','0'),(797,'Nitrate/nitrite screen','0','Toxicology','0'),(798,'Pesticide screen','0','Toxicology','0'),(799,'Serum zinc','0','Toxicology','0'),(800,'Strychnine','0','Toxicology','0'),(801,'Blood pressure (indirect)','0','Physiologic Testing','0'),(802,'Blood pressure (direct)','0','Physiologic Testing','0'),(803,'Sweat test (epinephrine)','0','Physiologic Testing','0'),(804,'Sweat test (terbutaline)','0','Physiologic Testing','0'),(805,'Exercise and re-examine','0','Physiologic Testing','0'),(806,'Post-exercise muscle enzymes','0','Physiologic Testing','0'),(807,'Exercise ECG','0','Physiologic Testing','0');
/*!40000 ALTER TABLE `Tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserDays`
--

DROP TABLE IF EXISTS `UserDays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserDays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_14DD497FA76ED395` (`user_id`),
  CONSTRAINT `FK_14DD497FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserDays`
--

LOCK TABLES `UserDays` WRITE;
/*!40000 ALTER TABLE `UserDays` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserDays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_users`
--

DROP TABLE IF EXISTS `app_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `case_study_id` int(11) DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `uin` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `location` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C2502824F85E0677` (`username`),
  UNIQUE KEY `UNIQ_C2502824E7927C74` (`email`),
  UNIQUE KEY `UNIQ_C2502824B34EEF18` (`uin`),
  KEY `IDX_C250282470CD7994` (`case_study_id`),
  CONSTRAINT `FK_C250282470CD7994` FOREIGN KEY (`case_study_id`) REFERENCES `Cases` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_users`
--

LOCK TABLES `app_users` WRITE;
/*!40000 ALTER TABLE `app_users` DISABLE KEYS */;
INSERT INTO `app_users` VALUES (1,NULL,'ROLE_SUPER_ADMIN','brandon','$2y$13$GdpILKYsXnaBBR0dhV0sVuKvlsE8j./QNr1XT/qx65idjz8jUcf8C','carrel2@illinois.edu','123123123',0,'Farm'),(4,NULL,'ROLE_ADMIN','admin','$2y$13$fmgTtVEq5Z1gxM/Jw1f40ORhImUe3Yapi3plikzXSA56p5O0ipuRm','test@test.com','111111111',0,'Farm'),(5,NULL,'ROLE_USER','user','$2y$13$lhIePNkv5fvaLAcK5fSN8ucA/Vsw3kIKXTZa.81DH.uOsPspllcPO','user@test.com','123456789',0,NULL);
/*!40000 ALTER TABLE `app_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-06 15:27:53
