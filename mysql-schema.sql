CREATE DATABASE  IF NOT EXISTS `nshis` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `nshis`;
-- MySQL dump 10.13  Distrib 5.1.40, for Win32 (ia32)
--
-- Host: localhost    Database: nshis
-- ------------------------------------------------------
-- Server version	5.1.36-community-log

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
-- Table structure for table `nshis_comments`
--

DROP TABLE IF EXISTS `nshis_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `device_id` int(11) DEFAULT NULL,
  `device` varchar(45) DEFAULT NULL,
  `comment` text,
  `cdate` varchar(45) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_choices_processor`
--

DROP TABLE IF EXISTS `nshis_choices_processor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_choices_processor` (
  `processor_id` int(11) NOT NULL AUTO_INCREMENT,
  `processor_name` varchar(45) NOT NULL,
  `processor_value` float DEFAULT NULL,
  PRIMARY KEY (`processor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_headsets`
--

DROP TABLE IF EXISTS `nshis_headsets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_headsets` (
  `headset_id` int(11) NOT NULL AUTO_INCREMENT,
  `cubicle_id` int(11) DEFAULT '0',
  `name` varchar(45) NOT NULL,
  `other_name` varchar(150) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT 'none',
  `cubicle_name` varchar(45) DEFAULT 'none',
  `flag_assigned` tinyint(4) DEFAULT '0',
  `date_purchased` varchar(15) DEFAULT NULL,
  `notes` text,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`headset_id`)
) ENGINE=MyISAM AUTO_INCREMENT=253 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_choices_memory`
--

DROP TABLE IF EXISTS `nshis_choices_memory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_choices_memory` (
  `memory_id` int(11) NOT NULL AUTO_INCREMENT,
  `memory_name` varchar(45) NOT NULL,
  `memory_value` int(11) DEFAULT NULL,
  `memory_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`memory_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_cpus`
--

DROP TABLE IF EXISTS `nshis_cpus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_cpus` (
  `cpu_id` int(11) NOT NULL AUTO_INCREMENT,
  `other_name` varchar(150) DEFAULT NULL,
  `cubicle_id` int(11) DEFAULT '0',
  `memory1_id` int(11) DEFAULT NULL,
  `memory2_id` int(11) DEFAULT NULL,
  `processor_id` int(11) DEFAULT NULL,
  `memory1_type_id` int(11) DEFAULT NULL,
  `memory2_type_id` int(11) DEFAULT NULL,
  `hd1_id` int(11) DEFAULT NULL,
  `hd2_id` int(11) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `hd1_type_id` int(11) DEFAULT NULL,
  `hd2_type_id` int(11) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT 'none',
  `cubicle_name` varchar(45) DEFAULT 'none',
  `flag_assigned` tinyint(4) DEFAULT '0',
  `date_purchased` varchar(15) DEFAULT NULL,
  `hostname` varchar(45) DEFAULT NULL,
  `notes` text,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`cpu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=379 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_upss`
--

DROP TABLE IF EXISTS `nshis_upss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_upss` (
  `ups_id` int(11) NOT NULL AUTO_INCREMENT,
  `cubicle_id` int(11) DEFAULT '0',
  `name` varchar(45) NOT NULL,
  `other_name` varchar(150) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT 'none',
  `cubicle_name` varchar(45) DEFAULT 'none',
  `flag_assigned` tinyint(4) DEFAULT '0',
  `date_purchased` varchar(15) DEFAULT NULL,
  `notes` text,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`ups_id`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_choices_memory_types`
--

DROP TABLE IF EXISTS `nshis_choices_memory_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_choices_memory_types` (
  `memory_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name_type` varchar(45) NOT NULL,
  PRIMARY KEY (`memory_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_logs`
--

DROP TABLE IF EXISTS `nshis_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `process` varchar(45) NOT NULL,
  `device_id` int(11) NOT NULL,
  `device` varchar(45) NOT NULL,
  `device_name` varchar(100) DEFAULT NULL,
  `cubicle_id` int(11) DEFAULT '0',
  `cubicle_name` varchar(100) DEFAULT NULL,
  `cdate` datetime NOT NULL,
  `usb_headset_assignment` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=932 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_choices_hd_types`
--

DROP TABLE IF EXISTS `nshis_choices_hd_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_choices_hd_types` (
  `hd_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name_type` varchar(45) NOT NULL,
  PRIMARY KEY (`hd_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_cubicles`
--

DROP TABLE IF EXISTS `nshis_cubicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_cubicles` (
  `cubicle_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `cpu` int(11) DEFAULT '0',
  `keyboard` int(11) DEFAULT '0',
  `mouse` int(11) DEFAULT '0',
  `monitor` int(11) DEFAULT '0',
  `dialpad` int(11) DEFAULT '0',
  `connector` int(11) DEFAULT '0',
  `headset` int(11) DEFAULT '0',
  `headset_usb` int(11) DEFAULT '0',
  `ups` int(11) DEFAULT '0',
  `cdate` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`cubicle_id`)
) ENGINE=MyISAM AUTO_INCREMENT=363 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_usb_headsets`
--

DROP TABLE IF EXISTS `nshis_usb_headsets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_usb_headsets` (
  `usb_headset_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `serial_number` varchar(100) DEFAULT 'none',
  `other_name` varchar(150) DEFAULT 'none',
  `assigned_person` varchar(100) DEFAULT NULL,
  `date_purchased` varchar(15) DEFAULT NULL,
  `notes` text,
  `cdate` datetime NOT NULL,
  `flag_assigned` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`usb_headset_id`)
) ENGINE=MyISAM AUTO_INCREMENT=191 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_users`
--

DROP TABLE IF EXISTS `nshis_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '1',
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_dialpads`
--

DROP TABLE IF EXISTS `nshis_dialpads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_dialpads` (
  `dialpad_id` int(11) NOT NULL AUTO_INCREMENT,
  `cubicle_id` int(11) DEFAULT '0',
  `name` varchar(45) NOT NULL,
  `other_name` varchar(150) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT 'none',
  `cubicle_name` varchar(45) DEFAULT 'none',
  `flag_assigned` tinyint(4) DEFAULT '0',
  `date_purchased` varchar(15) DEFAULT NULL,
  `notes` text,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`dialpad_id`)
) ENGINE=MyISAM AUTO_INCREMENT=259 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_usb_headsets_history`
--

DROP TABLE IF EXISTS `nshis_usb_headsets_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_usb_headsets_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `usb_headset_id` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_choices_hd`
--

DROP TABLE IF EXISTS `nshis_choices_hd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_choices_hd` (
  `hd_id` int(11) NOT NULL AUTO_INCREMENT,
  `hd_name` varchar(45) NOT NULL,
  `hd_value` int(11) DEFAULT NULL,
  `hd_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`hd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_connectors`
--

DROP TABLE IF EXISTS `nshis_connectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_connectors` (
  `connector_id` int(11) NOT NULL AUTO_INCREMENT,
  `cubicle_id` int(11) DEFAULT '0',
  `name` varchar(45) NOT NULL,
  `other_name` varchar(150) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT 'none',
  `cubicle_name` varchar(45) DEFAULT 'none',
  `flag_assigned` tinyint(4) DEFAULT '0',
  `date_purchased` varchar(15) DEFAULT NULL,
  `notes` text,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`connector_id`)
) ENGINE=MyISAM AUTO_INCREMENT=253 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_user_lvl`
--

DROP TABLE IF EXISTS `nshis_user_lvl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_user_lvl` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL DEFAULT '1',
  `permission` varchar(250) NOT NULL DEFAULT 'transfer,add,delete,edit',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_monitors`
--

DROP TABLE IF EXISTS `nshis_monitors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_monitors` (
  `monitor_id` int(11) NOT NULL AUTO_INCREMENT,
  `cubicle_id` int(11) DEFAULT '0',
  `name` varchar(45) NOT NULL,
  `other_name` varchar(150) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT 'none',
  `cubicle_name` varchar(45) DEFAULT 'none',
  `flag_assigned` tinyint(4) DEFAULT '0',
  `date_purchased` varchar(15) DEFAULT NULL,
  `notes` text,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`monitor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=366 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_keyboards`
--

DROP TABLE IF EXISTS `nshis_keyboards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_keyboards` (
  `keyboard_id` int(11) NOT NULL AUTO_INCREMENT,
  `cubicle_id` int(11) DEFAULT '0',
  `name` varchar(45) NOT NULL,
  `other_name` varchar(150) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT 'none',
  `cubicle_name` varchar(45) DEFAULT 'none',
  `flag_assigned` tinyint(4) DEFAULT '0',
  `date_purchased` varchar(15) DEFAULT NULL,
  `notes` text,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`keyboard_id`)
) ENGINE=MyISAM AUTO_INCREMENT=385 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nshis_mouses`
--

DROP TABLE IF EXISTS `nshis_mouses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nshis_mouses` (
  `mouse_id` int(11) NOT NULL AUTO_INCREMENT,
  `cubicle_id` int(11) DEFAULT '0',
  `name` varchar(45) NOT NULL,
  `other_name` varchar(150) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT 'none',
  `cubicle_name` varchar(45) DEFAULT 'none',
  `flag_assigned` tinyint(4) DEFAULT '0',
  `date_purchased` varchar(15) DEFAULT NULL,
  `notes` text,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`mouse_id`)
) ENGINE=MyISAM AUTO_INCREMENT=430 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-07-01 19:14:04
