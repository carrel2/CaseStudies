-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: project
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.2

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Animals`
--

LOCK TABLES `Animals` WRITE;
/*!40000 ALTER TABLE `Animals` DISABLE KEYS */;
INSERT INTO `Animals` VALUES (1,'Horse','97353bdd85066e1f7ee9f95f7b7b7916.png');
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
  CONSTRAINT `FK_DDDA2C8F8E962C16` FOREIGN KEY (`animal_id`) REFERENCES `Animals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cases`
--

LOCK TABLES `Cases` WRITE;
/*!40000 ALTER TABLE `Cases` DISABLE KEYS */;
INSERT INTO `Cases` VALUES (2,1,'Case 12','On March 8th, you examine a 5-year-old bay Standardbred gelding with a nose bleed. He raced 4 days ago and developed a slight bloody nose during the race. The epistaxis seemed to abate after the race. The horse seemed normal the day after the race. However, the epistaxis recurred 2 days after racing. The horse subsequently developed anorexia, a fever, and a cough. The fever seemed to decrease after the trainer administered Tribressen to the horse but the epistaxis and cough have persisted. The last dose of Tribressen was 24 hours ago.');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Days`
--

LOCK TABLES `Days` WRITE;
/*!40000 ALTER TABLE `Days` DISABLE KEYS */;
INSERT INTO `Days` VALUES (2,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `HotSpots`
--

LOCK TABLES `HotSpots` WRITE;
/*!40000 ALTER TABLE `HotSpots` DISABLE KEYS */;
INSERT INTO `HotSpots` VALUES (4,1,'Rectum',294,331,205,306),(5,1,'Eyes',823,850,75,105),(6,1,'Lungs',517,718,218,282),(13,1,'Nostrils',892,920,141,175),(15,1,'Ears',799,844,9,51),(16,1,'Heart',653,717,283,311);
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
  CONSTRAINT `FK_8F7B04EF6C905A1B` FOREIGN KEY (`user_day_id`) REFERENCES `UserDays` (`id`),
  CONSTRAINT `FK_8F7B04EF9C24126` FOREIGN KEY (`day_id`) REFERENCES `Days` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `HotSpotsInfo`
--

LOCK TABLES `HotSpotsInfo` WRITE;
/*!40000 ALTER TABLE `HotSpotsInfo` DISABLE KEYS */;
INSERT INTO `HotSpotsInfo` VALUES (6,2,NULL,4,'102.4° F'),(7,2,24,6,'20/min, coughing frequently. Somewhat decreased lung sounds ventrally on both sides of the chest with abnormal sounds, mainly crackles, present dorsally on both sides, the right worse than the left.'),(8,2,NULL,13,'Serosanguinous nasal discharge which worsens after bouts of coughing'),(9,2,23,16,'48/min');
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
  PRIMARY KEY (`id`),
  KEY `IDX_C7C851159C24126` (`day_id`),
  KEY `IDX_C7C851156C905A1B` (`user_day_id`),
  KEY `IDX_C7C851152C4DE6DA` (`medication_id`),
  CONSTRAINT `FK_C7C851152C4DE6DA` FOREIGN KEY (`medication_id`) REFERENCES `Medications` (`id`),
  CONSTRAINT `FK_C7C851156C905A1B` FOREIGN KEY (`user_day_id`) REFERENCES `UserDays` (`id`),
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Medications`
--

LOCK TABLES `Medications` WRITE;
/*!40000 ALTER TABLE `Medications` DISABLE KEYS */;
INSERT INTO `Medications` VALUES (1,'Na penicillin G IV','0'),(2,'K penicillin G IV','0'),(3,'Carbenicillin subconjunct','0'),(4,'Erythromycin IM','0'),(5,'Amikacin IV','0'),(6,'Prednisone PO','0'),(7,'Albuterol PO','0');
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
  PRIMARY KEY (`id`),
  KEY `IDX_501EDD88A76ED395` (`user_id`),
  CONSTRAINT `FK_501EDD88A76ED395` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
  PRIMARY KEY (`id`),
  KEY `IDX_B868B2F29C24126` (`day_id`),
  KEY `IDX_B868B2F26C905A1B` (`user_day_id`),
  KEY `IDX_B868B2F21E5D0459` (`test_id`),
  CONSTRAINT `FK_B868B2F21E5D0459` FOREIGN KEY (`test_id`) REFERENCES `Tests` (`id`),
  CONSTRAINT `FK_B868B2F26C905A1B` FOREIGN KEY (`user_day_id`) REFERENCES `UserDays` (`id`),
  CONSTRAINT `FK_B868B2F29C24126` FOREIGN KEY (`day_id`) REFERENCES `Days` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TestResults`
--

LOCK TABLES `TestResults` WRITE;
/*!40000 ALTER TABLE `TestResults` DISABLE KEYS */;
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
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `cost` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=235 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tests`
--

LOCK TABLES `Tests` WRITE;
/*!40000 ALTER TABLE `Tests` DISABLE KEYS */;
INSERT INTO `Tests` VALUES (1,'Opthalmic examination','0'),(2,'Atlantooccipital CSF','0'),(3,'Reticulocyte count','0'),(4,'Cholesterol','0'),(5,'Serum electroophoresis','0'),(6,'Plasma viscosity','0'),(7,'Abdominal radiography','0'),(8,'Echocardiography','0'),(9,'Bone marrow aspirate','0'),(10,'Oral xylose absorption','0'),(11,'Acetylpromazine IV','0'),(12,'Acetylpromazine IM','0'),(13,'Xylazine IV','0'),(14,'Xylazine IM','0'),(15,'Detomidine IV','0'),(16,'Diazepam IV','0'),(101,'Na penicillin G IV','0'),(102,'K penicillin G IV','0'),(103,'Procaine penicillin G IM','0'),(104,'Benzathine penicillin IM','0'),(105,'Ampicillin IV','0'),(106,'Ampicillin IM','0'),(107,'Amoxicillin PO','0'),(108,'Amoxicillin/clavulanic a PO','0'),(109,'Cloxacillin IV','0'),(110,'Cloxacillin IM','0'),(111,'Carbenicillin subconjunct','0'),(112,'Ticarcillin IV','0'),(113,'Ticarcillin IMCephalothin IV','0'),(114,'Cephalothin IM','0'),(115,'Cefazolin IV','0'),(116,'Cefazolin IM','0'),(117,'Cephalexin POCephotaxine IV','0'),(118,'Moxalactam IV','0'),(119,'Trimethoprim-sulfa IV','0'),(120,'Trimethoprim-sulfa IM','0'),(121,'Trimethoprim-sulfa PO','0'),(122,'Erythromycin IV','0'),(123,'Erythromycin IM','0'),(124,'Erythromycin PO','0'),(125,'Gentamicin IV','0'),(126,'Gentamicin IM','0'),(127,'Kanamycin IV','0'),(128,'Kanamycin IM','0'),(129,'Neomycin PO','0'),(130,'Amikacin IV','0'),(131,'Amikacin IM','0'),(132,'Chloramphenicol IV','0'),(133,'Chloramphenicol IM','0'),(134,'Chloramphenicol PO','0'),(135,'Oxytetracycline IV','0'),(136,'Oxytetracycline IM','0'),(137,'Rifampicin PO','0'),(138,'Amphotericin B IV','0'),(139,'Metronidazole PO','0'),(140,'Iodochlorhydroxyquin PO','0'),(141,'Pyrimethamine PO','0'),(142,'Griseofulvin PO','0'),(143,'Methylprednisolone IV','0'),(144,'Methylprednisolone IM','0'),(145,'Methylprednisolone IA','0'),(146,'Dexamethasone IV','0'),(147,'Dexamethosone IM','0'),(148,'Flumethasone IV','0'),(149,'Flumethasone IM','0'),(150,'Prednisolone PO','0'),(151,'Prednisone PO','0'),(152,'DMSO IV','0'),(153,'DMSO topically','0'),(154,'Mannitol IV','0'),(155,'Boldenone undecylen IM','0'),(156,'Stanozolol IM','0'),(157,'Nandrolone phenylp IM','0'),(158,'Testerone IM','0'),(159,'Altrenogest PO','0'),(160,'Estradiol IM','0'),(161,'PGF2a IM','0'),(162,'Aminophylline IV','0'),(163,'Aminophylline PO','0'),(164,'Clenbuterol PO','0'),(165,'Albuterol PO','0'),(166,'Cromolyn Na insuffl','0'),(167,'Flunixin IV','0'),(168,'Flunixin IM','0'),(169,'Flunixin PO','0'),(170,'Phenylbutazone IV','0'),(171,'Phenylbutazone PO','0'),(172,'Butorphanol IV','0'),(173,'Meperidine IM','0'),(174,'Morphine IM','0'),(175,'Pentazocien IV','0'),(176,'Dipyrone IV','0'),(177,'0.9% NaCl IV','0'),(178,'1.8% NaCl IV','0'),(179,'0.45% NaCl and 2.5% glucose IV','0'),(180,'5% glucose IV','0'),(181,'10% glucose IV','0'),(182,'Lactated Ringers solution IV','0'),(183,'Ringers solution IV','0'),(184,'NaHCO3 IV','0'),(185,'KCl IV','0'),(186,'Calcium gluconate IV','0'),(187,'Dextran IV','0'),(188,'Plasma IV','0'),(189,'Whole blood IV','0'),(190,'Ivermectin IM','0'),(191,'Ivermectin PO','0'),(192,'Pyrantel PO','0'),(193,'Pyrantel 2X PO','0'),(194,'Fenbendazole PO','0'),(195,'Fenbendazole 10X PO','0'),(196,'Thiabendazole PO','0'),(197,'Cambendazole PO','0'),(198,'Albendazole PO','0'),(199,'Trichlorfon PO','0'),(200,'Diethycarbamizine PO','0'),(201,'Piperazine PO','0'),(202,'Febantel PO','0'),(203,'Dichlorvos PO','0'),(204,'Furosemide IV','0'),(205,'Furosemide IM','0'),(206,'Furosemide PO','0'),(207,'Digoxin IV','0'),(208,'Digoxin PO','0'),(209,'Quinidine IV','0'),(210,'Quinidine PO','0'),(211,'Lidocaine IV','0'),(212,'Neostigmine SQ','0'),(213,'Atropine IV','0'),(214,'Atropine IM','0'),(215,'Atropine SQ','0'),(216,'Probanthine IV','0'),(217,'Dantrolene Na IV','0'),(218,'Dantrolene Na PO','0'),(219,'Doxapram IV','0'),(220,'Cimetidine IV','0'),(221,'Cimetidine PO','0'),(222,'Ranitidine PO','0'),(223,'Sucralfate PO','0'),(224,'Isoproterenol IV','0'),(225,'Dopamine IV','0'),(226,'Dobutamine IV','0'),(227,'Isoxsuprine PO','0'),(228,'Mineral oil PO','0'),(229,'DSS PO','0'),(230,'Metamucil PO','0'),(231,'TbCG','0'),(232,'Excision','0'),(233,'Cryotherapy','0'),(234,'Weap','0');
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserDays`
--

LOCK TABLES `UserDays` WRITE;
/*!40000 ALTER TABLE `UserDays` DISABLE KEYS */;
INSERT INTO `UserDays` VALUES (1,NULL),(2,NULL),(3,NULL),(4,NULL),(5,NULL),(6,NULL),(7,NULL),(8,NULL),(9,NULL),(10,NULL),(11,NULL),(12,NULL),(13,NULL),(14,NULL),(15,NULL),(16,NULL),(17,NULL),(18,NULL),(19,NULL),(20,NULL),(21,NULL),(22,NULL),(23,NULL),(24,NULL);
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C2502824F85E0677` (`username`),
  UNIQUE KEY `UNIQ_C2502824E7927C74` (`email`),
  UNIQUE KEY `UNIQ_C2502824B34EEF18` (`uin`),
  KEY `IDX_C250282470CD7994` (`case_study_id`),
  CONSTRAINT `FK_C250282470CD7994` FOREIGN KEY (`case_study_id`) REFERENCES `Cases` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_users`
--

LOCK TABLES `app_users` WRITE;
/*!40000 ALTER TABLE `app_users` DISABLE KEYS */;
INSERT INTO `app_users` VALUES (1,NULL,'ROLE_ADMIN','brandon','$2y$13$/0ZWoICiRtbdEZlgHJw4q.PPdAIAhuYZ863ONTnfrPCmXWhCd6Pri','carrel2@illinois.edu','123123123',0),(2,NULL,'ROLE_USER','test','$2y$13$9eU4r./jL9tSNrcN/c9SAepC504Dx6XtUw.jshv.StqqCZD5w73K6','test@test.com','111111111',0);
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

-- Dump completed on 2017-04-10 15:06:43
