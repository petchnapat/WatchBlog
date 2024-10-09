-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 09, 2024 at 08:34 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE `board` (
  `boardID` int NOT NULL,
  `boardHeader` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `boardBody` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `userID` int DEFAULT NULL,
  `categoryID` int DEFAULT NULL,
  `boardDate` date DEFAULT NULL,
  `boardTime` time DEFAULT NULL,
  `boardImage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `board`
--

INSERT INTO `board` (`boardID`, `boardHeader`, `boardBody`, `userID`, `categoryID`, `boardDate`, `boardTime`, `boardImage`) VALUES
(6, 'แจกสูตร ผัดกะเพราหมูสับ สูตรร้านตามสั่ง หอมฟุ้ง อร่อยเด็ดสะใจ !', 'ส่วนผสม ผัดกะเพราหมูสับ\r\nเนื้อหมู 400 กรัม\r\nใบกะเพรา 50 กรัม\r\nกระเทียม 2 หัว\r\nพริกแดงจินดา 12 เม็ด\r\nพริกแห้งแดงจินดา 6 เม็ด\r\nน้ำปลา 1 ช้อนโต๊ะ\r\nซอสปรุงรสฝาเขียว 1 1/2 ช้อนโต๊ะ\r\nซอสหอย 3 ช้อนโต๊ะ\r\nซีอิ้วดำหวาน 1/2 ช้อนโต๊ะ (ไม่ชอบกลิ่นตัดออกได้)\r\nน้ำตาลทราย 1/2 ช้อนโต๊ะ\r\n \r\n\r\nวิธีทำ ผัดกะเพราหมูสับ\r\nหั่นหมูสันคอออกเป็นชิ้นๆ แล้วสับหมูออกให้ละเอียดตามความต้องการ แล้วพักไว้\r\nโขลกพริกแห้งให้ละเอียด แล้วใส่พริกแดงจินดา และกระเทียมโขลกตามลงไปให้ละเอียด (สามารถปั่นแทนได้ ตามความชอบ)\r\nตั้งกระทะให้ร้อน ใส่น้ำมันพืชลงไปพอประมาณ ผัดพริกและกระเทียมให้มีกลิ่นหอม\r\nเมื่อพริกกระเทียมหอมได้ที่แล้ว ใส่หมูสับลงไปผัดให้กระจาย ไม่เกาะกันเป็นก้อน ผัดให้เข้ากับพริกกระเทียม ให้หมูสุกในระดับนึง แล้วปรุงรสด้วย น้ำมันหอย น้ำปลา ซอสปรุงรส และซีอิ๊วดำหวาน น้ำตาล เล็กน้อย เร่งไฟผัดให้เข้ากัน ชิมรสชาติ แล้วใส่ใบกะเพราลงไปผัดให้เข้ากัน ปิดเตา ตักเสิร์ฟ', 4, 4, '2024-10-03', '22:36:19', 'AnyConv.com__94.jpg'),
(7, 'แมนยู VS สเปอร์ส 0-3 : ผี 10 คนพ่ายเละ โดนไก่บุกถล่มคาบ้าน', 'แมนยู พบ สเปอร์ส : ผลบอล 0-3 | แฟนผีแดงต้องกุมขมับกับฟอร์มของทีมรักอีกครั้ง หลังจาก \"ปีศาจแดง\" แมนฯ ยูไนเต็ด พ่ายยับคาบ้านต่อ สเปอร์ส 0-3 โดยเกมนี้ทีมเยือนขึ้นนำตั้งแต่นาทีที่ 3 จาก เบรนแนน จอห์นสัน หลังจากนั้น แมนยู เหลือ 10 คนเมื่อ บรูโน่ แฟร์นันด์ส โดนใบแดงในช่วงท้ายครึ่งแรก ก่อนจะโดนทีม \"ไก่เดือยทอง\" ทะลวงตาข่ายเพิ่มอีก 2 ลูกจาก เดยัน คูลูเซฟสกี้ และ โดมินิค โซลันกี้ ในนาทีที่ 47 และ 77 ตามลำดับ', 6, 3, '2024-10-03', '22:40:36', 'thumbnail.jpg'),
(8, 'APINS คาเฟ่ขอนแก่นเปิดใหม่', 'มีคาเฟ่เปิดใหม่อีกแล้วว เราอยู่กันที่ APINS ร้านเพิ่งเปิดใหม่หมาดๆ วันนี้ เลยต้องมาลองสักหน่อย เค้าตกแต่งสไตล์ Mid-cencury modern โทนไม้ อบอุ่นๆ มีมุมถ่ายรูปเยอะ แนะนำช่วงเย็นแสงสวยฉ่ำ \r\nเมนูเครื่องดื่มเค้ามีให้เลือกหลากหลาย ทั้ง Coffee / Non - coffee, Specialty Coffee ก็มีนะ เบเกอรี่ที่นี่ก็เริ่ด เป็นชิ้นเล็กๆ พอดีทานแบบ  Financier, madeleine, Cookie ราคาน่ารักด้วยฮับ \r\nWeekday 07.00 น. - 17.00 (closed every Tuesday)\r\nWeekend  08.30 น.- 17.00\r\nพิกัด ซอยมิตรภาพ 13 ฝั่งตรงข้ามโรงพยาบาลศรีนครินทร์\r\nhttps://maps.app.goo.gl/6kbSbdTDXZU6CUCg7  ', 5, 4, '2024-10-03', '22:57:26', '460726778_122223691154006466_8551167717046480708_n.jpg'),
(9, 'ทำไหม น้องหมูเด้งชื่อหมูเด้งที่จริงเป็นฮิปโปครับ ?', 'ตามหัวข้อบอร์ดเลยครับ สงสัยจริงๆ นอนไม่หลับมา 1 เดือนล่ะ', 5, 1, '2024-10-03', '23:02:57', 'Moo_deng_หมูเด้ง_(2024-09-11)_-_img_02.jpg'),
(10, 'ตีกันต่อบ่หยุดยั้งตีกันต่อบ่หยุดยั้ง สัปดาห์แรกเดือนตุลาคม ก๊วนตีให้ตายก็บ่เก่งหรอก', 'ลงชื่อตีแบด ก๊วนตีให้ตายก็บ่เก่งหรอกได้ใต้คอมเม้นเลยครับ ตีเอาตายบ่ตายบ่เลิก !!!', 6, 3, '2024-10-03', '23:06:55', 'meta_7e32413b291737b82f0a4d1e44cd6d82.jpg'),
(11, '5 วิธีลดน้ำหนักง่ายๆ ด้วยตัวเอง ปลอดภัย ไม่ต้องพึ่งยาลดความอ้วน', '10 วิธีลดน้ำหนักง่ายๆ ด้วยตัวเอง สําหรับคนลดยาก มีอะไรบ้าง?\r\n1. กินอาหารให้ครบ 5 หมู่\r\n2. ดื่มน้ำก่อนมื้ออาหาร\r\n3. ลดความถี่ในการดื่มน้ำหวาน ชาไข่มุก และน้ำอัดลม\r\n4. เคี้ยวอาหารให้ละเอียด\r\n5. เพิ่มปริมาณผักและผลไม้', 4, 2, '2024-10-03', '23:10:08', 'deilc0p-e1d6f6e6-54df-450f-90e8-1aeffce3f930.jpg'),
(12, 'ไปเดินเล่นสถานที่ไหนดีครับ ? ', 'ตามห้อข้อบอร์ดเลยครับ ช่วงนี้เจ้านายไม่ค่อยว่างพาไปเดินเล่นเลยอยากไปเดินเองไปที่ไหนดีครับ ขอบรรยากาศดี คนตรีเพราะ ครับ', 7, 1, '2024-10-03', '23:20:25', NULL),
(13, 'ขอวิธีแก้อาการปวดหัวทีครับ', 'อยากจะมาสอบถามวิธีแก้อาการปวดหัวหน่อยครับ รบกวนทีครับ', 6, 2, '2024-10-03', '23:40:25', '424553438_122189938358006466_8028878563413087677_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryID` int NOT NULL,
  `categoryName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryName`) VALUES
(1, 'บันเทิง'),
(2, 'สุขภาพ'),
(3, 'กีฬา'),
(4, 'อาหาร');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentID` int NOT NULL,
  `userID` int DEFAULT NULL,
  `boardID` int DEFAULT NULL,
  `commentDetail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `commentDate` date DEFAULT NULL,
  `commentTime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`commentID`, `userID`, `boardID`, `commentDetail`, `commentDate`, `commentTime`) VALUES
(9, 5, 10, 'ชินจัง +1 ครับ', '2024-10-03', '23:48:16'),
(10, 5, 7, 'นี้แมนยูหรือโจ๊กครับเนี่ย เละเลย', '2024-10-03', '23:50:38'),
(11, 5, 6, 'อร่อยจริงครับ กินทุกวันทุกมื้อ', '2024-10-03', '23:51:09'),
(12, 6, 6, 'เปลี่ยนเมนูหน่อยก็ดีนะ แต่อร่อยดี', '2024-10-03', '23:51:54'),
(13, 6, 11, 'ลดได้จริง เห็นเหตุผลเร็ว', '2024-10-03', '23:52:20'),
(14, 6, 12, 'แนะนำสนามเด็กเล่นครับ', '2024-10-03', '23:53:18'),
(21, 5, 12, 'แนะนำบ้านครับ สนามกว้างดี', '2024-10-04', '01:19:13'),
(25, 7, 10, 'ชิโร่ +1 ', '2024-10-04', '01:27:34'),
(28, 4, 13, 'กดกด', '2024-10-04', '11:56:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `userPassword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `firstName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `userImage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `userDate` date DEFAULT NULL,
  `userTime` time DEFAULT NULL,
  `userRole` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `email`, `userPassword`, `firstName`, `lastName`, `userImage`, `userDate`, `userTime`, `userRole`) VALUES
(1, 'admin@admin.admin', '21232f297a57a5a743894a0e4a801fc3', 'admins', 'minad', '701827f915f3b68876368f260537e732.jpg', '2024-09-11', '16:57:45', 1),
(4, 'a@a.a', '0cc175b9c0f1b6a831c399e269772661', 'Misae', 'Nohara', 'images (1).jpg', '2024-09-11', '17:22:08', 0),
(5, 'teo@teo.teo', 'e827aa1ed78e96a113182dce12143f9f', 'Shinnosuke', 'Nohara', '701827f915f3b68876368f260537e732.jpg', '2024-09-17', '21:09:39', 1),
(6, 'p@p.p', '83878c91171338902e0fe0fb97a8c47a', 'Hiroshi', 'Nohara', 'Co8Qjv8E_400x400.jpg', '2024-10-03', '03:13:21', 0),
(7, 's@s.s', '03c7c0ace395d80182db07ae2c30f034', 'Shiro', 'Nohara', 'S3jbriICT4YlkCgdSBaY-_mDmRe2aPjjmlfEIEly-qUCNnk2q4GncAjJEh3Ef0QdhbOA60f1TU9fIQQswbrSqg.png', '2024-10-03', '23:15:55', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`boardID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `boardID` (`boardID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `board`
--
ALTER TABLE `board`
  MODIFY `boardID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `board`
--
ALTER TABLE `board`
  ADD CONSTRAINT `board_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `board_ibfk_2` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`boardID`) REFERENCES `board` (`boardID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
