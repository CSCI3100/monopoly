-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2014 at 07:22 PM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mono`
--

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `rid` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `playercount` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`rid`, `name`, `password`, `playercount`) VALUES
(1, '1312', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 22),
(2, 'fdgdfg', 'd68be914fb9ab947593f2d7b291bad8e7f8893e8', 1),
(3, 'fdgdfg', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 3),
(4, 'fdgdfg', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 3),
(5, 'fFdgdfg', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 20),
(6, '123', '601f1889667efaebb33b8c12572835da3f027f78', 7),
(7, '123124', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 5),
(8, 'qwe', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 5),
(9, 'avbsdf', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 4),
(10, 'test', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 6),
(11, 'one more', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 9),
(12, 'qwe', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 4),
(13, 'qwee', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 4),
(14, 'qwewqe', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 7),
(15, 'sss', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 10),
(24, '12345', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 3),
(28, 'qeqeqe', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 3),
(31, 'qq', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 2),
(32, 'aaa', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 2),
(33, 'wwwsss', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 4),
(34, 'eqweqwe', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 3),
(35, 'testpw', 'a9993e364706816aba3e25717850c26c9cd0d89d', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `money` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `name`, `password`, `money`) VALUES
(1, '1234', 'sdfsdfsdfsdfsdfsdfasgsagds', 0),
(2, '12345', 'sdfsdfsdfsdfsdfsdfasgsagds', 0),
(3, '123', '0c11d463c749db5838e2c0e489bf869d531e5403', 0),
(14, 'qwe', '0c11d463c749db5838e2c0e489bf869d531e5403', 0),
(15, 'acac', '3f2d4ebefe4365de1b98fb734f327770bc9476e7', 0),
(16, 'brian', '0c11d463c749db5838e2c0e489bf869d531e5403', 0),
(17, '111', '0c11d463c749db5838e2c0e489bf869d531e5403', 0),
(18, '555', '0c11d463c749db5838e2c0e489bf869d531e5403', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
