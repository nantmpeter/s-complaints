/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50615
Source Host           : localhost:3306
Source Database       : an

Target Server Type    : MYSQL
Target Server Version : 50615
File Encoding         : 65001

Date: 2014-11-09 11:55:13
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `dic_complaints_type_manage`
-- ----------------------------
DROP TABLE IF EXISTS `dic_complaints_type_manage`;
CREATE TABLE `dic_complaints_type_manage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键词',
  `complaints_problem_type` varchar(60) DEFAULT NULL COMMENT '投诉问题类型',
  `complaints_type` varchar(60) DEFAULT NULL COMMENT '投诉分类',
  `complaints_type_sort` int(11) DEFAULT NULL COMMENT '投诉分类排序',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `del_flag` tinyint(2) DEFAULT '0' COMMENT '删除标记 0 未删除 1已删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='投诉类型及问题分类管理';

-- ----------------------------
-- Records of dic_complaints_type_manage
-- ----------------------------
INSERT INTO dic_complaints_type_manage VALUES ('1', '的防守对方', '其他', '业务可用性', '1', '2014-11-08 14:51:29', '2014-11-08 17:54:02', '0');
INSERT INTO dic_complaints_type_manage VALUES ('2', null, '系统支撑不到位业务不可用', '业务可用性', '2', '2014-11-08 14:51:32', '2014-11-08 14:51:33', '0');
INSERT INTO dic_complaints_type_manage VALUES ('3', null, '内容设计不合理', '业务可用性', '3', '2014-11-08 14:51:33', '2014-11-08 14:51:34', '0');
INSERT INTO dic_complaints_type_manage VALUES ('4', null, '产品功能设计不完善', '业务可用性', '4', '2014-11-08 14:51:34', '2014-11-08 14:51:40', '0');
INSERT INTO dic_complaints_type_manage VALUES ('5', '士大夫|士大夫', '其他', '服务规范性', '5', '2014-11-08 14:51:35', '2014-11-08 17:55:29', '0');
INSERT INTO dic_complaints_type_manage VALUES ('6', null, '业务信息不规范', '服务规范性', '6', '2014-11-08 14:51:35', '2014-11-08 14:51:42', '0');
INSERT INTO dic_complaints_type_manage VALUES ('7', null, '收费不规范', '服务规范性', '7', '2014-11-08 14:51:36', '2014-11-08 14:51:43', '0');
INSERT INTO dic_complaints_type_manage VALUES ('8', null, '资费不明确', '服务规范性', '8', '2014-11-08 14:51:37', '2014-11-08 14:51:43', '0');
INSERT INTO dic_complaints_type_manage VALUES ('9', null, '业务取消不规范', '服务规范性', '9', '2014-11-08 14:51:37', '2014-11-08 14:51:44', '0');
INSERT INTO dic_complaints_type_manage VALUES ('10', null, '定制不规范', '服务规范性', '10', '2014-11-08 14:51:39', '2014-11-08 14:51:45', '0');
INSERT INTO dic_complaints_type_manage VALUES ('11', '地方官', '用户自行定制业务', '用户原因', '11', '2014-11-08 14:51:38', '2014-11-08 17:55:35', '0');
