-- MySQL dump 10.13  Distrib 8.4.6, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: landlord_master
-- ------------------------------------------------------
-- Server version	8.4.6-0ubuntu0.25.04.2

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
-- Table structure for table `account_statements`
--

DROP TABLE IF EXISTS `account_statements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_statements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned DEFAULT NULL,
  `account_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `closing_balance` decimal(15,2) NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_statements_company_id_index` (`company_id`),
  KEY `account_statements_account_id_index` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_statements`
--

LOCK TABLES `account_statements` WRITE;
/*!40000 ALTER TABLE `account_statements` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_statements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_transactions`
--

DROP TABLE IF EXISTS `account_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned DEFAULT NULL,
  `account_id` bigint unsigned NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `credit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `account_transactionable_id` bigint unsigned DEFAULT NULL,
  `account_transactionable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_transactions_company_id_index` (`company_id`),
  KEY `account_transactions_account_id_index` (`account_id`),
  KEY `account_transactions_created_by_index` (`created_by`),
  KEY `account_transactions_account_transactionable_id_index` (`account_transactionable_id`),
  KEY `account_transactions_account_transactionable_type_index` (`account_transactionable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_transactions`
--

LOCK TABLES `account_transactions` WRITE;
/*!40000 ALTER TABLE `account_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_types`
--

DROP TABLE IF EXISTS `account_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_types_title_unique` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_types`
--

LOCK TABLES `account_types` WRITE;
/*!40000 ALTER TABLE `account_types` DISABLE KEYS */;
INSERT INTO `account_types` VALUES (1,'Default','2025-09-06 13:30:01','2025-09-06 13:30:01'),(2,'Receivable','2025-09-06 13:30:01','2025-09-06 13:30:01'),(3,'Payable','2025-09-06 13:30:01','2025-09-06 13:30:01'),(4,'Wallet','2025-09-06 13:30:01','2025-09-06 13:30:01'),(5,'Bank','2025-09-06 13:30:01','2025-09-06 13:30:01'),(6,'Purchase','2025-09-06 13:30:01','2025-09-06 13:30:01'),(7,'Other_Expense','2025-09-06 13:30:01','2025-09-06 13:30:01'),(8,'Other_Income','2025-09-06 13:30:01','2025-09-06 13:30:01'),(9,'Unspecified','2025-09-06 13:30:01','2025-09-06 13:30:01');
/*!40000 ALTER TABLE `account_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned DEFAULT NULL,
  `account_no` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type_id` bigint unsigned DEFAULT NULL,
  `accountable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accountable_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `_lft` int DEFAULT NULL,
  `_rgt` int DEFAULT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `root_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1-Assets 2-Expenses 3-Liabilities 4-Income 5-Capital',
  `financial_statement_placement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accounts_company_id_index` (`company_id`),
  KEY `accounts_account_type_id_index` (`account_type_id`),
  KEY `accounts_accountable_id_index` (`accountable_id`),
  KEY `accounts_parent_id_index` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audits`
--

DROP TABLE IF EXISTS `audits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint unsigned NOT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  KEY `audits_user_id_user_type_index` (`user_id`,`user_type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audits`
--

LOCK TABLES `audits` WRITE;
/*!40000 ALTER TABLE `audits` DISABLE KEYS */;
INSERT INTO `audits` VALUES (1,'App\\Models\\User',6,'updated','App\\Models\\User',6,'{\"remember_token\": null}','{\"remember_token\": \"XgnMT4VhOklRmZCuBigx9zqb1sMyCXTAyVhZqcvmZNyIhkgeAyAYEbrXp85m\"}','http://127.0.0.1:8000/login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36',NULL,'2025-09-05 02:10:41','2025-09-05 02:10:41'),(2,'App\\Models\\User',6,'updated','App\\Models\\User',6,'{\"remember_token\": \"XgnMT4VhOklRmZCuBigx9zqb1sMyCXTAyVhZqcvmZNyIhkgeAyAYEbrXp85m\"}','{\"remember_token\": \"sIUd1BQCbmcV0EG6P3yxVKchzNSdkDmxZDGHhauzQM2u8UnnAs0KFV27hkCN\"}','http://127.0.0.1:8000/logout','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36',NULL,'2025-09-06 11:13:17','2025-09-06 11:13:17');
/*!40000 ALTER TABLE `audits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_accounts`
--

DROP TABLE IF EXISTS `bank_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bank_accounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned DEFAULT NULL,
  `bank_id` bigint unsigned NOT NULL,
  `account_no` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_accounts_account_id_index` (`account_id`),
  KEY `bank_accounts_bank_id_index` (`bank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_accounts`
--

LOCK TABLES `bank_accounts` WRITE;
/*!40000 ALTER TABLE `bank_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `banks_bank_name_unique` (`bank_name`),
  UNIQUE KEY `banks_short_name_unique` (`short_name`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banks`
--

LOCK TABLES `banks` WRITE;
/*!40000 ALTER TABLE `banks` DISABLE KEYS */;
INSERT INTO `banks` VALUES (1,'Dutch Bangla Bank Limited','DBBL','2025-09-06 13:30:01','2025-09-06 13:30:01'),(2,'Prime Bank Limited','Prime','2025-09-06 13:30:01','2025-09-06 13:30:01'),(3,'Unknown Bank','N/A','2025-09-06 13:30:01','2025-09-06 13:30:01'),(47,'AB Bank Limited','AB','2025-09-06 13:30:01','2025-09-06 13:30:01'),(48,'Bangladesh Commerce Bank Limited','BCBL','2025-09-06 13:30:01','2025-09-06 13:30:01'),(49,'BRAC Bank Limited','BRAC','2025-09-06 13:30:01','2025-09-06 13:30:01'),(50,'City Bank Limited','City','2025-09-06 13:30:01','2025-09-06 13:30:01'),(51,'Community Bank Bangladesh Limited','CBBL','2025-09-06 13:30:01','2025-09-06 13:30:01'),(52,'Dhaka Bank Limited','Dhaka','2025-09-06 13:30:01','2025-09-06 13:30:01'),(53,'Eastern Bank Limited','Eastern','2025-09-06 13:30:01','2025-09-06 13:30:01'),(54,'IFIC Bank Limited','IFIC','2025-09-06 13:30:01','2025-09-06 13:30:01'),(55,'Jamuna Bank Limited','Jamuna','2025-09-06 13:30:01','2025-09-06 13:30:01'),(56,'Meghna Bank Limited','Meghna','2025-09-06 13:30:01','2025-09-06 13:30:01'),(57,'Mercantile Bank Limited','Mercantile','2025-09-06 13:30:01','2025-09-06 13:30:01'),(58,'Midland Bank Limited','Midland','2025-09-06 13:30:01','2025-09-06 13:30:01'),(59,'Modhumoti Bank Limited','Modhumoti','2025-09-06 13:30:01','2025-09-06 13:30:01'),(60,'Mutual Trust Bank Limited','MTBL','2025-09-06 13:30:01','2025-09-06 13:30:01'),(61,'National Bank Limited','NBL','2025-09-06 13:30:01','2025-09-06 13:30:01'),(62,'National Credit & Commerce Bank Limited','NCCBL','2025-09-06 13:30:01','2025-09-06 13:30:01'),(63,'NRB Bank Limited','NRB','2025-09-06 13:30:01','2025-09-06 13:30:01'),(64,'NRB Commercial Bank Ltd','NRB Commercial','2025-09-06 13:30:01','2025-09-06 13:30:01'),(65,'NRB Global Bank Ltd','NRB Global','2025-09-06 13:30:01','2025-09-06 13:30:01'),(66,'One Bank Limited','One Bank','2025-09-06 13:30:01','2025-09-06 13:30:01'),(67,'Padma Bank Limited','Padma','2025-09-06 13:30:01','2025-09-06 13:30:01'),(68,'Premier Bank Limited','Premier','2025-09-06 13:30:01','2025-09-06 13:30:01'),(69,'Pubali Bank Limited','Pubali','2025-09-06 13:30:01','2025-09-06 13:30:01'),(70,'Standard Bank Limited','Standard','2025-09-06 13:30:01','2025-09-06 13:30:01'),(71,'Shimanto Bank Ltd','Shimanto','2025-09-06 13:30:01','2025-09-06 13:30:01'),(72,'Southeast Bank Limited','Southeast','2025-09-06 13:30:01','2025-09-06 13:30:01'),(73,'South Bangla Agriculture and Commerce Bank Limited','SBACBL','2025-09-06 13:30:01','2025-09-06 13:30:01'),(74,'Trust Bank Limited','Trust','2025-09-06 13:30:01','2025-09-06 13:30:01'),(75,'United Commercial Bank Ltd','UCBL','2025-09-06 13:30:01','2025-09-06 13:30:01'),(76,'Uttara Bank Limited','Uttara','2025-09-06 13:30:01','2025-09-06 13:30:01');
/*!40000 ALTER TABLE `banks` ENABLE KEYS */;
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
INSERT INTO `cache` VALUES ('laravel_cache_spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:135:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:14:\"dashboard-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:6:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:9:\"home-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:6:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:17:\"superadmin-access\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:9:\"user-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:11:\"user-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:9:\"user-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:11:\"user-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:16:\"user-role-assign\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:18:\"user-status-toggle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:9:\"role-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:11:\"role-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:9:\"role-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:11:\"role-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:15:\"permission-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:17:\"permission-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:15:\"permission-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:17:\"permission-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:10:\"store-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:12:\"store-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:10:\"store-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:12:\"store-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:12:\"store-select\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:10:\"brand-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:12:\"brand-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:10:\"brand-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:12:\"brand-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:13:\"category-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:15:\"category-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:13:\"category-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:15:\"category-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:9:\"unit-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:11:\"unit-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:9:\"unit-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:11:\"unit-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:12:\"product-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:14:\"product-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:12:\"product-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:14:\"product-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:18:\"product-modal-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:8:\"tax-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:10:\"tax-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:8:\"tax-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:14:\"tax-modal-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:10:\"tax-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:21:\"additional-field-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:23:\"additional-field-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:21:\"additional-field-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:23:\"additional-field-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:13:\"supplier-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:15:\"supplier-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:13:\"supplier-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:15:\"supplier-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:13:\"supplier-show\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:13:\"customer-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:15:\"customer-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:13:\"customer-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:15:\"customer-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:13:\"customer-show\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:13:\"purchase-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:15:\"purchase-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:13:\"purchase-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:15:\"purchase-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:13:\"purchase-show\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:21:\"purchase-payment-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:23:\"purchase-payment-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:23:\"purchase-payment-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:21:\"purchase-invoice-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:9:\"sale-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:11:\"sale-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:9:\"sale-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:11:\"sale-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:9:\"sale-show\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:17:\"sale-payment-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:19:\"sale-payment-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:19:\"sale-payment-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:17:\"sale-invoice-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:21:\"stock-adjustment-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:23:\"stock-adjustment-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:21:\"stock-adjustment-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:23:\"stock-adjustment-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:21:\"stock-adjustment-show\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:12:\"company-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:14:\"company-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:12:\"company-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:14:\"company-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:19:\"company-user-manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:86;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:20:\"company-profile-show\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:87;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:20:\"company-profile-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:88;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:17:\"report-sales-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:89;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:20:\"report-purchase-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:90;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:17:\"report-stock-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:91;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:13:\"report-export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:92;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:12:\"profile-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:6;}}i:93;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:12:\"profile-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:6;}}i:94;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:15:\"password-update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:6;}}i:95;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:22:\"password-reset-request\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:96;a:4:{s:1:\"a\";i:97;s:1:\"b\";s:20:\"account-voucher-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:97;a:4:{s:1:\"a\";i:98;s:1:\"b\";s:25:\"report-balance-sheet-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:98;a:4:{s:1:\"a\";i:99;s:1:\"b\";s:28:\"report-income-statement-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:99;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:28:\"report-equity-statement-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:100;a:4:{s:1:\"a\";i:101;s:1:\"b\";s:25:\"report-trail-balance-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:101;a:4:{s:1:\"a\";i:102;s:1:\"b\";s:15:\"de-account-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:102;a:4:{s:1:\"a\";i:103;s:1:\"b\";s:17:\"de-account-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:103;a:4:{s:1:\"a\";i:104;s:1:\"b\";s:15:\"de-account-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:104;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:17:\"de-account-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:105;a:4:{s:1:\"a\";i:106;s:1:\"b\";s:23:\"de-account-balance-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:106;a:4:{s:1:\"a\";i:107;s:1:\"b\";s:15:\"de-expense-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:107;a:4:{s:1:\"a\";i:108;s:1:\"b\";s:17:\"de-expense-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:108;a:4:{s:1:\"a\";i:109;s:1:\"b\";s:15:\"de-expense-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:109;a:4:{s:1:\"a\";i:110;s:1:\"b\";s:17:\"de-expense-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:110;a:4:{s:1:\"a\";i:111;s:1:\"b\";s:21:\"de-fund-transfer-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:111;a:4:{s:1:\"a\";i:112;s:1:\"b\";s:23:\"de-fund-transfer-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:112;a:4:{s:1:\"a\";i:113;s:1:\"b\";s:23:\"de-fund-transfer-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:113;a:4:{s:1:\"a\";i:114;s:1:\"b\";s:22:\"de-income-revenue-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:114;a:4:{s:1:\"a\";i:115;s:1:\"b\";s:24:\"de-income-revenue-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:115;a:4:{s:1:\"a\";i:116;s:1:\"b\";s:22:\"de-income-revenue-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:116;a:4:{s:1:\"a\";i:117;s:1:\"b\";s:24:\"de-income-revenue-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:117;a:4:{s:1:\"a\";i:118;s:1:\"b\";s:15:\"de-journal-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:118;a:4:{s:1:\"a\";i:119;s:1:\"b\";s:14:\"de-ledger-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:119;a:4:{s:1:\"a\";i:120;s:1:\"b\";s:23:\"de-loan-investment-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:120;a:4:{s:1:\"a\";i:121;s:1:\"b\";s:25:\"de-loan-investment-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:121;a:4:{s:1:\"a\";i:122;s:1:\"b\";s:23:\"de-loan-investment-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:122;a:4:{s:1:\"a\";i:123;s:1:\"b\";s:25:\"de-loan-investment-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:123;a:4:{s:1:\"a\";i:124;s:1:\"b\";s:22:\"de-loan-invreturn-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:124;a:4:{s:1:\"a\";i:125;s:1:\"b\";s:24:\"de-loan-invreturn-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:125;a:4:{s:1:\"a\";i:126;s:1:\"b\";s:22:\"de-loan-invreturn-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:126;a:4:{s:1:\"a\";i:127;s:1:\"b\";s:24:\"de-loan-invreturn-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:127;a:4:{s:1:\"a\";i:128;s:1:\"b\";s:15:\"de-payment-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:128;a:4:{s:1:\"a\";i:129;s:1:\"b\";s:17:\"de-payment-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:129;a:4:{s:1:\"a\";i:130;s:1:\"b\";s:15:\"de-payment-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:130;a:4:{s:1:\"a\";i:131;s:1:\"b\";s:17:\"de-payment-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:131;a:4:{s:1:\"a\";i:132;s:1:\"b\";s:24:\"de-security-deposit-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:132;a:4:{s:1:\"a\";i:133;s:1:\"b\";s:26:\"de-security-deposit-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:133;a:4:{s:1:\"a\";i:134;s:1:\"b\";s:24:\"de-security-deposit-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:134;a:4:{s:1:\"a\";i:135;s:1:\"b\";s:26:\"de-security-deposit-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}}s:5:\"roles\";a:6:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"Super Admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:13:\"Company Admin\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:15:\"Account Manager\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:17:\"Inventory Manager\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:13:\"Sales Manager\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:8:\"Employee\";s:1:\"c\";s:3:\"web\";}}}',1757244932);
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
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `config` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'QA Demo Co','NA','N/A','01900000000','qa@example.com','tenant_demo','ACTIVE',NULL,'2025-09-06 14:01:04','2025-09-06 14:01:04');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `de_journals`
--

DROP TABLE IF EXISTS `de_journals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `de_journals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned DEFAULT NULL,
  `date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `credit_transaction_id` bigint unsigned DEFAULT NULL,
  `debit_transaction_id` bigint unsigned DEFAULT NULL,
  `task_id` bigint unsigned DEFAULT NULL,
  `transaction_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'event',
  `created_by` bigint unsigned DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `journalable_id` bigint unsigned DEFAULT NULL,
  `journalable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `de_journals_company_id_index` (`company_id`),
  KEY `de_journals_credit_transaction_id_index` (`credit_transaction_id`),
  KEY `de_journals_debit_transaction_id_index` (`debit_transaction_id`),
  KEY `de_journals_task_id_index` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `de_journals`
--

LOCK TABLES `de_journals` WRITE;
/*!40000 ALTER TABLE `de_journals` DISABLE KEYS */;
/*!40000 ALTER TABLE `de_journals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fileable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fileable_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_05_24_182444_create_landlord_tenants_table',1),(5,'2025_05_24_192755_create_permission_tables',1),(6,'2025_05_27_112608_create_products_table',1),(7,'2025_06_02_000001_create_audits_table',1),(8,'2025_06_16_065113_create_user_otps_table',1),(9,'2025_06_24_081238_create_companies_table',1),(10,'01_2025_03_21_102419_create_hilinkz_account_types_table',2),(11,'02_2025_03_21_102434_create_hilinkz_banks_table',2),(12,'03_2025_03_21_102313_create_hilinkz_accounts_table',2),(13,'04_2025_03_21_102449_create_hilinkz_bank_accounts_table',2),(14,'05_2025_03_21_102608_create_hilinkz_tasks_table',2),(15,'06_2025_03_21_102533_create_hilinkz_account_transactions_table',2),(16,'07_2025_03_21_102548_create_hilinkz_account_statements_table',2),(17,'08_2025_03_21_102510_create_hilinkz_journals_table',2),(18,'09_2025_03_21_102621_create_hilinkz_files_table',2),(19,'10_2025_03_21_102636_create_hilinkz_taxes_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'dashboard-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(2,'home-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(3,'superadmin-access','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(4,'user-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(5,'user-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(6,'user-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(7,'user-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(8,'user-role-assign','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(9,'user-status-toggle','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(10,'role-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(11,'role-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(12,'role-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(13,'role-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(14,'permission-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(15,'permission-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(16,'permission-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(17,'permission-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(18,'store-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(19,'store-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(20,'store-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(21,'store-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(22,'store-select','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(23,'brand-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(24,'brand-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(25,'brand-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(26,'brand-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(27,'category-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(28,'category-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(29,'category-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(30,'category-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(31,'unit-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(32,'unit-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(33,'unit-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(34,'unit-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(35,'product-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(36,'product-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(37,'product-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(38,'product-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(39,'product-modal-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(40,'tax-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(41,'tax-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(42,'tax-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(43,'tax-modal-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(44,'tax-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(45,'additional-field-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(46,'additional-field-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(47,'additional-field-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(48,'additional-field-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(49,'supplier-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(50,'supplier-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(51,'supplier-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(52,'supplier-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(53,'supplier-show','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(54,'customer-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(55,'customer-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(56,'customer-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(57,'customer-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(58,'customer-show','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(59,'purchase-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(60,'purchase-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(61,'purchase-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(62,'purchase-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(63,'purchase-show','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(64,'purchase-payment-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(65,'purchase-payment-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(66,'purchase-payment-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(67,'purchase-invoice-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(68,'sale-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(69,'sale-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(70,'sale-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(71,'sale-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(72,'sale-show','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(73,'sale-payment-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(74,'sale-payment-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(75,'sale-payment-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(76,'sale-invoice-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(77,'stock-adjustment-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(78,'stock-adjustment-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(79,'stock-adjustment-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(80,'stock-adjustment-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(81,'stock-adjustment-show','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(82,'company-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(83,'company-create','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(84,'company-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(85,'company-delete','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(86,'company-user-manage','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(87,'company-profile-show','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(88,'company-profile-edit','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(89,'report-sales-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(90,'report-purchase-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(91,'report-stock-view','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(92,'report-export','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(93,'profile-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(94,'profile-edit','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(95,'password-update','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(96,'password-reset-request','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(97,'account-voucher-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(98,'report-balance-sheet-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(99,'report-income-statement-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(100,'report-equity-statement-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(101,'report-trail-balance-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(102,'de-account-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(103,'de-account-create','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(104,'de-account-edit','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(105,'de-account-delete','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(106,'de-account-balance-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(107,'de-expense-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(108,'de-expense-create','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(109,'de-expense-edit','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(110,'de-expense-delete','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(111,'de-fund-transfer-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(112,'de-fund-transfer-create','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(113,'de-fund-transfer-delete','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(114,'de-income-revenue-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(115,'de-income-revenue-create','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(116,'de-income-revenue-edit','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(117,'de-income-revenue-delete','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(118,'de-journal-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(119,'de-ledger-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(120,'de-loan-investment-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(121,'de-loan-investment-create','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(122,'de-loan-investment-edit','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(123,'de-loan-investment-delete','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(124,'de-loan-invreturn-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(125,'de-loan-invreturn-create','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(126,'de-loan-invreturn-edit','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(127,'de-loan-invreturn-delete','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(128,'de-payment-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(129,'de-payment-create','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(130,'de-payment-edit','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(131,'de-payment-delete','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(132,'de-security-deposit-view','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(133,'de-security-deposit-create','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(134,'de-security-deposit-edit','web','2025-09-06 10:58:56','2025-09-06 10:58:56'),(135,'de-security-deposit-delete','web','2025-09-06 10:58:56','2025-09-06 10:58:56');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1),(83,1),(84,1),(85,1),(86,1),(87,1),(88,1),(89,1),(90,1),(91,1),(92,1),(93,1),(94,1),(95,1),(96,1),(97,1),(98,1),(99,1),(100,1),(101,1),(102,1),(103,1),(104,1),(105,1),(106,1),(107,1),(108,1),(109,1),(110,1),(111,1),(112,1),(113,1),(114,1),(115,1),(116,1),(117,1),(118,1),(119,1),(120,1),(121,1),(122,1),(123,1),(124,1),(125,1),(126,1),(127,1),(128,1),(129,1),(130,1),(131,1),(132,1),(133,1),(134,1),(135,1),(1,2),(2,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(18,2),(19,2),(20,2),(21,2),(22,2),(35,2),(36,2),(37,2),(38,2),(59,2),(60,2),(61,2),(62,2),(63,2),(68,2),(69,2),(70,2),(71,2),(72,2),(82,2),(86,2),(87,2),(88,2),(89,2),(90,2),(91,2),(1,3),(2,3),(97,3),(98,3),(99,3),(100,3),(102,3),(103,3),(104,3),(105,3),(106,3),(107,3),(108,3),(109,3),(110,3),(111,3),(112,3),(113,3),(114,3),(115,3),(116,3),(117,3),(118,3),(119,3),(120,3),(121,3),(122,3),(123,3),(124,3),(125,3),(126,3),(127,3),(128,3),(129,3),(130,3),(131,3),(132,3),(133,3),(134,3),(135,3),(1,4),(2,4),(18,4),(22,4),(23,4),(24,4),(25,4),(26,4),(27,4),(28,4),(29,4),(30,4),(31,4),(32,4),(33,4),(34,4),(35,4),(36,4),(37,4),(38,4),(49,4),(50,4),(51,4),(52,4),(53,4),(77,4),(78,4),(79,4),(80,4),(81,4),(1,5),(2,5),(54,5),(55,5),(56,5),(57,5),(58,5),(68,5),(69,5),(70,5),(71,5),(72,5),(73,5),(74,5),(75,5),(1,6),(2,6),(93,6),(94,6),(95,6);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(2,'Company Admin','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(3,'Account Manager','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(4,'Inventory Manager','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(5,'Sales Manager','web','2025-09-06 10:58:55','2025-09-06 10:58:55'),(6,'Employee','web','2025-09-06 10:58:55','2025-09-06 10:58:55');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('3d7NngZ9aYE7hHpfA6SfnN7rR3z2ImDRqqK8qoy9',NULL,'127.0.0.1','curl/8.12.1','YTo1OntzOjY6Il90b2tlbiI7czo0MDoib3NLYjhuQlE1V0k2bmdMWHRNVW10V3VXakc2MXhWM1JjRk5acDFtUCI7czozNzoiZW5zdXJlX3ZhbGlkX3RlbmFudF9zZXNzaW9uX3RlbmFudF9pZCI7aTozO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1757028678),('A7APmzBqREhlMjroz7Iy3XV1eH4BP8Y4ctZBD3kK',NULL,'127.0.0.1','curl/8.12.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibk9ZaTQwcUk3T3NqVkRoZDgxRXFLZk9lcFhKUERxakdEWWtlSW9mMCI7czozNzoiZW5zdXJlX3ZhbGlkX3RlbmFudF9zZXNzaW9uX3RlbmFudF9pZCI7aTozO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1757028678),('ADrFOwoG7auwf4xgNPnCsEdrGgJagy4yn9LiXcqQ',NULL,'127.0.0.1','curl/8.12.1','YTo2OntzOjY6Il90b2tlbiI7czo0MDoicnBGNUtZNFRWVGE5WWw1NGdNMWdMVHBCTkZobnpWaktnN3lkTFk1ZyI7czozNzoiZW5zdXJlX3ZhbGlkX3RlbmFudF9zZXNzaW9uX3RlbmFudF9pZCI7aTozO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MTp7czoyNjoiMDFLNEZDWE1RMFRYWFBUVjJBQVZKRU1IRjciO047fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjt9fQ==',1757158498),('aFLO6qNngrT5eZP7XNahAm7s0VjKjNPM33qirtSv',6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo4OntzOjY6Il90b2tlbiI7czo0MDoiaHhyTGpEZFF3MzlsQ3oxUlAzcHB5STFSd1I2ZWZVb2ZlRm02RFQ0ciI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM3OiJlbnN1cmVfdmFsaWRfdGVuYW50X3Nlc3Npb25fdGVuYW50X2lkIjtpOjM7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NjtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NTcwMzgyNDE7fXM6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=',1757038915),('aj0jDogQfxL0aI30b4RHx3TdRZayolW52MgnpzYO',NULL,'127.0.0.1','curl/8.12.1','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQml4SWM5UmRVeEpEWUlGR3BqUW40aFliQ3JPY1MzRHZPVk1sOG9xRCI7czozNzoiZW5zdXJlX3ZhbGlkX3RlbmFudF9zZXNzaW9uX3RlbmFudF9pZCI7aTozO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1757031071),('arXZx9uTY05XwGMYPUVUCfMoSHyVdt5cDpFKMFkC',6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo4OntzOjY6Il90b2tlbiI7czo0MDoiR0ptOTlpS0RUcFJ6QmRpY3RyN2N6VjFvRlhBc2dkTGUwSHFtT05POCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM3OiJlbnN1cmVfdmFsaWRfdGVuYW50X3Nlc3Npb25fdGVuYW50X2lkIjtpOjM7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YToxOntzOjI2OiIwMUs0RkRCU0Y1RUJWUFpXNkExOEZIRlJRTiI7Tjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NjtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NTcxNTg5NTg7fX0=',1757158958),('FrAJBOGpntmDKDDkQ5eqJWDXFk4kU0oHSXBu4Sed',6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo3OntzOjY6Il90b2tlbiI7czo0MDoiVENFREEyUzRNZGNSNWdDRXB1MUhpVngwM1RHOTJwZUttQ2ZMVlNUZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO31zOjM3OiJlbnN1cmVfdmFsaWRfdGVuYW50X3Nlc3Npb25fdGVuYW50X2lkIjtpOjM7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NjtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NTcxNTkwMzQ7fX0=',1757159036),('HQ2ppL0a1ZZxk0Wttq4cTdYW1HnmQsohUUyCiazw',NULL,'127.0.0.1','curl/8.12.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNkgzZXJRcGZiQUkwdjFxY3hxeHpGaFFXckhFZTlMMWkwZlhxckpUbCI7czozNzoiZW5zdXJlX3ZhbGlkX3RlbmFudF9zZXNzaW9uX3RlbmFudF9pZCI7aTozO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1757031071),('jhU1SZCMMt4IgumsE9AScr4M4E4HYyWiBJPToiV6',NULL,'127.0.0.1','curl/8.12.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZkRaYWUyN0hJclhxcmtia0VDcWN3UGdDTFVtaFpaVFp4aHJUZDJwMCI7czozNzoiZW5zdXJlX3ZhbGlkX3RlbmFudF9zZXNzaW9uX3RlbmFudF9pZCI7aTozO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1757031309),('nTtH4afvEHrA95rmvV0hGbbSwug74YgrdOpN8xCg',NULL,'127.0.0.1','curl/8.12.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVklCTnZHWXdCTW8xR3A1SHBVa2xHSG52TVVjSGpLa0FHVDlGMnRjaSI7czozNzoiZW5zdXJlX3ZhbGlkX3RlbmFudF9zZXNzaW9uX3RlbmFudF9pZCI7aTozO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1757031601),('oDLpG9XQZFSheLTA8sTM99e3atWallBUv2SMoECr',NULL,'127.0.0.1','curl/8.12.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoicElGUXhVZUhKc2ZTQ1BIZEI2c0hpamJGaXZPaHBMWFgzWXg2elhHUyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2hvbWUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2hvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1757158482),('sczjAya1GJKiq4WBLJdBLwDdjEJKouNA2w3BnE0D',NULL,'127.0.0.1','curl/8.12.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHZ6aW95enVTRHFJVDEwOHZ4cXcxRVh4ZkJmZ29TVGkwRkl6aUh5VyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1757025258),('UpoJ4UqWktZmoxz2N0Tdn3LgbH506PRAuaPBxGXB',6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo4OntzOjY6Il90b2tlbiI7czo0MDoiMzN1S3M0cndjaEprc2JMT0dSS0VXcU5VVGdZWHRxN2l2MGhWd1R1bCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO31zOjM3OiJlbnN1cmVfdmFsaWRfdGVuYW50X3Nlc3Npb25fdGVuYW50X2lkIjtpOjM7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NjtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NTcxNTcyMTk7fXM6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=',1757158532);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taskable_id` bigint unsigned DEFAULT NULL,
  `taskable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_company_id_index` (`company_id`),
  KEY `tasks_taskable_id_index` (`taskable_id`),
  KEY `tasks_taskable_type_index` (`taskable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxes`
--

DROP TABLE IF EXISTS `taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taxes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxes`
--

LOCK TABLES `taxes` WRITE;
/*!40000 ALTER TABLE `taxes` DISABLE KEYS */;
/*!40000 ALTER TABLE `taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `database` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenants_domain_unique` (`domain`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
INSERT INTO `tenants` VALUES (1,1,'Acme Inc','localhost','tenant_demo','2025-09-04 22:06:37','2025-09-04 22:13:42'),(3,1,'Acme Inc (127.0.0.1)','127.0.0.1','tenant_demo','2025-09-04 22:56:36','2025-09-04 22:56:36');
/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_otps`
--

DROP TABLE IF EXISTS `user_otps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_otps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `otp` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'password_reset',
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_otps`
--

LOCK TABLES `user_otps` WRITE;
/*!40000 ALTER TABLE `user_otps` DISABLE KEYS */;
INSERT INTO `user_otps` VALUES (1,'01882021246',1,'50745','password_reset','2025-09-05 02:05:07','2025-09-05 02:02:07','2025-09-05 02:02:07');
/*!40000 ALTER TABLE `user_otps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,'Md Jamal Hossain','01882021246','robertmac8031@yahoo.com',NULL,'$2y$12$jBU2rs24y6SPlMM1RDzLLu0ve0BRBx1/acH3pUm0am3wDag9MYxGy',1,NULL,'2025-09-05 00:19:01','2025-09-05 00:19:01'),(2,NULL,'Md Jamal Hossain','01882021245','robertmac80312@yahoo.com',NULL,'$2y$12$neDTQfCvGN.3vLvIEFEQ/ekau6qm/Hb3v1TAnKD9HpxL8.o8yr8Ba',1,NULL,'2025-09-05 00:25:05','2025-09-05 00:25:05');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-06 19:39:12
