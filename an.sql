/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : an

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2014-09-14 23:03:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `co_base`
-- ----------------------------
DROP TABLE IF EXISTS `co_base`;
CREATE TABLE `co_base` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `province_id` varchar(255) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `order_time` varchar(255) DEFAULT NULL,
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

-- ----------------------------
-- Records of co_base
-- ----------------------------

-- ----------------------------
-- Table structure for `co_complaints`
-- ----------------------------
DROP TABLE IF EXISTS `co_complaints`;
CREATE TABLE `co_complaints` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `complaints_id` varchar(255) DEFAULT NULL,
  `sub_order_id` varchar(255) DEFAULT NULL,
  `case_id` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `part_name` varchar(255) DEFAULT NULL,
  `responsibility_code` varchar(255) DEFAULT NULL,
  `responsibility_name` varchar(255) DEFAULT NULL,
  `part_code` varchar(255) DEFAULT NULL,
  `order_time` varchar(255) DEFAULT NULL,
  `buss_type` varchar(255) DEFAULT NULL,
  `buss_type_code` varchar(255) DEFAULT NULL,
  `buss_name` varchar(255) DEFAULT NULL,
  `buss_code` varchar(255) DEFAULT NULL,
  `complaint_status` varchar(255) DEFAULT NULL,
  `appeal_status` varchar(255) DEFAULT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of co_complaints
-- ----------------------------

-- ----------------------------
-- Table structure for `co_custom`
-- ----------------------------
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of co_custom
-- ----------------------------

-- ----------------------------
-- Table structure for `osa_menu_url`
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 COMMENT='功能链接（菜单链接）';

-- ----------------------------
-- Records of osa_menu_url
-- ----------------------------
INSERT INTO `osa_menu_url` VALUES ('1', '首页', '/panel/index.php', '1', '0', '1', '1', '后台首页', '0');
INSERT INTO `osa_menu_url` VALUES ('2', '账号列表', '/panel/users.php', '1', '1', '1', '1', '账号列表', '0');
INSERT INTO `osa_menu_url` VALUES ('3', '修改账号', '/panel/user_modify.php', '1', '0', '1', '0', '修改账号', '2');
INSERT INTO `osa_menu_url` VALUES ('4', '新建账号', '/panel/user_add.php', '1', '0', '1', '1', '新建账号', '2');
INSERT INTO `osa_menu_url` VALUES ('5', '个人信息', '/panel/profile.php', '1', '0', '1', '1', '个人信息', '0');
INSERT INTO `osa_menu_url` VALUES ('6', '账号组成员', '/panel/group.php', '1', '0', '1', '0', '显示账号组详情及该组成员', '7');
INSERT INTO `osa_menu_url` VALUES ('7', '账号组管理', '/panel/groups.php', '1', '1', '1', '1', '增加管理员', '0');
INSERT INTO `osa_menu_url` VALUES ('8', '修改账号组', '/panel/group_modify.php', '1', '0', '1', '0', '修改账号组', '7');
INSERT INTO `osa_menu_url` VALUES ('9', '新建账号组', '/panel/group_add.php', '1', '0', '1', '1', '新建账号组', '7');
INSERT INTO `osa_menu_url` VALUES ('10', '权限管理', '/panel/group_role.php', '1', '1', '1', '1', '用户权限依赖于账号组的权限', '0');
INSERT INTO `osa_menu_url` VALUES ('11', '菜单模块', '/panel/modules.php', '1', '1', '1', '1', '菜单里的模块', '0');
INSERT INTO `osa_menu_url` VALUES ('12', '编辑菜单模块', '/panel/module_modify.php', '1', '0', '1', '0', '编辑模块', '11');
INSERT INTO `osa_menu_url` VALUES ('13', '添加菜单模块', '/panel/module_add.php', '1', '0', '1', '1', '添加菜单模块', '11');
INSERT INTO `osa_menu_url` VALUES ('14', '功能列表', '/panel/menus.php', '1', '1', '1', '1', '菜单功能及可访问的链接', '0');
INSERT INTO `osa_menu_url` VALUES ('15', '增加功能', '/panel/menu_add.php', '1', '0', '1', '1', '增加功能', '14');
INSERT INTO `osa_menu_url` VALUES ('16', '功能修改', '/panel/menu_modify.php', '1', '0', '1', '0', '修改功能', '14');
INSERT INTO `osa_menu_url` VALUES ('17', '设置模板', '/panel/set.php', '1', '0', '1', '1', '设置模板', '0');
INSERT INTO `osa_menu_url` VALUES ('18', '便签管理', '/panel/quicknotes.php', '1', '1', '1', '1', 'quick note', '0');
INSERT INTO `osa_menu_url` VALUES ('19', '菜单链接列表', '/panel/module.php', '1', '0', '1', '0', '显示模块详情及该模块下的菜单', '11');
INSERT INTO `osa_menu_url` VALUES ('20', '登入', '/login.php', '1', '0', '1', '1', '登入页面', '0');
INSERT INTO `osa_menu_url` VALUES ('21', '操作记录', '/panel/syslog.php', '1', '1', '1', '1', '用户操作的历史行为', '0');
INSERT INTO `osa_menu_url` VALUES ('22', '系统信息', '/panel/system.php', '1', '1', '1', '1', '显示系统相关信息', '0');
INSERT INTO `osa_menu_url` VALUES ('23', 'ajax访问修改快捷菜单', '/ajax/shortcut.php', '1', '0', '1', '0', 'ajax请求', '0');
INSERT INTO `osa_menu_url` VALUES ('24', '添加便签', '/panel/quicknote_add.php', '1', '0', '1', '1', '添加quicknote的内容', '18');
INSERT INTO `osa_menu_url` VALUES ('25', '修改便签', '/panel/quicknote_modify.php', '1', '0', '1', '0', '修改quicknote的内容', '18');
INSERT INTO `osa_menu_url` VALUES ('26', '系统设置', '/panel/setting.php', '1', '0', '1', '0', '系统设置', '0');
INSERT INTO `osa_menu_url` VALUES ('101', '样例', '/sample/sample.php', '2', '1', '1', '1', '', '0');
INSERT INTO `osa_menu_url` VALUES ('103', '读取XLS文件', '/sample/read_excel.php', '2', '1', '1', '1', '', '0');
INSERT INTO `osa_menu_url` VALUES ('104', '数据导入', '/complaint/import.php', '3', '1', '1', '1', '', '0');

-- ----------------------------
-- Table structure for `osa_module`
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='菜单模块';

-- ----------------------------
-- Records of osa_module
-- ----------------------------
INSERT INTO `osa_module` VALUES ('1', '控制面板', '/panel/index.php', '0', '配置OSAdmin的相关功能', 'icon-th', '1');
INSERT INTO `osa_module` VALUES ('2', '样例模块', '/panel/index.php', '1', '样例模块', 'icon-leaf', '1');
INSERT INTO `osa_module` VALUES ('3', '客诉分析', '/index.php', '1', '', 'icon-th', '1');

-- ----------------------------
-- Table structure for `osa_quick_note`
-- ----------------------------
DROP TABLE IF EXISTS `osa_quick_note`;
CREATE TABLE `osa_quick_note` (
  `note_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'note_id',
  `note_content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `owner_id` int(10) unsigned NOT NULL COMMENT '谁添加的',
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用于显示的quick note';

-- ----------------------------
-- Records of osa_quick_note
-- ----------------------------
INSERT INTO `osa_quick_note` VALUES ('6', '孔子说：万能的不是神，是程序员！', '1');
INSERT INTO `osa_quick_note` VALUES ('7', '听说飞信被渗透了几百台服务器', '1');
INSERT INTO `osa_quick_note` VALUES ('8', '（yamete）＝不要 ，一般音译为”亚美爹”，正确发音是：亚灭贴', '1');
INSERT INTO `osa_quick_note` VALUES ('9', '（kimochiii）＝爽死了，一般音译为”可莫其”，正确发音是：克一莫其一一 ', '1');
INSERT INTO `osa_quick_note` VALUES ('10', '（itai）＝疼 ，一般音译为以太', '1');
INSERT INTO `osa_quick_note` VALUES ('11', '（iku）＝要出来了 ，一般音译为一库', '1');
INSERT INTO `osa_quick_note` VALUES ('12', '（soko dame）＝那里……不可以 一般音译：锁扩，打灭', '1');
INSERT INTO `osa_quick_note` VALUES ('13', '(hatsukashi)＝羞死人了 ，音译：哈次卡西', '1');
INSERT INTO `osa_quick_note` VALUES ('14', '（atashinookuni）＝到人家的身体里了，音译：啊她西诺喔库你', '1');
INSERT INTO `osa_quick_note` VALUES ('15', '（mottto mottto）＝还要，还要，再大力点的意思 音译：毛掏 毛掏', '1');
INSERT INTO `osa_quick_note` VALUES ('20', '这是一条含HTML的便签 <a href=\"http://www.osadmin.org\">osadmin.org</a>', '1');
INSERT INTO `osa_quick_note` VALUES ('23', '你造吗？quick note可以关掉的，在右上角的我的账号里可以设置的。', '1');
INSERT INTO `osa_quick_note` VALUES ('24', '你造吗？“功能”其实就是“链接”啦啦，权限控制是根据用户访问的链接来验证的。', '1');
INSERT INTO `osa_quick_note` VALUES ('25', '你造吗？权限是赋予给账号组的，账号组下的用户拥有相同的权限。', '1');
INSERT INTO `osa_quick_note` VALUES ('26', 'Hi，你注意到navibar上的+号和-号了吗？', '1');
INSERT INTO `osa_quick_note` VALUES ('27', '假如世界上只剩下两坨屎，我一定会把热的留给你', '1');
INSERT INTO `osa_quick_note` VALUES ('28', '你造吗？这页面设计用是bootstrap模板改的', '1');
INSERT INTO `osa_quick_note` VALUES ('29', '你造吗？这全部都是我一个人开发的，可特么累了', '1');
INSERT INTO `osa_quick_note` VALUES ('30', '客官有什么建议可以直接在weibo.com上<a target=_blank  href =\"http://weibo.com/osadmin\">@OSAdmin官网</a> 本店服务一定会让客官满意的！亚美爹！', '1');

-- ----------------------------
-- Table structure for `osa_system`
-- ----------------------------
DROP TABLE IF EXISTS `osa_system`;
CREATE TABLE `osa_system` (
  `key_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `key_value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='系统配置表';

-- ----------------------------
-- Records of osa_system
-- ----------------------------
INSERT INTO `osa_system` VALUES ('timezone', '\"Asia/Shanghai\"');

-- ----------------------------
-- Table structure for `osa_sys_log`
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='操作日志表';

-- ----------------------------
-- Records of osa_sys_log
-- ----------------------------
INSERT INTO `osa_sys_log` VALUES ('1', 'admin', 'LOGIN', 'User', '1', '{\"IP\":\"127.0.0.1\"}', '1410686072');
INSERT INTO `osa_sys_log` VALUES ('2', 'admin', 'LOGIN', 'User', '1', '{\"IP\":\"127.0.0.1\"}', '1410686133');
INSERT INTO `osa_sys_log` VALUES ('3', 'admin', 'ADD', 'Module', '3', '{\"module_name\":\"\\u5ba2\\u8bc9\\u5206\\u6790\",\"module_desc\":\"\",\"module_url\":\"\\/index.php\",\"module_sort\":1,\"module_icon\":\"icon-th\"}', '1410686184');
INSERT INTO `osa_sys_log` VALUES ('4', 'admin', 'ADD', 'MenuUrl', '104', '{\"menu_name\":\"\\u6570\\u636e\\u5bfc\\u5165\",\"menu_url\":\"\\/complaint\\/import.php\",\"module_id\":\"3\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}', '1410686332');
INSERT INTO `osa_sys_log` VALUES ('5', 'admin', 'MODIFY', 'UserGroup', '1', '{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104\"}', '1410686338');

-- ----------------------------
-- Table structure for `osa_user`
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='后台用户';

-- ----------------------------
-- Records of osa_user
-- ----------------------------
INSERT INTO `osa_user` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'SomewhereYu', '13800138001', 'admin@osadmin.org', '初始的超级管理员!', '1410701724', '1', '127.0.0.1', '1', 'wintertide', '2,7,10,11,13,14,18,21,24', '0');
INSERT INTO `osa_user` VALUES ('26', 'demo', 'e10adc3949ba59abbe56e057f20f883e', 'SomewhereYu', '15812345678', 'yuwenqi@osadmin.org', '默认用户组成员', '1371605873', '1', '127.0.0.1', '2', 'schoolpainting', '', '1');

-- ----------------------------
-- Table structure for `osa_user_group`
-- ----------------------------
DROP TABLE IF EXISTS `osa_user_group`;
CREATE TABLE `osa_user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) DEFAULT NULL,
  `group_role` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '初始权限为1,5,17,18,22,23,24,25',
  `owner_id` int(11) DEFAULT NULL COMMENT '创建人ID',
  `group_desc` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='账号组';

-- ----------------------------
-- Records of osa_user_group
-- ----------------------------
INSERT INTO `osa_user_group` VALUES ('1', '超级管理员组', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104', '1', '万能的不是神，是程序员');
INSERT INTO `osa_user_group` VALUES ('2', '默认账号组', '1,5,17,18,20,22,23,24,25,101', '1', '默认账号组');

-- ----------------------------
-- Table structure for `sample`
-- ----------------------------
DROP TABLE IF EXISTS `sample`;
CREATE TABLE `sample` (
  `sample_id` int(11) NOT NULL,
  `sample_content` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sample
-- ----------------------------
INSERT INTO `sample` VALUES ('1', '这是一个样例');
