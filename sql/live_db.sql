-- MySQL dump 10.13  Distrib 5.1.56, for portbld-freebsd8.1 (i386)
--
-- Host: localhost    Database: digiblink_projects
-- ------------------------------------------------------
-- Server version	5.1.56-log

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
-- Table structure for table `sillaj_event`
--

DROP TABLE IF EXISTS `sillaj_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sillaj_event` (
  `intEventId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sillaj_task_intTaskId` smallint(5) unsigned NOT NULL,
  `sillaj_project_intProjectId` smallint(5) unsigned NOT NULL,
  `sillaj_user_strUserId` varchar(20) NOT NULL,
  `timStart` time DEFAULT NULL,
  `timEnd` time DEFAULT NULL,
  `timDuration` time DEFAULT NULL,
  `datEvent` date NOT NULL,
  `strRem` varchar(255) DEFAULT NULL,
  `datUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intEventId`,`sillaj_task_intTaskId`,`sillaj_project_intProjectId`),
  KEY `sillaj_event_FKIndex1` (`sillaj_task_intTaskId`),
  KEY `sillaj_event_FKIndex2` (`sillaj_user_strUserId`),
  KEY `sillaj_event_FKIndex3` (`sillaj_project_intProjectId`),
  KEY `sillaj_event_strRem` (`strRem`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `sillaj_project`
--

DROP TABLE IF EXISTS `sillaj_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sillaj_project` (
  `intProjectId` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `sillaj_user_strUserId` varchar(20) NOT NULL,
  `strProject` varchar(255) NOT NULL,
  `booDisplay` set('0','1') DEFAULT '1',
  `strRem` varchar(255) DEFAULT NULL,
  `booShare` set('0','1') DEFAULT '0',
  `booUseInReport` set('0','1') DEFAULT '1',
  `datUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intProjectId`),
  KEY `sillaj_project_FKIndex1` (`sillaj_user_strUserId`),
  KEY `sillaj_project_strProject` (`strProject`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sillaj_task`
--

DROP TABLE IF EXISTS `sillaj_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sillaj_task` (
  `intTaskId` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `sillaj_user_strUserId` varchar(20) NOT NULL,
  `strTask` varchar(255) NOT NULL,
  `booDisplay` set('0','1') DEFAULT '1',
  `strRem` varchar(255) DEFAULT NULL,
  `booShare` set('0','1') DEFAULT '0',
  `booUseInReport` set('0','1') DEFAULT '1',
  `datUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intTaskId`),
  KEY `sillaj_task_FKIndex1` (`sillaj_user_strUserId`),
  KEY `sillaj_task_strTask` (`strTask`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sillaj_task_project`
--

DROP TABLE IF EXISTS `sillaj_task_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sillaj_task_project` (
  `sillaj_task_intTaskId` smallint(5) unsigned NOT NULL,
  `sillaj_project_intProjectId` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`sillaj_task_intTaskId`,`sillaj_project_intProjectId`),
  KEY `sillaj_task_project_FKIndex1` (`sillaj_task_intTaskId`),
  KEY `sillaj_task_project_FKIndex2` (`sillaj_project_intProjectId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sillaj_user`
--

DROP TABLE IF EXISTS `sillaj_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sillaj_user` (
  `strUserId` varchar(20) NOT NULL,
  `strName` varchar(45) NOT NULL,
  `strFirstname` varchar(45) DEFAULT NULL,
  `strEmail` varchar(255) NOT NULL,
  `strPassword` char(32) NOT NULL,
  `booActive` set('0','1') DEFAULT '1',
  `booUseShare` set('0','1') DEFAULT '0',
  `booAllowOther` set('0','1') DEFAULT '0',
  `strLanguage` char(2) DEFAULT NULL,
  `strTemplate` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`strUserId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sillaj_user`
--

LOCK TABLES `sillaj_user` WRITE;
/*!40000 ALTER TABLE `sillaj_user` DISABLE KEYS */;
INSERT INTO `sillaj_user` VALUES ('admin','Super','Admin','contact@digiblink.eu','fe01ce2a7fbac8fafaed7c982a04e229','1','1','0','en','default');
/*!40000 ALTER TABLE `sillaj_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-06-10 16:04:57
