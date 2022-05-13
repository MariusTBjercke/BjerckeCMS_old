-- MySQL dump 10.13  Distrib 8.0.28, for Linux (x86_64)
--
-- Host: localhost    Database: bjerckecms
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `language_strings`
--

DROP TABLE IF EXISTS `language_strings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `language_strings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `no` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `en` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language_strings`
--

LOCK TABLES `language_strings` WRITE;
/*!40000 ALTER TABLE `language_strings` DISABLE KEYS */;
INSERT INTO `language_strings` VALUES (1,'not_signed_in','Du er ikke logget inn.','You are not signed in.'),(2,'login','Logg inn','Login'),(3,'register','Registrer deg','Register'),(4,'username','Brukernavn','Username'),(5,'password','Passord','Password'),(6,'welcome_to_forum','Velkommen til forumet.','Welcome to the forum.'),(7,'discuss_with_others','Her kan du diskutere forskjellige temaer med andre medlemmer.','Here you can discuss various topics with other users.'),(8,'latest_posts','Siste innlegg','Latest posts'),(9,'no_posts','Ingen innlegg enda.','No posts yet.'),(10,'forum','Forum','Forum'),(11,'new_post','Nytt innlegg','New post'),(12,'submit','Send','Submit'),(13,'close','Lukk','Close'),(14,'title','Tittel','Title'),(15,'type_something','Skriv noe','Type something'),(16,'logout','Logg ut','Logout'),(17,'home','Hjem','Home'),(18,'login','Logg inn','Login'),(19,'register','Registrer','Register'),(20,'forum','Forum','Forum'),(21,'profile','Profil','Profile'),(22,'admin','Admin','Admin'),(23,'pagebuilder','Sidebygger','Page Builder'),(24,NULL,'Velkommen til Bjercke CMS.','Welcome to Bjercke CMS.'),(25,NULL,'Logg inn på din brukerkonto.','Log in to your user account.'),(26,NULL,'Registrer deg for å få tilgang til vårt innhold.','Register to access our content.'),(27,NULL,'Kommuniser med andre medlemmer via forumet.','Communicate with other members in our forum.'),(28,NULL,'Administrasjonsside.','Administration page.'),(29,NULL,'Modifiser undersidene på nettsiden med sidebyggeren.','Modify the site pages with the page builder.'),(30,NULL,'Profilside.','User profile page.'),(31,'use_background_image','Bruk bakgrunnsbilde?','Use a background image?'),(32,'new_article','Ny artikkel','New article'),(33,'administer_articles','Endre artikler','Edit articles'),(34,'administer_tiles','Endre brikker','Edit tiles'),(35,'add_tile','Legg til ny brikke','Add new tile'),(36,'template_path','Mal sti','Template path'),(37,'choose','Velg','Choose'),(38,'administration','Administrasjon','Administration'),(39,'class_name','Klasse navn','Class name'),(40,NULL,'Eksempel: ArticleDisplay (i namespace Bjercke\\Tile)','Example: ArticleDisplay (in namespace Bjercke\\Tile)'),(41,'save','Lagre','Save'),(42,NULL,'Eksempel: Tiles/Articles/Display/articledisplay.html.twig','Example: Tiles/Articles/Display/articledisplay.html.twig'),(43,'existing_tiles','Eksisterende brikker','Existing tiles'),(44,'class','Klasse','Class'),(45,'edit_articles','Endre artikler','Edit articles'),(46,'edit_article','Endre artikkel','Edit article'),(47,'go_back','Gå tilbake','Go back');
/*!40000 ALTER TABLE `language_strings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-13 16:02:12
