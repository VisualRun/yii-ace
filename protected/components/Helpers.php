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
                		'class'=>'fa fa-tachometer',
                		'item'=>array(
                		),
                	),

                	'task'=>array(
                		'text'=>'任务中心',
                		'href'=>'#',
                		'class'=>'fa fa-tasks',
                		'item'=>array(
                            array('text'=>'发布任务','href'=>Yii::app()->createUrl('/task/create'),'action'=>array('create')),
                			array('text'=>'我的任务','href'=>Yii::app()->createUrl('/task/mytask'),'action'=>array('mytask')),
                			array('text'=>'所有任务','href'=>Yii::app()->createUrl('/task/list'),'action'=>array('list')),
                		),
                	),
                	'user'=>array(
                		'text'=>'个人中心',
                		'href'=>'#',
                		'class'=>'glyphicon glyphicon-user',
                		'item'=>array(
                            array('text'=>'个人提醒','href'=>Yii::app()->createUrl('/user/message'),'action'=>array('message')),
                			array('text'=>'个人资料','href'=>Yii::app()->createUrl('/user/profile'),'action'=>array('profile')),
                			array('text'=>'修改密码','href'=>Yii::app()->createUrl('/user/passwdedit'),'action'=>array('passwdedit')),
                		),
                	),
                	'admin'=>array(
                		'text'=>'组织中心',
                		'href'=>'#',
                		'class'=>'fa fa-users',
                		'item'=>array(
                			array('text'=>'部门管理','href'=>Yii::app()->createUrl('/admin/deptment'),'action'=>array('deptment')),
                			array('text'=>'岗位管理','href'=>Yii::app()->createUrl('/admin/workplace'),'action'=>array('workplace')),
                            array('text'=>'员工管理','href'=>Yii::app()->createUrl('/admin/user'),'action'=>array('user')),
                		),
                	),
                    'purviewadmin'=>array(
                        'text'=>'权限中心',
                        'href'=>'#',
                        'class'=>'fa fa-cog',
                        'item'=>array(
                            array('text'=>'权限管理','href'=>Yii::app()->createUrl('/purviewadmin/allpurview'),'action'=>array('allpurview')),
                            array('text'=>'用户权限','href'=>Yii::app()->createUrl('/purviewadmin/userpurview'),'action'=>array('userpurview')),
                        ),
                    ),
                );
                break;
            case '高级用户':
                $panels = array(
                    'home'=>array(
                		'text'=>'控制台',
                		'href'=>Yii::app()->createUrl('/home/index'),
                		'class'=>'fa fa-tachometer',
                		'item'=>array(
                		),
                	),

                	'task'=>array(
                		'text'=>'任务中心',
                		'href'=>'#',
                		'class'=>'fa fa-tasks',
                		'item'=>array(
                			array('text'=>'发布任务','href'=>Yii::app()->createUrl('/task/create'),'action'=>array('create')),
                            array('text'=>'我的任务','href'=>Yii::app()->createUrl('/task/mytask'),'action'=>array('mytask')),
                            array('text'=>'所有任务','href'=>Yii::app()->createUrl('/task/list'),'action'=>array('list')),
                		),
                	),
                	'user'=>array(
                		'text'=>'个人中心',
                		'href'=>'#',
                		'class'=>'glyphicon glyphicon-user',
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
                		'class'=>'fa fa-tachometer',
                		'item'=>array(
                		),
                	),

                	'task'=>array(
                		'text'=>'任务中心',
                		'href'=>'#',
                		'class'=>'fa fa-tasks',
                		'item'=>array(
                			array('text'=>'我的任务','href'=>Yii::app()->createUrl('/task/mytask'),'action'=>array('mytask')),
                            array('text'=>'所有任务','href'=>Yii::app()->createUrl('/task/list'),'action'=>array('list')),
                		),
                	),
                	'user'=>array(
                		'text'=>'个人中心',
                		'href'=>'#',
                		'class'=>'glyphicon glyphicon-user',
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

    /**
     * [syslog 日记记录]
     * @param  [string] $typeId [日志类别]
     * @param  [string] $content [日志内容]
     * @param  [string] $linkId [关联ID]
     * @param  [string] $linkId2 [关联ID2]
     * @return [boolean] true
     */
    public static function syslog($typeId,$content,$userId=0,$linkId='',$linkId2=''){
        $sys = new SysLog();
        $sys->typeId = $typeId;
        $sys->content = $content;
        $sys->linkId = $linkId;
        $sys->linkId2 = $linkId2;
        $sys->userId = $userId;
        $sys->save();
        return true;
    }

    /**
     * [taskpointlog 关闭任务后计算积分]
     * @param  [object] $ob [任务对象]
     * @return [] 积分值
     */
    public static function taskpointlog($ob){
        $log = new PointLog();


        if($ob->deadline >= date('Y-m-d',strtotime($ob->finishedDate)))
        {
            $point = $ob->point;
        }else{
            $daynum = (strtotime($ob->deadline) - strtotime($ob->estStarted))/86400;
            $average = round($ob->point/$daynum,2);

            $overdaynum = (strtotime(date('Y-m-d',strtotime($ob->finishedDate))) - strtotime($ob->deadline))/86400;

            $point = $ob->point - ($average*$overdaynum);
            $point = round($point,2);
        }

        $user = User::model()->findByPk($ob->finishedId);
        $user->point = $user->point+$point;
        $user->save();

        $log->userId = $ob->finishedId;
        $log->log_type = 1;
        $log->log_point = $point;
        $log->log_desc = "完成任务获取积分";
        $log->linkId = $ob->id;
        $log->save();

        $ob->finishedpoint = $point;
        $ob->save();

        return $point;
    }


    /**
     * [sendmessage 发送系统消息]
     * @param  [object] $touserId [接收消息]
     * @param  [object] $content [消息内容]
     * @param  [object] $typeId [消息类别]
     * @param  [object] $userId [发送者]
     * @param  [object] $linkId [关联ID]
     * @param  [object] $linkId2 [关联ID2]
     * @return [boolean] true
     */
    public static function sendmessage($touserId,$content,$typeId,$userId=0,$linkId='',$linkId2=''){
        $mess = new Message();
        $mess->touserId = $touserId;
        $mess->content = $content;
        $mess->typeId = $typeId;
        $mess->userId = $userId;
        $mess->linkId = $linkId;
        $mess->linkId2 = $linkId2;
        $mess->save();
        return true;
    }

    /**
     * 处理url中的参数 组成数组
     */
    public static function arrparam(){
        $queryString = Yii::app()->getRequest()->queryString;
        if(!empty($queryString))
        {
            $tmparr = explode('&',$queryString);
            $arr = array();
            foreach($tmparr as $key => $value)
            {
                $tmp = explode('=',$value);
                $arr[$tmp[0]]=$tmp[1];
            }
            return $arr;
        }
        else
            return array();

    }

}
