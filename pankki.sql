-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11.12.2024 klo 13:35
-- Palvelimen versio: 10.4.27-MariaDB
-- PHP Version: 8.1.12

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
  `kayttajatunnus` varchar(255) NOT NULL,
  `salasana` varchar(255) NOT NULL,
  `nimi` varchar(100) NOT NULL,
  `ika` tinyint(120) NOT NULL,
  `sukupuoli` tinyint(5) NOT NULL,
  `varat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `kayttajat`
--

INSERT INTO `kayttajat` (`id`, `kayttajatunnus`, `salasana`, `nimi`, `ika`, `sukupuoli`, `varat`) VALUES
(23, '123', '223', 'Aada', 5, 2, 239),
(24, '223', '123', 'Sofia', 12, 1, 256),
(25, '', '', 'Väinö', 2, 0, 602);

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
(11, 5, 2, 1, 'Aada teki 5£ omasiirron tililtä: e tilille: k', NULL),
(12, 10, 2, 1, 'Aada teki 10£ omasiirron tililtä: etutili tilille: käyttötili', NULL),
(14, 1, 2, 1, 'Aada teki 1£ tilisiirron tililtä: etutili tilille: käyttötili', NULL),
(15, 1, 4, 1, 'Aada teki 1£ tilisiirron tililtä: tuhlaustili tilille: käyttötili', NULL),
(16, 2, 1, 4, 'Aada teki 2£ tilisiirron tililtä: tuhlaustili tilille: käyttötili', NULL),
(19, 2, 4, 5, 'Sofia Siirsi 2£ tililtä tuhlaustili tilille etutili', NULL),
(20, 10, 4, 2, 'Sofia Siirsi 10£ tililtä tuhlaustili tilille FI12 3456 7890 987 65', NULL),
(21, 2, 1, 2, 'Aada Siirsi 2£ tililtä käyttötili tilille etutili', '2024-12-11 00:00:00'),
(22, 3, 2, 1, 'Aada Siirsi 3£ tililtä etutili tilille käyttötili', '2024-12-11 00:00:00'),
(23, 10, 1, 4, 'Aada Siirsi 10£ tililtä käyttötili tilille FI09 8765 4321 234 56', '2024-12-11 00:00:00'),
(24, 12, 4, 4, 'Sofia Siirsi 12£ tililtä tuhlaustili tilille FI09 8765 4321 234 56', '2024-12-11 00:00:00'),
(28, 0, 4, 4, 'Sofia Siirsi £ tililtä tuhlaustili tilille tuhlaustili', '2024-12-11 00:00:00'),
(29, 0, 4, 4, 'Sofia Siirsi £ tililtä tuhlaustili tilille tuhlaustili', '2024-12-11 00:00:00'),
(30, 1, 4, 5, 'Sofia Siirsi 1£ tililtä tuhlaustili tilille etutili', '2024-12-11 00:00:00'),
(31, 1, 4, 5, 'Sofia Siirsi 1£ tililtä tuhlaustili tilille etutili', '2024-12-11 00:00:00'),
(32, 1, 5, 4, 'Sofia Siirsi 1£ tililtä etutili tilille tuhlaustili', '2024-12-11 00:00:00'),
(33, 1, 4, 5, 'Sofia Siirsi 1£ tililtä tuhlaustili tilille etutili', '2024-12-11 12:13:21'),
(35, 21, 4, 2, 'Sofia Siirsi 21£ tililtä tuhlaustili tilille FI12 3456 7890 987 65', '2024-12-11 12:36:44');

--
-- Herättimet `tapahtumat`
--
DELIMITER $$
CREATE TRIGGER `update_tilit_receiver` BEFORE INSERT ON `tapahtumat` FOR EACH ROW UPDATE tilit SET amount = amount + NEW.amount WHERE tili_id = NEW.reciver_account_id
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
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `tilit`
--

INSERT INTO `tilit` (`tili_id`, `tilinimi`, `IBAN`, `kayttaja_id`, `amount`) VALUES
(1, 'käyttötili', 'FI21 1234 5600 000 76', 23, 10),
(2, 'etutili', 'FI12 3456 7890 987 65', 23, 250),
(4, 'tuhlausili', 'FI09 8765 4321 234 56', 24, 25),
(5, 'etutili', '', 24, 213);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tapahtumat`
--
ALTER TABLE `tapahtumat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tilit`
--
ALTER TABLE `tilit`
  MODIFY `tili_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
