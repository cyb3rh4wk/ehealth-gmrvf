-- phpMyAdmin SQL Dump
-- version 4.0.10.10
-- http://www.phpmyadmin.net
--
-- Host: 127.12.229.2:3306
-- Generation Time: Jul 13, 2015 at 03:00 PM
-- Server version: 5.5.41
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ehealth`
--

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE IF NOT EXISTS `diagnosis` (
  `diag_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_pid` varchar(12) NOT NULL DEFAULT '',
  `created` date NOT NULL,
  `p_prediag` varchar(255) DEFAULT NULL,
  `p_curr_diag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`diag_id`,`p_pid`),
  UNIQUE KEY `diag_id` (`diag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `p_pid` varchar(12) NOT NULL DEFAULT '',
  `p_genetic_problem` varchar(255) DEFAULT NULL,
  `p_smoke` tinyint(4) DEFAULT NULL,
  `p_alcohol` tinyint(4) DEFAULT NULL,
  `p_betel` tinyint(4) DEFAULT NULL,
  `p_spicy` tinyint(4) DEFAULT NULL,
  `p_junk` tinyint(4) DEFAULT NULL,
  `p_less_sleep` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`p_pid`),
  UNIQUE KEY `p_pid` (`p_pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `p_pid` varchar(12) NOT NULL,
  `image_path_small` text,
  `image_path_medium` text,
  PRIMARY KEY (`p_pid`),
  UNIQUE KEY `p_pid` (`p_pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `investigation`
--

CREATE TABLE IF NOT EXISTS `investigation` (
  `inv_id` int(12) NOT NULL AUTO_INCREMENT,
  `p_pid` varchar(12) NOT NULL,
  `created` date NOT NULL,
  `p_rbs` tinyint(4) DEFAULT NULL,
  `p_cbp` tinyint(4) DEFAULT NULL,
  `p_fbs` tinyint(4) DEFAULT NULL,
  `p_plbs` tinyint(4) DEFAULT NULL,
  `p_ecg` tinyint(4) DEFAULT NULL,
  `p_xray` tinyint(4) DEFAULT NULL,
  `p_esr` tinyint(4) DEFAULT NULL,
  `p_cue` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`inv_id`,`p_pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE IF NOT EXISTS `medicine` (
  `medicine_code` varchar(10) NOT NULL,
  `medicine_name` varchar(255) DEFAULT NULL,
  `medicine_remain` int(11) DEFAULT NULL,
  PRIMARY KEY (`medicine_code`),
  UNIQUE KEY `medicine_code` (`medicine_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`medicine_code`, `medicine_name`, `medicine_remain`) VALUES
('AMLO25', 'Amlo 2.5mg', 0),
('AMLO50', 'Amlo 5mG', 0),
('AMOX125', 'Amoxycillin 125mg', 0),
('AMOX250', 'Amoxycillin 250mg', 0),
('AMOX500', 'Amoxycillin 500mg', 0),
('ANTA', 'Antacid', 0),
('ASTHA', 'Asthalin', 0),
('ATEN50', 'Aten 50', 0),
('AZITH500', 'Azithral 500mg', 0),
('BCOMP', 'B.Complex', 0),
('BISAC', 'Bisacodyl', 0),
('CAL500', 'Calcium 500', 0),
('CEFX200', 'Cefixime 200mg', 0),
('CETRIZ', 'Cetrizin', 0),
('CHLORZX', 'Chlorzoxazone (Mobizox)', 0),
('CINNZ', 'Cinnarzine', 0),
('CIPLOX', 'Ciplox E/E drops', 0),
('CLOTRI', 'Clotrimazole tab', 0),
('COGHSYP', 'Cough syp', 0),
('DEFC6', 'Defcort 6mg', 0),
('DICLOGEL', 'Diclo gel (Enflam gel)', 0),
('DICLOPCM', 'Diclo +PCM', 0),
('DICLOSOD', 'Diclofenac sodium', 0),
('DICYHYD', 'Dicyclomine Hydrochloride', 0),
('DOMSTAL', 'Domstal', 0),
('ENAM5', 'Enam 5mg', 0),
('GLYN5', 'Glynase 5mg', 0),
('GLYNMET', 'Glynase+Metformin', 0),
('IRONTAB', 'Iron tab', 0),
('KARVOL', 'Karvol plus capsules', 0),
('LOPERA', 'Loperamide', 0),
('MET500', 'Metformin 500mg', 0),
('METRO400', 'Metrogyl 400mg', 0),
('MICONOINT', 'Miconazole oint.', 0),
('NOR400', 'Norflox 400mg', 0),
('OFLOX', 'Oflox-oz tab', 0),
('ORS', 'ORS powder', 0),
('PAN40', 'Pan 40mg', 0),
('PCM', 'PCM', 0),
('PCM650', 'Pcm 650', 0),
('POVIOD', 'Povidone iodine', 0),
('RAN150', 'Rantac 150mg', 0),
('RIBO', 'Riboflavine', 0),
('SERA', 'Seratiopeptidase', 0),
('SYPAMO', 'Syp.Amoxycillin', 0),
('SYPAUG', 'Syp.Augumentin', 0),
('SYPAZIT', 'Syp.Azithral', 0),
('SYPBCOM', 'Syp.B.complex', 0),
('SYPCAL', 'Syp.Calcium ', 0),
('SYPCET', 'Syp.Cetrizine', 0),
('SYPDOM', 'Syp.Domstal', 0),
('SYPOFLOX', 'Syp.Oflox ', 0),
('SYPOFOZ', 'Syp.Oflox-oz', 0),
('SYPPCM', 'Syp.PCM', 0),
('SYPZINCO', 'Syp.Zincovit', 0),
('TINI', 'Tinidazole', 0),
('ZINC', 'Zincovit', 0);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `p_pid` varchar(12) NOT NULL,
  `p_first_name` varchar(55) NOT NULL,
  `p_last_name` varchar(55) NOT NULL,
  `p_father_name` varchar(15) NOT NULL,
  `p_mother_name` varchar(15) NOT NULL,
  `p_dob` date NOT NULL,
  `p_sex` int(11) NOT NULL,
  `p_address_street` varchar(255) NOT NULL,
  `p_address_pincode` varchar(6) NOT NULL,
  `p_address_state` varchar(40) NOT NULL,
  `p_address_country` varchar(40) NOT NULL,
  `p_contact` varchar(10) DEFAULT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`p_pid`),
  UNIQUE KEY `p_pid` (`p_pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `symptoms`
--

CREATE TABLE IF NOT EXISTS `symptoms` (
  `sym_id` int(12) NOT NULL AUTO_INCREMENT,
  `p_pid` varchar(12) NOT NULL,
  `created` date NOT NULL,
  `p_sym1` varchar(255) DEFAULT NULL,
  `p_sym2` varchar(255) DEFAULT NULL,
  `p_sym3` varchar(255) DEFAULT NULL,
  `p_sym4` varchar(255) DEFAULT NULL,
  `p_sym5` varchar(255) DEFAULT NULL,
  `p_sym6` varchar(255) DEFAULT NULL,
  `p_sym7` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sym_id`),
  UNIQUE KEY `sym_id` (`sym_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(32) NOT NULL COMMENT 'Username of the Member',
  `password` varchar(32) NOT NULL COMMENT 'Password of the Member',
  `email` varchar(255) NOT NULL COMMENT 'E-Mail of the Member',
  `verified` tinyint(1) NOT NULL COMMENT 'If user is verified',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `verified`) VALUES
('admin', 'admin', 'gmrvf.cel@gmail.com', 1),
('ehealth.gmrvf.0a', 'ehealth.gmrvf.0a', 'gmrvf.cel@gmail.com', 1),
('ehealth.gmrvf.0b', 'ehealth.gmrvf.0b', 'gmrvf.cel@gmail.com', 1),
('ehealth.gmrvf.0c', 'ehealth.gmrvf.0c', 'gmrvf.cel@gmail.com', 1),
('ehealth.gmrvf.0d', 'ehealth.gmrvf.0d', 'gmrvf.cel@gmail.com', 1),
('ehealth.gmrvf.0e', 'ehealth.gmrvf.0e', 'gmrvf.cel@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vitals`
--

CREATE TABLE IF NOT EXISTS `vitals` (
  `vit_id` int(12) NOT NULL AUTO_INCREMENT,
  `p_pid` varchar(12) NOT NULL,
  `p_bp_systole` int(11) DEFAULT NULL,
  `p_bp_diastole` int(11) DEFAULT NULL,
  `p_temperature` float(5,2) DEFAULT NULL,
  `p_pulse` int(11) DEFAULT NULL,
  `p_respSys` varchar(255) DEFAULT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`vit_id`),
  UNIQUE KEY `vit_id` (`vit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
