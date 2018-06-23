/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50511
Source Host           : localhost:8816
Source Database       : fikcdn

Target Server Type    : MYSQL
Target Server Version : 50511
File Encoding         : 65001

Date: 2018-06-22 17:33:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cache_rule_fcache
-- ----------------------------
DROP TABLE IF EXISTS `cache_rule_fcache`;
CREATE TABLE `cache_rule_fcache` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `node_id` int(4) NOT NULL,
  `group_id` int(4) NOT NULL,
  `NO` int(4) NOT NULL,
  `Wid` int(4) NOT NULL,
  `Url` text NOT NULL,
  `Icase` smallint(1) NOT NULL,
  `Rules` smallint(1) NOT NULL,
  `Expire` int(4) NOT NULL,
  `Unit` smallint(1) NOT NULL,
  `Icookie` smallint(1) NOT NULL,
  `Olimit` smallint(1) NOT NULL,
  `IsDiskCache` smallint(1) NOT NULL,
  `Note` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cache_rule_fcache
-- ----------------------------

-- ----------------------------
-- Table structure for cache_rule_rcache
-- ----------------------------
DROP TABLE IF EXISTS `cache_rule_rcache`;
CREATE TABLE `cache_rule_rcache` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `node_id` int(4) NOT NULL,
  `group_id` int(4) NOT NULL,
  `NO` int(4) NOT NULL,
  `Wid` int(4) NOT NULL,
  `Url` text NOT NULL,
  `Icase` smallint(1) NOT NULL,
  `Rules` smallint(1) NOT NULL,
  `Olimit` smallint(1) NOT NULL,
  `CacheLocation` smallint(1) NOT NULL,
  `Note` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cache_rule_rcache
-- ----------------------------

-- ----------------------------
-- Table structure for cache_rule_rewrite
-- ----------------------------
DROP TABLE IF EXISTS `cache_rule_rewrite`;
CREATE TABLE `cache_rule_rewrite` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `node_id` int(4) NOT NULL,
  `group_id` int(4) NOT NULL,
  `NO` int(4) NOT NULL,
  `RewriteID` int(4) NOT NULL,
  `SourceUrl` text NOT NULL,
  `DestinationUrl` text NOT NULL,
  `Icase` smallint(1) NOT NULL,
  `Flag` smallint(1) NOT NULL,
  `Note` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cache_rule_rewrite
-- ----------------------------

-- ----------------------------
-- Table structure for domain_stat
-- ----------------------------
DROP TABLE IF EXISTS `domain_stat`;
CREATE TABLE `domain_stat` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(4) NOT NULL,
  `node_id` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `NO` int(4) NOT NULL,
  `ProxyID` int(4) NOT NULL,
  `Host` varchar(64) NOT NULL,
  `Balance` int(4) NOT NULL,
  `Enable` smallint(2) NOT NULL,
  `StartTime` bigint(8) NOT NULL,
  `EndTime` bigint(8) NOT NULL,
  `RequestCount` bigint(8) NOT NULL,
  `UploadCount` bigint(8) NOT NULL,
  `DownloadCount` bigint(8) NOT NULL,
  `IpCount` int(4) NOT NULL,
  `Note` text,
  `bandwidth_down` float DEFAULT '0',
  `bandwidth_up` float DEFAULT '0',
  `down_increase` bigint(8) DEFAULT '0',
  `up_increase` bigint(8) DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of domain_stat
-- ----------------------------

-- ----------------------------
-- Table structure for domain_stat_group_day
-- ----------------------------
DROP TABLE IF EXISTS `domain_stat_group_day`;
CREATE TABLE `domain_stat_group_day` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(4) NOT NULL,
  `domain_id` int(4) NOT NULL,
  `buy_id` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `Host` varchar(64) NOT NULL,
  `RequestCount` bigint(8) NOT NULL,
  `UploadCount` float NOT NULL COMMENT 'MB',
  `DownloadCount` float NOT NULL COMMENT 'MB',
  `IpCount` bigint(8) NOT NULL,
  `max_down_bandwidth` float DEFAULT NULL,
  `max_up_bandwidth` float DEFAULT NULL,
  `time_for_max` bigint(8) DEFAULT '0',
  `bandwidth_down` float DEFAULT '0',
  `bandwidth_up` float DEFAULT '0',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `group_id` (`time`,`Host`,`domain_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of domain_stat_group_day
-- ----------------------------

-- ----------------------------
-- Table structure for domain_stat_host_bandwidth
-- ----------------------------
DROP TABLE IF EXISTS `domain_stat_host_bandwidth`;
CREATE TABLE `domain_stat_host_bandwidth` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(4) NOT NULL,
  `buy_id` int(4) NOT NULL,
  `domain_id` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `Host` varchar(64) NOT NULL,
  `down_increase` bigint(8) DEFAULT '0',
  `up_increase` bigint(8) DEFAULT '0',
  `bandwidth_down` float DEFAULT '0',
  `bandwidth_up` float DEFAULT '0',
  `RequestCount_increase` bigint(8) DEFAULT '0',
  `IpCount_increase` bigint(8) DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of domain_stat_host_bandwidth
-- ----------------------------

-- ----------------------------
-- Table structure for domain_stat_host_max_bandwidth
-- ----------------------------
DROP TABLE IF EXISTS `domain_stat_host_max_bandwidth`;
CREATE TABLE `domain_stat_host_max_bandwidth` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(4) NOT NULL,
  `buy_id` int(4) NOT NULL,
  `domain_id` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `Host` varchar(64) NOT NULL,
  `bandwidth_down` float DEFAULT '0',
  `bandwidth_up` float DEFAULT '0',
  `down_increase` bigint(8) NOT NULL DEFAULT '0',
  `up_increase` bigint(8) NOT NULL DEFAULT '0',
  `RequestCount_increase` bigint(8) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `domain_max_time_domain_id` (`time`,`domain_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of domain_stat_host_max_bandwidth
-- ----------------------------

-- ----------------------------
-- Table structure for domain_stat_month
-- ----------------------------
DROP TABLE IF EXISTS `domain_stat_month`;
CREATE TABLE `domain_stat_month` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `Host` varchar(64) NOT NULL,
  `domain_id` int(4) NOT NULL,
  `buy_id` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `RequestCount` bigint(8) NOT NULL,
  `UploadCount` float NOT NULL COMMENT 'GB',
  `DownloadCount` float NOT NULL COMMENT 'GB',
  `IpCount` bigint(8) NOT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `index_domain_stat_month` (`domain_id`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of domain_stat_month
-- ----------------------------

-- ----------------------------
-- Table structure for domain_stat_product_bandwidth
-- ----------------------------
DROP TABLE IF EXISTS `domain_stat_product_bandwidth`;
CREATE TABLE `domain_stat_product_bandwidth` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(4) NOT NULL,
  `buy_id` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `bandwidth_down` float DEFAULT '0' COMMENT 'Mbps',
  `bandwidth_up` float DEFAULT '0' COMMENT 'Mbps',
  `down_increase` bigint(8) NOT NULL DEFAULT '0' COMMENT 'MB',
  `up_increase` bigint(8) NOT NULL DEFAULT '0' COMMENT 'MB',
  `RequestCount_increase` bigint(8) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`),
  KEY `product_bandwidth_time_id` (`time`,`buy_id`)
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of domain_stat_product_bandwidth
-- ----------------------------
INSERT INTO `domain_stat_product_bandwidth` VALUES ('1', '0', '1', '1389591000', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('2', '0', '1', '1421067000', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('3', '0', '1', '1423217910', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('4', '0', '1', '1426130103', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('5', '0', '1', '1426130403', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('6', '0', '1', '1426130703', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('7', '0', '1', '1426131003', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('8', '0', '1', '1426131304', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('9', '0', '1', '1426131604', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('10', '0', '1', '1426131904', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('11', '0', '1', '1437031846', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('12', '0', '1', '1437032146', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('13', '0', '1', '1437032447', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('14', '0', '1', '1437032747', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('15', '0', '1', '1437033047', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('16', '0', '1', '1437033347', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('17', '0', '1', '1437033647', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('18', '0', '1', '1437033947', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('19', '0', '1', '1437034247', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('20', '0', '1', '1437034547', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('21', '0', '1', '1437034847', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('22', '0', '1', '1437035147', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('23', '0', '1', '1437035448', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('24', '0', '1', '1437035748', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('25', '0', '1', '1437036048', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('26', '0', '1', '1437036348', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('27', '0', '1', '1437041170', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('28', '0', '1', '1437041470', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('29', '0', '1', '1437041770', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('30', '0', '1', '1437042070', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('31', '0', '1', '1437042370', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('32', '0', '1', '1437042670', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('33', '0', '1', '1437042971', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('34', '0', '1', '1437043271', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('35', '0', '1', '1437043571', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('36', '0', '1', '1437043871', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('37', '0', '1', '1437044171', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('38', '0', '1', '1437044471', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('39', '0', '1', '1437044771', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('40', '0', '1', '1437045071', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('41', '0', '1', '1437045372', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('42', '0', '1', '1437045672', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('43', '0', '1', '1437045972', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('44', '0', '1', '1437046272', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('45', '0', '1', '1437046572', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('46', '0', '1', '1437046872', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('47', '0', '1', '1437047172', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('48', '0', '1', '1437047472', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('49', '0', '1', '1437047772', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('50', '0', '1', '1437048072', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('51', '0', '1', '1437048373', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('52', '0', '1', '1437048673', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('53', '0', '1', '1437048973', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('54', '0', '1', '1437049273', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('55', '0', '1', '1437049573', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('56', '0', '1', '1437049873', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('57', '0', '1', '1437050173', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('58', '0', '1', '1437050473', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('59', '0', '1', '1437050774', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('60', '0', '1', '1437051074', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('61', '0', '1', '1437051765', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('62', '0', '1', '1437052063', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('63', '0', '1', '1437052363', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('64', '0', '1', '1437052663', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('65', '0', '1', '1437052963', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('66', '0', '1', '1437053264', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('67', '0', '1', '1437053564', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('68', '0', '1', '1437053864', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('69', '0', '1', '1437054164', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('70', '0', '1', '1437054464', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('71', '0', '1', '1437054764', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('72', '0', '1', '1437055064', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('73', '0', '1', '1437055365', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('74', '0', '1', '1437055665', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('75', '0', '1', '1437055965', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('76', '0', '1', '1437056265', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('77', '0', '1', '1437056565', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('78', '0', '1', '1437056865', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('79', '0', '1', '1437057165', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('80', '0', '1', '1437057466', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('81', '0', '1', '1437057766', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('82', '0', '1', '1437066005', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('83', '0', '1', '1437066305', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('84', '0', '1', '1437066605', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('85', '0', '1', '1437090394', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('86', '0', '1', '1437090694', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('87', '0', '1', '1437090994', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('88', '0', '1', '1437091294', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('89', '0', '1', '1437091594', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('90', '0', '1', '1437091895', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('91', '0', '1', '1437092195', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('92', '0', '1', '1437092495', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('93', '0', '1', '1437092795', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('94', '0', '1', '1437093095', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('95', '0', '1', '1437093395', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('96', '0', '1', '1437093695', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('97', '0', '1', '1437093995', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('98', '0', '1', '1437094295', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('99', '0', '1', '1437094595', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('100', '0', '1', '1437094896', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('101', '0', '1', '1437095196', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('102', '0', '1', '1437095496', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('103', '0', '1', '1437095796', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('104', '0', '1', '1437096096', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('105', '0', '1', '1437096396', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('106', '0', '1', '1437098545', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('107', '0', '1', '1437098846', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('108', '0', '1', '1437099146', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('109', '0', '1', '1437099446', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('110', '0', '1', '1529658388', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('111', '0', '1', '1529658688', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('112', '0', '1', '1529658988', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('113', '0', '1', '1529659288', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('114', '0', '1', '1529659588', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_bandwidth` VALUES ('115', '0', '1', '1529659888', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for domain_stat_product_day
-- ----------------------------
DROP TABLE IF EXISTS `domain_stat_product_day`;
CREATE TABLE `domain_stat_product_day` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `buy_id` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `RequestCount` bigint(8) NOT NULL,
  `UploadCount` float NOT NULL COMMENT 'GB',
  `DownloadCount` float NOT NULL COMMENT 'GB',
  `IpCount` bigint(8) NOT NULL,
  `time_for_max` bigint(8) DEFAULT '0',
  `bandwidth_down` float DEFAULT '0',
  `bandwidth_up` float DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of domain_stat_product_day
-- ----------------------------

-- ----------------------------
-- Table structure for domain_stat_product_max_bandwidth
-- ----------------------------
DROP TABLE IF EXISTS `domain_stat_product_max_bandwidth`;
CREATE TABLE `domain_stat_product_max_bandwidth` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(4) NOT NULL,
  `buy_id` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `bandwidth_down` float DEFAULT '0',
  `bandwidth_up` float DEFAULT '0',
  `down_increase` bigint(8) NOT NULL DEFAULT '0',
  `up_increase` bigint(8) NOT NULL DEFAULT '0',
  `RequestCount_increase` bigint(8) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `product_max_time_buy_id` (`time`,`buy_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of domain_stat_product_max_bandwidth
-- ----------------------------
INSERT INTO `domain_stat_product_max_bandwidth` VALUES ('1', '0', '1', '1423216800', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_max_bandwidth` VALUES ('2', '0', '1', '1423227600', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_max_bandwidth` VALUES ('3', '0', '1', '1437033600', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_max_bandwidth` VALUES ('4', '0', '1', '1437044400', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_max_bandwidth` VALUES ('5', '0', '1', '1437048000', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_max_bandwidth` VALUES ('6', '0', '1', '1437055200', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_max_bandwidth` VALUES ('7', '0', '1', '1437066000', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_max_bandwidth` VALUES ('8', '0', '1', '1437091200', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_max_bandwidth` VALUES ('9', '0', '1', '1437094800', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_max_bandwidth` VALUES ('10', '0', '1', '1437098400', '0', '0', '0', '0', '0');
INSERT INTO `domain_stat_product_max_bandwidth` VALUES ('11', '0', '1', '1526461200', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for domain_stat_product_month
-- ----------------------------
DROP TABLE IF EXISTS `domain_stat_product_month`;
CREATE TABLE `domain_stat_product_month` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `buy_id` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `RequestCount` bigint(8) NOT NULL,
  `UploadCount` float NOT NULL COMMENT 'GB',
  `DownloadCount` float NOT NULL COMMENT 'GB',
  `IpCount` bigint(8) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of domain_stat_product_month
-- ----------------------------

-- ----------------------------
-- Table structure for domain_stat_temp
-- ----------------------------
DROP TABLE IF EXISTS `domain_stat_temp`;
CREATE TABLE `domain_stat_temp` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(4) NOT NULL,
  `node_id` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `NO` int(4) NOT NULL,
  `ProxyID` int(4) NOT NULL,
  `Host` varchar(64) NOT NULL,
  `Balance` int(4) NOT NULL,
  `Enable` smallint(2) NOT NULL,
  `StartTime` bigint(8) NOT NULL,
  `EndTime` bigint(8) NOT NULL,
  `RequestCount` bigint(8) NOT NULL,
  `UploadCount` bigint(8) NOT NULL,
  `DownloadCount` bigint(8) NOT NULL,
  `IpCount` int(4) NOT NULL,
  `bandwidth_down` float DEFAULT '0',
  `bandwidth_up` float DEFAULT '0',
  `down_increase` bigint(8) DEFAULT '0',
  `up_increase` bigint(8) DEFAULT '0',
  `UserConnections` int(4) DEFAULT '0',
  `UpstreamConnections` int(4) DEFAULT '0',
  `RequestCount_increase` int(4) DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of domain_stat_temp
-- ----------------------------

-- ----------------------------
-- Table structure for fikcdn_admin
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_admin`;
CREATE TABLE `fikcdn_admin` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `power` int(4) NOT NULL DEFAULT '0',
  `last_login_ip` varchar(32) DEFAULT NULL,
  `last_login_time` bigint(8) NOT NULL DEFAULT '0',
  `enable` int(4) DEFAULT '1',
  `nick` varchar(64) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `qq` varchar(16) DEFAULT NULL,
  `addr` varchar(256) DEFAULT NULL,
  `note` varchar(512) DEFAULT NULL,
  `login_count` int(4) DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_admin
-- ----------------------------
INSERT INTO `fikcdn_admin` VALUES ('1', 'admin', '46f94c8de14fb36680850768ff1b7f2a', '10', '113.102.236.70', '1529658303', '1', '系统管理员', '88888888', '88888888', '最高权限', '', '9');
INSERT INTO `fikcdn_admin` VALUES ('2', 'keeper', '46f94c8de14fb36680850768ff1b7f2a', '9', '127.0.0.1', '1382326266', '0', '系统监控员', '88888888', '88888888', '监控员权限(临时冻结)', '用于监控统计带宽，无修改系统数据的权限；', '1');

-- ----------------------------
-- Table structure for fikcdn_buy
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_buy`;
CREATE TABLE `fikcdn_buy` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `product_id` int(4) NOT NULL,
  `begin_time` bigint(8) NOT NULL,
  `end_time` bigint(8) NOT NULL,
  `note` varchar(128) DEFAULT NULL,
  `status` smallint(2) DEFAULT '1',
  `auto_renew` smallint(2) DEFAULT '1',
  `price` float DEFAULT NULL,
  `has_data_flow` bigint(8) DEFAULT '0',
  `domain_num` smallint(2) DEFAULT NULL,
  `data_flow` bigint(8) DEFAULT '0',
  `is_focus` smallint(1) DEFAULT '1',
  `down_dataflow_total` float NOT NULL DEFAULT '0',
  `up_dataflow_total` float NOT NULL DEFAULT '0',
  `request_total` bigint(8) NOT NULL DEFAULT '0',
  `auto_stop` smallint(2) NOT NULL DEFAULT '0',
  `max_bandwidth` int(4) DEFAULT '0',
  `dns_cname` varchar(64) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_buy
-- ----------------------------
INSERT INTO `fikcdn_buy` VALUES ('1', 'client', '1', '1389590556', '2020742556', '系统自带帐号充值', '1', '1', '100', '104857600', '1000', '104857600', '1', '0', '0', '0', '0', '0', null);

-- ----------------------------
-- Table structure for fikcdn_buyhistory
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_buyhistory`;
CREATE TABLE `fikcdn_buyhistory` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `buy_id` int(4) NOT NULL,
  `price` float NOT NULL,
  `month` smallint(2) NOT NULL,
  `buy_time` bigint(8) NOT NULL,
  `end_time` bigint(8) NOT NULL,
  `auto_renew` smallint(2) DEFAULT NULL,
  `domain_num` smallint(2) NOT NULL,
  `data_flow` bigint(8) NOT NULL,
  `balance` float DEFAULT NULL,
  `type` smallint(1) NOT NULL DEFAULT '1',
  `ip` varchar(16) NOT NULL,
  `note` varchar(128) DEFAULT NULL,
  `frist_month_money` float DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_buyhistory
-- ----------------------------
INSERT INTO `fikcdn_buyhistory` VALUES ('1', 'client', '1', '100', '240', '1389590556', '2020742556', '1', '1000', '104857600', '76000', '0', '127.0.0.1', '系统自带帐号充值', '51');

-- ----------------------------
-- Table structure for fikcdn_client
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_client`;
CREATE TABLE `fikcdn_client` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `realname` varchar(32) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `money` float DEFAULT '0',
  `enable_login` smallint(2) NOT NULL DEFAULT '1',
  `register_time` bigint(8) NOT NULL,
  `register_ip` varchar(64) NOT NULL,
  `addr` varchar(256) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `company_name` varchar(256) DEFAULT NULL,
  `qq` varchar(32) DEFAULT NULL,
  `last_login_time` bigint(8) DEFAULT NULL,
  `last_login_ip` varchar(64) DEFAULT NULL,
  `note` text,
  `login_count` int(4) DEFAULT '0',
  `domain_need_verify` smallint(2) NOT NULL DEFAULT '1',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_client
-- ----------------------------
INSERT INTO `fikcdn_client` VALUES ('1', 'client', '客户端', '46f94c8de14fb36680850768ff1b7f2a', '76000', '1', '1389589584', '127.0.0.1', '广东省广州市', '88888888', 'Company', '88888888', '1432868217', '127.0.0.1', '默认密码：123qwe', '5', '1');

-- ----------------------------
-- Table structure for fikcdn_domain
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_domain`;
CREATE TABLE `fikcdn_domain` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `add_time` bigint(8) DEFAULT NULL,
  `buy_id` int(4) NOT NULL,
  `group_id` int(4) DEFAULT NULL,
  `status` smallint(2) DEFAULT '2',
  `upstream` varchar(128) NOT NULL,
  `icp` varchar(32) NOT NULL,
  `DNSName` varchar(64) NOT NULL,
  `begin_time` bigint(8) DEFAULT NULL,
  `end_time` bigint(8) DEFAULT NULL,
  `note` text,
  `is_focus` smallint(1) DEFAULT '1',
  `unicom_ip` varchar(64) DEFAULT NULL,
  `transit_group_id` int(4) DEFAULT '-1',
  `use_transit_node` smallint(1) DEFAULT '0',
  `is_stat` smallint(1) DEFAULT '0',
  `upstream_add_all` smallint(2) NOT NULL DEFAULT '0',
  `down_dataflow_total` float NOT NULL DEFAULT '0',
  `up_dataflow_total` float NOT NULL DEFAULT '0',
  `request_total` bigint(8) NOT NULL DEFAULT '0',
  `is_hide` smallint(2) NOT NULL DEFAULT '0',
  `offset` float NOT NULL DEFAULT '1',
  `upoffset` float NOT NULL DEFAULT '1',
  `down_begin_val` int(4) DEFAULT '0',
  `up_begin_val` int(4) DEFAULT '0',
  `SSLOpt` int(4) DEFAULT '0',
  `SSLCrtContent` text,
  `SSLKeyContent` text,
  `SSLExtraParams` text,
  `UpsSSLOpt` int(4) DEFAULT '0',
  `UpsSSLCrtContent` text,
  `UpsSSLKeyContent` text,
  `UpsSSLExtraParams` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_domain
-- ----------------------------

-- ----------------------------
-- Table structure for fikcdn_group
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_group`;
CREATE TABLE `fikcdn_group` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `create_time` bigint(8) DEFAULT NULL,
  `status` smallint(2) DEFAULT '0',
  `creator` varchar(64) DEFAULT NULL,
  `is_transit` smallint(1) DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_group
-- ----------------------------
INSERT INTO `fikcdn_group` VALUES ('1', 'Fikker节点组', '1389590152', '0', '', '0');

-- ----------------------------
-- Table structure for fikcdn_login_log
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_login_log`;
CREATE TABLE `fikcdn_login_log` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `login_ip` varchar(32) NOT NULL,
  `login_time` bigint(8) NOT NULL DEFAULT '0',
  `status` smallint(2) NOT NULL,
  `type` smallint(2) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_login_log
-- ----------------------------
INSERT INTO `fikcdn_login_log` VALUES ('3', 'admin', '113.102.236.70', '1529658135', '1', '1');
INSERT INTO `fikcdn_login_log` VALUES ('4', 'admin', '113.102.236.70', '1529658303', '1', '1');

-- ----------------------------
-- Table structure for fikcdn_node
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_node`;
CREATE TABLE `fikcdn_node` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `port` int(4) DEFAULT NULL,
  `admin_port` int(4) DEFAULT '6780',
  `username` varchar(64) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `type` int(4) DEFAULT NULL,
  `groupid` int(4) DEFAULT NULL,
  `bandwidth` int(4) DEFAULT '0',
  `add_time` bigint(8) DEFAULT '0',
  `note` text,
  `auth_domain` varchar(64) DEFAULT '0',
  `fik_version` varchar(64) DEFAULT NULL,
  `SessionID` varchar(64) DEFAULT NULL,
  `fik_LastLoginTime` varchar(32) DEFAULT NULL,
  `status` smallint(2) DEFAULT '1',
  `is_close` char(1) DEFAULT '0',
  `version_ext` varchar(32) DEFAULT NULL,
  `is_focus` smallint(1) DEFAULT '1',
  `unicom_ip` varchar(32) DEFAULT NULL,
  `is_transit` smallint(1) DEFAULT '0',
  `allow_bandwidth` int(4) DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_node
-- ----------------------------

-- ----------------------------
-- Table structure for fikcdn_operate_log
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_operate_log`;
CREATE TABLE `fikcdn_operate_log` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `opt_code` smallint(2) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `opt_time` bigint(8) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_operate_log
-- ----------------------------

-- ----------------------------
-- Table structure for fikcdn_order
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_order`;
CREATE TABLE `fikcdn_order` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `product_id` int(4) NOT NULL,
  `buy_time` bigint(8) NOT NULL,
  `note` varchar(128) DEFAULT NULL,
  `status` smallint(2) DEFAULT '1',
  `auto_renew` smallint(2) DEFAULT '1',
  `price` float NOT NULL,
  `month` smallint(2) NOT NULL,
  `type` smallint(2) DEFAULT NULL,
  `domain_num` smallint(2) NOT NULL,
  `data_flow` bigint(8) NOT NULL,
  `buy_id` int(4) DEFAULT NULL,
  `frist_month_money` float DEFAULT '0',
  `max_bandwidth` int(4) DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_order
-- ----------------------------

-- ----------------------------
-- Table structure for fikcdn_params
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_params`;
CREATE TABLE `fikcdn_params` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `value` varchar(128) NOT NULL,
  `time` bigint(8) NOT NULL,
  `note` varchar(128) DEFAULT NULL,
  `ext` varchar(64) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `index_globals_name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_params
-- ----------------------------
INSERT INTO `fikcdn_params` VALUES ('1', 'execute_task_enter', '0', '1529659976', null, null);
INSERT INTO `fikcdn_params` VALUES ('2', 'proxy_list_enter', '0', '1421067004', null, null);
INSERT INTO `fikcdn_params` VALUES ('3', 'execute_task_enter3', '0', '1529659977', null, null);
INSERT INTO `fikcdn_params` VALUES ('4', 'execute_task_enter2', '0', '1529659977', null, null);
INSERT INTO `fikcdn_params` VALUES ('5', 'realtime_list_enter', '0', '1423200338', null, null);

-- ----------------------------
-- Table structure for fikcdn_product
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_product`;
CREATE TABLE `fikcdn_product` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `price` float NOT NULL,
  `data_flow` bigint(8) NOT NULL DEFAULT '0',
  `domain_num` int(4) NOT NULL,
  `is_online` smallint(2) NOT NULL DEFAULT '0',
  `begin_time` bigint(8) NOT NULL,
  `note` text,
  `is_checks` smallint(2) DEFAULT NULL,
  `group_id` int(4) NOT NULL,
  `max_bandwidth` int(4) DEFAULT '0',
  `dns_cname` varchar(64) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_product
-- ----------------------------
INSERT INTO `fikcdn_product` VALUES ('1', 'CDN加速套餐', '100', '104857600', '1000', '1', '1389590309', '系统自带套餐', '1', '1', '0', null);

-- ----------------------------
-- Table structure for fikcdn_recharge
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_recharge`;
CREATE TABLE `fikcdn_recharge` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `money` float NOT NULL,
  `balance` float NOT NULL,
  `time` bigint(8) NOT NULL,
  `transactor` varchar(64) NOT NULL,
  `bank_name` varchar(64) NOT NULL,
  `serial_no` varchar(128) NOT NULL,
  `opt_username` varchar(64) DEFAULT NULL,
  `account` varchar(32) DEFAULT NULL,
  `note` varchar(128) DEFAULT NULL,
  `order_id` varchar(32) DEFAULT NULL,
  `ali_trade_no` varchar(128) DEFAULT NULL,
  `sub_ip` varchar(32) DEFAULT NULL,
  `status` int(4) DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_recharge
-- ----------------------------
INSERT INTO `fikcdn_recharge` VALUES ('1', 'client', '100000', '100000', '1389590439', '管理员', '支付宝帐号', '2345980394803', 'admin', null, '系统自带充值', null, null, null, '0');

-- ----------------------------
-- Table structure for fikcdn_task
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_task`;
CREATE TABLE `fikcdn_task` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `type` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `domain_id` int(4) NOT NULL,
  `node_id` int(4) DEFAULT NULL,
  `product_id` int(4) DEFAULT NULL,
  `buy_id` int(4) DEFAULT NULL,
  `hostname` varchar(64) DEFAULT NULL,
  `group_id` int(4) DEFAULT NULL,
  `ext` text,
  `execute_count` int(4) DEFAULT '0',
  `result_str` text,
  `url` text,
  `old_url` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_task
-- ----------------------------

-- ----------------------------
-- Table structure for fikcdn_upstream
-- ----------------------------
DROP TABLE IF EXISTS `fikcdn_upstream`;
CREATE TABLE `fikcdn_upstream` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `node_id` int(4) NOT NULL,
  `group_id` int(4) NOT NULL,
  `hostname` varchar(64) NOT NULL,
  `upstream` varchar(128) NOT NULL,
  `note` varchar(128) DEFAULT NULL,
  `upstream2` varchar(128) DEFAULT NULL,
  `upstream_add_all` smallint(2) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `index_upstream_domain_node_id` (`node_id`,`hostname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fikcdn_upstream
-- ----------------------------

-- ----------------------------
-- Table structure for realtime_list
-- ----------------------------
DROP TABLE IF EXISTS `realtime_list`;
CREATE TABLE `realtime_list` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(4) NOT NULL,
  `node_id` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `StartTime` bigint(8) NOT NULL,
  `EndTime` bigint(8) NOT NULL,
  `CurrentUserConnections` int(4) NOT NULL,
  `CurrentUpstreamConnections` int(4) NOT NULL,
  `TotalSendKB` bigint(8) NOT NULL,
  `TotalRecvKB` bigint(8) NOT NULL,
  `TotalSendToResponseKB` bigint(8) NOT NULL,
  `TotalRecvFromResponseKB` bigint(8) NOT NULL,
  `bandwidth_down` float DEFAULT '0',
  `bandwidth_up` float DEFAULT '0',
  `down_increase` bigint(8) DEFAULT '0',
  `up_increase` bigint(8) DEFAULT '0',
  `upstream_bandwidth_down` float NOT NULL DEFAULT '0',
  `upstream_bandwidth_up` float NOT NULL DEFAULT '0',
  `upstream_down_increase` bigint(8) NOT NULL DEFAULT '0',
  `upstream_up_increase` bigint(8) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of realtime_list
-- ----------------------------

-- ----------------------------
-- Table structure for realtime_list_all
-- ----------------------------
DROP TABLE IF EXISTS `realtime_list_all`;
CREATE TABLE `realtime_list_all` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `time` bigint(8) NOT NULL,
  `bandwidth_down` float DEFAULT '0' COMMENT '下载带宽',
  `bandwidth_up` float DEFAULT '0' COMMENT '上传带宽',
  `user_down` float NOT NULL DEFAULT '0' COMMENT 'MB',
  `user_up` float NOT NULL DEFAULT '0' COMMENT 'MB',
  `upstream_bandwidth_down` float NOT NULL DEFAULT '0',
  `upstream_bandwidth_up` float NOT NULL DEFAULT '0',
  `upstream_down` float NOT NULL DEFAULT '0' COMMENT 'MB',
  `upstream_up` float NOT NULL DEFAULT '0' COMMENT 'MB',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=219 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of realtime_list_all
-- ----------------------------
INSERT INTO `realtime_list_all` VALUES ('1', '1389589800', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('2', '1389590400', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('3', '1389591000', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('4', '1401156300', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('5', '1421066700', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('6', '1423200300', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('7', '1423200382', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('8', '1423200442', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('9', '1423217730', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('10', '1423217850', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('11', '1423218026', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('12', '1423230534', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('13', '1423230576', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('14', '1423542917', '0', '0', '0', '0', '0', '0', '0.066', '0');
INSERT INTO `realtime_list_all` VALUES ('15', '1423542920', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('16', '1426129803', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('17', '1426129983', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('18', '1426130163', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('19', '1426130343', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('20', '1426130523', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('21', '1426130703', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('22', '1426130883', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('23', '1426131063', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('24', '1426131243', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('25', '1426131423', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('26', '1426131604', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('27', '1426131784', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('28', '1426131964', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('29', '1432868009', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('30', '1432868189', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('31', '1433827387', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('32', '1433827467', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('33', '1437031546', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('34', '1437031726', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('35', '1437031906', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('36', '1437032086', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('37', '1437032266', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('38', '1437032447', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('39', '1437032627', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('40', '1437032807', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('41', '1437032987', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('42', '1437033167', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('43', '1437033347', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('44', '1437033527', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('45', '1437033707', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('46', '1437033888', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('47', '1437034068', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('48', '1437034248', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('49', '1437034428', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('50', '1437034608', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('51', '1437034788', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('52', '1437034968', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('53', '1437035149', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('54', '1437035329', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('55', '1437035509', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('56', '1437035689', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('57', '1437035869', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('58', '1437036049', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('59', '1437036229', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('60', '1437036410', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('61', '1437040861', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('62', '1437041041', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('63', '1437041221', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('64', '1437041401', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('65', '1437041581', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('66', '1437041761', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('67', '1437041941', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('68', '1437042122', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('69', '1437042302', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('70', '1437042482', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('71', '1437042662', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('72', '1437042842', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('73', '1437043022', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('74', '1437043202', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('75', '1437043382', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('76', '1437043562', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('77', '1437043742', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('78', '1437043922', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('79', '1437044102', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('80', '1437044282', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('81', '1437044462', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('82', '1437044642', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('83', '1437044822', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('84', '1437045002', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('85', '1437045182', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('86', '1437045363', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('87', '1437045543', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('88', '1437045723', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('89', '1437045903', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('90', '1437046083', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('91', '1437046263', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('92', '1437046443', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('93', '1437046623', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('94', '1437046804', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('95', '1437046984', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('96', '1437047164', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('97', '1437047344', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('98', '1437047524', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('99', '1437047704', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('100', '1437047884', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('101', '1437048064', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('102', '1437048244', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('103', '1437048424', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('104', '1437048604', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('105', '1437048784', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('106', '1437048964', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('107', '1437049144', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('108', '1437049325', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('109', '1437049505', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('110', '1437049685', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('111', '1437049865', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('112', '1437050045', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('113', '1437050225', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('114', '1437050405', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('115', '1437050585', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('116', '1437050765', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('117', '1437050946', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('118', '1437051126', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('119', '1437051763', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('120', '1437051943', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('121', '1437052123', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('122', '1437052303', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('123', '1437052483', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('124', '1437052663', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('125', '1437052844', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('126', '1437053024', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('127', '1437053204', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('128', '1437053384', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('129', '1437053564', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('130', '1437053744', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('131', '1437053924', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('132', '1437054104', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('133', '1437054284', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('134', '1437054464', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('135', '1437054644', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('136', '1437054824', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('137', '1437055004', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('138', '1437055185', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('139', '1437055365', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('140', '1437055545', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('141', '1437055725', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('142', '1437055905', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('143', '1437056085', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('144', '1437056265', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('145', '1437056445', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('146', '1437056625', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('147', '1437056805', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('148', '1437056986', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('149', '1437057166', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('150', '1437057346', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('151', '1437057526', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('152', '1437057706', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('153', '1437057886', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('154', '1437066005', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('155', '1437066185', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('156', '1437066365', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('157', '1437066546', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('158', '1437066726', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('159', '1437090394', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('160', '1437090574', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('161', '1437090754', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('162', '1437090934', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('163', '1437091114', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('164', '1437091294', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('165', '1437091474', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('166', '1437091655', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('167', '1437091835', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('168', '1437092015', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('169', '1437092195', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('170', '1437092375', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('171', '1437092555', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('172', '1437092735', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('173', '1437092915', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('174', '1437093095', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('175', '1437093275', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('176', '1437093455', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('177', '1437093635', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('178', '1437093816', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('179', '1437093996', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('180', '1437094176', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('181', '1437094356', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('182', '1437094536', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('183', '1437094716', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('184', '1437094896', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('185', '1437095076', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('186', '1437095256', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('187', '1437095436', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('188', '1437095616', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('189', '1437095797', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('190', '1437095977', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('191', '1437096157', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('192', '1437096337', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('193', '1437098242', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('194', '1437098422', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('195', '1437098602', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('196', '1437098782', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('197', '1437098962', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('198', '1437099142', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('199', '1437099322', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('200', '1437099502', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('201', '1442927309', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('202', '1443260605', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('203', '1443260785', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('204', '1450735824', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('205', '1450736004', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('206', '1526461041', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('207', '1526461221', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('208', '1529658078', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('209', '1529658259', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('210', '1529658439', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('211', '1529658619', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('212', '1529658799', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('213', '1529658979', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('214', '1529659159', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('215', '1529659339', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('216', '1529659519', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('217', '1529659699', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `realtime_list_all` VALUES ('218', '1529659879', '0', '0', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for realtime_list_all_day
-- ----------------------------
DROP TABLE IF EXISTS `realtime_list_all_day`;
CREATE TABLE `realtime_list_all_day` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `time` bigint(8) NOT NULL,
  `user_down` float NOT NULL DEFAULT '0' COMMENT 'MB',
  `user_up` float NOT NULL DEFAULT '0' COMMENT 'MB',
  `upstream_down` float NOT NULL DEFAULT '0' COMMENT 'MB',
  `upstream_up` float NOT NULL DEFAULT '0' COMMENT 'MB',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of realtime_list_all_day
-- ----------------------------

-- ----------------------------
-- Table structure for realtime_list_all_host
-- ----------------------------
DROP TABLE IF EXISTS `realtime_list_all_host`;
CREATE TABLE `realtime_list_all_host` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `time` bigint(8) NOT NULL,
  `user_down` float NOT NULL DEFAULT '0' COMMENT 'MB',
  `user_up` float NOT NULL DEFAULT '0' COMMENT 'MB',
  `upstream_down` float NOT NULL DEFAULT '0' COMMENT 'MB',
  `upstream_up` float NOT NULL DEFAULT '0' COMMENT 'MB',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `node_all_max_time` (`time`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of realtime_list_all_host
-- ----------------------------
INSERT INTO `realtime_list_all_host` VALUES ('1', '1389589200', '0', '0', '0', '0');
INSERT INTO `realtime_list_all_host` VALUES ('2', '1423216800', '0', '0', '0', '0');
INSERT INTO `realtime_list_all_host` VALUES ('3', '1423227600', '0', '0', '0', '0');
INSERT INTO `realtime_list_all_host` VALUES ('4', '1437033600', '0', '0', '0', '0');
INSERT INTO `realtime_list_all_host` VALUES ('5', '1437044400', '0', '0', '0', '0');
INSERT INTO `realtime_list_all_host` VALUES ('6', '1437048000', '0', '0', '0', '0');
INSERT INTO `realtime_list_all_host` VALUES ('7', '1437055200', '0', '0', '0', '0');
INSERT INTO `realtime_list_all_host` VALUES ('8', '1437066000', '0', '0', '0', '0');
INSERT INTO `realtime_list_all_host` VALUES ('9', '1437091200', '0', '0', '0', '0');
INSERT INTO `realtime_list_all_host` VALUES ('10', '1437094800', '0', '0', '0', '0');
INSERT INTO `realtime_list_all_host` VALUES ('11', '1437098400', '0', '0', '0', '0');
INSERT INTO `realtime_list_all_host` VALUES ('12', '1526461200', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for realtime_list_day
-- ----------------------------
DROP TABLE IF EXISTS `realtime_list_day`;
CREATE TABLE `realtime_list_day` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `node_id` int(4) NOT NULL,
  `group_id` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `user_down` bigint(8) NOT NULL DEFAULT '0' COMMENT 'KB',
  `user_up` bigint(8) NOT NULL DEFAULT '0' COMMENT 'KB',
  `upstream_down` bigint(8) NOT NULL DEFAULT '0' COMMENT 'KB',
  `upstream_up` bigint(8) NOT NULL DEFAULT '0' COMMENT 'KB',
  `time_for_max` bigint(8) DEFAULT '0',
  `bandwidth_down` float DEFAULT '0',
  `bandwidth_up` float DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of realtime_list_day
-- ----------------------------

-- ----------------------------
-- Table structure for realtime_list_max
-- ----------------------------
DROP TABLE IF EXISTS `realtime_list_max`;
CREATE TABLE `realtime_list_max` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(4) NOT NULL,
  `node_id` int(4) NOT NULL,
  `time` bigint(8) NOT NULL,
  `bandwidth_down` float DEFAULT '0' COMMENT '下载带宽',
  `bandwidth_up` float DEFAULT '0' COMMENT '上传带宽',
  `down_increase` bigint(8) DEFAULT '0' COMMENT '下载增量 KB',
  `up_increase` bigint(8) DEFAULT '0' COMMENT '上传增量 KB',
  `upstream_bandwidth_down` float NOT NULL DEFAULT '0',
  `upstream_bandwidth_up` float NOT NULL DEFAULT '0',
  `upstream_down_increase` bigint(8) NOT NULL DEFAULT '0' COMMENT 'KB',
  `upstream_up_increase` bigint(8) NOT NULL DEFAULT '0' COMMENT 'KB',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `node_max_time_id` (`time`,`node_id`),
  KEY `realtime_list_max_time_index` (`node_id`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of realtime_list_max
-- ----------------------------

-- ----------------------------
-- Table structure for realtime_totalstat
-- ----------------------------
DROP TABLE IF EXISTS `realtime_totalstat`;
CREATE TABLE `realtime_totalstat` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(4) DEFAULT '0',
  `node_id` int(4) DEFAULT '0',
  `time` bigint(8) DEFAULT NULL,
  `StartTime` bigint(8) DEFAULT NULL,
  `EndTime` bigint(8) DEFAULT NULL,
  `HitCachesRate` float DEFAULT '0',
  `IP` bigint(8) DEFAULT '0',
  `PV` bigint(8) DEFAULT '0',
  `TR` bigint(8) DEFAULT '0',
  `PR` float DEFAULT NULL,
  `RealTimeReport` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of realtime_totalstat
-- ----------------------------
