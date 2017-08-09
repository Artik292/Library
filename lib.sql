-- MySQL dump 10.16  Distrib 10.2.7-MariaDB, for osx10.13 (x86_64)
--
-- Host: localhost    Database: library
-- ------------------------------------------------------
-- Server version	10.2.7-MariaDB

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
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `year_published` date DEFAULT NULL,
  `total_quantity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (1,'Moby Dick','Himenguey','2015-11-10',3),(2,'name','author',NULL,1),(3,'name','author','2017-07-03',0),(4,'Superhero coloring book','Mr T','2017-08-09',3);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checkout`
--

DROP TABLE IF EXISTS `checkout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_checked_out` datetime DEFAULT NULL,
  `date_return` datetime DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `librarian_id` int(11) DEFAULT NULL,
  `returned` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_borrow_students_idx` (`student_id`),
  KEY `fk_borrow_books1_idx` (`book_id`),
  CONSTRAINT `fk_borrow_books1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_borrow_students` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkout`
--

LOCK TABLES `checkout` WRITE;
/*!40000 ALTER TABLE `checkout` DISABLE KEYS */;
INSERT INTO `checkout` VALUES (1,'2017-07-11 00:00:00','2017-08-31 00:00:00',26,1,1,0),(2,'2017-07-11 00:00:00','2017-05-09 00:00:00',24,1,1,0),(3,NULL,'2017-09-09 00:00:00',26,4,1,1),(4,'2017-08-09 00:00:00','2017-09-09 00:00:00',2,4,1,1),(5,'2017-08-09 00:00:00','2017-09-09 00:00:00',1,1,2,1),(6,'2017-08-09 00:00:00','2017-09-09 00:00:00',1,1,2,1),(7,'2017-08-09 00:00:00','2017-09-09 00:00:00',1,1,2,1),(8,'2017-08-09 00:00:00','2017-09-09 00:00:00',1,1,2,0);
/*!40000 ALTER TABLE `checkout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `librarian`
--

DROP TABLE IF EXISTS `librarian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `librarian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `librarian`
--

LOCK TABLES `librarian` WRITE;
/*!40000 ALTER TABLE `librarian` DISABLE KEYS */;
INSERT INTO `librarian` VALUES (1,'john','smith','123'),(2,'boo',NULL,'boo');
/*!40000 ALTER TABLE `librarian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `grade` varchar(5) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `contact` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'в','в','в','d',NULL),(2,'ю','ю','ю','.',NULL),(3,'ж','ж','ж',';',NULL),(4,'l','ll','l','l',NULL),(5,'a','a','a','a',NULL),(6,'d','d','d','d',NULL),(7,'ko','ko','kok','ko',NULL),(8,'d','','','d',NULL),(9,'p','p','p','p',NULL),(10,'admin','','','admin',NULL),(11,'admin','','','l',NULL),(12,'admin','','','j',NULL),(13,'admin','','','d',NULL),(14,'admin','','','d',NULL),(15,'admin','','','Lolol',NULL),(16,'admin','','','admin',NULL),(17,'name','','','password',NULL),(18,'admin','','','admin',NULL),(19,'admin','','','a',NULL),(20,'admin','','','kl',NULL),(21,'awdaw','','','awdaw',NULL),(22,'lol','','','lol',NULL),(23,'admin','','','admin',NULL),(24,'a','b','c','e','+OEUOEU'),(25,'Д','Д','Д','l',NULL),(26,'Arthur','Konevnikov','11-b1','Password','blah blah blah blah.'),(27,'admin','','','admin',NULL),(28,'admin','','','admin',NULL),(29,'librarian','','','lol',NULL),(30,'admin','','','l',NULL),(31,'librarian','','','m',NULL),(32,'d','','','d',NULL),(33,'test','test','test','test',NULL);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-09 15:14:13
