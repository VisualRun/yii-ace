<?php
return array(
	'user_type'=>array(1=>'超级用户',2=>'高级用户',3=>'普通用户'),
	'status'=>array('-1'=>'删除','停用','启用'),
	'gender'=>array('男','女'),
	'task_type'=>array(1=>'主要任务',2=>'次要任务'),
	'task_important_type'=>array('普通','高','较高','紧急'),
	'task_status'=>array(0=>'等待',1=>'激活',2=>'完成',3=>'暂停',4=>'取消',5=>'确认完成'),
	'is_ync' => array("否","是"),
	'valid'=>array(0=>'无效', 1=>'有效'),
	'log_type'=>array(1=>'系统', 2=>'任务', 3=>'积分', 4=>'个人', 5=>'部门', 6=>'岗位'),
	'point_type'=>array(1=>'任务积分'),
	'message_type'=>array(1=>'系统消息',2=>'任务消息'),
	'checkout'=>array('未看','已看'),
	'subtraction'=>array(1=>'增加',2=>'减少'),
	'deadline_type'=>array(1=>'按天','按小时')
);