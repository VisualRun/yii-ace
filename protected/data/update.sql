ALTER TABLE `ao_task` ADD `deadline_type` tinyint(1) DEFAULT '1' COMMENT '最后时限类别';
ALTER TABLE `ao_task` MODIFY `deadline` VARCHAR(30) NOT NULL COMMENT '任务最后时限';

ALTER TABLE `ao_sys_log` MODIFY `content` varchar(250) DEFAULT NULL COMMENT '日志内容';

ALTER TABLE `ao_point_log` MODIFY `log_point` decimal(8,2)  NOT NULL DEFAULT '0.00' COMMENT '积分值';


ALTER TABLE `ao_task` ADD `assignedIdGroup` varchar(100) DEFAULT '' COMMENT '指派到一组人';
ALTER TABLE `ao_task` MODIFY `assignedId` varchar(100) DEFAULT '0' COMMENT '指派到人ID';