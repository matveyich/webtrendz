/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50026
Source Host           : localhost:3306
Source Database       : extra

Target Server Type    : MYSQL
Target Server Version : 50026
File Encoding         : 65001

Date: 2010-06-14 22:29:29
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `so_categories`
-- ----------------------------
DROP TABLE IF EXISTS `so_categories`;
CREATE TABLE `so_categories` (
  `ID` int(11) NOT NULL auto_increment,
  `Name` varchar(256) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of so_categories
-- ----------------------------
INSERT INTO `so_categories` VALUES ('1', 'Hotel');
INSERT INTO `so_categories` VALUES ('2', 'Holiday');
INSERT INTO `so_categories` VALUES ('3', 'Tour');
