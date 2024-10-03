-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for webboard
CREATE DATABASE IF NOT EXISTS `webboard` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `webboard`;

-- Dumping structure for table webboard.board
CREATE TABLE IF NOT EXISTS `board` (
  `boardID` int NOT NULL AUTO_INCREMENT,
  `boardHeader` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `boardBody` text COLLATE utf8mb4_general_ci,
  `userID` int DEFAULT NULL,
  `categoryID` int DEFAULT NULL,
  `boardDate` date DEFAULT NULL,
  `boardTime` time DEFAULT NULL,
  `boardImageName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`boardID`),
  KEY `FK_board_users` (`userID`),
  KEY `FK_board_category` (`categoryID`),
  CONSTRAINT `board_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`),
  CONSTRAINT `board_ibfk_2` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`),
  CONSTRAINT `FK_board_category` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`),
  CONSTRAINT `FK_board_users` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table webboard.board: ~3 rows (approximately)
INSERT INTO `board` (`boardID`, `boardHeader`, `boardBody`, `userID`, `categoryID`, `boardDate`, `boardTime`, `boardImageName`) VALUES
	(1, 'Play Game', 'Play', 1, 2, '2024-09-15', '22:20:41', NULL),
	(2, 'Work Outs', 'find friendfind friend find friend find friend find friend find friend find friend find friend find friend find friend find friend find friend find friend find friendfind friend find friend find friend find friend find friend find friend find friend find friend find friend find friend find friend find friend', 1, 2, '2024-09-15', '22:21:42', NULL),
	(3, 'Hi everyon !!', 'I\'m test', 3, 1, '2024-09-17', '23:52:27', NULL);

-- Dumping structure for table webboard.category
CREATE TABLE IF NOT EXISTS `category` (
  `categoryID` int NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`categoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table webboard.category: ~2 rows (approximately)
INSERT INTO `category` (`categoryID`, `categoryName`) VALUES
	(1, 'บันเทิง'),
	(2, 'สุขภาพ');

-- Dumping structure for table webboard.comment
CREATE TABLE IF NOT EXISTS `comment` (
  `commentID` int NOT NULL AUTO_INCREMENT,
  `userID` int DEFAULT NULL,
  `boardID` int DEFAULT NULL,
  `commentDetail` text COLLATE utf8mb4_general_ci,
  `commnetImageID` int DEFAULT NULL,
  `commentStatus` int DEFAULT (0),
  `commentDate` date DEFAULT NULL,
  `commentTime` time DEFAULT NULL,
  PRIMARY KEY (`commentID`),
  KEY `userID` (`userID`),
  KEY `boardID` (`boardID`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`boardID`) REFERENCES `board` (`boardID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table webboard.comment: ~5 rows (approximately)
INSERT INTO `comment` (`commentID`, `userID`, `boardID`, `commentDetail`, `commnetImageID`, `commentStatus`, `commentDate`, `commentTime`) VALUES
	(1, 3, 1, 'User : Test  Text : test Comment', NULL, 0, '2024-09-16', '23:03:44'),
	(2, 1, 2, 'MY USER: admin :  Myboard Comment Test', NULL, 0, '2024-09-16', '23:33:35'),
	(3, 4, 1, 'User: a Text : text from Another User Test', NULL, 0, '2024-09-16', '23:42:07'),
	(4, 4, 2, 'User : A Text: Text from Another User Test', NULL, 0, '2024-09-16', '23:43:25'),
	(5, 4, 2, 'user : A text : test New Comment', NULL, 0, '2024-09-17', '09:56:09');

-- Dumping structure for table webboard.users
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `userPassword` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `firstName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `userImage` text COLLATE utf8mb4_general_ci,
  `userDate` date DEFAULT NULL,
  `userTime` time DEFAULT NULL,
  `userRole` int DEFAULT '0',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table webboard.users: ~4 rows (approximately)
INSERT INTO `users` (`userID`, `email`, `userPassword`, `firstName`, `lastName`, `userImage`, `userDate`, `userTime`, `userRole`) VALUES
	(1, 'admin@admin.admin', '21232f297a57a5a743894a0e4a801fc3', 'admins', 'minad', NULL, '2024-09-11', '16:57:45', 1),
	(3, 'test@test.test', '098f6bcd4621d373cade4e832627b4f6', 'Test', 'tseT', NULL, '2024-09-11', '17:01:40', 0),
	(4, 'a@a.a', '0cc175b9c0f1b6a831c399e269772661', 'Aa', 'aA', NULL, '2024-09-11', '17:22:08', 0),
	(5, 'teo@teo.teo', 'e827aa1ed78e96a113182dce12143f9f', 'Thanaphol', 'Wuttitada', NULL, '2024-09-17', '21:09:39', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
