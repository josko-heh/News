## Simple news website.

[//]: # (online: http://amsnews.eu5.org/pages/index.ph)

For site to work as intended you need to set up database and modify data/config.php file.
Also, there should be images folder that article images are stored into. From insert.php: `$target_dir = "../images/";`

User needs to be changed manually to admin in DB (set permissionId to 1).


### My database:<br/>
![DB schema](https://github.com/josko-heh/news/blob/master/db_schema.png?raw=true)<br/>
<br/>
-- Database: `news`<br/>
CREATE DATABASE IF NOT EXISTS `news` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `news`;<br/>

-- Table structure for table `articles`<br/>
CREATE TABLE `articles` (<br/>
  `id` int(10) UNSIGNED NOT NULL,<br/>
  `headline` varchar(100) NOT NULL,<br/>
  `summary` tinytext NOT NULL,<br/>
  `story` text NOT NULL,<br/>
  `image` varchar(512) DEFAULT NULL,<br/>
  `categoryId` smallint(5) UNSIGNED NOT NULL,<br/>
  `isArchived` tinyint(1) NOT NULL,<br/>
  `dateTime` datetime DEFAULT NULL<br/>
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;<br/>


-- Table structure for table `categories`<br/>
CREATE TABLE `categories` (<br/>
  `id` smallint(5) UNSIGNED NOT NULL,<br/>
  `name` varchar(32) NOT NULL<br/>
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;<br/>

INSERT INTO `categories` (`id`, `name`) VALUES<br/>
(1, 'Sport'),<br/>
(2, 'Show'),<br/>
(4, 'Science');<br/>


-- Table structure for table `permissions`<br/>
CREATE TABLE `permissions` (<br/>
  `id` tinyint(3) UNSIGNED NOT NULL,<br/>
  `level` varchar(32) NOT NULL<br/>
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;<br/>

INSERT INTO `permissions` (`id`, `level`) VALUES<br/>
(1, 'admin'),<br/>
(2, 'user');<br/>


-- Table structure for table `users`<br/>
CREATE TABLE `users` (<br/>
  `id` int(11) UNSIGNED NOT NULL,<br/>
  `name` varchar(32) NOT NULL,<br/>
  `surname` varchar(32) NOT NULL,<br/>
  `username` varchar(32) NOT NULL,<br/>
  `password` varchar(255) NOT NULL,<br/>
  `permissionId` tinyint(3) UNSIGNED NOT NULL<br/>
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;<br/>

INSERT INTO `users` (`id`, `name`, `surname`, `username`, `password`, `permissionId`) VALUES<br/>
(5, 'Neki', 'Tamo', 'user', '$2y$10$zXLviOFq9.zZSS0UmzVyMe9Ln2gUGWtVDrOPzgAvy1ra3594Q9HL.', 2),<br/>
(45, 'admin', 'admin', 'admin', '$2y$10$nN48LPfAFC6VMjKDe7LYsejph0h26tJ8vieb9opAN7dnurBo51nAC', 1);<br/>
-- user pass: user12<br/>
-- admin pass: admin1<br/>
<br/>
<br/>
-- Indexes for table `articles`<br/>
ALTER TABLE `articles`<br/>
  ADD PRIMARY KEY (`id`),<br/>
  ADD KEY `categoryId` (`categoryId`);<br/>
<br/>
-- Indexes for table `categories`<br/>
ALTER TABLE `categories`<br/>
  ADD PRIMARY KEY (`id`);<br/>
<br/>
-- Indexes for table `permissions`<br/>
ALTER TABLE `permissions`<br/>
  ADD PRIMARY KEY (`id`);<br/>
<br/>
-- Indexes for table `users`<br/>
ALTER TABLE `users`<br/>
  ADD PRIMARY KEY (`id`),<br/>
  ADD UNIQUE KEY `username` (`username`),<br/>
  ADD KEY `permissionId` (`permissionId`);<br/>
<br/>
<br/>
-- Constraints for table `articles`<br/>
ALTER TABLE `articles`<br/>
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`);<br/>
<br/>
-- Constraints for table `users`<br/>
ALTER TABLE `users`<br/>
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`permissionId`) REFERENCES `permissions` (`id`);<br/>
COMMIT;<br/>
