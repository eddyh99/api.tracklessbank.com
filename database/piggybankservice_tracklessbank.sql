-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2022 at 09:47 AM
-- Server version: 8.0.31
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `piggybankservice_tracklessbank`
--

-- --------------------------------------------------------

--
-- Table structure for table `bankmember`
--

CREATE TABLE `bankmember` (
  `id` int NOT NULL,
  `bank_name` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `site` varchar(100) NOT NULL,
  `ucode_mwallet` char(8) NOT NULL,
  `apikey` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bankmember`
--

INSERT INTO `bankmember` (`id`, `bank_name`, `address`, `site`, `ucode_mwallet`, `apikey`, `date_created`) VALUES
(1, 'Freedy Bank', '', 'https://freedybank.com', 'fr33dyb4', 'MgX7HTkke3KK70uVEwEc304ijKVcyoaaA4mjoFMT6Au3zXgoQM', '2022-10-27 04:24:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currency`
--

CREATE TABLE `tbl_currency` (
  `currency` varchar(5) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `min_amt` double NOT NULL,
  `status` enum('active','disabled') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_currency`
--

INSERT INTO `tbl_currency` (`currency`, `symbol`, `name`, `min_amt`, `status`) VALUES
('AED', 'AED', 'Arab Emirat Dirham', 0, 'active'),
('ARS', 'ARS', 'Argentine Peso\r\n', 150, 'active'),
('AUD', '&#8371;', 'Australian Dollar', 1, 'active'),
('BDT', 'BDT', 'Bangladesh Taka\r\n', 0, 'active'),
('BGN', 'BGN', 'Bulgarian lev', 5, 'active'),
('BWP', 'BWP', 'Botswana Pula', 200, 'active'),
('CAD', 'CAD', 'Canadian Dollar', 1, 'active'),
('CHF', 'CHF', 'Swiss Franc', 5, 'active'),
('CLP', 'CLP', 'Chilean Peso', 4500, 'active'),
('CNY', '&#20803;', 'Chinese Yuan', 10, 'active'),
('CRC', 'CRC', 'Costa Rican Colon', 2666, 'active'),
('CZK', 'CZK', 'Czech koruna', 5, 'active'),
('DKK', 'DKK', 'Danish Krone', 5, 'active'),
('EGP', 'EGP', 'Egyptian Pound', 34, 'active'),
('EUR', '&euro;', 'Euro', 1, 'active'),
('GBP', '&pound;', 'Pound sterling', 1, 'active'),
('GEL', 'GEL', 'Georgian lari', 5, 'active'),
('GHS', 'GHS', 'Ghanaian cedi', 10, 'active'),
('HKD', 'HKD', 'Hongkong Dollar', 5, 'active'),
('HRK', 'HRK', 'Croatian kuna', 5, 'active'),
('HUF', 'HUF', 'Hungarian Forint\r\n', 5, 'active'),
('IDR', 'Rp.', 'Indonesian Rupiah', 0, 'active'),
('ILS', '&#8362;', 'Israeli new shekel', 18, 'active'),
('INR', '&#8377;', 'Indian Rupee', 0, 'active'),
('JPY', '&yen;', 'Japanese Yen', 5, 'active'),
('KES', 'KES', 'Kenyan Shilling', 181, 'active'),
('KRW', '&#8361;', 'South Korea Won', 1541, 'active'),
('LKR', 'LKR', 'Sri Lankan Rupee', 164, 'active'),
('MAD', 'MAD', 'Moroccan dirham', 25, 'active'),
('MXN', 'MXN', 'Mexican Peso', 13, 'active'),
('MYR', 'MYR', 'Malaysian Ringgit', 0, 'active'),
('NGN', 'NGN', 'Nigerian Naira', 232, 'active'),
('NOK', 'NOK', 'Norwegian krone\r\n', 5, 'active'),
('NPR', 'NPR', 'Nepalese rupee', 323, 'active'),
('NZD', 'NZD', 'New Zealand dollar', 1, 'active'),
('PEN', 'PEN', 'Peruvian sol', 10, 'active'),
('PHP', 'PHP', 'Philippine peso', 12, 'active'),
('PKR', 'PKR', 'Pakistani Rupee', 0, 'active'),
('PLN', 'PLN', 'Polish złoty', 5, 'active'),
('RON', 'RON', 'Romanian Leu', 5, 'active'),
('RUB', '&#8381;', 'Russian Ruble', 141, 'active'),
('SEK', 'SEK', 'Swedish krona', 5, 'active'),
('SGD', 'S$', 'Singapore Dollar', 1, 'active'),
('THB', '&#3647;', 'Thailand Bath', 31, 'active'),
('TRY', '&#8378;', 'Turkish Lira', 0, 'active'),
('TZS', 'TZS', 'Tanzanian shilling', 0, 'active'),
('UAH', 'UAH', 'Ukrainian hryvnia', 5, 'active'),
('UGX', 'UGX', 'Ugandan shilling', 0, 'active'),
('USD', '&dollar;', 'US. Dollar', 1, 'active'),
('UYU', 'UYU', 'Uruguayan Peso', 164, 'active'),
('VND', '&#8363;', 'Vietnamese dong', 32538, 'active'),
('XOF', 'XOF', 'West African CFA franc', 2058, 'active'),
('ZAR', 'ZAR', 'South African rand\r\n', 87, 'active'),
('ZMW', 'ZMW', 'Zambian Kwacha', 71, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_defaultfee`
--

CREATE TABLE `tbl_defaultfee` (
  `bank_id` int NOT NULL,
  `currency` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `topup` decimal(9,2) NOT NULL DEFAULT '0.00',
  `wallet_sender` decimal(9,2) NOT NULL DEFAULT '0.00',
  `wallet_receiver` decimal(9,2) NOT NULL DEFAULT '0.00',
  `walletbank_circuit` decimal(9,2) NOT NULL DEFAULT '0.00',
  `walletbank_outside` decimal(9,2) NOT NULL DEFAULT '0.00',
  `swap` decimal(9,2) NOT NULL DEFAULT '0.00',
  `referral_send` decimal(9,2) NOT NULL DEFAULT '0.00',
  `referral_receive` decimal(9,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_defaultfee`
--

INSERT INTO `tbl_defaultfee` (`bank_id`, `currency`, `topup`, `wallet_sender`, `wallet_receiver`, `walletbank_circuit`, `walletbank_outside`, `swap`, `referral_send`, `referral_receive`) VALUES
(1, 'USD', '0.05', '0.05', '0.05', '0.05', '0.05', '0.05', '0.05', '0.05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_swap`
--

CREATE TABLE `tbl_master_swap` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `amount` decimal(9,2) NOT NULL DEFAULT '0.00',
  `currency` char(3) NOT NULL,
  `pbs_cost` decimal(9,2) NOT NULL DEFAULT '0.00',
  `target_cur` char(3) NOT NULL,
  `receive` decimal(9,2) NOT NULL DEFAULT '0.00',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_master_swap`
--

INSERT INTO `tbl_master_swap` (`id`, `user_id`, `amount`, `currency`, `pbs_cost`, `target_cur`, `receive`, `date_created`) VALUES
(1, 1, '1.00', 'USD', '0.05', 'AED', '3.45', '2022-11-16 22:11:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_withdraw`
--

CREATE TABLE `tbl_master_withdraw` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `currency` char(3) NOT NULL,
  `amount` decimal(9,2) NOT NULL,
  `pbs_cost` decimal(9,2) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member`
--

CREATE TABLE `tbl_member` (
  `id` int NOT NULL,
  `bank_id` int NOT NULL,
  `ucode` char(8) NOT NULL,
  `refcode` char(8) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `status` enum('new','active','disabled') NOT NULL DEFAULT 'new',
  `token` varchar(50) DEFAULT NULL,
  `id_referral` int DEFAULT NULL,
  `location` varchar(60) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_accessed` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_member`
--

INSERT INTO `tbl_member` (`id`, `bank_id`, `ucode`, `refcode`, `email`, `passwd`, `status`, `token`, `id_referral`, `location`, `date_created`, `last_accessed`) VALUES
(2, 1, 'dpjhzf7y', 'dr8hyfzn', 'eeinformationservices@gmail.com', '8a73c0282045064012c8d2fda5d7ecb9bf061304', 'active', '5zljnk2zw1y683g5xh3lj4qrzf469kvxwdpqx409vor5m7xy', NULL, 'Asia/Singapore', '2022-10-31 09:00:47', '2022-11-06 07:39:02'),
(3, 1, 'dqmtmfxn', 'dwwtxfxn', 'principe.nerini@gmail.com', 'bdf63bf2a1fca175a21cef756600365e23fadb8c', 'active', NULL, NULL, 'Asia/Singapore', '2022-10-31 19:43:50', '2022-11-01 14:47:43'),
(4, 1, 'dr2arf2x', 'dx7a4fr3', 'robertonolfo62@gmail.com', '0a80b8d8f7637e4ff4cc190298f564f79a08a492', 'active', NULL, NULL, 'Asia/Singapore', '2022-11-01 19:41:28', '2022-11-02 08:42:06'),
(5, 1, 'dw8b4f8w', 'dy7bjf4p', 'xlnklena@gmail.com', '5f1e976c158e6ad4d76c7932469beaeef957789a', 'new', '6q0k895zqolm32d1ztqrm1188u4v9w2vpe7xvpr1wnyj64jr', NULL, 'Asia/Singapore', '2022-11-02 03:01:15', '2022-11-02 16:01:15'),
(6, 1, 'dxyc2fyw', 'dzkcyf74', 'mamugeming00@gmail.com', '074b2b180ac38ba922054cedd56e6e3f72580145', 'active', '5y9j32wyn51mq0dzwuq69yk43cw05prl1dpk7r8lz6o4vxm6', NULL, 'Asia/Singapore', '2022-11-03 19:52:51', '2022-11-14 09:04:23'),
(10, 1, 'e3ma8fmk', 'e7ra4fjr', 'infoqrproject@gmail.com', '8a73c0282045064012c8d2fda5d7ecb9bf061304', 'active', NULL, NULL, 'Asia/Singapore', '2022-11-06 01:24:09', '2022-11-06 17:33:55'),
(16, 1, 'mw4a7fx7', 'p42apfkq', 'robnolfo62@gmail.com', '79eff894e3a2d24b46f56d082ea32fdc84e2566d', 'active', NULL, NULL, 'Asia/Singapore', '2022-11-06 03:58:11', '2022-11-06 18:00:53'),
(17, 1, 'n44b2f48', 'qxxbyfpy', 'lisette.paula8899@gmail.com', 'be17395c6d2fd7edeccbc62cdd5162319b032f42', 'active', NULL, NULL, 'Asia/Singapore', '2022-11-06 04:00:57', '2022-11-11 08:42:24'),
(19, 1, 'qxmfmfxn', 'w7wfxfxn', 'eddy_h99@yahoo.com', 'be17395c6d2fd7edeccbc62cdd5162319b032f42', 'active', NULL, 17, 'Asia/Singapore', '2022-11-10 23:09:45', '2022-11-11 13:10:07'),
(20, 1, 'rm2hrf2x', 'xx7h4fr3', 'nicola.santagata@outlook.it', '2f2588698d3e7b012dfe10ef6f085a52e0a25db4', 'active', NULL, NULL, 'Asia/Singapore', '2022-11-11 04:33:16', '2022-11-11 23:42:30'),
(21, 1, 'w78t4f8w', 'yy7tjf4p', 'norttrom@mail.ru', '05f4072af0d636f9e13cab32cdd98a5f65276489', 'active', NULL, NULL, 'Asia/Singapore', '2022-11-13 02:12:09', '2022-11-16 03:04:15'),
(23, 1, 'yypbkfq3', '2ynbrfpn', 'gemingvalentina@gmail.com', '074b2b180ac38ba922054cedd56e6e3f72580145', 'active', NULL, NULL, 'Asia/Singapore', '2022-11-14 18:57:03', '2022-11-15 09:11:22'),
(25, 1, '2ywfmf4q', '4wjf2fwq', 'pjake7450@gmail.com', '0a39ae59835ba32fbafd2db511331648d31c7159', 'active', NULL, NULL, 'Asia/Singapore', '2022-11-15 20:26:16', '2022-11-16 11:36:36'),
(26, 1, '37mh8fmk', '7zrh4fjr', 'gdeva3356@gmail.com', 'da989d7f28a2818f128388d19b3e5c47c08cfea4', 'new', '9mwznxl4pqv263ey3kbo52j5r4tkxxmrr2dj91komr78y50p', NULL, 'Asia/Singapore', '2022-11-16 00:41:24', '2022-11-16 14:41:24'),
(27, 1, '4wptpf82', '8qxtyf3j', 'simesmail@gmail.com', '067a4dd1bf7dba1a4490d261c15d0847400def8a', 'new', 'n8wm82k6l017jpgr5wcx14823ktjov49le5y9xoqz3vrn47x', NULL, 'Asia/Singapore', '2022-11-16 02:57:26', '2022-11-16 16:57:26'),
(28, 1, '7zya2fnw', 'j8jarfxw', 'peronemarco614@gmail.com', '7f78781a2ddb8b01695b15f5fa65d79877d5ad1b', 'active', NULL, NULL, 'Asia/Singapore', '2022-11-16 07:51:38', '2022-11-16 21:53:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member_currency`
--

CREATE TABLE `tbl_member_currency` (
  `id_member` int NOT NULL,
  `currency` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('active','disabled') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_member_currency`
--

INSERT INTO `tbl_member_currency` (`id_member`, `currency`, `status`) VALUES
(2, 'AED', 'active'),
(2, 'ARS', 'active'),
(2, 'AUD', 'active'),
(3, 'AED', 'active'),
(6, 'AED', 'active'),
(6, 'ARS', 'disabled'),
(6, 'AUD', 'disabled'),
(6, 'BDT', 'disabled'),
(6, 'SGD', 'active'),
(17, 'AED', 'active'),
(19, 'AED', 'disabled'),
(25, 'AED', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member_swap`
--

CREATE TABLE `tbl_member_swap` (
  `id` int NOT NULL,
  `id_member` int NOT NULL,
  `amount` decimal(9,2) NOT NULL DEFAULT '0.00',
  `currency` char(3) NOT NULL,
  `pbs_cost` decimal(9,2) NOT NULL DEFAULT '0.00',
  `fee` decimal(9,2) NOT NULL DEFAULT '0.00',
  `target_cur` char(3) NOT NULL,
  `receive` decimal(9,2) NOT NULL DEFAULT '0.00',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_member_swap`
--

INSERT INTO `tbl_member_swap` (`id`, `id_member`, `amount`, `currency`, `pbs_cost`, `fee`, `target_cur`, `receive`, `date_created`) VALUES
(1, 17, '5.00', 'USD', '0.05', '0.05', 'EUR', '4.78', '2022-11-11 14:45:41'),
(2, 17, '3.00', 'USD', '0.05', '0.05', 'AED', '10.54', '2022-11-11 14:46:05'),
(3, 23, '1.80', 'USD', '0.05', '0.05', 'EUR', '1.64', '2022-11-15 13:58:43'),
(4, 23, '1.00', 'USD', '0.05', '0.05', 'EUR', '0.86', '2022-11-15 14:19:53'),
(5, 6, '1.00', 'USD', '0.05', '0.05', 'EUR', '0.86', '2022-11-15 14:53:23'),
(6, 6, '1.00', 'USD', '0.05', '0.05', 'AED', '3.27', '2022-11-16 08:07:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member_tobank`
--

CREATE TABLE `tbl_member_tobank` (
  `id` int NOT NULL,
  `sender_id` int NOT NULL,
  `type` enum('circuit','outside') NOT NULL,
  `receiver_name` varchar(100) NOT NULL,
  `IBAN` varchar(30) NOT NULL,
  `BIC` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bank_name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `receiver_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `amount` decimal(9,2) NOT NULL DEFAULT '0.00',
  `currency` char(3) NOT NULL,
  `pbs_cost` decimal(9,2) NOT NULL DEFAULT '0.00',
  `wise_cost` decimal(9,2) NOT NULL DEFAULT '0.00',
  `fee` decimal(9,2) NOT NULL DEFAULT '0.00',
  `referral_fee` decimal(9,2) NOT NULL DEFAULT '0.00',
  `causal` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_member_tobank`
--

INSERT INTO `tbl_member_tobank` (`id`, `sender_id`, `type`, `receiver_name`, `IBAN`, `BIC`, `bank_name`, `receiver_address`, `amount`, `currency`, `pbs_cost`, `wise_cost`, `fee`, `referral_fee`, `causal`, `date_created`) VALUES
(1, 17, 'circuit', 'Agus', '123', NULL, NULL, NULL, '10.00', 'USD', '0.05', '0.00', '0.05', '0.05', 'testing', '2022-11-14 12:18:43'),
(2, 17, 'circuit', 'Agus budiman', '13719713158835300', '041215032', '', '2607 County Line Road', '1.00', 'USD', '0.05', '0.00', '0.05', '0.05', 'test', '2022-11-16 23:27:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member_topup`
--

CREATE TABLE `tbl_member_topup` (
  `id` int NOT NULL,
  `id_member` int NOT NULL,
  `amount` decimal(9,2) NOT NULL,
  `currency` char(3) NOT NULL,
  `pbs_cost` decimal(9,2) NOT NULL DEFAULT '0.00',
  `fee` decimal(9,2) NOT NULL DEFAULT '0.00',
  `referral_fee` decimal(9,2) NOT NULL DEFAULT '0.00',
  `admin_id` int NOT NULL,
  `type` enum('circuit','outside') NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_member_topup`
--

INSERT INTO `tbl_member_topup` (`id`, `id_member`, `amount`, `currency`, `pbs_cost`, `fee`, `referral_fee`, `admin_id`, `type`, `date_created`) VALUES
(1, 17, '50.00', 'USD', '0.05', '0.05', '0.05', 0, 'circuit', '2022-11-14 12:17:55'),
(2, 6, '1000.00', 'USD', '0.00', '0.00', '0.00', 0, 'circuit', '2022-11-15 09:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member_towallet`
--

CREATE TABLE `tbl_member_towallet` (
  `id` int NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `amount` decimal(9,2) NOT NULL,
  `currency` char(3) NOT NULL,
  `pbs_sender_cost` decimal(9,2) NOT NULL DEFAULT '0.00',
  `sender_fee` decimal(9,2) NOT NULL DEFAULT '0.00',
  `pbs_receiver_cost` decimal(9,2) NOT NULL DEFAULT '0.00',
  `receiver_fee` decimal(9,2) NOT NULL DEFAULT '0.00',
  `referral_sender_fee` decimal(9,2) NOT NULL DEFAULT '0.00',
  `referral_receiver_fee` decimal(9,2) NOT NULL DEFAULT '0.00',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_member_towallet`
--

INSERT INTO `tbl_member_towallet` (`id`, `sender_id`, `receiver_id`, `amount`, `currency`, `pbs_sender_cost`, `sender_fee`, `pbs_receiver_cost`, `receiver_fee`, `referral_sender_fee`, `referral_receiver_fee`, `date_created`) VALUES
(1, 17, 19, '10.00', 'USD', '0.05', '0.05', '0.05', '0.05', '0.05', '0.05', '2022-11-14 12:19:30'),
(2, 6, 23, '0.10', 'USD', '0.05', '0.05', '0.05', '0.05', '0.05', '0.05', '2022-11-15 10:44:36'),
(3, 6, 23, '10.00', 'USD', '0.05', '0.05', '0.05', '0.05', '0.05', '0.05', '2022-11-15 10:54:48'),
(4, 6, 23, '0.10', 'USD', '0.05', '0.05', '0.05', '0.05', '0.05', '0.05', '2022-11-15 10:56:15'),
(5, 6, 23, '12.00', 'USD', '0.05', '0.05', '0.05', '0.05', '0.05', '0.05', '2022-11-15 11:03:51'),
(7, 17, 19, '1.00', 'USD', '0.05', '0.05', '0.05', '0.05', '0.05', '0.05', '2022-11-17 07:02:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tracklessbank`
--

CREATE TABLE `tbl_tracklessbank` (
  `currency` varchar(5) NOT NULL,
  `c_registered_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `c_account_number` varchar(100) NOT NULL,
  `c_routing_number` varchar(100) NOT NULL,
  `c_bank_name` varchar(100) DEFAULT NULL,
  `c_bank_address` varchar(200) DEFAULT NULL,
  `oc_registered_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `oc_iban` varchar(20) NOT NULL,
  `oc_bic` varchar(20) NOT NULL,
  `oc_bank_name` varchar(100) DEFAULT NULL,
  `oc_bank_address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int NOT NULL,
  `bank_id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwd` char(40) NOT NULL,
  `role` enum('admin','super admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'admin',
  `status` enum('active','disabled') NOT NULL DEFAULT 'active',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_accessed` datetime DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `bank_id`, `name`, `email`, `passwd`, `role`, `status`, `date_created`, `last_accessed`, `location`) VALUES
(1, 1, 'si+', 'f@f.f', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin', 'active', '2022-08-15 00:52:03', NULL, 'Asia/Makassar');

-- --------------------------------------------------------

--
-- Table structure for table `trackless_fee`
--

CREATE TABLE `trackless_fee` (
  `id` int NOT NULL,
  `bank_id` int NOT NULL,
  `currency` char(3) NOT NULL,
  `topup` decimal(9,2) NOT NULL DEFAULT '0.00',
  `wallet_sender` decimal(9,2) NOT NULL DEFAULT '0.00',
  `wallet_receiver` decimal(9,2) NOT NULL DEFAULT '0.00',
  `walletbank_circuit` decimal(9,2) NOT NULL DEFAULT '0.00',
  `walletbank_outside` decimal(9,2) NOT NULL DEFAULT '0.00',
  `swap` decimal(9,2) NOT NULL DEFAULT '0.00',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `trackless_fee`
--

INSERT INTO `trackless_fee` (`id`, `bank_id`, `currency`, `topup`, `wallet_sender`, `wallet_receiver`, `walletbank_circuit`, `walletbank_outside`, `swap`, `date_created`, `last_update`) VALUES
(1, 1, 'USD', '0.05', '0.05', '0.05', '0.05', '0.05', '0.05', '2022-11-11 12:45:53', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `wise_cost`
--

CREATE TABLE `wise_cost` (
  `currency` varchar(5) NOT NULL,
  `transfer_cf` decimal(9,2) NOT NULL DEFAULT '0.00',
  `transfer_ocf` decimal(9,2) NOT NULL DEFAULT '0.00',
  `min_amount` decimal(9,2) NOT NULL DEFAULT '0.00',
  `last_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wise_cost`
--

INSERT INTO `wise_cost` (`currency`, `transfer_cf`, `transfer_ocf`, `min_amount`, `last_modified`) VALUES
('AED', '5.62', '0.00', '6.62', '2022-08-24 21:55:07'),
('ARS', '124.25', '0.00', '125.25', '2022-08-24 21:55:07'),
('AUD', '0.57', '0.00', '1.57', '2022-08-24 21:55:08'),
('BDT', '145.39', '0.00', '146.39', '2022-08-24 21:55:08'),
('BGN', '0.84', '0.00', '1.84', '2022-08-24 21:55:08'),
('BWP', '60.07', '0.00', '61.07', '2022-08-24 21:55:09'),
('CAD', '0.61', '0.00', '1.61', '2022-08-24 21:55:09'),
('CHF', '0.50', '0.00', '1.50', '2022-08-24 21:55:10'),
('CLP', '3374.99', '0.00', '3376.00', '2022-08-24 21:55:10'),
('CNY', '4.27', '0.00', '5.27', '2022-08-24 21:55:11'),
('CRC', '2665.34', '0.00', '2666.41', '2022-08-24 21:55:11'),
('CZK', '7.99', '0.00', '8.99', '2022-08-24 21:55:12'),
('DKK', '2.92', '0.00', '3.92', '2022-08-24 21:55:12'),
('EGP', '33.50', '0.00', '34.50', '2022-08-24 21:55:13'),
('EUR', '0.28', '3.83', '1.28', '2022-08-24 21:55:14'),
('GBP', '0.32', '0.00', '1.32', '2022-08-24 21:55:14'),
('GEL', '0.73', '0.00', '1.73', '2022-08-24 21:55:14'),
('GHS', '9.02', '0.00', '10.02', '2022-08-24 21:55:15'),
('HKD', '5.33', '0.00', '6.33', '2022-08-24 21:55:15'),
('HRK', '8.44', '0.00', '9.44', '2022-08-24 21:55:16'),
('HUF', '88.00', '0.00', '89.00', '2022-08-24 21:55:16'),
('IDR', '9145.09', '0.00', '9146.00', '2022-08-24 21:55:17'),
('ILS', '17.95', '0.00', '18.95', '2022-08-24 21:55:17'),
('INR', '30.03', '0.00', '31.03', '2022-08-24 21:55:18'),
('JPY', '200.00', '0.00', '201.00', '2022-08-24 21:55:18'),
('KES', '180.00', '0.00', '181.00', '2022-08-24 21:55:18'),
('KRW', '1449.98', '0.00', '1451.00', '2022-08-24 21:55:19'),
('LKR', '163.83', '0.00', '164.84', '2022-08-24 21:55:19'),
('MAD', '24.28', '0.00', '25.28', '2022-08-24 21:55:20'),
('MXN', '14.28', '0.00', '15.28', '2022-08-24 21:55:20'),
('MYR', '1.34', '0.00', '2.34', '2022-08-24 21:55:21'),
('NGN', '231.44', '0.00', '232.44', '2022-08-24 21:55:21'),
('NOK', '3.25', '0.00', '4.25', '2022-08-24 21:55:22'),
('NPR', '322.00', '0.00', '323.00', '2022-08-24 21:55:22'),
('NZD', '0.76', '0.00', '1.76', '2022-08-24 21:55:22'),
('PEN', '9.45', '0.00', '10.45', '2022-08-24 21:55:23'),
('PHP', '43.92', '0.00', '44.92', '2022-08-24 21:55:23'),
('PKR', '108.15', '0.00', '109.15', '2022-08-24 21:55:24'),
('PLN', '1.82', '0.00', '2.82', '2022-08-24 21:55:24'),
('RON', '2.67', '0.00', '3.67', '2022-08-24 21:55:25'),
('RUB', '140.11', '0.00', '141.11', '2022-08-24 21:55:25'),
('SEK', '3.83', '0.00', '4.83', '2022-08-24 21:55:25'),
('SGD', '0.61', '0.00', '1.61', '2022-08-24 21:55:26'),
('THB', '31.70', '0.00', '32.70', '2022-08-24 21:55:26'),
('TRY', '24.34', '0.00', '25.34', '2022-08-24 21:55:27'),
('TZS', '3012.40', '0.00', '3013.30', '2022-08-24 21:55:27'),
('UAH', '7.20', '0.00', '8.20', '2022-08-24 21:55:28'),
('UGX', '4419.12', '0.00', '4420.00', '2022-08-24 21:55:28'),
('USD', '0.39', '3.29', '1.39', '2022-08-24 21:55:29'),
('UYU', '163.30', '0.00', '164.30', '2022-08-24 21:55:30'),
('VND', '32538.00', '0.00', '32538.00', '2022-08-24 21:55:30'),
('XOF', '2056.97', '0.00', '2058.00', '2022-08-24 21:55:31'),
('ZAR', '86.34', '0.00', '87.34', '2022-08-24 21:55:31'),
('ZMW', '70.72', '0.00', '71.72', '2022-08-24 21:55:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bankmember`
--
ALTER TABLE `bankmember`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_currency`
--
ALTER TABLE `tbl_currency`
  ADD PRIMARY KEY (`currency`);

--
-- Indexes for table `tbl_defaultfee`
--
ALTER TABLE `tbl_defaultfee`
  ADD PRIMARY KEY (`bank_id`,`currency`),
  ADD KEY `tbl_defaultfee_ibfk_2` (`currency`);

--
-- Indexes for table `tbl_master_swap`
--
ALTER TABLE `tbl_master_swap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `currency` (`currency`),
  ADD KEY `target_cur` (`target_cur`);

--
-- Indexes for table `tbl_master_withdraw`
--
ALTER TABLE `tbl_master_withdraw`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency` (`currency`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_member`
--
ALTER TABLE `tbl_member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ucode` (`ucode`),
  ADD UNIQUE KEY `refcode` (`refcode`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_referral` (`id_referral`) USING BTREE,
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `tbl_member_currency`
--
ALTER TABLE `tbl_member_currency`
  ADD PRIMARY KEY (`id_member`,`currency`),
  ADD KEY `currency` (`currency`);

--
-- Indexes for table `tbl_member_swap`
--
ALTER TABLE `tbl_member_swap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `currency` (`currency`),
  ADD KEY `target_cur` (`target_cur`);

--
-- Indexes for table `tbl_member_tobank`
--
ALTER TABLE `tbl_member_tobank`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `currency` (`currency`);

--
-- Indexes for table `tbl_member_topup`
--
ALTER TABLE `tbl_member_topup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency` (`currency`),
  ADD KEY `id_member` (`id_member`) USING BTREE;

--
-- Indexes for table `tbl_member_towallet`
--
ALTER TABLE `tbl_member_towallet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `currency` (`currency`);

--
-- Indexes for table `tbl_tracklessbank`
--
ALTER TABLE `tbl_tracklessbank`
  ADD PRIMARY KEY (`currency`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `trackless_fee`
--
ALTER TABLE `trackless_fee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_id` (`bank_id`),
  ADD KEY `currency` (`currency`);

--
-- Indexes for table `wise_cost`
--
ALTER TABLE `wise_cost`
  ADD PRIMARY KEY (`currency`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bankmember`
--
ALTER TABLE `bankmember`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_master_swap`
--
ALTER TABLE `tbl_master_swap`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_master_withdraw`
--
ALTER TABLE `tbl_master_withdraw`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_member`
--
ALTER TABLE `tbl_member`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_member_swap`
--
ALTER TABLE `tbl_member_swap`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_member_tobank`
--
ALTER TABLE `tbl_member_tobank`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_member_topup`
--
ALTER TABLE `tbl_member_topup`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_member_towallet`
--
ALTER TABLE `tbl_member_towallet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trackless_fee`
--
ALTER TABLE `trackless_fee`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_defaultfee`
--
ALTER TABLE `tbl_defaultfee`
  ADD CONSTRAINT `tbl_defaultfee_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `bankmember` (`id`),
  ADD CONSTRAINT `tbl_defaultfee_ibfk_2` FOREIGN KEY (`currency`) REFERENCES `tbl_currency` (`currency`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tbl_master_swap`
--
ALTER TABLE `tbl_master_swap`
  ADD CONSTRAINT `tbl_master_swap_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`),
  ADD CONSTRAINT `tbl_master_swap_ibfk_2` FOREIGN KEY (`currency`) REFERENCES `tbl_currency` (`currency`),
  ADD CONSTRAINT `tbl_master_swap_ibfk_3` FOREIGN KEY (`target_cur`) REFERENCES `tbl_currency` (`currency`);

--
-- Constraints for table `tbl_master_withdraw`
--
ALTER TABLE `tbl_master_withdraw`
  ADD CONSTRAINT `tbl_master_withdraw_ibfk_2` FOREIGN KEY (`currency`) REFERENCES `tbl_currency` (`currency`),
  ADD CONSTRAINT `tbl_master_withdraw_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`);

--
-- Constraints for table `tbl_member`
--
ALTER TABLE `tbl_member`
  ADD CONSTRAINT `tbl_member_ibfk_1` FOREIGN KEY (`id_referral`) REFERENCES `tbl_member` (`id`),
  ADD CONSTRAINT `tbl_member_ibfk_2` FOREIGN KEY (`bank_id`) REFERENCES `bankmember` (`id`);

--
-- Constraints for table `tbl_member_currency`
--
ALTER TABLE `tbl_member_currency`
  ADD CONSTRAINT `tbl_member_currency_ibfk_1` FOREIGN KEY (`currency`) REFERENCES `tbl_currency` (`currency`),
  ADD CONSTRAINT `tbl_member_currency_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `tbl_member` (`id`);

--
-- Constraints for table `tbl_member_swap`
--
ALTER TABLE `tbl_member_swap`
  ADD CONSTRAINT `tbl_member_swap_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `tbl_member` (`id`),
  ADD CONSTRAINT `tbl_member_swap_ibfk_2` FOREIGN KEY (`currency`) REFERENCES `tbl_currency` (`currency`),
  ADD CONSTRAINT `tbl_member_swap_ibfk_3` FOREIGN KEY (`target_cur`) REFERENCES `tbl_currency` (`currency`);

--
-- Constraints for table `tbl_member_tobank`
--
ALTER TABLE `tbl_member_tobank`
  ADD CONSTRAINT `tbl_member_tobank_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `tbl_member` (`id`),
  ADD CONSTRAINT `tbl_member_tobank_ibfk_2` FOREIGN KEY (`currency`) REFERENCES `tbl_currency` (`currency`);

--
-- Constraints for table `tbl_member_topup`
--
ALTER TABLE `tbl_member_topup`
  ADD CONSTRAINT `tbl_member_topup_ibfk_1` FOREIGN KEY (`currency`) REFERENCES `tbl_currency` (`currency`),
  ADD CONSTRAINT `tbl_member_topup_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `tbl_member` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tbl_member_towallet`
--
ALTER TABLE `tbl_member_towallet`
  ADD CONSTRAINT `tbl_member_towallet_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `tbl_member` (`id`),
  ADD CONSTRAINT `tbl_member_towallet_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `tbl_member` (`id`),
  ADD CONSTRAINT `tbl_member_towallet_ibfk_3` FOREIGN KEY (`currency`) REFERENCES `tbl_currency` (`currency`);

--
-- Constraints for table `tbl_tracklessbank`
--
ALTER TABLE `tbl_tracklessbank`
  ADD CONSTRAINT `tbl_tracklessbank_ibfk_1` FOREIGN KEY (`currency`) REFERENCES `tbl_currency` (`currency`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `bankmember` (`id`);

--
-- Constraints for table `trackless_fee`
--
ALTER TABLE `trackless_fee`
  ADD CONSTRAINT `trackless_fee_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `bankmember` (`id`),
  ADD CONSTRAINT `trackless_fee_ibfk_2` FOREIGN KEY (`currency`) REFERENCES `tbl_currency` (`currency`);

--
-- Constraints for table `wise_cost`
--
ALTER TABLE `wise_cost`
  ADD CONSTRAINT `wise_cost_ibfk_1` FOREIGN KEY (`currency`) REFERENCES `tbl_currency` (`currency`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
