-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 17.12.2024 klo 09:00
-- Palvelimen versio: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pankki`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `kayttajat`
--

CREATE TABLE `kayttajat` (
  `id` int(11) NOT NULL,
  `kayttajatunnus` varchar(20) NOT NULL,
  `salasana` varchar(255) NOT NULL,
  `nimi` varchar(100) NOT NULL,
  `varat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `kayttajat`
--

INSERT INTO `kayttajat` (`id`, `kayttajatunnus`, `salasana`, `nimi`, `varat`) VALUES
(1, 'root', '$2y$10$0woS/XLA3SHztte7ERZhAuGXFuZKk.YYsAkrhbWgFJCT/.U4mMlmW', '', 0),
(23, '123', '$2y$10$D6txuu5c9oQCEQEIfpjbUe8oXX6O7dD0DLzThGM2McDpk3XwTyb5y', 'Aada', 239),
(24, '223', '$2y$10$M2P9MpS7O.noTLk3DQUR/OZl7mDZZfXs1mcbaAD0NgBiDsyWpD55a', 'Sofia', 256),
(25, 'v', '$2y$10$iq4neFqByOgRuW7UCDjXj.IsDZUYsNR52ZY25Lr6GsSRZJWWa3qvm', 'Väinö', 602),
(53, 'va0622', '$2y$10$6e2aGvbr2xPUdLo4RX.CQuT9j4Sa8I2Andh7kjA2deKPl1guFMRwi', 'Vili', 0);

-- --------------------------------------------------------

--
-- Rakenne taululle `tapahtumat`
--

CREATE TABLE `tapahtumat` (
  `id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `sender_account_id` int(20) NOT NULL,
  `reciver_account_id` int(20) NOT NULL,
  `information` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `tapahtumat`
--

INSERT INTO `tapahtumat` (`id`, `amount`, `sender_account_id`, `reciver_account_id`, `information`, `date`) VALUES
(33, 10, 1, 2, 'Aada Siirsi 10£ tililtä käyttötili tilille etutili', NULL),
(34, 2, 2, 1, 'Aada Siirsi 2£ tililtä etutili tilille käyttötili', NULL),
(35, 1, 1, 2, 'Aada Siirsi 1£ tililtä käyttötili tilille etutili', NULL),
(48, 12, 1, 2, 'Aada Siirsi 12£ tililtä käyttötili tilille FI12 3456 7890 987 65', NULL),
(49, 1, 2, 1, 'Aada Siirsi 1£ tililtä etutili tilille käyttötili', NULL),
(51, 14, 2, 1, 'Aada Siirsi 14£ tililtä etutili tilille käyttötili', NULL),
(52, 4, 1, 4, 'Aada Siirsi 4£ tililtä käyttötili tilille FI09 8765 4321 234 56', NULL),
(53, 1, 1, 2, 'Aada Siirsi 1£ tililtä käyttötili tilille etutili', NULL),
(54, 2, 1, 2, 'Aada Siirsi 2£ tililtä käyttötili tilille etutili', NULL),
(55, 2, 1, 4, 'Aada Siirsi 2£ tililtä käyttötili tilille FI09 8765 4321 234 56', NULL),
(56, 1, 1, 2, 'Aada Siirsi 1£ tililtä käyttötili tilille etutili', NULL),
(57, 1, 2, 1, 'Aada Siirsi 1£ tililtä etutili tilille FI21 1234 5600 000 76', '2024-12-13 09:02:52'),
(60, 1, 1, 1, 'Aada Siirsi 1£ tililtä käyttötili tilille FI21 1234 5600 000 76', '2024-12-13 09:38:56'),
(61, 1, 1, 1, 'Aada Siirsi 1£ tililtä käyttötili tilille FI21 1234 5600 000 76', '2024-12-13 09:39:21'),
(67, 1, 1, 1, 'Aada Siirsi 1£ tililtä FI21 1234 5600 000 76 tilille FI21 1234 5600 000 76', '2024-12-13 09:58:16'),
(68, 10, 2, 5, 'Aada Siirsi 10£ tililtä FI12 3456 7890 987 65 tilille FI5912723279897644', '2024-12-13 09:59:19'),
(69, 110, 5, 2, 'Sofia Siirsi 110£ tililtä FI5912723279897644 tilille FI12 3456 7890 987 65', '2024-12-13 10:00:15'),
(70, 1, 1, 2, 'Aada Siirsi 1£ tililtä käyttötili tilille etutili', '2024-12-13 10:00:27'),
(74, 1, 1, 1, 'Aada Siirsi 1£ tililtä FI21 1234 5600 000 76 tilille FI21 1234 5600 000 76', '2024-12-13 10:11:22'),
(76, 132, 1, 1, 'Aada Siirsi 132£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:13:19'),
(77, 321321, 1, 1, 'Aada Siirsi 321321£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:13:27'),
(78, 3213213, 1, 1, 'Aada Siirsi 3213213£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:13:31'),
(79, 321321321, 1, 1, 'Aada Siirsi 321321321£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:13:47'),
(80, 0, 1, 1, 'Aada Siirsi £ tililtä käyttötili tilille käyttötili', '2024-12-13 10:13:50'),
(81, 0, 1, 1, 'Aada Siirsi £ tililtä käyttötili tilille käyttötili', '2024-12-13 10:14:00'),
(82, 12, 1, 1, 'Aada Siirsi 12£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:17:58'),
(83, 1, 1, 1, 'Aada Siirsi 1£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:18:09'),
(84, 12, 1, 1, 'Aada Siirsi 12£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:18:12'),
(85, 999, 1, 1, 'Aada Siirsi 999£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:18:15'),
(86, 2147483647, 1, 1, 'Aada Siirsi 97658765876587568£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:18:18'),
(87, 1000, 1, 1, 'Aada Siirsi 1000£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:18:41'),
(88, 1000000000, 1, 1, 'Aada Siirsi 1000000000£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:18:44'),
(89, 2147483647, 1, 1, 'Aada Siirsi 1000000000000£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:18:48'),
(90, 2147483647, 1, 1, 'Aada Siirsi 432432143214£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:18:50'),
(91, 2147483647, 1, 1, 'Aada Siirsi 43214321432143214£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:18:53'),
(92, 2147483647, 1, 1, 'Aada Siirsi 432432143214321432143214£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:18:55'),
(93, 2147483647, 1, 1, 'Aada Siirsi 432143243214321432143211432143243£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:18:59'),
(95, 1, 1, 2, 'Aada Siirsi 1£ tililtä käyttötili tilille etutili', '2024-12-13 10:19:11'),
(96, 11, 1, 1, 'Aada Siirsi 11£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:19:15'),
(97, 3213213, 1, 2, 'Aada Siirsi 3213213£ tililtä käyttötili tilille etutili', '2024-12-13 10:19:18'),
(98, 2147483647, 1, 1, 'Aada Siirsi 213213213213213213£ tililtä FI21 1234 5600 000 76 tilille FI21 1234 5600 000 76', '2024-12-13 10:21:18'),
(99, 2132131, 1, 1, 'Aada Siirsi 2132131£ tililtä FI21 1234 5600 000 76 tilille FI21 1234 5600 000 76', '2024-12-13 10:21:40'),
(100, 11, 1, 1, 'Aada Siirsi 11£ tililtä FI21 1234 5600 000 76 tilille FI21 1234 5600 000 76', '2024-12-13 10:21:48'),
(101, 2147483647, 1, 1, 'Aada Siirsi 3213241321432143214321432143214321£ tililtä FI21 1234 5600 000 76 tilille FI21 1234 5600 000 76', '2024-12-13 10:21:56'),
(102, 1, 1, 1, 'Aada Siirsi 1£ tililtä käyttötili tilille käyttötili', '2024-12-13 10:22:51'),
(103, 0, 1, 1, 'Aada Siirsi £ tililtä käyttötili tilille käyttötili', '2024-12-13 10:23:07'),
(104, 97, 1, 2, 'Aada Siirsi 97£ tililtä  tilille ', '2024-12-16 08:44:53'),
(105, 97, 1, 2, 'Aada Siirsi 97£ tililtä  tilille ', '2024-12-16 08:45:31'),
(109, 97, 1, 2, 'Aada Siirsi 97£ tililtä käyttötili tilille ', '2024-12-16 08:51:10'),
(110, 97, 1, 2, 'Aada Siirsi 97£ tililtä käyttötili tilille etutili', '2024-12-16 08:51:38'),
(111, 97, 1, 2, 'Aada Siirsi 97£ tililtä käyttötili tilille etutili', '2024-12-16 08:51:49'),
(112, 97, 2, 1, 'Aada Siirsi 97£ tililtä etutili tilille käyttötili', '2024-12-16 08:51:55'),
(113, 97, 2, 1, 'Aada Siirsi 97£ tililtä etutili tilille käyttötili', '2024-12-16 09:17:33'),
(115, 1000, 2, 32, 'Aada Siirsi 1000£ tililtä FI12 3456 7890 987 65 tilille FI1033351125869550', '2024-12-16 12:34:30'),
(116, 100, 32, 31, 'Vili Siirsi 100£ tililtä etutili tilille käyttötili', '2024-12-16 12:34:49'),
(117, 100, 1, 2, 'Aada Siirsi 100£ tililtä käyttötili tilille etutili', '2024-12-16 13:41:05'),
(118, 100, 2, 1, 'Aada Siirsi 100£ tililtä etutili tilille käyttötili', '2024-12-16 13:41:20'),
(119, 1, 1, 41, 'Aada Siirsi 1£ tililtä käyttötili tilille testi', '2024-12-16 14:22:34'),
(120, 1, 41, 1, 'Aada Siirsi 1£ tililtä FI1267691940048199 tilille FI21 1234 5600 000 76', '2024-12-16 14:23:05'),
(121, 1, 1, 41, 'Aada Siirsi 1£ tililtä FI21 1234 5600 000 76 tilille FI1267691940048199', '2024-12-17 09:54:26'),
(122, 1, 41, 1, 'Aada Siirsi 1£ tililtä testi tilille käyttötili', '2024-12-17 09:54:34'),
(123, 2, 1, 41, 'Aada Siirsi 2£ tililtä FI21 1234 5600 000 76 tilille FI1267691940048199', '2024-12-17 09:56:02'),
(124, 2, 41, 1, 'Aada Siirsi 2£ tililtä testi tilille käyttötili', '2024-12-17 09:56:24');

--
-- Herättimet `tapahtumat`
--
DELIMITER $$
CREATE TRIGGER `update_tilit_receiver` BEFORE INSERT ON `tapahtumat` FOR EACH ROW BEGIN
    DECLARE receiver_deleted INT;

    -- Check if the receiver account is deleted
    SELECT deleted INTO receiver_deleted
    FROM tilit
    WHERE tili_id = NEW.reciver_account_id;

    -- If the receiver account is deleted, raise an error
    IF (receiver_deleted = 1 OR receiver_deleted = 2) THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Vastaanottajan tili on poistettu. Mitä nää koetat?';
    ELSE
        -- Update the receiver's account balance
        UPDATE tilit 
        SET amount = amount + NEW.amount 
        WHERE tili_id = NEW.reciver_account_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_tilit_sender` BEFORE INSERT ON `tapahtumat` FOR EACH ROW BEGIN
    DECLARE sender_balance FLOAT;
    
    SELECT amount INTO sender_balance
    FROM tilit
    WHERE tili_id = NEW.sender_account_id;
    
    IF sender_balance - NEW.amount < 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Tilillä ei ole tarpeeksi rahee';
    ELSE
        UPDATE tilit SET amount = amount - NEW.amount WHERE tili_id = NEW.sender_account_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Rakenne taululle `tilit`
--

CREATE TABLE `tilit` (
  `tili_id` int(11) NOT NULL,
  `tilinimi` varchar(255) NOT NULL,
  `IBAN` varchar(30) NOT NULL,
  `kayttaja_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `tilit`
--

INSERT INTO `tilit` (`tili_id`, `tilinimi`, `IBAN`, `kayttaja_id`, `amount`, `deleted`) VALUES
(1, 'käyttötili', 'FI21 1234 5600 000 76', 23, 100, 0),
(2, 'etutili', 'FI12 3456 7890 987 65', 23, 3600, 0),
(4, 'tuhlaustili', 'FI09 8765 4321 234 56', 24, 50, 0),
(5, 'etutili', 'FI5912723279897644', 24, 1900, 0),
(11, 'miut', 'FI8461093876018015', 24, 0, 1),
(31, 'käyttötili', 'FI9126150783300965', 53, 100, 0),
(32, 'etutili', 'FI1033351125869550', 53, 1000, 0),
(34, 'fsa', 'FI0410585696836383', 53, 0, 0),
(41, 'testi', 'FI1267691940048199', 23, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kayttajat`
--
ALTER TABLE `kayttajat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tapahtumat`
--
ALTER TABLE `tapahtumat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lähettävä_tili` (`sender_account_id`),
  ADD KEY `vastaanottava_tili` (`reciver_account_id`);

--
-- Indexes for table `tilit`
--
ALTER TABLE `tilit`
  ADD PRIMARY KEY (`tili_id`),
  ADD KEY `kayttaja_id` (`kayttaja_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kayttajat`
--
ALTER TABLE `kayttajat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tapahtumat`
--
ALTER TABLE `tapahtumat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `tilit`
--
ALTER TABLE `tilit`
  MODIFY `tili_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `tapahtumat`
--
ALTER TABLE `tapahtumat`
  ADD CONSTRAINT `tapahtumat_ibfk_2` FOREIGN KEY (`reciver_account_id`) REFERENCES `tilit` (`tili_id`),
  ADD CONSTRAINT `tapahtumat_ibfk_3` FOREIGN KEY (`sender_account_id`) REFERENCES `tilit` (`tili_id`);

--
-- Rajoitteet taululle `tilit`
--
ALTER TABLE `tilit`
  ADD CONSTRAINT `tilit_ibfk_1` FOREIGN KEY (`kayttaja_id`) REFERENCES `kayttajat` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
