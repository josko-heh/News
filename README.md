Simple news website.

For site to work as intended you need to set up database.
Also, there should be images folder that article images are stored into. From insert.php: `$target_dir = "../images/";`

User needs to be changed manually to admin in DB (set permissionId to 1).


My database:
--
-- Database: `news`
--

-- Table structure for table `articles`
CREATE TABLE `articles` (
  `id` int(10) UNSIGNED NOT NULL,
  `headline` varchar(100) NOT NULL,
  `summary` tinytext NOT NULL,
  `story` text NOT NULL,
  `image` varchar(512) DEFAULT NULL,
  `categoryId` smallint(5) UNSIGNED NOT NULL,
  `isArchived` tinyint(1) NOT NULL,
  `dateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Table structure for table `categories`
CREATE TABLE `categories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Sport'),
(2, 'Show'),
(4, 'Science');


-- Table structure for table `permissions`
CREATE TABLE `permissions` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `level` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `permissions` (`id`, `level`) VALUES
(1, 'admin'),
(2, 'user');


-- Table structure for table `users`
CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `permissionId` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `name`, `surname`, `username`, `password`, `permissionId`) VALUES
(5, 'Dylan Bartlett', 'Skinner', 'user', '$2y$10$zXLviOFq9.zZSS0UmzVyMe9Ln2gUGWtVDrOPzgAvy1ra3594Q9HL.', 2),
(45, 'admin', 'admin', 'admin', '$2y$10$nN48LPfAFC6VMjKDe7LYsejph0h26tJ8vieb9opAN7dnurBo51nAC', 1);
-- user pass: user12
-- admin pass: admin1


-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryId` (`categoryId`);

-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `permissionId` (`permissionId`);


--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`permissionId`) REFERENCES `permissions` (`id`);
COMMIT;