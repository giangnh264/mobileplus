/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : mobileplus

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-01-29 00:54:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for contact
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `project_type` enum('mobile','web') COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_pirce` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_time` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_des` text COLLATE utf8_unicode_ci,
  `created_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
