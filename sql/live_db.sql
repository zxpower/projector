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
-- Dumping data for table `sillaj_event`
--

LOCK TABLES `sillaj_event` WRITE;
/*!40000 ALTER TABLE `sillaj_event` DISABLE KEYS */;
INSERT INTO `sillaj_event` VALUES (1,1,1,'demo','13:00:00','14:00:00','01:00:00','2012-05-02','Spent time installing Sillaj','2012-05-02 10:28:42'),(2,1,1,'demo','08:00:00','20:00:00','12:00:00','2012-05-02','test?','2012-05-02 10:51:27'),(8,7,6,'demo','08:00:00','17:00:00','09:00:00','2012-05-02','','2012-05-03 13:07:11'),(4,3,2,'demo',NULL,NULL,'100:00:00','2012-05-02','','2012-05-02 11:12:02'),(5,6,5,'demo',NULL,NULL,'300:00:00','2012-05-02','','2012-05-02 11:22:38'),(6,6,5,'demo','08:00:00','20:00:00','12:00:00','2012-05-02','555','2012-05-02 11:26:15'),(7,5,4,'demo',NULL,NULL,'24:00:00','2012-05-02','aaa','2012-05-02 11:28:09'),(9,8,7,'demo',NULL,NULL,'12:00:00','2012-05-09','','2012-05-09 10:33:05'),(10,9,8,'demo',NULL,NULL,'05:00:00','2012-05-10','','2012-05-10 09:16:37'),(11,7,6,'demo',NULL,NULL,'02:00:00','2012-05-10','','2012-05-10 14:42:18'),(12,6,9,'demo','13:20:00','14:00:00','00:40:00','2012-06-06','','2012-06-06 13:05:31');
/*!40000 ALTER TABLE `sillaj_event` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `sillaj_project`
--

LOCK TABLES `sillaj_project` WRITE;
/*!40000 ALTER TABLE `sillaj_project` DISABLE KEYS */;
INSERT INTO `sillaj_project` VALUES (1,'demo','Test project','1','Test project','1','1','2012-05-02 10:27:58'),(2,'demo','tests1','1','jknsd','0','1','2012-05-02 11:07:17'),(3,'demo','TESTS2','1','','0','1','2012-05-02 11:15:51'),(4,'demo','tests3','1','','0','1','2012-05-02 11:18:31'),(5,'demo','tests5555','1','555','0','1','2012-05-02 11:22:01'),(6,'demo','k-rauta','1','atziime','0','1','2012-05-03 13:06:26'),(7,'elvijs','tests1','1','aaa','1','1','2012-05-09 10:32:05'),(8,'demo','guilty klients a','1','pieziime','0','1','2012-05-10 09:15:54'),(9,'demo','maby','1','klients','0','1','2012-06-06 13:02:41');
/*!40000 ALTER TABLE `sillaj_project` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `sillaj_task`
--

LOCK TABLES `sillaj_task` WRITE;
/*!40000 ALTER TABLE `sillaj_task` DISABLE KEYS */;
INSERT INTO `sillaj_task` VALUES (1,'demo','Test task','1','Test task','1','1','2012-05-02 10:28:18'),(2,'demo','tests1','1','saygvx','0','1','2012-05-02 11:05:59'),(3,'demo','zjb','1','jsanb','0','1','2012-05-02 11:07:39'),(4,'demo','tests2','0','tests','0','1','2012-05-02 11:17:50'),(5,'demo','tests22','1','sd','0','1','2012-05-02 11:18:00'),(6,'demo','55555','1','sasd','0','1','2012-05-02 11:22:22'),(7,'demo','maketi nr1','1','','0','1','2012-05-03 13:06:39'),(8,'elvijs','darbs1','1','aaa','1','1','2012-05-09 10:32:22'),(9,'demo','uzdevums 1','1','aaa','0','1','2012-05-10 09:16:13'),(10,'demo','sapulce','1','ar klientu','0','1','2012-06-06 13:02:54');
/*!40000 ALTER TABLE `sillaj_task` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `sillaj_task_project`
--

LOCK TABLES `sillaj_task_project` WRITE;
/*!40000 ALTER TABLE `sillaj_task_project` DISABLE KEYS */;
INSERT INTO `sillaj_task_project` VALUES (1,1),(1,9),(2,9),(3,2),(5,2),(5,3),(5,7),(6,5),(6,9),(7,6),(7,9),(8,7),(8,9),(9,8),(10,9);
/*!40000 ALTER TABLE `sillaj_task_project` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `sillaj_user` VALUES ('demo','Demo','Demo','contact@digiblink.eu','fe01ce2a7fbac8fafaed7c982a04e229','1','1','0','en','default'),('elvijs','elvijs','Elvijs','elvijs@adm.lv','e5e5cca3cfec7df5962fce1fb0ac87b7','1','1','0','en','default');
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
