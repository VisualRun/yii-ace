/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : ace_oa

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-11-03 02:10:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ao_deptment
-- ----------------------------
DROP TABLE IF EXISTS `ao_deptment`;
CREATE TABLE `ao_deptment` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) DEFAULT NULL COMMENT '部门编码',
  `name` varchar(32) DEFAULT NULL COMMENT '部门名称',
  `status` tinyint(1) DEFAULT '0' COMMENT '0=停用 1=启用',
  `parentId` int(8) DEFAULT NULL COMMENT '上级部门ID',
  `remark` varchar(128) DEFAULT NULL COMMENT '备注',
  `opAdminId` int(8) DEFAULT NULL COMMENT '操作人ID',
  `createdTime` datetime DEFAULT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='部门表';

-- ----------------------------
-- Records of ao_deptment
-- ----------------------------
INSERT INTO `ao_deptment` VALUES ('1', 'd1', '开发部', '1', '0', '测试', '1', '2014-10-21 00:00:29');
INSERT INTO `ao_deptment` VALUES ('2', 'd2', '客服部', '1', '0', '测试', '1', '2014-10-21 00:00:53');
INSERT INTO `ao_deptment` VALUES ('3', 'd3', '运营部', '1', '0', '测试', '1', '2014-10-23 01:05:00');
INSERT INTO `ao_deptment` VALUES ('4', 'd4', '测试部', '1', '0', '哈哈', '1', '2014-11-01 23:03:54');

-- ----------------------------
-- Table structure for ao_file
-- ----------------------------
DROP TABLE IF EXISTS `ao_file`;
CREATE TABLE `ao_file` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pathname` char(100) NOT NULL COMMENT '附件地址',
  `title` char(90) NOT NULL COMMENT '附件标题',
  `extension` char(30) NOT NULL COMMENT '附件后缀名',
  `size` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '附件大小',
  `taskID` mediumint(9) NOT NULL COMMENT '附件ID',
  `addedId` int(8) DEFAULT NULL COMMENT '添加人ID',
  `addedDate` datetime DEFAULT NULL COMMENT '添加时间',
  `downloads` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `extra` varchar(255) DEFAULT NULL COMMENT '特别',
  `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`),
  KEY `taskID` (`taskID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='附件表';

-- ----------------------------
-- Records of ao_file
-- ----------------------------

-- ----------------------------
-- Table structure for ao_message
-- ----------------------------
DROP TABLE IF EXISTS `ao_message`;
CREATE TABLE `ao_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeId` tinyint(1) NOT NULL DEFAULT '1' COMMENT '消息类别',
  `userId` int(11) DEFAULT '0' COMMENT '发送人用户ID 0为系统',
  `touserId` int(11) DEFAULT '0' COMMENT '接收人用户ID 0为系统',
  `linkId` int(11) DEFAULT NULL COMMENT '关联ID',
  `linkId2` int(11) DEFAULT NULL COMMENT '关联ID2',
  `content` varchar(256) DEFAULT NULL COMMENT '消息内容',
  `checkout` tinyint(1) DEFAULT '0' COMMENT '0=未看 1=已看',
  `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除',
  `opAdminId` int(8) DEFAULT NULL COMMENT '操作人ID',
  `createdTime` datetime DEFAULT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`),
  KEY `typeId` (`typeId`),
  KEY `userId` (`userId`),
  KEY `touserId` (`touserId`),
  KEY `linkId` (`linkId`),
  KEY `linkId2` (`linkId2`),
  KEY `content` (`content`(255)),
  KEY `checkout` (`checkout`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='消息表';

-- ----------------------------
-- Records of ao_message
-- ----------------------------
INSERT INTO `ao_message` VALUES ('30', '2', '0', '4', '8', null, '你创建的任务 [测试任务啦] 已由测试3完成', '0', '0', '5', '2014-11-03 02:09:05');
INSERT INTO `ao_message` VALUES ('31', '2', '0', '5', '8', null, '任务 [测试任务啦] 已由测试2关闭，你将得到 1000 的积分', '0', '0', '4', '2014-11-03 02:09:48');

-- ----------------------------
-- Table structure for ao_point_log
-- ----------------------------
DROP TABLE IF EXISTS `ao_point_log`;
CREATE TABLE `ao_point_log` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT '0' COMMENT '用户ID',
  `log_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '积分类型',
  `log_point` int(6) NOT NULL DEFAULT '0' COMMENT '积分值',
  `log_desc` varchar(128) NOT NULL DEFAULT '' COMMENT '积分说明',
  `linkId` int(11) DEFAULT NULL COMMENT '关联ID',
  `valid` tinyint(1) DEFAULT '1' COMMENT '0=无效 1=有效',
  `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除',
  `opAdminId` int(8) DEFAULT NULL COMMENT '操作人ID',
  `createdTime` datetime DEFAULT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`),
  KEY `linkId` (`linkId`),
  KEY `log_point` (`log_point`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='积分日志表';

-- ----------------------------
-- Records of ao_point_log
-- ----------------------------
INSERT INTO `ao_point_log` VALUES ('1', '5', '1', '-700', '完成任务获取积分', '8', '1', '0', '4', '2014-11-03 01:42:40');
INSERT INTO `ao_point_log` VALUES ('2', '5', '1', '1000', '完成任务获取积分', '8', '1', '0', '4', '2014-11-03 02:09:48');

-- ----------------------------
-- Table structure for ao_purview
-- ----------------------------
DROP TABLE IF EXISTS `ao_purview`;
CREATE TABLE `ao_purview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(64) DEFAULT NULL COMMENT '权限编码',
  `name` varchar(32) DEFAULT NULL COMMENT '权限名称',
  `controller` varchar(64) DEFAULT NULL COMMENT '控制器名',
  `action` varchar(64) DEFAULT NULL COMMENT '方法名',
  `valid` tinyint(1) DEFAULT '1' COMMENT '0=无效 1=有效',
  `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除',
  `opAdminId` int(8) DEFAULT NULL COMMENT '操作人ID',
  `createdTime` datetime DEFAULT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `controller` (`controller`),
  KEY `action` (`action`),
  KEY `valid` (`valid`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='系统权限表';

-- ----------------------------
-- Records of ao_purview
-- ----------------------------
INSERT INTO `ao_purview` VALUES ('1', 'TASK_CREATE', '发布任务', 'TASK', 'CREATE', '1', '0', '1', '2014-11-02 23:53:56');

-- ----------------------------
-- Table structure for ao_sys_log
-- ----------------------------
DROP TABLE IF EXISTS `ao_sys_log`;
CREATE TABLE `ao_sys_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) DEFAULT NULL COMMENT '日志编码',
  `typeId` tinyint(1) NOT NULL DEFAULT '1' COMMENT '日志类别',
  `linkId` int(11) DEFAULT NULL COMMENT '关联ID',
  `linkId2` int(11) DEFAULT NULL COMMENT '关联ID2',
  `content` varchar(32) DEFAULT NULL COMMENT '日志内容',
  `valid` tinyint(1) DEFAULT '1' COMMENT '0=无效 1=有效',
  `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除',
  `opAdminId` int(8) DEFAULT NULL COMMENT '操作人ID',
  `createdTime` datetime DEFAULT NULL COMMENT '生成时间',
  `userId` int(11) DEFAULT '0' COMMENT '关联用户ID 0为系统',
  PRIMARY KEY (`id`),
  KEY `typeId` (`typeId`),
  KEY `linkId` (`linkId`),
  KEY `linkId2` (`linkId2`),
  KEY `content` (`content`),
  KEY `valid` (`valid`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='系统日志表';

-- ----------------------------
-- Records of ao_sys_log
-- ----------------------------
INSERT INTO `ao_sys_log` VALUES ('4', '', '4', null, null, 'admin退出系统', '1', '0', '1', '2014-11-03 00:18:42', '1');
INSERT INTO `ao_sys_log` VALUES ('5', '', '4', null, null, 'admin登陆系统', '1', '0', null, '2014-11-03 00:18:56', null);
INSERT INTO `ao_sys_log` VALUES ('6', '', '4', null, null, 'admin退出系统', '1', '0', '1', '2014-11-03 00:19:20', '1');
INSERT INTO `ao_sys_log` VALUES ('7', '', '4', null, null, 'admin登陆系统', '1', '0', null, '2014-11-03 00:20:12', null);
INSERT INTO `ao_sys_log` VALUES ('8', '', '4', '4', null, 'admin更新了员工 [测试2] 信息', '1', '0', '1', '2014-11-03 00:20:29', '1');
INSERT INTO `ao_sys_log` VALUES ('9', '', '4', null, null, 'admin退出系统', '1', '0', '1', '2014-11-03 00:20:31', '1');
INSERT INTO `ao_sys_log` VALUES ('10', '', '4', null, null, '测试2登陆系统', '1', '0', null, '2014-11-03 00:20:38', null);
INSERT INTO `ao_sys_log` VALUES ('11', '', '2', '6', null, '测试2发布了任务 [测试任务]', '1', '0', '4', '2014-11-03 00:22:03', '4');
INSERT INTO `ao_sys_log` VALUES ('12', '', '4', null, null, '退出系统', '1', '0', '4', '2014-11-03 00:22:18', '4');
INSERT INTO `ao_sys_log` VALUES ('13', '', '4', null, null, '测试3登陆系统', '1', '0', null, '2014-11-03 00:22:24', null);
INSERT INTO `ao_sys_log` VALUES ('14', '', '2', '7', null, '测试2发布了任务 [212]', '1', '0', '4', '2014-11-03 00:36:06', '4');
INSERT INTO `ao_sys_log` VALUES ('15', '', '2', '7', null, '测试2将 [212] 指派任务给 测试3', '1', '0', '4', '2014-11-03 00:36:25', '4');
INSERT INTO `ao_sys_log` VALUES ('16', '', '2', '7', null, '测试3开始了任务 [212]', '1', '0', '5', '2014-11-03 00:40:41', '5');
INSERT INTO `ao_sys_log` VALUES ('17', '', '2', '7', null, '测试3完成任务 [212]', '1', '0', '5', '2014-11-03 00:40:49', '5');
INSERT INTO `ao_sys_log` VALUES ('18', '', '2', '8', null, '测试2发布了任务 [测试任务啦]', '1', '0', '4', '2014-11-03 01:10:00', '4');
INSERT INTO `ao_sys_log` VALUES ('19', '', '2', '8', null, '测试2将 [测试任务啦] 指派任务给 测试3', '1', '0', '4', '2014-11-03 01:11:00', '4');
INSERT INTO `ao_sys_log` VALUES ('20', '', '2', '8', null, '测试3开始了任务 [测试任务啦]', '1', '0', '5', '2014-11-03 01:11:35', '5');
INSERT INTO `ao_sys_log` VALUES ('21', '', '2', '8', null, '测试3完成任务 [测试任务啦]', '1', '0', '5', '2014-11-03 01:11:45', '5');
INSERT INTO `ao_sys_log` VALUES ('22', '', '2', '8', null, '测试2关闭任务 [测试任务啦]', '1', '0', '4', '2014-11-03 01:15:31', '4');
INSERT INTO `ao_sys_log` VALUES ('23', '', '2', '8', null, '测试2关闭任务 [测试任务啦]', '1', '0', '4', '2014-11-03 01:17:31', '4');
INSERT INTO `ao_sys_log` VALUES ('24', '', '2', '8', null, '测试2关闭任务 [测试任务啦]', '1', '0', '4', '2014-11-03 01:34:35', '4');
INSERT INTO `ao_sys_log` VALUES ('25', '', '2', '8', null, '测试2关闭任务 [测试任务啦]', '1', '0', '4', '2014-11-03 01:35:33', '4');
INSERT INTO `ao_sys_log` VALUES ('26', '', '2', '8', null, '测试2关闭任务 [测试任务啦]', '1', '0', '4', '2014-11-03 01:40:55', '4');
INSERT INTO `ao_sys_log` VALUES ('27', '', '2', '8', null, '测试2关闭任务 [测试任务啦]', '1', '0', '4', '2014-11-03 01:41:27', '4');
INSERT INTO `ao_sys_log` VALUES ('28', '', '2', '8', null, '测试2关闭任务 [测试任务啦]', '1', '0', '4', '2014-11-03 01:42:01', '4');
INSERT INTO `ao_sys_log` VALUES ('29', '', '2', '8', null, '测试2关闭任务 [测试任务啦]', '1', '0', '4', '2014-11-03 01:42:40', '4');
INSERT INTO `ao_sys_log` VALUES ('30', '', '4', null, null, '测试3登陆系统', '1', '0', '5', '2014-11-03 02:08:55', '5');
INSERT INTO `ao_sys_log` VALUES ('31', '', '2', '8', null, '测试3完成任务 [测试任务啦]', '1', '0', '5', '2014-11-03 02:09:05', '5');
INSERT INTO `ao_sys_log` VALUES ('32', '', '2', '8', null, '测试2关闭任务 [测试任务啦]', '1', '0', '4', '2014-11-03 02:09:48', '4');

-- ----------------------------
-- Table structure for ao_task
-- ----------------------------
DROP TABLE IF EXISTS `ao_task`;
CREATE TABLE `ao_task` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) DEFAULT NULL COMMENT '任务编码',
  `typeId` tinyint(1) NOT NULL DEFAULT '1' COMMENT '主次类别',
  `imtypeId` tinyint(1) NOT NULL DEFAULT '0' COMMENT '重要类别',
  `name` varchar(32) DEFAULT NULL COMMENT '任务名称',
  `desc` text NOT NULL COMMENT '任务说明',
  `status` tinyint(1) DEFAULT '0' COMMENT '0=等待 1=激活 2=完成 3=暂停 4=取消 5=关闭',
  `deadline` date NOT NULL COMMENT '任务最后时限',
  `openedId` int(8) DEFAULT NULL COMMENT '创建人ID',
  `openedDate` datetime DEFAULT NULL COMMENT '创建时间',
  `assignedId` int(8) DEFAULT NULL COMMENT '指派到人ID',
  `assignedDate` datetime DEFAULT NULL COMMENT '指派时间',
  `estStarted` date DEFAULT NULL COMMENT '预计开始时间',
  `realStarted` date DEFAULT NULL COMMENT '真实开始时间',
  `finishedId` int(8) DEFAULT NULL COMMENT '完成人ID',
  `finishedDate` datetime DEFAULT NULL COMMENT '完成时间',
  `canceledId` int(8) DEFAULT NULL COMMENT '取消人ID',
  `canceledDate` datetime DEFAULT NULL COMMENT '取消时间',
  `closedId` int(8) DEFAULT NULL COMMENT '关闭人ID',
  `closedDate` datetime DEFAULT NULL COMMENT '关闭时间',
  `closedReason` varchar(30) DEFAULT NULL COMMENT '关闭原因',
  `lastEditedId` int(8) DEFAULT NULL COMMENT '最后操作人ID',
  `lastEditedDate` datetime DEFAULT NULL COMMENT '最后操作时间',
  `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除',
  `remark` varchar(128) DEFAULT NULL COMMENT '备注',
  `opAdminId` int(8) DEFAULT NULL COMMENT '操作人ID',
  `createdTime` datetime DEFAULT NULL COMMENT '生成时间',
  `point` int(4) DEFAULT '0' COMMENT '任务积分值',
  `finishedpoint` float(6,2) DEFAULT '0.00' COMMENT '完成任务积分',
  PRIMARY KEY (`id`),
  KEY `typeId` (`typeId`),
  KEY `imtypeId` (`imtypeId`),
  KEY `name` (`name`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='任务表';

-- ----------------------------
-- Records of ao_task
-- ----------------------------
INSERT INTO `ao_task` VALUES ('8', 'T1IM0000008', '1', '0', '测试任务啦', '测试的任务啦', '5', '2014-11-13', '4', '2014-11-03 01:10:00', '5', '2014-11-03 01:11:00', '2014-11-03', '2014-11-03', '5', '2014-11-03 02:09:05', null, '0000-00-00 00:00:00', '4', '2014-11-03 02:09:47', '', '4', '2014-11-03 02:09:48', '0', '', '4', '2014-11-03 02:09:48', '1000', '1000.00');

-- ----------------------------
-- Table structure for ao_task_remark
-- ----------------------------
DROP TABLE IF EXISTS `ao_task_remark`;
CREATE TABLE `ao_task_remark` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) DEFAULT NULL COMMENT '任务备注编码',
  `taskId` tinyint(1) NOT NULL DEFAULT '1' COMMENT '任务ID',
  `remark` text NOT NULL COMMENT '任务备注',
  `valid` tinyint(1) DEFAULT '1' COMMENT '0=无效 1=有效',
  `userId` int(8) DEFAULT NULL COMMENT '创建人ID',
  `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除',
  `opAdminId` int(8) DEFAULT NULL COMMENT '操作人ID',
  `createdTime` datetime DEFAULT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`),
  KEY `taskId` (`taskId`),
  KEY `valid` (`valid`),
  KEY `userId` (`userId`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务备注表';

-- ----------------------------
-- Records of ao_task_remark
-- ----------------------------

-- ----------------------------
-- Table structure for ao_user
-- ----------------------------
DROP TABLE IF EXISTS `ao_user`;
CREATE TABLE `ao_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) DEFAULT NULL COMMENT '员工编码',
  `account` char(30) NOT NULL DEFAULT '' COMMENT '账号',
  `password` varchar(32) NOT NULL,
  `typeId` tinyint(1) DEFAULT NULL COMMENT '类别',
  `realname` varchar(32) DEFAULT NULL COMMENT '真实姓名',
  `deptId` int(8) DEFAULT NULL COMMENT '部门ID',
  `workplaceId` int(11) DEFAULT NULL COMMENT '岗位ID',
  `status` tinyint(1) DEFAULT '0' COMMENT '0=停用 1=启用',
  `address` varchar(128) DEFAULT NULL COMMENT '家庭地址',
  `officeTel` varchar(64) DEFAULT NULL COMMENT '办公电话',
  `mobile` varchar(64) DEFAULT NULL COMMENT '手机号',
  `officeEmail` varchar(32) DEFAULT NULL COMMENT '办公邮箱',
  `employTime` date DEFAULT NULL COMMENT '入职时间',
  `unemplyTime` date DEFAULT NULL COMMENT '离职时间',
  `handonStaffId` int(8) DEFAULT NULL COMMENT '前任员工ID',
  `personNumber` varchar(128) DEFAULT NULL COMMENT '身份证号码',
  `personAddress` varchar(128) DEFAULT NULL COMMENT '身份证地址',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别',
  `residence` varchar(128) DEFAULT NULL COMMENT '户籍',
  `studyLevel` varchar(128) DEFAULT NULL COMMENT '学历',
  `yearOfWorking` varchar(128) DEFAULT NULL COMMENT '合同期限',
  `graduationYear` varchar(128) DEFAULT NULL COMMENT '毕业年份',
  `homeAddress` varchar(128) DEFAULT NULL COMMENT '家庭地址',
  `homeTel` varchar(128) DEFAULT NULL COMMENT '家庭电话',
  `homeEmail` varchar(128) DEFAULT NULL COMMENT '个人Email',
  `reconcactorPerson` varchar(128) DEFAULT NULL COMMENT '紧急联系人姓名',
  `reconcactorTel` varchar(128) DEFAULT NULL COMMENT '紧急联系人电话',
  `workYearlimit` varchar(128) DEFAULT NULL COMMENT '工作年限',
  `remark` varchar(128) DEFAULT NULL COMMENT '备注',
  `opAdminId` int(8) DEFAULT NULL COMMENT '操作员工ID',
  `createdTime` datetime DEFAULT NULL COMMENT '生成时间',
  `logNum` int(8) DEFAULT '0' COMMENT '登陆次数',
  `point` float(10,2) DEFAULT '0.00' COMMENT '积分',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`),
  KEY `deptId` (`deptId`),
  KEY `workplaceId` (`workplaceId`),
  KEY `status` (`status`),
  KEY `sex` (`sex`),
  KEY `opAdminId` (`opAdminId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='员工表';

-- ----------------------------
-- Records of ao_user
-- ----------------------------
INSERT INTO `ao_user` VALUES ('1', 'u1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '1', '管理员', '1', '1', '1', '', '', '', '', '0000-00-00', '0000-00-00', null, '', '', '0', '', '', '', '', '', '', '', '', '', '', '', null, '2014-11-03 00:20:12', '37', '0.00');
INSERT INTO `ao_user` VALUES ('4', 'U0004', '测试2', 'e10adc3949ba59abbe56e057f20f883e', '2', '测试2', '1', '1', '1', '', '', '', '', '0000-00-00', '0000-00-00', null, '', '', '1', '', '', '', '', '', '', '', '', '', '', '测试', null, '2014-11-03 00:20:38', '2', '0.00');
INSERT INTO `ao_user` VALUES ('5', 'U0005', '测试3', 'e10adc3949ba59abbe56e057f20f883e', '2', '测试3', '1', '1', '1', '', '', '', '', '0000-00-00', '0000-00-00', null, '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '4', '2014-11-03 02:09:48', '2', '300.00');

-- ----------------------------
-- Table structure for ao_user_purview
-- ----------------------------
DROP TABLE IF EXISTS `ao_user_purview`;
CREATE TABLE `ao_user_purview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usertypeId` varchar(32) DEFAULT NULL COMMENT '用户分类',
  `purviewId` varchar(64) DEFAULT NULL COMMENT '权限主表ID',
  `valid` tinyint(1) DEFAULT '1' COMMENT '0=无效 1=有效',
  `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除',
  `opAdminId` int(8) DEFAULT NULL COMMENT '操作人ID',
  `createdTime` datetime DEFAULT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`),
  KEY `usertypeId` (`usertypeId`),
  KEY `purviewId` (`purviewId`),
  KEY `valid` (`valid`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='个人权限表';

-- ----------------------------
-- Records of ao_user_purview
-- ----------------------------
INSERT INTO `ao_user_purview` VALUES ('1', '2', '1', '1', '0', '1', '2014-11-03 00:01:38');

-- ----------------------------
-- Table structure for ao_workplace
-- ----------------------------
DROP TABLE IF EXISTS `ao_workplace`;
CREATE TABLE `ao_workplace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) DEFAULT NULL COMMENT '岗位编码',
  `name` varchar(32) DEFAULT NULL COMMENT '岗位名称',
  `status` tinyint(1) DEFAULT '0' COMMENT '0=停用 1=启用',
  `remark` varchar(128) DEFAULT NULL COMMENT '备注',
  `opAdminId` int(8) DEFAULT NULL COMMENT '操作人ID',
  `createdTime` datetime DEFAULT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='岗位表';

-- ----------------------------
-- Records of ao_workplace
-- ----------------------------
INSERT INTO `ao_workplace` VALUES ('1', 'w1', '程序员', '1', '测试', '1', '2014-10-23 01:36:14');
INSERT INTO `ao_workplace` VALUES ('2', 'W002', '美工', '1', '测试啊啊啊', '1', '2014-10-23 21:59:57');
INSERT INTO `ao_workplace` VALUES ('3', 'W003', '运营专员', '1', '测试啊', '1', '2014-11-01 22:49:02');
INSERT INTO `ao_workplace` VALUES ('4', 'W004', '测试工程师', '1', '测试工程师啊', '1', '2014-11-01 22:49:22');
