--
-- MySQL 5.1.33
-- Mon, 24 Aug 2009 18:56:36 +0000
--

CREATE DATABASE `db` DEFAULT CHARSET latin1;

USE `db`;

CREATE TABLE `articles` (
   `id` int(11),
   `title` varchar(255),
   `text` text,
   `author` varchar(255),
   `time` timestamp,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET latin1;

INSERT INTO `articles` (`id`, `title`, `text`, `author`, `time`) VALUES 
('1', 'Article Post #1', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br/><br/>\n\nDonec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.', 'Sirupsen', '2009-08-16 16:51:20'),
('2', 'Article Post #2', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br/><br/>\n\nDonec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.', 'Sirupsen', '2009-08-16 16:51:20');

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

CREATE TABLE `links` (
   `id` int(11),
   `url` varchar(255),
   `name` varchar(255),
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET latin1;

INSERT INTO `links` (`id`, `url`, `name`) VALUES 
('1', 'http://sirupsen.dk', 'Sirupsen.dk'),
('2', 'http://github.com/Sirupsen/Flimpl/tree/master', 'Github'),
('3', 'http://php.net/', 'php.net');
