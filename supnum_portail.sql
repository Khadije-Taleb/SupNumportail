CREATE DATABASE  IF NOT EXISTS `supnum_portail` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `supnum_portail`;
-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: supnum_portail
-- ------------------------------------------------------
-- Server version	9.1.0

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS admin;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  id bigint unsigned NOT NULL AUTO_INCREMENT,
  utilisateur_id bigint unsigned DEFAULT NULL,
  nom varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  prenom varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY admin_utilisateur_id_unique (utilisateur_id)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES admin WRITE;
/*!40000 ALTER TABLE admin DISABLE KEYS */;
INSERT INTO admin VALUES (1,1,'Admin','Principal');
/*!40000 ALTER TABLE admin ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificat_medical`
--

DROP TABLE IF EXISTS certificat_medical;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE certificat_medical (
  id bigint unsigned NOT NULL AUTO_INCREMENT,
  matricule_etudiant varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  photo_certificat varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  annee enum('L1','L2','L3','M1','M2') COLLATE utf8mb4_unicode_ci NOT NULL,
  evaluation_id bigint unsigned DEFAULT NULL,
  date_absence date NOT NULL,
  statut enum('EN_ATTENTE','VALIDE','REFUSE') COLLATE utf8mb4_unicode_ci DEFAULT 'EN_ATTENTE',
  remarque_admin text COLLATE utf8mb4_unicode_ci,
  admin_id bigint unsigned DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY certificat_medical_matricule_etudiant_foreign (matricule_etudiant),
  KEY certificat_medical_admin_id_foreign (admin_id),
  KEY certificat_medical_evaluation_id_foreign (evaluation_id)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificat_medical`
--

LOCK TABLES certificat_medical WRITE;
/*!40000 ALTER TABLE certificat_medical DISABLE KEYS */;
INSERT INTO certificat_medical VALUES (1,'SUP001','certificats/GocVEw0FYqi8cpS0PxLV1OdTT6N7i92fb0vJ1rwP.png','L1',NULL,'2025-09-02','EN_ATTENTE',NULL,NULL,'2026-01-07 13:50:49'),(2,'SUP001','certificats/sJIuwNbLzpBNXqm3hr0mRMKk3S9mSyjQ9znUNZn0.png','L1',NULL,'2026-12-12','VALIDE',NULL,NULL,'2026-01-07 14:04:18'),(3,'SUP003','certificats/WmPxyVFJdBcnbnZ4tIxEE4dbIDvyMlKa4dq8RIcI.jpg','M2',NULL,'2026-01-03','REFUSE','le certificat est fake',NULL,'2026-01-09 02:59:20'),(4,'SUP001','certificats/4Uc2NeXVHwXvqc8pXz5JfNh3p7VEFsL3iWsWudqs.png','L1',11,'2026-01-03','VALIDE','le retrapage de devoir sera faire a bientot',NULL,'2026-01-11 18:58:12'),(5,'SUP001','certificats/dm6MHJYu32ptIi1m0zxtwkutj3GnmkR3olzjUQC6.png','L2',11,'2026-01-02','REFUSE','fhsfgshygfw',NULL,'2026-01-12 09:57:40');
/*!40000 ALTER TABLE certificat_medical ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demande`
--

DROP TABLE IF EXISTS demande;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE demande (
  id bigint unsigned NOT NULL AUTO_INCREMENT,
  matricule_etudiant varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  document_id bigint unsigned DEFAULT NULL,
  justificatif varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  commentaire text COLLATE utf8mb4_unicode_ci,
  statut enum('en_attente','en_cours_traitement','fin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  remarque_admin text COLLATE utf8mb4_unicode_ci,
  admin_id bigint unsigned DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY demande_matricule_etudiant_foreign (matricule_etudiant),
  KEY demande_document_id_foreign (document_id),
  KEY demande_admin_id_foreign (admin_id)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demande`
--

LOCK TABLES demande WRITE;
/*!40000 ALTER TABLE demande DISABLE KEYS */;
INSERT INTO demande VALUES (1,'SUP003',2,NULL,NULL,'en_cours_traitement','vfkjlfjldrjklgj',1,'2026-01-09 02:08:07','2026-01-10 00:13:30'),(2,'SUP003',2,NULL,NULL,'fin','vous trouvez vos document au niveau de scolarite',1,'2026-01-09 02:57:10','2026-01-10 00:01:44'),(3,'SUP001',2,NULL,NULL,'fin','votre demande en cours',1,'2026-01-13 15:05:22','2026-01-13 16:16:11');
/*!40000 ALTER TABLE demande ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS document;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE document (
  id bigint unsigned NOT NULL AUTO_INCREMENT,
  nom_document varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  actif tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES document WRITE;
/*!40000 ALTER TABLE document DISABLE KEYS */;
INSERT INTO document VALUES (2,'Relevé de notes','Document détaillant les notes et crédits obtenus pour un semestre ou une année.',1),(3,'Diplome','votre diplome',1),(4,'Diplôme / Attestation de réussite','Document certifiant la validation finale de votre cursus.',1);
/*!40000 ALTER TABLE document ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etudiant`
--

DROP TABLE IF EXISTS etudiant;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE etudiant (
  matricule varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  utilisateur_id bigint unsigned DEFAULT NULL,
  nom varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  prenom varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  email varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  annee enum('L1','L2','L3','M1','M2') COLLATE utf8mb4_unicode_ci NOT NULL,
  filiere varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (matricule),
  UNIQUE KEY etudiant_utilisateur_id_unique (utilisateur_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudiant`
--

LOCK TABLES etudiant WRITE;
/*!40000 ALTER TABLE etudiant DISABLE KEYS */;
INSERT INTO etudiant VALUES ('ETU2025001',2,'Bah','Mamadou','etudiant@supnum.ne','L3','Genie Logiciel'),('SUP001',3,'Ahmed','Ali','ahmed.ali@supnum.edu','L1','Informatique'),('SUP002',4,'Fatima','Saleh','fatima.saleh@supnum.edu','L2','Réseaux'),('SUP003',5,'Mohamed','Omar','mohamed.omar@supnum.edu','L3','Génie Logiciel'),('SUP004',6,'Aicha','Sidi','aicha.sidi@supnum.edu','M1','Data Science'),('SUP005',7,'Khadija','Brahim','khadija.brahim@supnum.edu','M2','Cybersécurité');
/*!40000 ALTER TABLE etudiant ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation`
--

DROP TABLE IF EXISTS evaluation;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE evaluation (
  id int NOT NULL AUTO_INCREMENT,
  type_evaluation varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  nom_matiere varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation`
--

LOCK TABLES evaluation WRITE;
/*!40000 ALTER TABLE evaluation DISABLE KEYS */;
INSERT INTO evaluation VALUES (1,'devoir_ecrit','Mathématiques'),(2,'examen_final','Mathématiques'),(3,'tp_note','Algorithmes'),(4,'devoir_pratique','Algorithmes'),(5,'devoir_ecrit','Base de données'),(6,'examen_final','Base de données'),(7,'tp_note','Réseaux'),(8,'devoir_pratique','Programmation Web'),(9,'examen_final','Programmation Web'),(10,'devoir_ecrit','Systèmes d\'exploitation'),(11,'devoir_ecrit','dev210');
/*!40000 ALTER TABLE evaluation ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS migrations;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE migrations (
  id int unsigned NOT NULL AUTO_INCREMENT,
  migration varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  batch int NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES migrations WRITE;
/*!40000 ALTER TABLE migrations DISABLE KEYS */;
INSERT INTO migrations VALUES (1,'2026_01_13_200000_fix_notification_roles',1);
/*!40000 ALTER TABLE migrations ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS notification;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE notification (
  id bigint unsigned NOT NULL AUTO_INCREMENT,
  id_utilisateur bigint unsigned DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  title varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  matricule_etudiant varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  message text COLLATE utf8mb4_unicode_ci NOT NULL,
  link varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  is_read tinyint(1) NOT NULL DEFAULT '0',
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY notification_matricule_etudiant_foreign (matricule_etudiant),
  KEY notification_id_utilisateur_foreign (id_utilisateur)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES notification WRITE;
/*!40000 ALTER TABLE notification DISABLE KEYS */;
INSERT INTO notification VALUES (1,NULL,'etudiant',NULL,NULL,'SUP003','Votre demande est en cours de traitement par la scolarité. Remarque : vous devez trouver votre document au niveau de scolarite',NULL,0,'2026-01-09 23:36:21',NULL),(2,NULL,'etudiant',NULL,NULL,'SUP003','Votre document est prêt. Vous pouvez le récupérer au niveau de la scolarité. Remarque : vous trouvez vos document au niveau de scolarite',NULL,0,'2026-01-10 00:01:44',NULL),(3,5,'etudiant',NULL,NULL,'SUP003','Votre demande est en cours de traitement par la scolarité. Remarque : vfkjlfjldrjklgj',NULL,1,'2026-01-10 00:13:30',NULL),(4,5,'etudiant',NULL,NULL,'SUP003','Certificat médical traité : Votre certificat médical a été rejeté. Remarque de l\'administration : le certificat est fake',NULL,0,'2026-01-11 16:46:23',NULL),(5,3,'etudiant',NULL,NULL,'SUP001','Certificat médical traité : Votre certificat médical a été accepté.',NULL,1,'2026-01-11 17:28:44',NULL),(6,3,'etudiant',NULL,NULL,'SUP001','Certificat médical traité : Votre certificat médical a été accepté. Remarque de l\'administration : le retrapage de devoir sera faire a bientot',NULL,1,'2026-01-11 19:03:25',NULL),(7,3,'etudiant',NULL,NULL,'SUP001','Certificat médical traité : Votre certificat médical a été rejeté. Remarque de l\'administration : fhsfgshygfw',NULL,1,'2026-01-12 09:58:37',NULL),(8,1,'admin','Nouvelle demande de document','demande','SUP001','Une nouvelle demande de  a été envoyée par l\'étudiant Ali Ahmed',NULL,1,'2026-01-13 15:05:22',NULL),(9,3,'etudiant','Mise à jour de votre demande','demande','SUP001','Votre demande pour le document :  est désormais en cours. Remarque : votre demande en cours','http://127.0.0.1:8000/etudiant/mes-demandes',0,'2026-01-13 16:13:07',NULL),(10,3,'etudiant','Mise à jour de votre demande','demande','SUP001','Votre demande pour le document :  est désormais terminée. Remarque : votre demande en cours','http://127.0.0.1:8000/etudiant/mes-demandes',1,'2026-01-13 16:16:11',NULL);
/*!40000 ALTER TABLE notification ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS utilisateur;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE utilisateur (
  id bigint unsigned NOT NULL AUTO_INCREMENT,
  email varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('etudiant','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  premiere_connexion tinyint(1) NOT NULL DEFAULT '1',
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY utilisateur_email_unique (email)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES utilisateur WRITE;
/*!40000 ALTER TABLE utilisateur DISABLE KEYS */;
INSERT INTO utilisateur VALUES (1,'admin@supnum.ne','$2y$12$Xldsv/nASIcI2ddObsL0Fuf/xL0UyhrYhDVwIpCOfUBqvgfZkK97W','admin',0,'2026-01-07 09:36:04'),(2,'etudiant@supnum.ne','$2y$12$x1A1n7QjYY.ozyexvhRCMeJjIUvwtIphxt3TTI8d2M.Ymn7lh5cdm','etudiant',1,'2026-01-07 09:36:04'),(3,'ahmed.ali@supnum.edu','$2y$12$nvkkrGI1rwk/84nCpWkINu7t3aVGLEv6ICuPvB21cKdQLYlyHHCyu','etudiant',0,'2026-01-07 10:57:09'),(4,'fatima.saleh@supnum.edu','$2y$12$dBImVseccpjA.Fc7XIU11OeW37SN4KOK.kNj9rC7WHdXo/yRmYzDe','etudiant',1,'2026-01-07 10:57:10'),(5,'mohamed.omar@supnum.edu','$2y$12$HICIkOgGpHvFYtMLGgSqY.odiRYhVwK1DnSayYy0MZBhZr/WUjq0W','etudiant',0,'2026-01-07 10:57:10'),(6,'aicha.sidi@supnum.edu','$2y$12$AKJi6TUzuXHKQbpktz54iepcU/8M6/cO0k5sETXph9V0Wzdeg1XtK','etudiant',1,'2026-01-07 10:57:11'),(7,'khadija.brahim@supnum.edu','$2y$12$EoLiWJiwNWer4iJ2xlMwUO/U24/1SDu0Om3nubKpbEFK.oNP2fiG.','etudiant',1,'2026-01-07 10:57:11'),(8,'test.student@supnum.edu','$2y$12$mqkqYOnJylaSJ.DBZVfzHua0WspSRU/tTZCFfvn1wKP1uwDoJzEXm','etudiant',0,'2026-01-09 01:55:24');
/*!40000 ALTER TABLE utilisateur ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-13 16:26:54
