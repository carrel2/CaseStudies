-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: project
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

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
-- Table structure for table `Cases`
--

DROP TABLE IF EXISTS `Cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cases`
--

LOCK TABLES `Cases` WRITE;
/*!40000 ALTER TABLE `Cases` DISABLE KEYS */;
INSERT INTO `Cases` VALUES (1,'Case 1','This is a test case.'),(2,'Case 2','Another test case.');
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
  `session_id` int(11) DEFAULT NULL,
  `tests` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `medications` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4BD65358613FECDF` (`session_id`),
  CONSTRAINT `FK_4BD65358613FECDF` FOREIGN KEY (`session_id`) REFERENCES `Sessions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Days`
--

LOCK TABLES `Days` WRITE;
/*!40000 ALTER TABLE `Days` DISABLE KEYS */;
INSERT INTO `Days` VALUES (4,4,'a:0:{}','a:0:{}',1);
/*!40000 ALTER TABLE `Days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Hotspots`
--

DROP TABLE IF EXISTS `Hotspots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Hotspots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) DEFAULT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `info` longtext COLLATE utf8_unicode_ci NOT NULL,
  `day_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_668E5F00CF10D4F5` (`case_id`),
  KEY `IDX_668E5F009C24126` (`day_id`),
  CONSTRAINT `FK_668E5F009C24126` FOREIGN KEY (`day_id`) REFERENCES `Days` (`id`),
  CONSTRAINT `FK_668E5F00CF10D4F5` FOREIGN KEY (`case_id`) REFERENCES `Cases` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Hotspots`
--

LOCK TABLES `Hotspots` WRITE;
/*!40000 ALTER TABLE `Hotspots` DISABLE KEYS */;
INSERT INTO `Hotspots` VALUES (2,1,'Lungs','Everything is fine.',4),(3,1,'Nostrils','Everything is fine.',4),(4,1,'Ears','Everything is fine.',4),(5,2,'Lungs','Coughing frequently.',NULL),(6,2,'Heart','Everything is fine.',NULL),(7,2,'Nostrils','Serosanguinous nasal discharge which worsens after bouts of coughing.',NULL),(8,2,'Ears','Everything is fine.',NULL),(9,NULL,'Lungs','Everything is fine.',NULL);
/*!40000 ALTER TABLE `Hotspots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MedicationResults`
--

DROP TABLE IF EXISTS `MedicationResults`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MedicationResults` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) DEFAULT NULL,
  `medication_id` int(11) DEFAULT NULL,
  `results` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C7C85115CF10D4F5` (`case_id`),
  KEY `IDX_C7C851152C4DE6DA` (`medication_id`),
  CONSTRAINT `FK_C7C851152C4DE6DA` FOREIGN KEY (`medication_id`) REFERENCES `Medications` (`id`),
  CONSTRAINT `FK_C7C85115CF10D4F5` FOREIGN KEY (`case_id`) REFERENCES `Cases` (`id`)
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Medications`
--

LOCK TABLES `Medications` WRITE;
/*!40000 ALTER TABLE `Medications` DISABLE KEYS */;
/*!40000 ALTER TABLE `Medications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Sessions`
--

DROP TABLE IF EXISTS `Sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6316FF45CF10D4F5` (`case_id`),
  CONSTRAINT `FK_6316FF45CF10D4F5` FOREIGN KEY (`case_id`) REFERENCES `Cases` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sessions`
--

LOCK TABLES `Sessions` WRITE;
/*!40000 ALTER TABLE `Sessions` DISABLE KEYS */;
INSERT INTO `Sessions` VALUES (4,1);
/*!40000 ALTER TABLE `Sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TestResults`
--

DROP TABLE IF EXISTS `TestResults`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TestResults` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL,
  `results` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B868B2F21E5D0459` (`test_id`),
  KEY `IDX_B868B2F2CF10D4F5` (`case_id`),
  CONSTRAINT `FK_B868B2F21E5D0459` FOREIGN KEY (`test_id`) REFERENCES `Tests` (`id`),
  CONSTRAINT `FK_B868B2F2CF10D4F5` FOREIGN KEY (`case_id`) REFERENCES `Cases` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TestResults`
--

LOCK TABLES `TestResults` WRITE;
/*!40000 ALTER TABLE `TestResults` DISABLE KEYS */;
INSERT INTO `TestResults` VALUES (1,1,3,'Severe chronic abscessing bronchopneumonia.\r\nA large focal abscess was found in the left caudoventral lung. Several much smaller abscesses were found in the caudoventral and caudodorsal lung fields on the right side.\r\nA positive culture for Streptococcus zooepidemicus was obtained which was sensitive to Ampillicin, Cephalothin,Furacin, Methicillin, Penicillin, and Tetracycline.');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tests`
--

LOCK TABLES `Tests` WRITE;
/*!40000 ALTER TABLE `Tests` DISABLE KEYS */;
INSERT INTO `Tests` VALUES (1,'Nasogastric intubation','0'),(2,'Rectal examination','0'),(3,'Necropsy','0');
/*!40000 ALTER TABLE `Tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_users`
--

DROP TABLE IF EXISTS `app_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `uin` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C2502824E7927C74` (`email`),
  UNIQUE KEY `UNIQ_C2502824B34EEF18` (`uin`),
  UNIQUE KEY `UNIQ_C2502824F85E0677` (`username`),
  UNIQUE KEY `UNIQ_C2502824613FECDF` (`session_id`),
  CONSTRAINT `FK_C2502824613FECDF` FOREIGN KEY (`session_id`) REFERENCES `Sessions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_users`
--

LOCK TABLES `app_users` WRITE;
/*!40000 ALTER TABLE `app_users` DISABLE KEYS */;
INSERT INTO `app_users` VALUES (2,'brandon','$2y$13$zaLVi4efXukppV45ty9BPum8voj9cr3fg3JGh0qtGPV6MdqYArfrG','carrel2@illinois.edu',1,'675389176',4);
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

-- Dump completed on 2017-02-10 14:18:36
