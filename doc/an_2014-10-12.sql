# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.15)
# Database: an
# Generation Time: 2014-10-12 15:40:47 +0000
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

LOCK TABLES `co_base` WRITE;
/*!40000 ALTER TABLE `co_base` DISABLE KEYS */;

INSERT INTO `co_base` (`id`, `province_id`, `order_id`, `order_time`, `complaint_phone`, `complaint_content`, `sp_name`, `sp_corp_code`, `sp_code`, `suggestion`, `order_department`, `buss_department`, `buss_name`, `buss_name_detail`, `buss_rates`, `problem`, `reconciliations`, `charge_back`, `buss_type`, `buss_type_name`, `complaint_type`, `problem_type`, `problem_result`, `complaint_level`, `buss_line`, `work_id`)
VALUES
	(1,'1','1','1409673600','1',X'31','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1'),
	(2,'2','2','1409673600','2',X'32','2','2','2','2','2','2','23','2','2','2','2','2','2','2','2','2','2','2','2','2'),
	(3,'3','3','1409673600','3',X'33','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3'),
	(4,'4','4','1409673600','4',X'34','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4'),
	(5,'5','5','1409673600','5',X'35','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5'),
	(6,'6','6','1409673600','6',X'36','6','6','6','6','6','6','6','6','6','6','6','6','6','6','6','6','6','6','6','6'),
	(7,'7','7','1409673600','7',X'37','7','7','7','7','7','7','7','7','7','7','7','7','7','7','7','7','7','7','7','7'),
	(8,'8','8','1409673600','8',X'38','8','8','8','8','8','8','8','8','8','8','8','8','8','8','8','8','8','8','8','8'),
	(9,'9','9','1409673600','9',X'39','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9'),
	(10,'10','10','1409673600','10',X'3130','10','10','10','10','10','10','10','10','10','10','10','10','10','10','10','10','10','10','10','10'),
	(11,'11','11','1409673600','11',X'3131','11','11','11','11','11','11','11','11','11','11','11','11','11','11','11','11','11','11','11','11'),
	(12,'12','12','1409673600','12',X'3132','12','12','12','12','12','12','12','12','12','12','12','12','12','12','12','12','12','12','12','12'),
	(13,'13','13','1409673600','13',X'3133','13','13','13','13','13','13','13','13','13','13','13','13','13','13','13','13','13','13','13','13'),
	(14,'14','14','1409673600','14',X'3134','14','14','14','14','14','14','14','14','14','14','14','14','14','14','14','14','14','14','14','14'),
	(15,'15','15','1409673600','15',X'3135','15','15','15','15','15','15','15','15','15','15','15','15','15','15','15','15','15','15','15','15'),
	(16,'16','16','1409673600','16',X'3136','16','16','16','16','16','16','16','16','16','16','16','16','16','16','16','16','16','16','16','16'),
	(17,'17','17','1409673600','17',X'3137','17','17','17','17','17','17','17','17','17','17','17','17','17','17','17','17','17','17','17','17'),
	(18,'18','18','1409673600','18',X'3138','18','18','18','18','18','18','18','18','18','18','18','18','18','18','18','18','18','18','18','18'),
	(19,'19','19','1409673600','19',X'3139','19','19','19','19','19','19','19','19','19','19','19','19','19','19','19','19','19','19','19','19'),
	(20,'20','20','1409673600','20',X'3230','20','20','20','20','20','20','20','20','20','20','20','20','20','20','20','20','20','20','20','20'),
	(21,'21','21','1409673600','21',X'3231','21','21','21','21','21','21','21','21','21','21','21','21','21','21','21','21','21','21','21','21'),
	(22,'22','22','1409673600','22',X'3232','22','22','22','22','22','22','22','22','22','22','22','22','22','22','22','22','22','22','22','22'),
	(23,'23','23','1409673600','23',X'3233','23','23','23','23','23','23','23','23','23','23','23','23','23','23','23','23','23','23','23','23'),
	(24,'24','24','1409673600','24',X'3234','24','24','24','24','24','24','24','24','24','24','24','24','24','24','24','24','24','24','24','24'),
	(25,'1','1','1409673600','1',X'31','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1'),
	(26,'2','2','1409673600','2',X'32','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2'),
	(27,'3','3','1409673600','3',X'33','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3'),
	(28,'4','4','1409673600','4',X'34','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4'),
	(29,'5','5','1409673600','5',X'35','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5'),
	(30,'6','6','1409673600','6',X'36','6','6','6','6','6','6','6','6','6','6','6','6','6','6','6','6','6','6','6','6'),
	(31,'7','7','1409673600','7',X'37','7','7','7','7','7','7','7','7','7','7','7','7','7','7','7','7','7','7','7','7'),
	(32,'8','8','1409673600','8',X'38','8','8','8','8','8','8','8','8','8','8','8','8','8','8','8','8','8','8','8','8'),
	(33,'9','9','1409673600','9',X'39','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9'),
	(34,'10','10','1409673600','10',X'3130','10','10','10','10','10','10','10','10','10','10','10','10','10','10','10','10','10','10','10','10'),
	(35,'11','11','1409673600','11',X'3131','11','11','11','11','11','11','11','11','11','11','11','11','11','11','11','11','11','11','11','11'),
	(36,'12','12','1409673600','12',X'3132','12','12','12','12','12','12','12','12','12','12','12','12','12','12','12','12','12','12','12','12'),
	(37,'13','13','1409673600','13',X'3133','13','13','13','13','13','13','13','13','13','13','13','13','13','13','13','13','13','13','13','13'),
	(38,'14','14','1409673600','14',X'3134','14','14','14','14','14','14','14','14','14','14','14','14','14','14','14','14','14','14','14','14'),
	(39,'15','15','1409673600','15',X'3135','15','15','15','15','15','15','15','15','15','15','15','15','15','15','15','15','15','15','15','15'),
	(40,'16','16','1409673600','16',X'3136','16','16','16','16','16','16','16','16','16','16','16','16','16','16','16','16','16','16','16','16'),
	(41,'17','17','1409673600','17',X'3137','17','17','17','17','17','17','17','17','17','17','17','17','17','17','17','17','17','17','17','17'),
	(42,'18','18','1409673600','18',X'3138','18','18','18','18','18','18','18','18','18','18','18','18','18','18','18','18','18','18','18','18'),
	(43,'19','19','1409673600','19',X'3139','19','19','19','19','19','19','19','19','19','19','19','19','19','19','19','19','19','19','19','19'),
	(44,'20','20','1409673600','20',X'3230','20','20','20','20','20','20','20','20','20','20','20','20','20','20','20','20','20','20','20','20'),
	(45,'21','21','1409673600','21',X'3231','21','21','21','21','21','21','21','21','21','21','21','21','21','21','21','21','21','21','21','21'),
	(46,'22','22','1409673600','22',X'3232','22','22','22','22','22','22','22','22','22','22','22','22','22','22','22','22','22','22','22','22'),
	(47,'23','23','1409673600','23',X'3233','23','23','23','23','23','23','23','23','23','23','23','23','23','23','23','23','23','23','23','23'),
	(48,'24','24','1409673600','24',X'3234','24','24','24','24','24','24','24','24','24','24','24','24','24','24','24','24','24','24','24','24');

/*!40000 ALTER TABLE `co_base` ENABLE KEYS */;
UNLOCK TABLES;


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

LOCK TABLES `osa_menu_url` WRITE;
/*!40000 ALTER TABLE `osa_menu_url` DISABLE KEYS */;

INSERT INTO `osa_menu_url` (`menu_id`, `menu_name`, `menu_url`, `module_id`, `is_show`, `online`, `shortcut_allowed`, `menu_desc`, `father_menu`)
VALUES
	(1,'首页','/panel/index.php',1,0,1,1,'后台首页',0),
	(2,'账号列表','/panel/users.php',1,1,1,1,'账号列表',0),
	(3,'修改账号','/panel/user_modify.php',1,0,1,0,'修改账号',2),
	(4,'新建账号','/panel/user_add.php',1,0,1,1,'新建账号',2),
	(5,'个人信息','/panel/profile.php',1,0,1,1,'个人信息',0),
	(6,'账号组成员','/panel/group.php',1,0,1,0,'显示账号组详情及该组成员',7),
	(7,'账号组管理','/panel/groups.php',1,1,1,1,'增加管理员',0),
	(8,'修改账号组','/panel/group_modify.php',1,0,1,0,'修改账号组',7),
	(9,'新建账号组','/panel/group_add.php',1,0,1,1,'新建账号组',7),
	(10,'权限管理','/panel/group_role.php',1,1,1,1,'用户权限依赖于账号组的权限',0),
	(11,'菜单模块','/panel/modules.php',1,1,1,1,'菜单里的模块',0),
	(12,'编辑菜单模块','/panel/module_modify.php',1,0,1,0,'编辑模块',11),
	(13,'添加菜单模块','/panel/module_add.php',1,0,1,1,'添加菜单模块',11),
	(14,'功能列表','/panel/menus.php',1,1,1,1,'菜单功能及可访问的链接',0),
	(15,'增加功能','/panel/menu_add.php',1,0,1,1,'增加功能',14),
	(16,'功能修改','/panel/menu_modify.php',1,0,1,0,'修改功能',14),
	(17,'设置模板','/panel/set.php',1,0,1,1,'设置模板',0),
	(18,'便签管理','/panel/quicknotes.php',1,1,1,1,'quick note',0),
	(19,'菜单链接列表','/panel/module.php',1,0,1,0,'显示模块详情及该模块下的菜单',11),
	(20,'登入','/login.php',1,0,1,1,'登入页面',0),
	(21,'操作记录','/panel/syslog.php',1,1,1,1,'用户操作的历史行为',0),
	(22,'系统信息','/panel/system.php',1,1,1,1,'显示系统相关信息',0),
	(23,'ajax访问修改快捷菜单','/ajax/shortcut.php',1,0,1,0,'ajax请求',0),
	(24,'添加便签','/panel/quicknote_add.php',1,0,1,1,'添加quicknote的内容',18),
	(25,'修改便签','/panel/quicknote_modify.php',1,0,1,0,'修改quicknote的内容',18),
	(26,'系统设置','/panel/setting.php',1,0,1,0,'系统设置',0),
	(101,'样例','/sample/sample.php',2,1,1,1,'',0),
	(103,'读取XLS文件','/sample/read_excel.php',2,1,1,1,'',0),
	(104,'数据导入','/complaint/import.php',3,1,1,1,'',0),
	(105,'基本信息分析','/pannel/pannel',3,0,1,1,'',0),
	(106,'全国投诉情况分析','/complaint/analyze.php',3,1,1,1,'',105),
	(107,'客户投诉查询','/complaint/search.php',3,1,1,1,'',0),
	(108,'不规范定制查询','/complaint/custom_search.php',3,1,1,1,'',0),
	(109,'不规范定制分析','/complaint/custom_analyze.php',3,1,1,1,'',0),
	(110,'工信部投诉查询','/complaint/complaints_search.php',3,1,1,1,'',0),
	(111,'全国不规范定制件数/各省业务收入','/complaint/custom_analyze2.php',3,0,1,1,'',106);

/*!40000 ALTER TABLE `osa_menu_url` ENABLE KEYS */;
UNLOCK TABLES;


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

LOCK TABLES `osa_module` WRITE;
/*!40000 ALTER TABLE `osa_module` DISABLE KEYS */;

INSERT INTO `osa_module` (`module_id`, `module_name`, `module_url`, `module_sort`, `module_desc`, `module_icon`, `online`)
VALUES
	(1,'控制面板','/panel/index.php',0,'配置OSAdmin的相关功能','icon-th',1),
	(2,'样例模块','/panel/index.php',1,'样例模块','icon-leaf',1),
	(3,'客诉分析','/index.php',1,'','icon-th',1);

/*!40000 ALTER TABLE `osa_module` ENABLE KEYS */;
UNLOCK TABLES;


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

LOCK TABLES `osa_sys_log` WRITE;
/*!40000 ALTER TABLE `osa_sys_log` DISABLE KEYS */;

INSERT INTO `osa_sys_log` (`op_id`, `user_name`, `action`, `class_name`, `class_obj`, `result`, `op_time`)
VALUES
	(1,'admin','LOGIN','User','1','{\"IP\":\"127.0.0.1\"}',1410686072),
	(2,'admin','LOGIN','User','1','{\"IP\":\"127.0.0.1\"}',1410686133),
	(3,'admin','ADD','Module','3','{\"module_name\":\"\\u5ba2\\u8bc9\\u5206\\u6790\",\"module_desc\":\"\",\"module_url\":\"\\/index.php\",\"module_sort\":1,\"module_icon\":\"icon-th\"}',1410686184),
	(4,'admin','ADD','MenuUrl','104','{\"menu_name\":\"\\u6570\\u636e\\u5bfc\\u5165\",\"menu_url\":\"\\/complaint\\/import.php\",\"module_id\":\"3\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1410686332),
	(5,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104\"}',1410686338),
	(6,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1410786335),
	(7,'admin','ADD','MenuUrl','105','{\"menu_name\":\"\\u57fa\\u672c\\u4fe1\\u606f\\u5206\\u6790\",\"menu_url\":\"\\/pannel\\/pannel\",\"module_id\":\"3\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1410875867),
	(8,'admin','ADD','MenuUrl','106','{\"menu_name\":\"\\u5168\\u56fd\\u6295\\u8bc9\\u60c5\\u51b5\\u5206\\u6790\",\"menu_url\":\"\\/\",\"module_id\":\"3\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"105\"}',1410875928),
	(9,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106\"}',1410875938),
	(10,'admin','MODIFY','MenuUrl','106','{\"menu_name\":\"\\u5168\\u56fd\\u6295\\u8bc9\\u60c5\\u51b5\\u5206\\u6790\",\"menu_url\":\"\\/complaint\\/analyze.php\",\"is_show\":\"1\",\"online\":\"1\",\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"105\",\"module_id\":\"3\"}',1410876685),
	(11,'admin','MODIFY','MenuUrl','105','{\"menu_name\":\"\\u57fa\\u672c\\u4fe1\\u606f\\u5206\\u6790\",\"menu_url\":\"\\/pannel\\/pannel\",\"is_show\":\"0\",\"online\":\"1\",\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\",\"module_id\":\"3\"}',1410876737),
	(12,'admin','ADD','MenuUrl','107','{\"menu_name\":\"\\u5ba2\\u6237\\u6295\\u8bc9\\u67e5\\u8be2\",\"menu_url\":\"\\/complaint\\/search.php\",\"module_id\":\"3\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1410958886),
	(13,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106,107\"}',1410958899),
	(14,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1410964462),
	(15,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1411136382),
	(16,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1411701269),
	(17,'admin','LOGOUT','User','1','',1411715647),
	(18,'test','LOGIN','User','','\"\\u7528\\u6237\\u540d\\u6216\\u5bc6\\u7801\\u9519\\u8bef\"',1411715663),
	(19,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1411715686),
	(20,'admin','LOGOUT','User','1','',1411715780),
	(21,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1411715795),
	(22,'admin','LOGOUT','User','1','',1411715824),
	(23,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1411715837),
	(24,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1411919513),
	(25,'admin','ADD','MenuUrl','108','{\"menu_name\":\"\\u4e0d\\u89c4\\u8303\\u5b9a\\u5236\\u67e5\\u8be2\",\"menu_url\":\"\\/complaint\\/custom_search.php\",\"module_id\":\"3\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1411997764),
	(26,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106,107,108\"}',1411997780),
	(27,'admin','ADD','MenuUrl','109','{\"menu_name\":\"\\u4e0d\\u89c4\\u8303\\u5b9a\\u5236\\u5206\\u6790\",\"menu_url\":\"\\/complaint\\/custom_analyze.php\",\"module_id\":\"3\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1412005916),
	(28,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106,107,108,109\"}',1412005927),
	(29,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1412139249),
	(30,'admin','ADD','MenuUrl','110','{\"menu_name\":\"\\u5de5\\u4fe1\\u90e8\\u6295\\u8bc9\\u67e5\\u8be2\",\"menu_url\":\"\\/complaint\\/complaints_search.php\",\"module_id\":\"3\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1412147397),
	(31,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106,107,108,109,110\"}',1412147459),
	(32,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1412512265),
	(33,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1412681973),
	(34,'admin','LOGOUT','User','1','',1412685805),
	(35,'test','LOGIN','User','','\"\\u7528\\u6237\\u540d\\u6216\\u5bc6\\u7801\\u9519\\u8bef\"',1412685816),
	(36,'test','LOGIN','User','','\"\\u7528\\u6237\\u540d\\u6216\\u5bc6\\u7801\\u9519\\u8bef\"',1412685845),
	(37,'admin','LOGIN','User','','\"\\u7528\\u6237\\u540d\\u6216\\u5bc6\\u7801\\u9519\\u8bef\"',1412686365),
	(38,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1412686379),
	(39,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1413040162),
	(40,'admin','ADD','MenuUrl','111','{\"menu_name\":\"\\u5168\\u56fd\\u4e0d\\u89c4\\u8303\\u5b9a\\u5236\\u4ef6\\u6570\\/\\u5404\\u7701\\u4e1a\\u52a1\\u6536\\u5165\",\"menu_url\":\"\\/complaint\\/custom_analyze2.php\",\"module_id\":\"3\",\"is_show\":\"0\",\"online\":1,\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"106\"}',1413121593),
	(41,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106,107,108,109,110,111\"}',1413121619),
	(42,'admin','LOGIN','User','1','{\"IP\":\"::1\"}',1413128276);

/*!40000 ALTER TABLE `osa_sys_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table osa_system
# ------------------------------------------------------------

DROP TABLE IF EXISTS `osa_system`;

CREATE TABLE `osa_system` (
  `key_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `key_value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='系统配置表';

LOCK TABLES `osa_system` WRITE;
/*!40000 ALTER TABLE `osa_system` DISABLE KEYS */;

INSERT INTO `osa_system` (`key_name`, `key_value`)
VALUES
	('timezone','\"Asia/Shanghai\"');

/*!40000 ALTER TABLE `osa_system` ENABLE KEYS */;
UNLOCK TABLES;


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

LOCK TABLES `osa_user` WRITE;
/*!40000 ALTER TABLE `osa_user` DISABLE KEYS */;

INSERT INTO `osa_user` (`user_id`, `user_name`, `password`, `real_name`, `mobile`, `email`, `user_desc`, `login_time`, `status`, `login_ip`, `user_group`, `template`, `shortcuts`, `show_quicknote`)
VALUES
	(1,'admin','e10adc3949ba59abbe56e057f20f883e','SomewhereYu','13800138001','admin@osadmin.org','初始的超级管理员!',1413128276,1,'::1',1,'wintertide','2,7,10,11,13,14,18,21,24',0),
	(26,'demo','e10adc3949ba59abbe56e057f20f883e','SomewhereYu','15812345678','yuwenqi@osadmin.org','默认用户组成员',1371605873,1,'127.0.0.1',2,'schoolpainting','',1);

/*!40000 ALTER TABLE `osa_user` ENABLE KEYS */;
UNLOCK TABLES;


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

LOCK TABLES `osa_user_group` WRITE;
/*!40000 ALTER TABLE `osa_user_group` DISABLE KEYS */;

INSERT INTO `osa_user_group` (`group_id`, `group_name`, `group_role`, `owner_id`, `group_desc`)
VALUES
	(1,'超级管理员组','1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106,107,108,109,110,111',1,'万能的不是神，是程序员'),
	(2,'默认账号组','1,5,17,18,20,22,23,24,25,101',1,'默认账号组');

/*!40000 ALTER TABLE `osa_user_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table province
# ------------------------------------------------------------

DROP TABLE IF EXISTS `province`;

CREATE TABLE `province` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `pinyin` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `province` WRITE;
/*!40000 ALTER TABLE `province` DISABLE KEYS */;

INSERT INTO `province` (`id`, `name`, `pinyin`)
VALUES
	(1,'西藏自治区','xizang'),
	(2,'浙江','zhejiang'),
	(3,'内蒙古自治区','neimenggu'),
	(4,'广西壮族自治区','guangxi'),
	(5,'陕西','shaanxi'),
	(6,'黑龙江','heilongjiang'),
	(7,'香港','xianggang'),
	(8,'澳门','aomen'),
	(9,'宁夏回族自治区','ningxia'),
	(10,'吉林','jilin'),
	(11,'甘肃','gansu'),
	(12,'辽宁','liaoning'),
	(13,'江西','jiangxi'),
	(14,'湖北','hubei'),
	(15,'河北','hebei'),
	(16,'福建','fujian'),
	(17,'贵州','guizhou'),
	(18,'河南','henan'),
	(19,'湖南','hunan'),
	(20,'青海','qinghai'),
	(21,'安徽','anhui'),
	(22,'江苏','jiangsu'),
	(23,'广东','guangdong'),
	(24,'山西','shanxi'),
	(25,'新疆维吾尔自治区','xinjiang'),
	(26,'四川','sichuan'),
	(27,'海南','hainan'),
	(28,'台湾','taiwan'),
	(29,'山东','shandong'),
	(30,'云南','yunnan'),
	(31,'重庆','chongqing'),
	(32,'天津','tianjin'),
	(33,'上海','shanghai'),
	(34,'北京','beijing');

/*!40000 ALTER TABLE `province` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sample
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sample`;

CREATE TABLE `sample` (
  `sample_id` int(11) NOT NULL,
  `sample_content` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `sample` WRITE;
/*!40000 ALTER TABLE `sample` DISABLE KEYS */;

INSERT INTO `sample` (`sample_id`, `sample_content`)
VALUES
	(1,'这是一个样例');

/*!40000 ALTER TABLE `sample` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
