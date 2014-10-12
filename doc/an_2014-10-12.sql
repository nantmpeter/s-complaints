# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.15)
# Database: an
# Generation Time: 2014-10-12 15:12:16 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table co_base
# ------------------------------------------------------------

DROP TABLE IF EXISTS `co_base`;

CREATE TABLE `co_base` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `province_id` varchar(255) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `order_time` varchar(255) DEFAULT '',
  `complaint_phone` varchar(255) DEFAULT NULL,
  `complaint_content` blob,
  `sp_name` varchar(255) DEFAULT NULL,
  `sp_corp_code` varchar(255) DEFAULT NULL,
  `sp_code` varchar(255) DEFAULT NULL,
  `suggestion` varchar(255) DEFAULT NULL,
  `order_department` varchar(255) DEFAULT NULL,
  `buss_department` varchar(255) DEFAULT NULL,
  `buss_name` varchar(255) DEFAULT NULL,
  `buss_name_detail` varchar(255) DEFAULT NULL,
  `buss_rates` varchar(255) DEFAULT NULL,
  `problem` varchar(255) DEFAULT NULL,
  `reconciliations` varchar(255) DEFAULT NULL,
  `charge_back` varchar(255) DEFAULT NULL,
  `buss_type` varchar(255) DEFAULT NULL,
  `buss_type_name` varchar(255) DEFAULT NULL,
  `complaint_type` varchar(255) DEFAULT NULL,
  `problem_type` varchar(255) DEFAULT NULL,
  `problem_result` varchar(255) DEFAULT NULL,
  `complaint_level` varchar(255) DEFAULT NULL,
  `buss_line` varchar(255) DEFAULT NULL,
  `work_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table co_complaints
# ------------------------------------------------------------

DROP TABLE IF EXISTS `co_complaints`;

CREATE TABLE `co_complaints` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `complaints_id` varchar(255) DEFAULT NULL,
  `case_id` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `dispute_phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `about_corp` varchar(255) DEFAULT NULL,
  `corp_area` varchar(255) DEFAULT NULL,
  `type_one` varchar(255) DEFAULT NULL,
  `type_two` varchar(255) DEFAULT NULL,
  `type_three` varchar(255) DEFAULT NULL,
  `buss_one` varchar(255) DEFAULT NULL,
  `buss_two` varchar(255) DEFAULT NULL,
  `buss_three` varchar(255) DEFAULT NULL,
  `buss_four` varchar(255) DEFAULT NULL,
  `complaint_source` varchar(255) DEFAULT NULL,
  `comfirm_user` varchar(255) DEFAULT NULL,
  `complaint_time` varchar(255) DEFAULT NULL,
  `get_time` varchar(255) DEFAULT NULL,
  `handle_time` varchar(255) DEFAULT NULL,
  `complaint_content` blob,
  `complaint10010` varchar(255) DEFAULT NULL,
  `10010status` blob,
  `complaint10015` varchar(255) DEFAULT NULL,
  `10015status` blob,
  `complaint_status` blob,
  `problem` varchar(255) DEFAULT NULL,
  `problem_type` varchar(255) DEFAULT NULL,
  `contact_element` varchar(255) DEFAULT NULL,
  `element` varchar(255) DEFAULT NULL,
  `buss_type` varchar(255) DEFAULT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `problem_channel` varchar(255) DEFAULT NULL,
  `service_need` varchar(255) DEFAULT NULL,
  `buss_way` varchar(255) DEFAULT NULL,
  `netproblem` varchar(255) DEFAULT NULL,
  `phoneproblem` varchar(255) DEFAULT NULL,
  `vipuser` varchar(255) DEFAULT NULL,
  `partment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table co_custom
# ------------------------------------------------------------

DROP TABLE IF EXISTS `co_custom`;

CREATE TABLE `co_custom` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) DEFAULT NULL,
  `sub_order_id` varchar(255) DEFAULT NULL,
  `part_name` varchar(255) DEFAULT NULL,
  `responsibility_code` varchar(255) DEFAULT NULL,
  `responsibility_name` varchar(255) DEFAULT NULL,
  `part_code` varchar(255) DEFAULT NULL,
  `order_time` varchar(255) DEFAULT NULL,
  `buss_type` varchar(255) DEFAULT NULL,
  `buss_type_code` varchar(255) DEFAULT NULL,
  `buss_name` varchar(255) DEFAULT NULL,
  `buss_code` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `complaint_status` varchar(255) DEFAULT NULL,
  `appeal_status` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `complaint_phone` varchar(255) DEFAULT NULL,
  `complaint_type` varchar(255) DEFAULT NULL,
  `custom` varchar(255) DEFAULT NULL,
  `complaint_total` varchar(255) DEFAULT NULL,
  `complaint_content` blob,
  `appeal_content` blob,
  `province_id` varchar(255) DEFAULT NULL,
  `cooperative` varchar(255) DEFAULT NULL,
  `all_net` varchar(255) DEFAULT NULL,
  `order_end_time` varchar(255) DEFAULT NULL,
  `complaint_id` varchar(50) DEFAULT NULL,
  `deductions` varchar(50) DEFAULT NULL,
  `buss_line` varchar(50) DEFAULT NULL,
  `month` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table co_income
# ------------------------------------------------------------

DROP TABLE IF EXISTS `co_income`;

CREATE TABLE `co_income` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `province_id` varchar(255) DEFAULT NULL,
  `sp_name` varchar(255) DEFAULT NULL,
  `sp_code` varchar(255) DEFAULT NULL,
  `buss_type` varchar(255) DEFAULT NULL,
  `province_income` varchar(255) DEFAULT NULL,
  `sp_income` varchar(255) DEFAULT NULL,
  `owe` varchar(255) DEFAULT NULL,
  `tuipei_cost` varchar(255) DEFAULT NULL,
  `imbalance_cost` varchar(255) DEFAULT NULL,
  `20_cost` varchar(255) DEFAULT NULL,
  `diaozhang_cost` varchar(255) DEFAULT NULL,
  `violate_cost` varchar(255) DEFAULT NULL,
  `custom_cost` varchar(255) DEFAULT NULL,
  `month` varchar(50) DEFAULT NULL,
  `mastsp_code` varchar(50) DEFAULT NULL,
  `mastsp_cost` varchar(50) DEFAULT NULL,
  `mastsp_sleave` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table osa_menu_url
# ------------------------------------------------------------

DROP TABLE IF EXISTS `osa_menu_url`;

CREATE TABLE `osa_menu_url` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(50) NOT NULL,
  `menu_url` varchar(255) NOT NULL,
  `module_id` int(11) NOT NULL,
  `is_show` tinyint(4) NOT NULL COMMENT '是否在sidebar里出现',
  `online` int(11) NOT NULL DEFAULT '1' COMMENT '在线状态，还是下线状态，即可用，不可用。',
  `shortcut_allowed` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '是否允许快捷访问',
  `menu_desc` varchar(255) DEFAULT NULL,
  `father_menu` int(11) NOT NULL DEFAULT '0' COMMENT '上一级菜单',
  PRIMARY KEY (`menu_id`),
  UNIQUE KEY `menu_url` (`menu_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='功能链接（菜单链接）';



# Dump of table osa_module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `osa_module`;

CREATE TABLE `osa_module` (
  `module_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) NOT NULL,
  `module_url` varchar(128) NOT NULL,
  `module_sort` int(11) unsigned NOT NULL DEFAULT '1',
  `module_desc` varchar(255) DEFAULT NULL,
  `module_icon` varchar(32) DEFAULT 'icon-th' COMMENT '菜单模块图标',
  `online` int(11) NOT NULL DEFAULT '1' COMMENT '模块是否在线',
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单模块';



# Dump of table osa_quick_note
# ------------------------------------------------------------

DROP TABLE IF EXISTS `osa_quick_note`;

CREATE TABLE `osa_quick_note` (
  `note_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'note_id',
  `note_content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `owner_id` int(10) unsigned NOT NULL COMMENT '谁添加的',
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用于显示的quick note';



# Dump of table osa_sys_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `osa_sys_log`;

CREATE TABLE `osa_sys_log` (
  `op_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  `action` varchar(255) NOT NULL,
  `class_name` varchar(255) NOT NULL COMMENT '操作了哪个类的对象',
  `class_obj` varchar(32) NOT NULL COMMENT '操作的对象是谁，可能为对象的ID',
  `result` text NOT NULL COMMENT '操作的结果',
  `op_time` int(11) NOT NULL,
  PRIMARY KEY (`op_id`),
  KEY `op_time` (`op_time`),
  KEY `class_name` (`class_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作日志表';



# Dump of table osa_system
# ------------------------------------------------------------

DROP TABLE IF EXISTS `osa_system`;

CREATE TABLE `osa_system` (
  `key_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `key_value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='系统配置表';



# Dump of table osa_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `osa_user`;

CREATE TABLE `osa_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `real_name` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_desc` varchar(255) DEFAULT NULL,
  `login_time` int(11) DEFAULT NULL COMMENT '登录时间',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `login_ip` varchar(32) DEFAULT NULL,
  `user_group` int(11) NOT NULL,
  `template` varchar(32) NOT NULL DEFAULT 'default' COMMENT '主题模板',
  `shortcuts` text COMMENT '快捷菜单',
  `show_quicknote` int(11) NOT NULL DEFAULT '1' COMMENT '是否显示quicknote',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台用户';



# Dump of table osa_user_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `osa_user_group`;

CREATE TABLE `osa_user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) DEFAULT NULL,
  `group_role` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '初始权限为1,5,17,18,22,23,24,25',
  `owner_id` int(11) DEFAULT NULL COMMENT '创建人ID',
  `group_desc` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='账号组';



# Dump of table province
# ------------------------------------------------------------

DROP TABLE IF EXISTS `province`;

CREATE TABLE `province` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `pinyin` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sample
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sample`;

CREATE TABLE `sample` (
  `sample_id` int(11) NOT NULL,
  `sample_content` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
