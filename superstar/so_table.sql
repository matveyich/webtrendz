/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50026
Source Host           : localhost:3306
Source Database       : extra

Target Server Type    : MYSQL
Target Server Version : 50026
File Encoding         : 65001

Date: 2010-06-14 22:29:23
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `so_table`
-- ----------------------------
DROP TABLE IF EXISTS `so_table`;
CREATE TABLE `so_table` (
  `ID` int(11) NOT NULL auto_increment,
  `destination` smallint(6) default NULL,
  `category` smallint(6) default NULL,
  `resort_name` varchar(256) default NULL,
  `room_type` varchar(256) default NULL,
  `num_of_nights` varchar(256) default NULL,
  `stars` varchar(256) default NULL,
  `tour_type` varchar(256) default NULL,
  `direct_flights` varchar(512) default NULL,
  `departure_date` varchar(128) default NULL,
  `board_type` varchar(256) default NULL,
  `price` varchar(256) default NULL,
  `link` varchar(512) default NULL,
  `img_src` varchar(512) default NULL,
  `featured` tinyint(4) default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of so_table
-- ----------------------------
INSERT INTO `so_table` VALUES ('1', '2', '2', '1st', 'huge', '4', '4', 'cool', 'no', 'today', 'nice', '100$', 'google.com', 'so_1_2649-bild.jpg', '1');
