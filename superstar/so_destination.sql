/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50026
Source Host           : localhost:3306
Source Database       : extra

Target Server Type    : MYSQL
Target Server Version : 50026
File Encoding         : 65001

Date: 2010-06-14 22:29:17
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `so_destination`
-- ----------------------------
DROP TABLE IF EXISTS `so_destination`;
CREATE TABLE `so_destination` (
  `ID` int(11) NOT NULL auto_increment,
  `Name` varchar(256) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of so_destination
-- ----------------------------
INSERT INTO `so_destination` VALUES ('1', 'Ber Sheva');
INSERT INTO `so_destination` VALUES ('2', 'Caesarea');
INSERT INTO `so_destination` VALUES ('3', 'Dead Sea');
INSERT INTO `so_destination` VALUES ('4', 'Eilat');
INSERT INTO `so_destination` VALUES ('5', 'Haifa');
INSERT INTO `so_destination` VALUES ('6', 'Herzliya');
INSERT INTO `so_destination` VALUES ('7', 'Jerusalem');
INSERT INTO `so_destination` VALUES ('8', 'Netanya');
INSERT INTO `so_destination` VALUES ('9', 'Tel Aviv');
INSERT INTO `so_destination` VALUES ('10', 'Tiberias');
