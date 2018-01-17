/*
Navicat MySQL Data Transfer

Source Server         : 微信小程序数据库
Source Server Version : 50628
Source Host           : 数据库url:port
Source Database       : sca

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2018-01-17 15:06:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sca_admin
-- ----------------------------
DROP TABLE IF EXISTS `sca_admin`;
CREATE TABLE `sca_admin` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(10) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sca_admin
-- ----------------------------
INSERT INTO `sca_admin` VALUES ('1', '2017001', 'e8cc30392cc453bb1f37e2340577063f');
INSERT INTO `sca_admin` VALUES ('2', '2017002', 'e8cc30392cc453bb1f37e2340577063f');

-- ----------------------------
-- Table structure for sca_seat
-- ----------------------------
DROP TABLE IF EXISTS `sca_seat`;
CREATE TABLE `sca_seat` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `location` varchar(10) NOT NULL,
  `code` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sca_seat
-- ----------------------------
INSERT INTO `sca_seat` VALUES ('1', '二层03排04号', '20304');
INSERT INTO `sca_seat` VALUES ('2', '二层03排05号', '20305');
INSERT INTO `sca_seat` VALUES ('3', '二层03排06号', '20306');
INSERT INTO `sca_seat` VALUES ('4', '二层03排07号', '20307');
INSERT INTO `sca_seat` VALUES ('5', '二层03排08号', '20308');
INSERT INTO `sca_seat` VALUES ('6', '二层03排09号', '20309');
INSERT INTO `sca_seat` VALUES ('7', '二层03排10号', '20310');

-- ----------------------------
-- Table structure for sca_user
-- ----------------------------
DROP TABLE IF EXISTS `sca_user`;
CREATE TABLE `sca_user` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) DEFAULT NULL COMMENT '微信唯一',
  `number` varchar(10) DEFAULT NULL COMMENT '学号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sca_user
-- ----------------------------

-- ----------------------------
-- Table structure for sca_yxwh
-- ----------------------------
DROP TABLE IF EXISTS `sca_yxwh`;
CREATE TABLE `sca_yxwh` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `number` varchar(10) NOT NULL,
  `qrcode_url` varchar(100) DEFAULT NULL COMMENT '二维码链接',
  `qrcode` varchar(15) NOT NULL COMMENT '位置信息',
  `ticket_status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sca_yxwh
-- ----------------------------
INSERT INTO `sca_yxwh` VALUES ('1', '2015413845', 'http://app2.showapi.com/img/qrCode/20180117/1516119952120.jpg', '20302', '0');
INSERT INTO `sca_yxwh` VALUES ('2', '2015413849', 'http://app2.showapi.com/img/qrCode/20180117/1516119952234.jpg', '20303', '0');
