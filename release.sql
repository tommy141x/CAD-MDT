-- MySQL dump 10.13  Distrib 8.0.22, for Win64 (x86_64)
--
-- Host: 51.81.82.33    Database: cad-release
-- ------------------------------------------------------
-- Server version	8.0.22-0ubuntu0.20.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `mdt_announcements`
--

DROP TABLE IF EXISTS `mdt_announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_announcements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `checked` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_announcements`
--

LOCK TABLES `mdt_announcements` WRITE;
/*!40000 ALTER TABLE `mdt_announcements` DISABLE KEYS */;
/*!40000 ALTER TABLE `mdt_announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdt_apparatus`
--

DROP TABLE IF EXISTS `mdt_apparatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_apparatus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `apparatus_name` text NOT NULL,
  `apparatus_status` text NOT NULL,
  `apparatus_division` text NOT NULL,
  `apparatus_call` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_apparatus`
--

LOCK TABLES `mdt_apparatus` WRITE;
/*!40000 ALTER TABLE `mdt_apparatus` DISABLE KEYS */;
INSERT INTO `mdt_apparatus` VALUES (1,'ENGINE 01','10-42','none','none'),(2,'ENGINE 02','10-42','none','none'),(3,'LADDER 01','10-42','none','none'),(4,'LADDER 02','10-42','none','none'),(5,'AMBULANCE 01','10-42','none','none'),(6,'AMBULANCE 02','10-42','none','none'),(7,'AIR SUPPORT 01','10-42','none','none'),(8,'AIR SUPPORT 02','10-42','none','none');
/*!40000 ALTER TABLE `mdt_apparatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdt_arrests`
--

DROP TABLE IF EXISTS `mdt_arrests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_arrests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `arr_owner` text NOT NULL,
  `arr_creator` text NOT NULL,
  `arr_type` text NOT NULL,
  `arr_details` text NOT NULL,
  `arr_street` text NOT NULL,
  `arr_postal` text NOT NULL,
  `arr_date` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_arrests`
--

LOCK TABLES `mdt_arrests` WRITE;
/*!40000 ALTER TABLE `mdt_arrests` DISABLE KEYS */;
/*!40000 ALTER TABLE `mdt_arrests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdt_bolos`
--

DROP TABLE IF EXISTS `mdt_bolos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_bolos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bolo_creator` text NOT NULL,
  `bolo_desc` text NOT NULL,
  `bolo_createdAt` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_bolos`
--

LOCK TABLES `mdt_bolos` WRITE;
/*!40000 ALTER TABLE `mdt_bolos` DISABLE KEYS */;
/*!40000 ALTER TABLE `mdt_bolos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdt_calls`
--

DROP TABLE IF EXISTS `mdt_calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_calls` (
  `id` int NOT NULL AUTO_INCREMENT,
  `call_id` text NOT NULL,
  `call_name` text NOT NULL,
  `call_description` text NOT NULL,
  `call_location` text NOT NULL,
  `call_postal` text NOT NULL,
  `call_type` text NOT NULL,
  `call_isPriority` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=292 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_calls`
--

LOCK TABLES `mdt_calls` WRITE;
/*!40000 ALTER TABLE `mdt_calls` DISABLE KEYS */;
/*!40000 ALTER TABLE `mdt_calls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdt_characters`
--

DROP TABLE IF EXISTS `mdt_characters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_characters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `owner_id` text NOT NULL,
  `char_name` text NOT NULL,
  `char_dob` text NOT NULL,
  `char_address` text NOT NULL,
  `char_dl` text NOT NULL,
  `char_wl` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_characters`
--

LOCK TABLES `mdt_characters` WRITE;
/*!40000 ALTER TABLE `mdt_characters` DISABLE KEYS */;
/*!40000 ALTER TABLE `mdt_characters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdt_citations`
--

DROP TABLE IF EXISTS `mdt_citations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_citations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cit_owner` text NOT NULL,
  `cit_creator` text NOT NULL,
  `cit_type` text NOT NULL,
  `cit_details` text NOT NULL,
  `cit_street` text NOT NULL,
  `cit_postal` text NOT NULL,
  `cit_fine` text NOT NULL,
  `cit_date` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_citations`
--

LOCK TABLES `mdt_citations` WRITE;
/*!40000 ALTER TABLE `mdt_citations` DISABLE KEYS */;
/*!40000 ALTER TABLE `mdt_citations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdt_departments`
--

DROP TABLE IF EXISTS `mdt_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_departments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dept_name` text,
  `dept_abv` text,
  `dept_logo` text,
  `dept_type` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_departments`
--

LOCK TABLES `mdt_departments` WRITE;
/*!40000 ALTER TABLE `mdt_departments` DISABLE KEYS */;
INSERT INTO `mdt_departments` VALUES (1,'Civilian Operations','Civilian','https://i.imgur.com/1CSI1Xw.png','CIV'),(2,'Blaine County Sheriff\'s Office','BCSO','https://static.wixstatic.com/media/756edd_dd2a51f33d9f482a8c2998bff4ba0edd~mv2.png/v1/fill/w_400,h_400,al_c,lg_1,q_85/BCSO%20LOGO.webp','LEO'),(3,'San Andreas State Police','SASP','https://i.imgur.com/yThIYhc.png','LEO'),(4,'Los Santos Police Department','LSPD','https://i.imgur.com/RCO4Qv1.png','LEO'),(5,'San Andreas Fire Department','SAFD','https://i.imgur.com/8czcvhe.png','FIRE'),(6,'San Andreas Communications Department','SACD','https://i.imgur.com/C5CUK8Z.png','DISPATCH');
/*!40000 ALTER TABLE `mdt_departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdt_medreps`
--

DROP TABLE IF EXISTS `mdt_medreps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_medreps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `report_owner` text NOT NULL,
  `report_creator` text NOT NULL,
  `report_desc` text NOT NULL,
  `report_date` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_medreps`
--

LOCK TABLES `mdt_medreps` WRITE;
/*!40000 ALTER TABLE `mdt_medreps` DISABLE KEYS */;
/*!40000 ALTER TABLE `mdt_medreps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdt_status`
--

DROP TABLE IF EXISTS `mdt_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mdt_data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_status`
--

LOCK TABLES `mdt_status` WRITE;
/*!40000 ALTER TABLE `mdt_status` DISABLE KEYS */;
INSERT INTO `mdt_status` VALUES (1,'285'),(2,'0');
/*!40000 ALTER TABLE `mdt_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdt_units`
--

DROP TABLE IF EXISTS `mdt_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_units` (
  `id` int NOT NULL AUTO_INCREMENT,
  `steam_id` text NOT NULL,
  `unit_callsign` text NOT NULL,
  `unit_name` text NOT NULL,
  `unit_status` text NOT NULL,
  `unit_call` text NOT NULL,
  `unit_division` text NOT NULL,
  `unit_type` text NOT NULL,
  `unit_panic` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=431 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_units`
--

LOCK TABLES `mdt_units` WRITE;
/*!40000 ALTER TABLE `mdt_units` DISABLE KEYS */;
/*!40000 ALTER TABLE `mdt_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdt_users`
--

DROP TABLE IF EXISTS `mdt_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `steam_id` text NOT NULL,
  `time_registered` text NOT NULL,
  `username` text NOT NULL,
  `perm_id` text NOT NULL,
  `approved_dept` text NOT NULL,
  `user_theme` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_users`
--

LOCK TABLES `mdt_users` WRITE;
/*!40000 ALTER TABLE `mdt_users` DISABLE KEYS */;
INSERT INTO `mdt_users` VALUES (112,'76561198198659291','01/01/2021','Tommy','3','1,2,5,6','');
/*!40000 ALTER TABLE `mdt_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdt_vehicles`
--

DROP TABLE IF EXISTS `mdt_vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_vehicles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `owner_id` text NOT NULL,
  `veh_plate` text NOT NULL,
  `veh_model` text NOT NULL,
  `veh_color` text NOT NULL,
  `veh_flags` text NOT NULL,
  `veh_owner_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_vehicles`
--

LOCK TABLES `mdt_vehicles` WRITE;
/*!40000 ALTER TABLE `mdt_vehicles` DISABLE KEYS */;
/*!40000 ALTER TABLE `mdt_vehicles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdt_warrants`
--

DROP TABLE IF EXISTS `mdt_warrants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdt_warrants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `warrant_owner` text NOT NULL,
  `warrant_desc` text NOT NULL,
  `warrant_creator` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdt_warrants`
--

LOCK TABLES `mdt_warrants` WRITE;
/*!40000 ALTER TABLE `mdt_warrants` DISABLE KEYS */;
/*!40000 ALTER TABLE `mdt_warrants` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-28 18:13:45
