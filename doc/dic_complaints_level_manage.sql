/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50615
Source Host           : localhost:3306
Source Database       : an

Target Server Type    : MYSQL
Target Server Version : 50615
File Encoding         : 65001

Date: 2014-11-09 11:55:07
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `dic_complaints_level_manage`
-- ----------------------------
DROP TABLE IF EXISTS `dic_complaints_level_manage`;
CREATE TABLE `dic_complaints_level_manage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键词',
  `complaints_type` varchar(60) DEFAULT NULL COMMENT '投诉分类',
  `complaints_level` varchar(60) DEFAULT NULL COMMENT '投诉分级',
  `complaints_level_sort` int(11) DEFAULT NULL COMMENT '投诉分级排序',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `del_flag` tinyint(2) DEFAULT '0' COMMENT '删除标记 0未删除 1已删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='投诉分级管理';

-- ----------------------------
-- Records of dic_complaints_level_manage
-- ----------------------------
INSERT INTO dic_complaints_level_manage VALUES ('1', '士大夫', '10015集团受理', '越级投诉', '1', '2014-11-08 14:13:36', '2014-11-08 17:49:08', '0');
INSERT INTO dic_complaints_level_manage VALUES ('2', '地方官', '公众渠道', '越级投诉', '2', '2014-11-08 14:15:38', '2014-11-08 17:49:12', '0');
INSERT INTO dic_complaints_level_manage VALUES ('3', '地方官', '省通管局投诉', '越级投诉', '3', '2014-11-08 14:15:40', '2014-11-08 17:49:15', '0');
INSERT INTO dic_complaints_level_manage VALUES ('4', '地方官', '工信部投诉', '越级投诉', '4', '2014-11-08 14:15:40', '2014-11-08 17:49:17', '0');
INSERT INTO dic_complaints_level_manage VALUES ('5', '人', '专业投诉', '疑难投诉', '5', '2014-11-08 14:15:42', '2014-11-08 17:49:20', '0');
INSERT INTO dic_complaints_level_manage VALUES ('6', '地方', '恶意投诉', '疑难投诉', '6', '2014-11-08 14:15:44', '2014-11-08 17:48:18', '0');
INSERT INTO dic_complaints_level_manage VALUES ('7', '个', '高额赔付', '疑难投诉', '7', '2014-11-08 14:15:46', '2014-11-08 17:48:21', '0');
INSERT INTO dic_complaints_level_manage VALUES ('8', '地方官', '态度强烈', '疑难投诉', '8', '2014-11-08 14:15:47', '2014-11-08 17:48:22', '0');
INSERT INTO dic_complaints_level_manage VALUES ('9', 'dfgdfg|sdf第三方', '一般投诉', '一般投诉', '9', '2014-11-08 14:15:48', '2014-11-08 17:48:24', '0');
