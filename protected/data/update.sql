ALTER TABLE `ao_task` ADD `deadline_type` tinyint(1) DEFAULT '1' COMMENT '最后时限类别';
ALTER TABLE `ao_task` MODIFY `deadline` VARCHAR(30) NOT NULL COMMENT '任务最后时限';

ALTER TABLE `ao_sys_log` MODIFY `content` varchar(250) DEFAULT NULL COMMENT '日志内容';

ALTER TABLE `ao_point_log` MODIFY `log_point` decimal(8,2)  NOT NULL DEFAULT '0.00' COMMENT '积分值';


CREATE TABLE `ao_gift` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) DEFAULT NULL COMMENT '礼品编码',
  `name` varchar(64) DEFAULT NULL COMMENT '礼品名称',
  `addId` int(8) DEFAULT '0' COMMENT '添加人ID',
  `addDate` datetime DEFAULT NULL COMMENT '添加时间',
  `status` tinyint(1) DEFAULT '0' COMMENT '0=停用 1=启用',
  `score` int(8) DEFAULT '0' COMMENT '兑换分值',
  `num` int(8) DEFAULT '0' COMMENT '数量',
  `remark` varchar(128) DEFAULT NULL COMMENT '备注',
  `opAdminId` int(8) DEFAULT NULL COMMENT '操作人ID',
  `createdTime` datetime DEFAULT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='礼品表';

CREATE TABLE `ao_gift_exchange` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) DEFAULT NULL COMMENT '兑换编码',
  `giftId` varchar(64) DEFAULT NULL COMMENT '礼品ID',
  `applyId` int(8) DEFAULT NULL COMMENT '申请人ID',
  `applyDate` datetime DEFAULT NULL COMMENT '申请时间',
  `checkId` int(8) DEFAULT NULL COMMENT '审核人ID',
  `checkDate` datetime DEFAULT NULL COMMENT '审核时间',
  `status` tinyint(1) DEFAULT '0' COMMENT '-1=审核不过 0=新兑换 1=兑换成功',
  `num` int(8) DEFAULT '0' COMMENT '数量',
  `score` int(8) DEFAULT '0' COMMENT '兑换分值',
  `remark` varchar(128) DEFAULT NULL COMMENT '备注',
  `opAdminId` int(8) DEFAULT NULL COMMENT '操作人ID',
  `createdTime` datetime DEFAULT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`),
  KEY `giftId` (`giftId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='礼品兑换表';