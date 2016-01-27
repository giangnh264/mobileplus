/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : mobileplus

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-01-27 23:37:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for news_event
-- ----------------------------
DROP TABLE IF EXISTS `news_event`;
CREATE TABLE `news_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `sorder` int(10) DEFAULT '0',
  `custom_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `channel` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'wap',
  `content` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_time` datetime DEFAULT NULL,
  `img_url` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
