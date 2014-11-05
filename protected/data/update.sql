ALTER TABLE `ao_task` ADD `deadline_type` tinyint(1) DEFAULT '1' COMMENT '最后时限类别';
ALTER TABLE `ao_task` MODIFY `deadline` VARCHAR(30) NOT NULL COMMENT '任务最后时限';