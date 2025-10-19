-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: fitlife
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `biographies`
--

DROP TABLE IF EXISTS `biographies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `biographies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `biographies_user_id_foreign` (`user_id`),
  CONSTRAINT `biographies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `biographies`
--

LOCK TABLES `biographies` WRITE;
/*!40000 ALTER TABLE `biographies` DISABLE KEYS */;
INSERT INTO `biographies` VALUES (1,1,'Vlad',18,176.00,63.00,'male','2025-09-09 18:06:43','2025-10-15 03:44:46'),(2,3,'Alex',20,185.00,89.00,'male','2025-09-19 02:56:58','2025-09-25 07:58:12');
/*!40000 ALTER TABLE `biographies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-admin@admin.com|127.0.0.1','i:2;',1760422422),('laravel-cache-admin@admin.com|127.0.0.1:timer','i:1760422422;',1760422422),('laravel-cache-comment_105_dislike_count','i:0;',1760596694),('laravel-cache-comment_105_like_count','i:1;',1760596694),('laravel-cache-comment_106_dislike_count','i:1;',1760596097),('laravel-cache-comment_106_like_count','i:0;',1760596097),('laravel-cache-comment_107_dislike_count','i:0;',1760596096),('laravel-cache-comment_107_like_count','i:1;',1760596096),('laravel-cache-comment_11_dislike_count','i:0;',1760690055),('laravel-cache-comment_11_like_count','i:1;',1760690055),('laravel-cache-comment_113_dislike_count','i:0;',1760690015),('laravel-cache-comment_113_like_count','i:1;',1760690015),('laravel-cache-post_35_views','i:6;',1760596265),('laravel-cache-post_4_views','i:19;',1760595841),('laravel-cache-post_47_views','i:1;',1760597048),('laravel-cache-post_48_views','i:0;',1760596167),('laravel-cache-post_9_views','i:18;',1760595841),('laravel-cache-post_view_47_1','b:1;',1760596105),('laravel-cache-posts_page_2','O:42:\"Illuminate\\Pagination\\LengthAwarePaginator\":12:{s:8:\"\0*\0items\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:10:\"\0*\0perPage\";i:10;s:14:\"\0*\0currentPage\";i:2;s:7:\"\0*\0path\";s:27:\"http://127.0.0.1:8000/posts\";s:8:\"\0*\0query\";a:0:{}s:11:\"\0*\0fragment\";N;s:11:\"\0*\0pageName\";s:4:\"page\";s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:10:\"onEachSide\";i:3;s:10:\"\0*\0options\";a:2:{s:4:\"path\";s:27:\"http://127.0.0.1:8000/posts\";s:8:\"pageName\";s:4:\"page\";}s:8:\"\0*\0total\";i:4;s:11:\"\0*\0lastPage\";i:1;}',1760615223);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendars`
--

DROP TABLE IF EXISTS `calendars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calendars` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `type` enum('workout','rest','goal','running','gym','yoga','cardio','stretching','cycling','swimming','weightlifting','pilates','hiking','boxing','dance','crossfit','walking','meditation','tennis','basketball','soccer','climbing','rowing','martial_arts','recovery') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `calendars_user_id_foreign` (`user_id`),
  CONSTRAINT `calendars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendars`
--

LOCK TABLES `calendars` WRITE;
/*!40000 ALTER TABLE `calendars` DISABLE KEYS */;
INSERT INTO `calendars` VALUES (3,1,'2025-10-09','rest','Chil😎',1,'2025-10-08 08:51:02','2025-10-14 02:54:58'),(7,1,'2025-10-11','gym',NULL,1,'2025-10-08 09:06:26','2025-10-14 02:51:57'),(9,1,'2025-10-13','yoga','peace and tranquility😉',0,'2025-10-09 02:59:08','2025-10-09 02:59:08'),(13,1,'2025-10-14','walking',NULL,0,'2025-10-13 07:31:27','2025-10-13 07:31:27'),(14,1,'2025-10-15','rest','Chil😎',0,'2025-10-13 07:31:49','2025-10-13 07:31:49'),(15,1,'2025-10-16','walking','❤️',0,'2025-10-14 03:00:33','2025-10-14 03:00:33'),(16,1,'2025-10-17','running',NULL,0,'2025-10-15 06:10:16','2025-10-15 06:10:16');
/*!40000 ALTER TABLE `calendars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment_likes`
--

DROP TABLE IF EXISTS `comment_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment_likes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `type` enum('like','dislike') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `comment_likes_comment_id_user_id_unique` (`comment_id`,`user_id`),
  KEY `comment_likes_user_id_foreign` (`user_id`),
  CONSTRAINT `comment_likes_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comment_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment_likes`
--

LOCK TABLES `comment_likes` WRITE;
/*!40000 ALTER TABLE `comment_likes` DISABLE KEYS */;
INSERT INTO `comment_likes` VALUES (18,9,1,'like','2025-10-01 08:33:01','2025-10-01 08:33:01'),(43,11,1,'like','2025-10-17 05:33:15','2025-10-17 05:33:15');
/*!40000 ALTER TABLE `comment_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_post_id_foreign` (`post_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_parent_id_foreign` (`parent_id`),
  CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (9,4,1,NULL,'I will definitely be there','2025-09-19 03:01:09','2025-09-19 03:01:09'),(11,4,3,9,'❤️','2025-09-19 03:18:13','2025-09-19 03:18:13');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foods`
--

DROP TABLE IF EXISTS `foods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `foods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `calories` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `foods_user_id_foreign` (`user_id`),
  CONSTRAINT `foods_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foods`
--

LOCK TABLES `foods` WRITE;
/*!40000 ALTER TABLE `foods` DISABLE KEYS */;
/*!40000 ALTER TABLE `foods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friends` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `friend_id` bigint unsigned NOT NULL,
  `status` enum('pending','accepted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `friends_user_id_friend_id_unique` (`user_id`,`friend_id`),
  KEY `friends_friend_id_foreign` (`friend_id`),
  CONSTRAINT `friends_friend_id_foreign` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `friends_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` VALUES (14,1,5,'accepted','2025-10-02 05:19:17','2025-10-02 05:19:20'),(15,5,1,'accepted','2025-10-02 05:19:20','2025-10-02 05:19:20'),(19,3,1,'accepted','2025-10-02 05:27:19','2025-10-02 05:27:21'),(20,1,3,'accepted','2025-10-02 05:27:21','2025-10-02 05:27:21');
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friendships`
--

DROP TABLE IF EXISTS `friendships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friendships` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `friend_id` bigint unsigned NOT NULL,
  `status` enum('pending','accepted','blocked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `friendships_user_id_friend_id_unique` (`user_id`,`friend_id`),
  KEY `friendships_friend_id_foreign` (`friend_id`),
  CONSTRAINT `friendships_friend_id_foreign` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `friendships_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendships`
--

LOCK TABLES `friendships` WRITE;
/*!40000 ALTER TABLE `friendships` DISABLE KEYS */;
/*!40000 ALTER TABLE `friendships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goal_logs`
--

DROP TABLE IF EXISTS `goal_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goal_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `goal_id` bigint unsigned NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `goal_logs_goal_id_foreign` (`goal_id`),
  CONSTRAINT `goal_logs_goal_id_foreign` FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goal_logs`
--

LOCK TABLES `goal_logs` WRITE;
/*!40000 ALTER TABLE `goal_logs` DISABLE KEYS */;
INSERT INTO `goal_logs` VALUES (1,1,10000.00,'2025-09-09','2025-09-09 18:44:47','2025-09-09 18:44:47'),(2,2,3245.00,'2025-09-19','2025-09-19 02:50:10','2025-09-19 02:50:10'),(3,3,5.00,'2025-09-24','2025-09-24 07:52:44','2025-09-24 07:52:44'),(4,3,1.20,'2025-09-24','2025-09-24 07:52:58','2025-09-24 07:52:58'),(5,5,5000.00,'2025-09-25','2025-09-25 15:30:16','2025-09-25 15:30:16'),(6,2,5000.00,'2025-10-03','2025-10-03 04:17:31','2025-10-03 04:17:31'),(7,6,2.00,'2025-10-03','2025-10-03 04:17:39','2025-10-03 04:17:39'),(8,8,1.00,'2025-10-15','2025-10-15 06:27:47','2025-10-15 06:27:47'),(9,8,12499.00,'2025-10-15','2025-10-15 06:27:55','2025-10-15 06:27:55');
/*!40000 ALTER TABLE `goal_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goals`
--

DROP TABLE IF EXISTS `goals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_value` decimal(10,2) NOT NULL,
  `current_value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `goals_user_id_foreign` (`user_id`),
  CONSTRAINT `goals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goals`
--

LOCK TABLES `goals` WRITE;
/*!40000 ALTER TABLE `goals` DISABLE KEYS */;
INSERT INTO `goals` VALUES (1,1,'steps',10000.00,10000.00,'2025-09-11','2025-09-09 18:41:49','2025-09-09 18:44:47'),(2,1,'calories',25000.00,8245.00,'2025-09-21','2025-09-19 02:50:02','2025-10-03 04:17:31'),(3,1,'sleep',9.00,6.20,'2025-09-25','2025-09-24 07:51:36','2025-09-24 07:52:58'),(4,2,'steps',50000.00,0.00,'2025-09-30','2025-09-25 02:55:34','2025-09-25 02:55:34'),(5,1,'steps',20000.00,5000.00,'2025-09-30','2025-09-25 15:29:55','2025-09-25 15:30:16'),(6,1,'sleep',9.00,2.00,'2025-10-04','2025-10-03 04:00:08','2025-10-03 04:17:39'),(7,1,'weight',67.00,0.00,'2025-10-30','2025-10-03 04:18:36','2025-10-03 04:18:36'),(8,1,'calories',23546.00,12500.00,'2025-11-08','2025-10-03 04:18:47','2025-10-15 06:27:55');
/*!40000 ALTER TABLE `goals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `type` enum('like','dislike') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `likes_user_id_foreign` (`user_id`),
  CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (7,4,3,'like','2025-09-19 02:58:42','2025-09-19 02:58:42'),(10,4,2,'like','2025-09-19 02:59:08','2025-09-19 02:59:08'),(16,9,2,'like','2025-09-23 09:03:13','2025-09-24 04:17:23'),(18,4,1,'like','2025-09-24 04:55:47','2025-10-03 02:20:03'),(26,9,1,'like','2025-09-25 02:53:48','2025-09-30 08:06:03'),(27,9,3,'like','2025-09-25 08:10:33','2025-09-25 08:10:33'),(31,11,1,'like','2025-09-25 08:36:18','2025-09-29 08:02:01'),(36,21,1,'like','2025-10-01 07:13:00','2025-10-01 07:13:00'),(37,25,1,'like','2025-10-01 07:13:59','2025-10-01 07:13:59'),(39,4,5,'like','2025-10-01 09:12:07','2025-10-01 09:12:07'),(40,9,5,'like','2025-10-01 09:12:07','2025-10-01 09:12:07'),(41,11,5,'like','2025-10-01 09:12:08','2025-10-01 09:12:08'),(42,19,5,'like','2025-10-01 09:12:10','2025-10-01 09:12:10'),(43,26,1,'like','2025-10-02 04:13:40','2025-10-06 06:54:55'),(44,28,1,'like','2025-10-03 03:39:17','2025-10-03 03:39:19'),(45,29,1,'like','2025-10-03 03:50:42','2025-10-03 03:50:42'),(46,30,1,'like','2025-10-03 03:50:42','2025-10-03 03:50:42'),(47,31,1,'like','2025-10-06 08:37:05','2025-10-06 08:37:34'),(49,33,1,'like','2025-10-06 09:02:59','2025-10-06 09:02:59'),(55,32,1,'like','2025-10-07 03:44:43','2025-10-07 08:02:24'),(57,19,1,'like','2025-10-08 03:34:47','2025-10-08 03:34:47'),(58,35,1,'like','2025-10-08 03:50:43','2025-10-17 05:31:42'),(68,42,1,'like','2025-10-10 04:33:33','2025-10-10 04:33:34'),(69,45,1,'like','2025-10-13 04:49:11','2025-10-13 06:35:45'),(71,4,7,'like','2025-10-15 05:16:38','2025-10-15 05:16:38'),(72,9,7,'like','2025-10-15 05:16:39','2025-10-15 05:16:39'),(73,35,7,'like','2025-10-15 05:16:41','2025-10-15 05:16:41'),(74,47,1,'like','2025-10-16 03:27:20','2025-10-16 03:27:20');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meal_logs`
--

DROP TABLE IF EXISTS `meal_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meal_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `meal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `food` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `calories` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meal_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `meal_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meal_logs`
--

LOCK TABLES `meal_logs` WRITE;
/*!40000 ALTER TABLE `meal_logs` DISABLE KEYS */;
INSERT INTO `meal_logs` VALUES (3,1,'Breakfast','Cucumber',100,16,'2025-09-09 12:16:37','2025-09-09 12:16:37'),(4,1,'Breakfast','Beef',300,750,'2025-09-09 12:16:37','2025-09-09 12:16:37'),(5,1,'Breakfast','Butter',200,1434,'2025-09-09 12:16:37','2025-09-09 12:16:37'),(6,1,'Lunch','Yogurt',250,148,'2025-09-09 12:16:37','2025-09-09 12:16:37'),(7,1,'Lunch','Tuna',400,528,'2025-09-09 12:16:37','2025-09-09 12:16:37'),(8,1,'Lunch','Egg',350,543,'2025-09-09 12:16:37','2025-09-09 12:16:37'),(9,1,'Dinner','Cheese',200,804,'2025-09-09 12:16:37','2025-09-09 12:16:37'),(10,1,'Dinner','Egg',350,543,'2025-09-09 12:16:37','2025-09-09 12:16:37'),(11,1,'Dinner','Banana',300,267,'2025-09-09 12:16:37','2025-09-09 12:16:37'),(12,1,'Snack','Orange',600,282,'2025-09-09 12:16:37','2025-09-09 12:16:37'),(13,1,'Snack','Oatmeal',300,204,'2025-09-09 12:16:37','2025-09-09 12:16:37'),(14,1,'Snack','Burger',460,1357,'2025-09-09 12:16:37','2025-09-09 12:16:37'),(15,1,'Breakfast','Pork',532,1287,'2025-09-18 03:31:40','2025-09-18 03:31:40'),(16,1,'Breakfast','Tomato',432,78,'2025-09-18 03:31:40','2025-09-18 03:31:40'),(17,1,'Breakfast','Bread',400,1060,'2025-09-18 03:31:40','2025-09-18 03:31:40'),(18,1,'Lunch','Egg',400,620,'2025-09-18 03:31:40','2025-09-18 03:31:40'),(19,1,'Lunch','Butter',435,3119,'2025-09-18 03:31:40','2025-09-18 03:31:40'),(20,1,'Lunch','Cucumber',435,70,'2025-09-18 03:31:40','2025-09-18 03:31:40'),(21,1,'Dinner','Orange',500,235,'2025-09-18 03:31:40','2025-09-18 03:31:40'),(22,1,'Dinner','Cheese',435,1749,'2025-09-18 03:31:40','2025-09-18 03:31:40'),(23,1,'Dinner','Beef',1000,2500,'2025-09-18 03:31:40','2025-09-18 03:31:40'),(24,1,'Snack','Rice',789,1026,'2025-09-18 03:31:40','2025-09-18 03:31:40'),(25,1,'Snack','Carrot',165,68,'2025-09-18 03:31:40','2025-09-18 03:31:40'),(26,1,'Snack','Fries',654,2040,'2025-09-18 03:31:40','2025-09-18 03:31:40'),(27,1,'Breakfast','Salmon',324,674,'2025-09-19 02:51:51','2025-09-19 02:51:51'),(28,1,'Lunch','Egg',352,546,'2025-09-19 02:51:51','2025-09-19 02:51:51'),(29,1,'Breakfast','Salmon',345,718,'2025-09-22 08:42:13','2025-09-22 08:42:13'),(30,1,'Breakfast','Salmon',345,718,'2025-09-22 08:42:23','2025-09-22 08:42:23'),(31,1,'Lunch','Beef',324,810,'2025-09-22 08:42:23','2025-09-22 08:42:23'),(32,1,'Breakfast','Salmon',345,718,'2025-09-22 08:42:27','2025-09-22 08:42:27'),(33,1,'Lunch','Beef',324,810,'2025-09-22 08:42:27','2025-09-22 08:42:27'),(34,1,'Breakfast','Salmon',345,718,'2025-09-22 08:42:51','2025-09-22 08:42:51'),(35,1,'Lunch','Beef',324,810,'2025-09-22 08:42:51','2025-09-22 08:42:51'),(36,1,'Dinner','Cheese',540,2171,'2025-09-22 08:42:51','2025-09-22 08:42:51'),(37,1,'Snack','Oatmeal',400,272,'2025-09-22 08:42:51','2025-09-22 08:42:51'),(38,1,'Breakfast','Salmon',345,718,'2025-09-22 08:42:52','2025-09-22 08:42:52'),(39,1,'Lunch','Beef',324,810,'2025-09-22 08:42:52','2025-09-22 08:42:52'),(40,1,'Dinner','Cheese',540,2171,'2025-09-22 08:42:52','2025-09-22 08:42:52'),(41,1,'Snack','Oatmeal',400,272,'2025-09-22 08:42:52','2025-09-22 08:42:52'),(42,1,'Breakfast','Salmon',345,718,'2025-09-22 08:42:53','2025-09-22 08:42:53'),(43,1,'Lunch','Beef',324,810,'2025-09-22 08:42:53','2025-09-22 08:42:53'),(44,1,'Dinner','Cheese',540,2171,'2025-09-22 08:42:53','2025-09-22 08:42:53'),(45,1,'Snack','Oatmeal',400,272,'2025-09-22 08:42:53','2025-09-22 08:42:53'),(46,1,'Breakfast','Salmon',345,718,'2025-09-22 08:42:53','2025-09-22 08:42:53'),(47,1,'Lunch','Beef',324,810,'2025-09-22 08:42:53','2025-09-22 08:42:53'),(48,1,'Dinner','Cheese',540,2171,'2025-09-22 08:42:53','2025-09-22 08:42:53'),(49,1,'Snack','Oatmeal',400,272,'2025-09-22 08:42:53','2025-09-22 08:42:53'),(50,1,'Breakfast','Salmon',345,718,'2025-09-22 08:42:53','2025-09-22 08:42:53'),(51,1,'Lunch','Beef',324,810,'2025-09-22 08:42:53','2025-09-22 08:42:53'),(52,1,'Dinner','Cheese',540,2171,'2025-09-22 08:42:53','2025-09-22 08:42:53'),(53,1,'Snack','Oatmeal',400,272,'2025-09-22 08:42:53','2025-09-22 08:42:53'),(54,1,'Breakfast','Salmon',345,718,'2025-09-22 08:42:54','2025-09-22 08:42:54'),(55,1,'Lunch','Beef',324,810,'2025-09-22 08:42:54','2025-09-22 08:42:54'),(56,1,'Dinner','Cheese',540,2171,'2025-09-22 08:42:54','2025-09-22 08:42:54'),(57,1,'Snack','Oatmeal',400,272,'2025-09-22 08:42:54','2025-09-22 08:42:54'),(58,1,'Breakfast','Salmon',345,718,'2025-09-22 08:42:55','2025-09-22 08:42:55'),(59,1,'Lunch','Beef',324,810,'2025-09-22 08:42:55','2025-09-22 08:42:55'),(60,1,'Dinner','Cheese',540,2171,'2025-09-22 08:42:55','2025-09-22 08:42:55'),(61,1,'Snack','Oatmeal',400,272,'2025-09-22 08:42:55','2025-09-22 08:42:55'),(62,1,'Breakfast','Beef',5467,13668,'2025-09-22 08:43:17','2025-09-22 08:43:17'),(63,1,'Breakfast','Tuna',4567,6028,'2025-09-22 08:43:17','2025-09-22 08:43:17'),(64,1,'Breakfast','Beef',434,1085,'2025-09-23 02:57:01','2025-09-23 02:57:01'),(65,1,'Breakfast','Pork',546,1321,'2025-09-23 02:57:01','2025-09-23 02:57:01'),(66,1,'Breakfast','Beef',434,1085,'2025-09-23 02:57:38','2025-09-23 02:57:38'),(67,1,'Breakfast','Pork',546,1321,'2025-09-23 02:57:38','2025-09-23 02:57:38'),(68,1,'Breakfast','Chicken breast',234,386,'2025-09-23 03:09:05','2025-09-23 03:09:05'),(69,1,'Breakfast','Cheese',402,1616,'2025-09-23 03:09:05','2025-09-23 03:09:05'),(70,1,'Breakfast','Chicken breast',234,386,'2025-09-23 03:09:09','2025-09-23 03:09:09'),(71,1,'Breakfast','Cheese',402,1616,'2025-09-23 03:09:09','2025-09-23 03:09:09'),(72,1,'Breakfast','Chicken breast',234,386,'2025-09-23 03:09:45','2025-09-23 03:09:45'),(73,1,'Breakfast','Cheese',402,1616,'2025-09-23 03:09:45','2025-09-23 03:09:45'),(74,1,'Breakfast','Egg',155,240,'2025-09-23 03:12:19','2025-09-23 03:12:19'),(75,1,'Breakfast','Butter',200,1434,'2025-09-23 03:12:19','2025-09-23 03:12:19'),(76,1,'Breakfast','Rice',455,592,'2025-09-23 03:18:45','2025-09-23 03:18:45'),(77,1,'Breakfast','Rice',100,130,'2025-09-23 03:20:40','2025-09-23 03:20:40'),(78,1,'Breakfast','Rice',190,247,'2025-09-24 05:18:59','2025-09-24 05:18:59'),(79,1,'Breakfast','Cucumber',400,64,'2025-09-24 05:18:59','2025-09-24 05:18:59'),(80,1,'Breakfast','Milk (whole)',455,278,'2025-09-24 05:25:09','2025-09-24 05:25:09'),(81,1,'Breakfast','Chicken breast',234,386,'2025-09-24 07:14:52','2025-09-24 07:14:52'),(82,1,'Breakfast','Chicken breast',243,401,'2025-09-24 07:15:17','2025-09-24 07:15:17'),(83,1,'Lunch','Salmon',234,487,'2025-09-24 07:15:17','2025-09-24 07:15:17'),(84,1,'Dinner','Egg',235,364,'2025-09-24 07:15:17','2025-09-24 07:15:17'),(85,1,'Snack','Egg',534,828,'2025-09-24 07:15:17','2025-09-24 07:15:17'),(86,1,'Breakfast','Beef',532,1330,'2025-09-24 07:17:15','2025-09-24 07:17:15'),(87,1,'Breakfast','Rice',600,780,'2025-09-25 15:25:49','2025-09-25 15:25:49'),(88,1,'Lunch','Egg',260,403,'2025-09-25 15:25:49','2025-09-25 15:25:49'),(89,1,'Breakfast','Rice',344,447,'2025-09-25 18:14:55','2025-09-25 18:14:55'),(90,1,'Lunch','Chicken breast',352,581,'2025-09-25 18:14:55','2025-09-25 18:14:55'),(91,1,'Breakfast','Rice',324,421,'2025-10-01 07:34:19','2025-10-01 07:34:19'),(92,1,'Breakfast','Rice',130,169,'2025-10-01 07:34:44','2025-10-01 07:34:44'),(93,1,'Breakfast','Chicken breast',5435,8968,'2025-10-03 03:57:52','2025-10-03 03:57:52'),(94,1,'Breakfast','Chicken breast',5435,8968,'2025-10-03 03:57:59','2025-10-03 03:57:59'),(95,1,'Breakfast','Chicken breast',432,713,'2025-10-03 03:58:06','2025-10-03 03:58:06'),(96,1,'Breakfast','Beef',423,1058,'2025-10-03 04:02:45','2025-10-03 04:02:45'),(97,1,'Breakfast','Burger',423,1248,'2025-10-03 04:12:52','2025-10-03 04:12:52'),(98,1,'Breakfast','Chicken breast',326,538,'2025-10-07 08:37:07','2025-10-07 08:37:07'),(99,1,'Breakfast','Salmon',124,258,'2025-10-07 08:37:26','2025-10-07 08:37:26'),(100,1,'Breakfast','Rice',434,564,'2025-10-08 04:01:54','2025-10-08 04:01:54'),(101,1,'Breakfast','Chocolate (dark)',1000,5460,'2025-10-08 04:02:07','2025-10-08 04:02:07');
/*!40000 ALTER TABLE `meal_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint unsigned NOT NULL,
  `receiver_id` bigint unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_sender_id_foreign` (`sender_id`),
  KEY `messages_receiver_id_foreign` (`receiver_id`),
  CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_09_03_121111_create_food_table',2),(5,'2025_09_04_063912_create_progress_photos_table',2),(6,'2025_09_04_071440_create_progress_table',2),(7,'2025_09_05_062028_create_meal_logs_table',2),(8,'2025_09_05_064819_create_sleeps_table',2),(9,'2025_09_05_070144_create_goals_table',2),(10,'2025_09_06_141807_create_water_logs_table',2),(11,'2025_09_06_150943_create_biographies_table',2),(12,'2025_09_09_214422_create_goal_logs_table',3),(13,'2025_09_11_054732_create_ai_plans_table',4),(14,'2025_09_18_101357_create_friendships_table',5),(15,'2025_09_18_101408_create_posts_table',5),(16,'2025_09_18_101425_create_messages_table',5),(17,'2025_09_18_110349_create_posts_table',6),(18,'2025_09_18_110353_create_comments_table',6),(19,'2025_09_18_110356_create_likes_table',6),(20,'2025_09_19_060453_add_avatar_to_users_table',7),(21,'2025_09_24_071518_add_views_column_to_posts_table',8),(22,'2025_09_24_113221_add_profile_photo_to_users_table',9),(23,'2025_09_25_080840_add_banner_to_users_table',10),(24,'2025_09_29_102455_create_comment_likes_table',11),(25,'2025_10_01_115721_add_username_to_users_table',12),(26,'2025_10_01_121414_create_friends_table',13),(27,'2025_10_03_090028_create_messages_table',14),(28,'2025_10_07_060324_create_post_views_table',15),(29,'2025_10_08_104506_create_calendars_table',16),(30,'2025_10_09_061227_add_role_to_users_table',17),(31,'2025_10_13_061104_create_notifications_table',18);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `related_id` bigint unsigned NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_views`
--

DROP TABLE IF EXISTS `post_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_views` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_views_post_id_user_id_unique` (`post_id`,`user_id`),
  CONSTRAINT `post_views_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_views`
--

LOCK TABLES `post_views` WRITE;
/*!40000 ALTER TABLE `post_views` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_views` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_foreign` (`user_id`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (4,3,'Who\'s going to the gym today? 😁',NULL,19,'2025-09-19 02:58:19','2025-10-13 04:23:01'),(9,2,'hi, how are u?',NULL,18,'2025-09-23 09:03:08','2025-10-13 04:23:01'),(35,1,'hi everyone','posts/post_68e6099d475d6.jpg',6,'2025-10-08 03:50:05','2025-10-13 04:28:35');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `progress`
--

DROP TABLE IF EXISTS `progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `progress` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `progress_user_id_foreign` (`user_id`),
  CONSTRAINT `progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `progress`
--

LOCK TABLES `progress` WRITE;
/*!40000 ALTER TABLE `progress` DISABLE KEYS */;
INSERT INTO `progress` VALUES (3,1,'progress/8HNb3RD1f50wrihALuQ1C4lJs8v2rzzQ7e6dPi8H.jpg','my body build at the moment )','2025-09-18 05:18:42','2025-09-24 07:47:43'),(4,1,'progress/qmodcpZ3J0JL6HkWxJZNXNA8fgIxVpoy3YHR1uUP.jpg','I\'m before my eighteenth birthday 😉','2025-09-25 15:29:22','2025-10-08 04:14:02'),(5,1,'progress/L1Jifw3r6pgnfMbSy40SqiiD85Vi591bgKSXxJCo.jpg','just chill🔥🔥','2025-10-01 07:52:52','2025-10-01 07:52:52');
/*!40000 ALTER TABLE `progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `progress_photos`
--

DROP TABLE IF EXISTS `progress_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `progress_photos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `progress_photos_user_id_foreign` (`user_id`),
  CONSTRAINT `progress_photos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `progress_photos`
--

LOCK TABLES `progress_photos` WRITE;
/*!40000 ALTER TABLE `progress_photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `progress_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('1ZlRGNG3sJu8Q8SswitDKw7m8hzcpCPYeWBZGZ3j',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 OPR/122.0.0.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNUJuYmRUVGlYZHFhd2o2U1B1bEhDdlo3M1Nhc3Q5R2ZQTU9pTXRCUCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1760683688),('97Egut1JhM666cScVEBkUPCWIesKJ7Sd9lOdd5kQ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 OPR/122.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoienJkQTdSUXpIQnVaQmxwaFJsMDBuOEJmNGxsWTFpcUJ0bjdUWElrVCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Bvc3RzIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1760810226),('nw4adHkAeSTC5g2pSNpQq0g6AwToG7ERI3LmMsok',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 OPR/122.0.0.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVWszbDdrRmdIMHlCdjRjeUhZWE10WTREaHJiYUxSVWU0ZXhhbEluViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcHJvZmlsZS8yIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1760690020);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sleeps`
--

DROP TABLE IF EXISTS `sleeps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sleeps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `duration` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sleeps_user_id_foreign` (`user_id`),
  CONSTRAINT `sleeps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sleeps`
--

LOCK TABLES `sleeps` WRITE;
/*!40000 ALTER TABLE `sleeps` DISABLE KEYS */;
INSERT INTO `sleeps` VALUES (1,1,'2025-09-09','01:50:00','07:40:00',5.8333333333333,'2025-09-09 18:08:28','2025-09-09 18:08:28'),(2,1,'2025-09-18','03:32:00','07:40:00',4.1333333333333,'2025-09-18 03:24:17','2025-09-18 03:24:17'),(3,1,'2025-09-18','10:00:00','07:46:00',21.766666666667,'2025-09-18 05:19:22','2025-09-18 05:19:22'),(4,1,'2025-09-19','02:36:00','07:50:00',5.2333333333333,'2025-09-19 03:19:27','2025-09-19 03:19:27'),(5,1,'2025-09-23','20:00:00','05:04:00',9.0666666666667,'2025-09-22 08:33:00','2025-09-22 08:33:00'),(6,1,'2025-09-24','00:34:00','08:00:00',7.4333333333333,'2025-09-24 07:40:14','2025-09-24 07:40:14'),(7,1,'2025-09-01','01:34:00','07:28:00',5.9,'2025-09-24 07:40:59','2025-09-24 07:40:59'),(8,1,'2025-09-24','01:40:00','08:00:00',6.3333333333333,'2025-09-25 15:26:40','2025-09-25 15:26:40'),(9,1,'2025-09-30','02:50:00','11:30:00',8.6666666666667,'2025-10-01 07:42:53','2025-10-01 07:42:53'),(10,1,'2025-10-02','00:30:00','07:50:00',7.3333333333333,'2025-10-03 03:59:25','2025-10-03 03:59:25'),(11,1,'2025-10-06','01:00:00','19:00:00',18,'2025-10-06 08:05:21','2025-10-06 08:05:21'),(12,1,'2025-10-06','01:00:00','02:00:00',1,'2025-10-06 08:05:43','2025-10-06 08:05:43'),(13,1,'2025-10-08','00:30:00','06:40:00',6.1666666666667,'2025-10-08 04:05:57','2025-10-08 04:05:57'),(14,1,'2025-10-07','03:00:00','08:00:00',5,'2025-10-08 04:06:34','2025-10-08 04:06:34'),(15,1,'2025-10-06','20:00:00','07:00:00',11,'2025-10-08 04:06:58','2025-10-08 04:06:58'),(16,1,'2025-10-06','20:00:00','07:00:00',11,'2025-10-08 04:07:17','2025-10-08 04:07:17'),(17,1,'2025-10-08','20:00:00','07:00:00',11,'2025-10-08 04:07:35','2025-10-08 04:07:35'),(18,1,'2025-10-08','23:40:00','10:00:00',10.333333333333,'2025-10-08 04:08:02','2025-10-08 04:08:02'),(19,1,'2025-10-16','03:45:00','08:10:00',4.4166666666667,'2025-10-16 08:42:44','2025-10-16 08:42:44');
/*!40000 ALTER TABLE `sleeps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Vladislav','admin','admin@admin.lv','profile_photos/bcAQYsbvEMboRLrG1dpiOWcR7k1vZQ27A1FfgrgO.jpg','avatars/xza6nSpCayLefQDfmemkCmuUPM3rYKTCriX9TlOA.jpg','banner/Y4HRt2YjadStNz8I7gclRL4oUW1UNOx0TTd5NIsH.jpg',NULL,'admin','$2y$12$7ZQXNjqgEwTDdMIWnuhg8Ot9FEPwPpHO4qM.l2xb.zNkqWaMyc07i','R4RVm4wWvrGdwLjR8hosJiO9jSvcf99uWrvqbikjbohKFLTJgjseYqj0vRVp','2025-09-09 11:23:13','2025-10-10 04:40:20'),(2,'Jon','StrongerMan','Jon@gmail.com',NULL,'avatars/VAlE7d8UKn5oCnMqVs0as7iAdGK9wTB1m9UoUYjX.jpg','banner/nUxS2EnOtnnoBSDXjhfyEew21hjyqilrqy5XkI3O.jpg',NULL,'user','$2y$12$aDagpwq1X8NhYf1XSKGSBeH5x8ztwKwjrlKOk42McupZmu5ckH3SC','gNFFUuSS9XMbU7TupQp1L0Odd5xAKrjbzaxhXiE7k7ifhUVwSAKtyQTyXCxS','2025-09-18 07:39:21','2025-10-16 02:52:57'),(3,'Alex','alex','alex@gmail.com',NULL,'avatars/6nXB1IAJSAP3542aIuTCupD0peGpgVbGXHMGverX.jpg','banner/tIfLhq4yIUXxHvrKN3U727fHtUB8InjaqOTsrOWC.png',NULL,'user','$2y$12$k9enM4bcycfHd1BpYd/AoO11rWUpRWcN.gPSP22T7dVD734rFQF1O',NULL,'2025-09-19 02:56:26','2025-10-01 09:09:21'),(5,'Denis','denissport','denis@gmail.com',NULL,NULL,NULL,NULL,'user','$2y$12$sToZ2DFBifWzFa7B7uKZN.BmF3kb6Pj2rhe2cfc3H9XpNRJirhnBy','cwLQb547vp5Q9KDuQP4WEn2nGMoKVpD0srBlEsyan73ZN7itYx9KiZuihjEj','2025-10-01 09:10:43','2025-10-01 09:10:43'),(7,'FitLife User','spidorman','perviyvlad2007@gmail.com',NULL,'avatars/JmyCsJQ9EhVee8SKtelcDjVQJ9BBYAy9ZPGCILb8.png','banner/b3S7Q2I544UWSd2sOGHeXQoTKNCCdO0DTo6BLYcw.png',NULL,'user','$2y$12$E6koS3A7j.PsJBychV3OK.W5qipc5l/J2kyuVQ6nFK/.hvvOuu8zq','WBxNv2hOkyGqjCzB15HgekRF5AIWLR3mInnxuaGhsnVs7jz4BKoJXTXwc14K','2025-10-15 05:16:02','2025-10-16 08:50:19');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `water_logs`
--

DROP TABLE IF EXISTS `water_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `water_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `amount` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `water_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `water_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `water_logs`
--

LOCK TABLES `water_logs` WRITE;
/*!40000 ALTER TABLE `water_logs` DISABLE KEYS */;
INSERT INTO `water_logs` VALUES (1,1,5000,'2025-09-09 18:07:53','2025-09-09 18:07:53'),(2,1,14354,'2025-09-18 03:23:18','2025-09-18 03:23:18'),(3,1,15000,'2025-09-19 02:52:37','2025-09-19 02:52:37'),(4,1,21433,'2025-09-22 08:28:17','2025-09-22 08:28:17'),(5,1,1834,'2025-09-24 07:33:51','2025-09-24 07:33:51'),(6,1,342,'2025-09-24 07:34:47','2025-09-24 07:34:47'),(7,1,1400,'2025-09-25 15:27:21','2025-09-25 15:27:21'),(8,1,4234,'2025-10-03 03:59:48','2025-10-03 03:59:48'),(9,1,4236,'2025-10-08 04:10:45','2025-10-08 04:10:45');
/*!40000 ALTER TABLE `water_logs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-18 21:14:48
