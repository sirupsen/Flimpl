--
-- MySQL 5.1.33
-- Fri, 14 Aug 2009 22:03:55 +0000
--

CREATE DATABASE `db` DEFAULT CHARSET latin1;

USE `db`;

CREATE TABLE `names` (
   `id` int(11),
   `name` varchar(255),
   `age` varchar(255),
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET latin1;

INSERT INTO `names` (`id`, `name`, `column`) VALUES 
('1', 'Simon', '14'),
('2', 'Anders', '15');
