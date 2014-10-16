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
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                		),
                	),
                	'user'=>array(
                		'text'=>'个人中心',
                		'href'=>'#',
                		'class'=>'fa-tag',
                		'item'=>array(
                			array('text'=>'个人信息','href'=>Yii::app()->createUrl('/user/index'),'action'=>array('index')),
                			array('text'=>'修改密码','href'=>Yii::app()->createUrl('/user/passwdedit'),'action'=>array('passwdedit')),
                		),
                	),
                	'admin'=>array(
                		'text'=>'管理中心',
                		'href'=>'#',
                		'class'=>'fa-pencil-square-o',
                		'item'=>array(
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
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
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                		),
                	),
                	'user'=>array(
                		'text'=>'个人中心',
                		'href'=>'#',
                		'class'=>'fa-tag',
                		'item'=>array(
                			array('text'=>'个人信息','href'=>Yii::app()->createUrl('/user/index'),'action'=>array('index')),
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
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                			array('text'=>'1212','href'=>'#','action'=>array('index')),
                		),
                	),
                	'user'=>array(
                		'text'=>'个人中心',
                		'href'=>'#',
                		'class'=>'fa-tag',
                		'item'=>array(
                			array('text'=>'个人信息','href'=>Yii::app()->createUrl('/user/index'),'action'=>array('index')),
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
}