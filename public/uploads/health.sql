-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 05, 2015 at 04:04 PM
-- Server version: 5.6.24-0ubuntu2
-- PHP Version: 5.6.4-4ubuntu6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `health`
--

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE IF NOT EXISTS `diagnosis` (
  `diag_id` int(11) NOT NULL,
  `p_pid` varchar(12) NOT NULL DEFAULT '',
  `created` date NOT NULL,
  `p_prediag` varchar(255) DEFAULT NULL,
  `p_curr_diag` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `diagnosis`
--


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
  `p_less_sleep` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history`


-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `p_pid` varchar(12) NOT NULL,
  `image_path_small` text,
  `image_path_medium` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `investigation`
--

CREATE TABLE IF NOT EXISTS `investigation` (
`inv_id` int(12) NOT NULL,
  `p_pid` varchar(12) NOT NULL,
  `created` date NOT NULL,
  `p_rbs` tinyint(4) DEFAULT NULL,
  `p_cbp` tinyint(4) DEFAULT NULL,
  `p_fbs` tinyint(4) DEFAULT NULL,
  `p_plbs` tinyint(4) DEFAULT NULL,
  `p_ecg` tinyint(4) DEFAULT NULL,
  `p_xray` tinyint(4) DEFAULT NULL,
  `p_esr` tinyint(4) DEFAULT NULL,
  `p_cue` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `investigation`


-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE IF NOT EXISTS `medicine` (
  `medicine_code` varchar(10) NOT NULL,
  `medicine_name` varchar(255) DEFAULT NULL,
  `medicine_remain` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`medicine_code`, `medicine_name`, `medicine_remain`) VALUES
('AZITH', 'Azithral', 0),
('COMB', 'Combiflam', 563),
('DOLO650', 'Dolo 650', 1523),
('PARAC', 'Paracetomol', 1896);

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
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--
-- --------------------------------------------------------

--
-- Table structure for table `symptoms`
--

CREATE TABLE IF NOT EXISTS `symptoms` (
`sym_id` int(12) NOT NULL,
  `p_pid` varchar(12) NOT NULL,
  `created` date NOT NULL,
  `p_sym1` varchar(255) DEFAULT NULL,
  `p_sym2` varchar(255) DEFAULT NULL,
  `p_sym3` varchar(255) DEFAULT NULL,
  `p_sym4` varchar(255) DEFAULT NULL,
  `p_sym5` varchar(255) DEFAULT NULL,
  `p_sym6` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--


--

-- --------------------------------------------------------

--
-- Table structure for table `vitals`
--

CREATE TABLE IF NOT EXISTS `vitals` (
`vit_id` int(12) NOT NULL,
  `p_pid` varchar(12) NOT NULL,
  `p_bp_systole` int(11) DEFAULT NULL,
  `p_bp_diastole` int(11) DEFAULT NULL,
  `p_temperature` float(5,2) DEFAULT NULL,
  `p_pulse` int(11) DEFAULT NULL,
  `p_respSys` varchar(255) DEFAULT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diagnosis`
--
ALTER TABLE `diagnosis`
 ADD PRIMARY KEY (`diag_id`,`p_pid`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
 ADD PRIMARY KEY (`p_pid`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
 ADD PRIMARY KEY (`p_pid`), ADD UNIQUE KEY `p_pid` (`p_pid`);

--
-- Indexes for table `investigation`
--
ALTER TABLE `investigation`
 ADD PRIMARY KEY (`inv_id`,`p_pid`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
 ADD PRIMARY KEY (`medicine_code`), ADD UNIQUE KEY `medicine_code` (`medicine_code`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
 ADD PRIMARY KEY (`p_pid`), ADD UNIQUE KEY `p_pid` (`p_pid`);

--
-- Indexes for table `symptoms`
--
ALTER TABLE `symptoms`
 ADD PRIMARY KEY (`sym_id`,`p_pid`), ADD UNIQUE KEY `sym_id` (`sym_id`), ADD UNIQUE KEY `p_pid` (`p_pid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`username`);

--
-- Indexes for table `vitals`
--
ALTER TABLE `vitals`
 ADD PRIMARY KEY (`vit_id`,`p_pid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `investigation`
--
ALTER TABLE `investigation`
MODIFY `inv_id` int(12) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `symptoms`
--
ALTER TABLE `symptoms`
MODIFY `sym_id` int(12) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `vitals`
--
ALTER TABLE `vitals`
MODIFY `vit_id` int(12) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
