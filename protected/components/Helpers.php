<?php
/**
 * 助手类
 * @author:wxw
 * @time:2014-10-17
 */
class Helpers
{
	/**
     * 用户等级菜单
     */
    static function getUserMenu()
    {
        $panels = array();
        switch (Helpers::getUserTypeName()) {
            case '超级用户':
                $panels = array(
                	'home'=>array(
                		'text'=>'控制台',
                		'href'=>Yii::app()->createUrl('/home/index'),
                		'class'=>'fa-tachometer',
                		'item'=>array(
                		),
                	),

                	'task'=>array(
                		'text'=>'任务中心',
                		'href'=>'#',
                		'class'=>'fa-list-alt',
                		'item'=>array(
                            array('text'=>'任务发布','href'=>Yii::app()->createUrl('/task/create'),'action'=>array('create')),
                            // array('text'=>'任务发布','href'=>Yii::app()->createUrl('/task/add'),'action'=>array('add')),
                			array('text'=>'我的任务','href'=>Yii::app()->createUrl('/task/mytask'),'action'=>array('mytask')),
                			array('text'=>'所有任务','href'=>Yii::app()->createUrl('/task/list'),'action'=>array('list')),
                		),
                	),
                	'user'=>array(
                		'text'=>'个人中心',
                		'href'=>'#',
                		'class'=>'fa-tag',
                		'item'=>array(
					array('text'=>'个人提醒','href'=>Yii::app()->createUrl('/user/message'),'action'=>array('message')),
                			array('text'=>'个人资料','href'=>Yii::app()->createUrl('/user/profile'),'action'=>array('profile')),
                			array('text'=>'修改密码','href'=>Yii::app()->createUrl('/user/passwdedit'),'action'=>array('passwdedit')),
                		),
                	),
                	'admin'=>array(
                		'text'=>'管理中心',
                		'href'=>'#',
                		'class'=>'fa-pencil-square-o',
                		'item'=>array(
                			array('text'=>'部门管理','href'=>Yii::app()->createUrl('/admin/deptment'),'action'=>array('deptment')),
                			array('text'=>'岗位管理','href'=>Yii::app()->createUrl('/admin/workplace'),'action'=>array('workplace')),
                            array('text'=>'员工管理','href'=>Yii::app()->createUrl('/admin/user'),'action'=>array('user')),
                		),
                	),
                );
                break;
            case '高级用户':
                $panels = array(
                    'home'=>array(
                		'text'=>'控制台',
                		'href'=>Yii::app()->createUrl('/home/index'),
                		'class'=>'fa-tachometer',
                		'item'=>array(
                		),
                	),

                	'task'=>array(
                		'text'=>'任务中心',
                		'href'=>'#',
                		'class'=>'fa-list-alt',
                		'item'=>array(
                			array('text'=>'任务发布','href'=>'#','action'=>array('index')),
                            array('text'=>'我的任务','href'=>'#','action'=>array('index')),
                            array('text'=>'所有任务','href'=>'#','action'=>array('index')),
                		),
                	),
                	'user'=>array(
                		'text'=>'个人中心',
                		'href'=>'#',
                		'class'=>'fa-tag',
                		'item'=>array(
					array('text'=>'个人提醒','href'=>Yii::app()->createUrl('/user/message'),'action'=>array('message')),
                			array('text'=>'个人资料','href'=>Yii::app()->createUrl('/user/profile'),'action'=>array('profile')),
                			array('text'=>'修改密码','href'=>Yii::app()->createUrl('/user/passwdedit'),'action'=>array('passwdedit')),
                		),
                	),
                );
                break;
            case '普通用户':
                $panels = array(
                    'home'=>array(
                		'text'=>'控制台',
                		'href'=>Yii::app()->createUrl('/home/index'),
                		'class'=>'fa-tachometer',
                		'item'=>array(
                		),
                	),

                	'task'=>array(
                		'text'=>'任务中心',
                		'href'=>'#',
                		'class'=>'fa-list-alt',
                		'item'=>array(
                			array('text'=>'我的任务','href'=>'#','action'=>array('index')),
                            array('text'=>'所有任务','href'=>'#','action'=>array('index')),
                		),
                	),
                	'user'=>array(
                		'text'=>'个人中心',
                		'href'=>'#',
                		'class'=>'fa-tag',
                		'item'=>array(
					array('text'=>'个人提醒','href'=>Yii::app()->createUrl('/user/message'),'action'=>array('message')),
                			array('text'=>'个人资料','href'=>Yii::app()->createUrl('/user/profile'),'action'=>array('profile')),
                			array('text'=>'修改密码','href'=>Yii::app()->createUrl('/user/passwdedit'),'action'=>array('passwdedit')),
                		),
                	),
                );
                break;
            default:
                break;
        }
        return $panels;
    }

    /**
     * 用户等级名称
     */
    static function getUserTypeName()
    {
       	$type = Yii::app()->user->getState('type');
        return Yii::app()->params['user_type'][$type];
    }

    /**
     * [cArray 一维对象转为数组]
     * @param  [object] $ob [一维对象]
     * @return [array]    [一维数组]
     */
    public static function cArray($ob){
        $arrs=array();
        foreach($ob as $k=>$v){
                $arrs[$k]=$ob->$k;
        }
        return $arrs;
    }

}
