/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : ace_oa

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-10-23 01:52:20
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
INSERT INTO `ao_deptment` VALUES ('4', 'd4', '测试部', '-1', null, '哈哈', '1', '2014-10-23 01:26:53');

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`),
  KEY `deptId` (`deptId`),
  KEY `workplaceId` (`workplaceId`),
  KEY `status` (`status`),
  KEY `sex` (`sex`),
  KEY `opAdminId` (`opAdminId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='员工表';

-- ----------------------------
-- Records of ao_user
-- ----------------------------
INSERT INTO `ao_user` VALUES ('1', 'u1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '1', '管理员', '1', '1', '1', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, '', '1', '2014-10-23 01:51:56', '16');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='岗位表';

-- ----------------------------
-- Records of ao_workplace
-- ----------------------------
INSERT INTO `ao_workplace` VALUES ('1', 'w1', '程序员', '1', '测试', '1', '2014-10-23 01:36:14');
