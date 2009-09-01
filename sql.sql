--
-- MySQL 5.1.33
-- Mon, 24 Aug 2009 18:56:36 +0000
--

CREATE DATABASE `db` DEFAULT CHARSET latin1;

USE `db`;

CREATE TABLE `errors` (
   `id` int(11),
   `no` varchar(255),
   `message` text,
   `file` varchar(255),
   `line` varchar(255),
   `created` timestamp,
   `time` int(11),
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET latin1;

-- [Table `errors` is empty]
