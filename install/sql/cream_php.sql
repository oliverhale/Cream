-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2016 at 11:27 PM
-- Server version: 5.7.9
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cream_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_areas`
--

DROP TABLE IF EXISTS `access_areas`;
CREATE TABLE IF NOT EXISTS `access_areas` (
  `id` char(36) NOT NULL,
  `controller` char(32) NOT NULL,
  `method` char(32) NOT NULL,
  `created` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `access_templates`
--

DROP TABLE IF EXISTS `access_templates`;
CREATE TABLE IF NOT EXISTS `access_templates` (
  `id` char(36) NOT NULL,
  `access_area_id` char(36) NOT NULL,
  `entity_table` char(32) NOT NULL,
  `prim_key` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `address_line_1` varchar(200) NOT NULL,
  `address_line_2` varchar(200) NOT NULL,
  `address_line_3` varchar(200) NOT NULL,
  `city` varchar(100) NOT NULL,
  `sub_region_id` char(36) NOT NULL,
  `region_id` char(36) NOT NULL,
  `country_id` int(36) NOT NULL,
  `postal_code` char(10) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assoc_logs`
--

DROP TABLE IF EXISTS `assoc_logs`;
CREATE TABLE IF NOT EXISTS `assoc_logs` (
  `id` char(36) NOT NULL,
  `entity_table` char(30) NOT NULL,
  `prim_key` char(36) NOT NULL,
  `log_id` char(36) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` char(36) NOT NULL,
  `name` varchar(200) NOT NULL,
  `country_code` char(3) NOT NULL,
  `currency_code` char(3) NOT NULL,
  `currency_symbol` char(3) NOT NULL,
  `currency_symbol_html` char(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Uses ISO4217 and ISO3166-1';

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL,
  `name` varchar(36) NOT NULL,
  `entity_table` varchar(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `message` text NOT NULL,
  `data_before` text NOT NULL,
  `data_after` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` char(36) NOT NULL,
  `path` varchar(255) NOT NULL,
  `browser_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `content` text NOT NULL,
  `website_id` char(32) NOT NULL,
  `header` char(32) NOT NULL,
  `footer` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `path`, `browser_title`, `meta_description`, `meta_keywords`, `content`, `website_id`, `header`, `footer`) VALUES
('', '/hello/world', 'test test ', 'meta description', 'meta keywords', 'content', 'website id', 'header', 'footer'),
('0107BD3C-8C6C-E0F9-A229-97B0773C4891', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('068C3D47-AE8D-1B18-09FD-2085DB546BE7', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('0BBE5C1D-082D-ABBF-8029-24F468C79394', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('0D15D490-608F-B0C8-FCEB-41F42834CF49', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('10669B92-EA35-F671-D45E-281F3DDC52F4', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('170514A2-24D5-F194-1241-86034A792467', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('1D4EF0ED-DB16-5F45-812A-BEBF174D712B', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('3042ECA8-695B-0B3A-E0E6-6DC6CDAA65F6', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('40B021AB-13F2-A5D9-2A89-6F4E4E0D0223', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('451631CF-9C75-987F-E4DB-F89224676004', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('4D568122-94A6-AB32-CE56-4555216E52D4', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('533F1773-70A4-7976-3E41-2AE31E49FC92', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('5A17F5C4-1D81-6F5A-7ED4-F9000A5A3C3E', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('68A365DF-D222-D9A5-9A68-81B89E25DDCB', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('69716466-470C-365F-F91F-B6C2A7E2FBC8', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('71F942C0-9333-8773-F7CA-A33D8652E75E', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('7407EC25-FBA9-348C-1311-0F41E7C61878', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('7412FADD-D0E3-0B42-E3CC-DD7AB54BE4BB', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('7CD654E9-B4D6-4527-29DB-02F918E094B2', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('7DDB27A6-1239-4ABE-B470-7CD9C5B6B25D', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('88B0DF0C-5AD0-9649-41D7-EAC658FD6C0F', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('8CB702DE-F696-63ED-CC97-E1D448B7C658', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('98B46BB4-B086-8CCA-0337-62AFC7596721', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('A1255540-A834-0E3B-9FFB-EF46E4C1BBF2', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('A3FFC10C-CABC-EA27-E8F2-4637CE6DA06D', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('AC2E97AE-E0D3-A8CA-E37A-0E5C47B255E6', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('AC39B69D-316D-AA4A-9F9C-81D96571032B', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('ADF78FC9-4468-F193-1391-388E846B5D83', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('B49BB8DE-7F68-17A6-B2B6-F716725859E2', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('B543F0C8-EACF-99BC-2A5D-686CF5D3CC9F', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('B6A407A9-281E-C9C6-CCB4-DAC9DB9BCFD4', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('B7DD95D7-1678-6A92-F5AD-AD44E54834E9', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('CCA3CBE6-7707-F0E4-7BC8-3AB44C28B4BE', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('CD1ABCBE-0674-7638-4389-7747D730D543', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('DA6008F2-9D2F-B814-70FA-7CE4120CD4AA', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('DC4B053D-1D7B-8825-A622-19F2608D658C', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('E5C32CB4-05FB-753D-025B-26A801A3B6DD', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('E934CAB1-8EF5-A3D5-6BE1-F348C336B19E', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('EBC92B01-1D0F-237D-1802-D7A0E0BA89C4', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('F0085A36-2176-A4AE-F44B-398B9AB9981C', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('F198FA5F-0A97-8066-24C8-8524554679D8', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', ''),
('F6584709-F4B6-0624-5B92-D449F38F467F', '/test/', '/test/', '/test/', '/test/', '/test/', '/test/', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
CREATE TABLE IF NOT EXISTS `regions` (
  `id` char(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country_id` char(36) NOT NULL,
  `time_zone_id` char(36) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `security_questions`
--

DROP TABLE IF EXISTS `security_questions`;
CREATE TABLE IF NOT EXISTS `security_questions` (
  `id` char(36) NOT NULL,
  `question` varchar(200) NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(36) NOT NULL,
  `entity_table` varchar(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_regions`
--

DROP TABLE IF EXISTS `sub_regions`;
CREATE TABLE IF NOT EXISTS `sub_regions` (
  `id` char(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country_id` char(36) NOT NULL,
  `time_zone_id` char(36) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `time_zones`
--

DROP TABLE IF EXISTS `time_zones`;
CREATE TABLE IF NOT EXISTS `time_zones` (
  `id` char(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `offset` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` char(36) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `middle_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `dob` date NOT NULL,
  `username` varchar(36) NOT NULL,
  `password` char(36) NOT NULL,
  `email` varchar(200) NOT NULL,
  `security_question_a_id` char(36) NOT NULL,
  `security_answer_a` varchar(255) NOT NULL,
  `security_question_b_id` int(36) NOT NULL,
  `security_answer_b` varchar(255) NOT NULL,
  `last_login` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
CREATE TABLE IF NOT EXISTS `user_types` (
  `id` char(36) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `websites`
--

DROP TABLE IF EXISTS `websites`;
CREATE TABLE IF NOT EXISTS `websites` (
  `id` char(36) NOT NULL,
  `name` varchar(150) NOT NULL,
  `domain` varchar(75) NOT NULL,
  `website_id` char(36) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
