-- MySQL dump 10.13  Distrib 8.0.28, for macos11 (x86_64)
--
-- Host: 127.0.0.1    Database: php_pro
-- ------------------------------------------------------
-- Server version	8.0.31

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
-- Table structure for table `catalog_city`
--

DROP TABLE IF EXISTS `catalog_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catalog_city` (
  `id` int NOT NULL,
  `new_post_city_id` varchar(255) DEFAULT NULL,
  `justin_city_id` int DEFAULT NULL,
  `name_uk` varchar(255) NOT NULL,
  `name_ru` varchar(255) NOT NULL,
  `region_name_uk` varchar(255) DEFAULT NULL,
  `area_name_uk` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `region_name_ru` varchar(255) DEFAULT NULL,
  `area_name_ru` varchar(255) DEFAULT NULL,
  `ukr_poshta_city_id` int DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalog_city`
--

LOCK TABLES `catalog_city` WRITE;
/*!40000 ALTER TABLE `catalog_city` DISABLE KEYS */;
INSERT INTO `catalog_city` VALUES (3235,'db5c88ce-391c-11dd-90d9-001a92567626',73,'Біла Церква','Белая Церковь','Білоцерківський','Київська','2019-05-15 20:21:06','2022-11-20 04:10:57','Белоцерковский','Киевская',5791,'bila-tserkva'),(12278,'d63931c7-dae7-11e9-b48a-005056b24375',NULL,'Жоравка','Жоравка','Яготинський','Київська','2019-07-31 23:45:38','2022-11-20 04:10:45','Яготинский','Киевская',5869,'zhoravka'),(12306,'f78c2e69-8836-11e9-898c-005056b24375',NULL,'Супоївка','Супоивка','Яготинський','Київська','2019-07-31 23:45:39','2022-11-20 04:10:48','Яготинский','Киевская',5880,'supoivka'),(3816,'5b0cc18d-a8ee-11e3-9fa0-0050568002cf',182,'Крюківщина','Крюковщина','Києво-Святошинський','Київська','2019-05-15 20:22:17','2022-11-20 04:10:48','Киево-Святошинский','Киевская',5565,'kryukivshchina'),(11590,NULL,NULL,'Липівка','Липовка','Макарівський','Київська','2019-07-31 23:44:38','2019-08-14 14:05:13','Макаровский','Киевская',5597,'lipivka'),(11662,'a35fceb7-4d37-11ec-80fb-b8830365bd04',NULL,'Македони','Македоны','Миронівський','Київська','2019-07-31 23:44:42','2022-03-06 04:13:15','Мироновский','Киевская',5629,'makedoni'),(11233,'6640f033-9e35-11e9-898c-005056b24375',NULL,'Литвинівка','Литвиновка','Вишгородський','Київська','2019-07-31 23:44:04','2022-11-20 04:10:49','Вышгородский','Киевская',5456,'litvinivka'),(3714,'5905bca1-ff8c-11e8-ad0d-005056b24375',NULL,'Ківшовата','Кившувата','Таращанський','Київська','2019-05-15 20:22:05','2022-11-20 04:10:53','Таращанский','Киевская',5798,'kivshovata'),(10708,'ae9c3496-07dd-11eb-80fb-b8830365bd04',NULL,'Кропивня','Кропивня','Іванківський','Київська','2019-07-31 23:43:17','2022-03-06 04:13:17','Иванковский','Киевская',5208,'kropivnya'),(3505,NULL,NULL,'Гурівщина','Гуровщина','Києво-Святошинський','Київська','2019-05-15 20:21:40','2019-08-14 14:06:57','Киево-Святошинский','Киевская',5561,'gurivshchina'),(3869,NULL,NULL,'Лукаші','Лукаши','Баришівський','Київська','2019-05-15 20:22:27','2022-02-13 04:10:46','Барышевский','Киевская',5285,'lukashi'),(18149,'7d9cee21-de44-11ea-80fb-b8830365bd04',NULL,'Сезенків','Сезенков','Баришівський','Київська','2019-07-31 23:53:54','2022-11-20 04:10:44','Барышевский','Киевская',15173,'sezenkiv'),(4172,'a9cb64c7-c347-11e9-b0c5-005056b24375',206,'Погреби','Погреби','Тетіївський','Київська','2019-05-15 20:23:03','2022-11-20 04:10:52','Тетиевский','Киевская',29165,'pogrebi'),(3593,'65a62535-ffe7-11e5-899e-005056887b8d',NULL,'Забір’я','Заборье','Києво-Святошинський','Київська','2019-05-15 20:21:52','2022-11-20 04:10:49','Киево-Святошинский','Киевская',5563,'zabirya'),(11463,NULL,NULL,'Слобода','Слобода','Кагарлицький','Київська','2019-07-31 23:44:22','2019-08-14 14:06:15','Кагарлыцкий','Киевская',5541,'sloboda'),(11325,NULL,NULL,'Ясногородка','Ясногородка','Макарівський','Київська','2019-07-31 23:44:14','2019-08-13 17:24:30','Макаровский','Киевская',5619,'yasnogorodka'),(11456,'cf75f5cb-4638-11ed-a361-48df37b92096',NULL,'Півці','Пивцы','Кагарлицький','Київська','2019-07-31 23:44:22','2022-11-20 04:10:49','Кагарлыцкий','Киевская',5536,'pivtsi'),(10772,'daabecee-96ce-11ea-a970-b8830365ade4',NULL,'Матюші','Матюши','Білоцерківський','Київська','2019-07-31 23:43:23','2022-11-20 04:10:49','Белоцерковский','Киевская',5247,'matyushi'),(3477,'d1389571-a9e7-11e8-ad0d-005056b24375',NULL,'Гореничі','Гореничи','Києво-Святошинський','Київська','2019-05-15 20:21:38','2022-11-20 04:10:49','Киево-Святошинский','Киевская',5559,'gorenichi');
/*!40000 ALTER TABLE `catalog_city` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-11-22  9:54:45
