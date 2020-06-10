SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;

CREATE DATABASE obis;
USE obis;

CREATE TABLE `bmi` (
`id` int(11) NOT NULL,
`year_value` int(4) NOT NULL,
`locationabbr` char(2) NOT NULL,
`sample_size` int(11) NOT NULL,
`data_value_percentage` float NOT NULL,
`confidence_limit_low` float NOT NULL,
`confidence_limit_high` float NOT NULL,
`response_id` varchar(10) NOT NULL,
`break_out_id` varchar(10) NOT NULL,
`break_out_category_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `break_outs` (
`break_out_id` varchar(10) NOT NULL,
`break_out` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `break_out_categories` (
`break_out_category_id` varchar(10) NOT NULL,
`break_out_category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `contactmessages` (
`id` int(11) NOT NULL,
`name` varchar(128) NOT NULL,
`email` varchar(128) NOT NULL,
`message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `locations` (
`locationabbr` char(2) NOT NULL,
`location_name` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `responses` (
`response_id` varchar(10) NOT NULL,
`response` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
`id` int(11) NOT NULL,
`firstname` varchar(64) NOT NULL,
`lastname` varchar(64) NOT NULL,
`email` varchar(128) NOT NULL,
`password` varchar(1024) NOT NULL,
`created` datetime NOT NULL DEFAULT current_timestamp(),
`modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `bmi`
ADD PRIMARY KEY (`id`),
ADD KEY `locationabbr` (`locationabbr`),
ADD KEY `response_id` (`response_id`),
ADD KEY `break_out_id` (`break_out_id`),
ADD KEY `break_out_category_id` (`break_out_category_id`);

ALTER TABLE `break_outs`
ADD PRIMARY KEY (`break_out_id`);

ALTER TABLE `break_out_categories`
ADD PRIMARY KEY (`break_out_category_id`);

ALTER TABLE `contactmessages`
ADD PRIMARY KEY (`id`);

ALTER TABLE `locations`
ADD PRIMARY KEY (`locationabbr`);

ALTER TABLE `responses`
ADD PRIMARY KEY (`response_id`);

ALTER TABLE `users`
ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
ADD UNIQUE(`email`);

ALTER TABLE `users`
ADD `admin` TINYINT(1) NOT NULL DEFAULT '0' AFTER `id`;

ALTER TABLE `bmi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140759;

ALTER TABLE `contactmessages`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `bmi`
ADD CONSTRAINT `fk_break_out_category_id` FOREIGN KEY (`break_out_category_id`) REFERENCES `break_out_categories` (`break_out_category_id`),
ADD CONSTRAINT `fk_break_out_id` FOREIGN KEY (`break_out_id`) REFERENCES `break_outs` (`break_out_id`),
ADD CONSTRAINT `fk_locationabbr` FOREIGN KEY (`locationabbr`) REFERENCES `locations` (`locationabbr`),
ADD CONSTRAINT `fk_responseid` FOREIGN KEY (`response_id`) REFERENCES `responses` (`response_id`);

COMMIT;