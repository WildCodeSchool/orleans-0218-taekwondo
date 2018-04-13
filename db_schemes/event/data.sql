-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: wcs_taekwondo
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.17.10.1

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
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_event` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,1607606136,'Stage GM Lee Kwan Young','Nous aurons une nouvelle fois l\'honneur d\'accueillir à Olivet Maître LEE Kwan-Young, pionnier du Taekwondo en France, ainsi que Maître Michel CARRON.\n\nRéservez donc dès à présent votre Samedi 14 avril, de 14h30 à 17h30 ! Renseignements et inscriptions auprès d\'Alix Chaselas.','assets/images/event/TW1.jpg'),(2,1605014136,'Stage GM Lee Kwan mi Young','Nous aurons une nouvelle fois l\'honneur d\'accueillir à Olivet Maître LEE Kwan-Young, pionnier du Taekwondo en France, ainsi que Maître Michel CARRON.\n\nRéservez donc dès à présent votre Samedi 14 avril, de 14h30 à 17h30 ! Renseignements et inscriptions auprès d\'Alix Chaselas.','assets/images/event/TW2.jpg'),(3,1604914136,'Stage GM Lee Kwan Young','Nous aurons une nouvelle fois l\'honneur d\'accueillir à Olivet Maître LEE Kwan-Young, pionnier du Taekwondo en France, ainsi que Maître Michel CARRON.\n\nRéservez donc dès à présent votre Samedi 14 avril, de 14h30 à 17h30 ! Renseignements et inscriptions auprès d\'Alix Chaselas.','assets/images/event/TW1.jpg'),(4,1604814136,'Stage GM Lee Kwan semi Old','Nous aurons une nouvelle fois l\'honneur d\'accueillir à Olivet Maître LEE Kwan-Young, pionnier du Taekwondo en France, ainsi que Maître Michel CARRON.\n\nRéservez donc dès à présent votre Samedi 14 avril, de 14h30 à 17h30 ! Renseignements et inscriptions auprès d\'Alix Chaselas.','assets/images/event/TW2.jpg'),(5,1604714136,'Stage GM Lee Kwan mi Old','Nous aurons une nouvelle fois l\'honneur d\'accueillir à Olivet Maître LEE Kwan-Young, pionnier du Taekwondo en France, ainsi que Maître Michel CARRON.\n\nRéservez donc dès à présent votre Samedi 14 avril, de 14h30 à 17h30 ! Renseignements et inscriptions auprès d\'Alix Chaselas.','assets/images/event/TW1.jpg'),(6,1604614136,'Stage GM Lee Kwan Old','Nous aurons une nouvelle fois l\'honneur d\'accueillir à Olivet Maître LEE Kwan-Young, pionnier du Taekwondo en France, ainsi que Maître Michel CARRON.\n\nRéservez donc dès à présent votre Samedi 14 avril, de 14h30 à 17h30 ! Renseignements et inscriptions auprès d\'Alix Chaselas.','assets/images/event/TW2.jpg'),(7,614136,'Stage GM Lee Kwan Old','Nous aurons une nouvelle fois l\'honneur d\'accueillir à Olivet Maître LEE Kwan-Young, pionnier du Taekwondo en France, ainsi que Maître Michel CARRON.\n\nRéservez donc dès à présent votre Samedi 14 avril, de 14h30 à 17h30 ! Renseignements et inscriptions auprès d\'Alix Chaselas.','assets/images/event/TW1.jpg'),(8,14136,'Stage GM Lee Kwan Old','Nous aurons une nouvelle fois l\'honneur d\'accueillir à Olivet Maître LEE Kwan-Young, pionnier du Taekwondo en France, ainsi que Maître Michel CARRON.\n\nRéservez donc dès à présent votre Samedi 14 avril, de 14h30 à 17h30 ! Renseignements et inscriptions auprès d\'Alix Chaselas.','assets/images/event/TW2.jpg');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-12 17:42:17
