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
                            array('text'=>'发布任务','href'=>Yii::app()->createUrl('/task/add'),'action'=>array('add')),
                            array('text'=>'我发布的任务','href'=>Yii::app()->createUrl('/task/mypublishtask'),'action'=>array('mypublishtask')),
                			array('text'=>'我处理的任务','href'=>Yii::app()->createUrl('/task/myhandletask'),'action'=>array('myhandletask')),
                			array('text'=>'所有任务','href'=>Yii::app()->createUrl('/task/list'),'action'=>array('list')),
                		),
                	),
                	'user'=>array(
                		'text'=>'个人中心',
                		'href'=>'#',
                		'class'=>'glyphicon glyphicon-user',
                		'item'=>array(
                            array('text'=>'个人消息','href'=>Yii::app()->createUrl('/user/message'),'action'=>array('message')),
                			array('text'=>'个人积分','href'=>Yii::app()->createUrl('/user/point'),'action'=>array('point')),
                			array('text'=>'修改密码','href'=>Yii::app()->createUrl('/user/passwdedit'),'action'=>array('passwdedit')),
                		),
                	),
                    'gift'=>array(
                        'text'=>'兑换中心',
                        'href'=>'#',
                        'class'=>'fa fa-exchange',
                        'item'=>array(
                            array('text'=>'兑换物品管理','href'=>Yii::app()->createUrl('/gift/giftlist'),'action'=>array('giftlist')),
                            array('text'=>'兑换记录审核','href'=>Yii::app()->createUrl('/gift/exchangecheck',array('status'=>0)),'action'=>array('exchangecheck')),
                            array('text'=>'兑换操作','href'=>Yii::app()->createUrl('/gift/gift'),'action'=>array('gift')),
                            array('text'=>'个人兑换记录','href'=>Yii::app()->createUrl('/gift/exchange'),'action'=>array('exchange')),
                        ),
                    ),
                	'admin'=>array(
                		'text'=>'管理中心',
                		'href'=>'#',
                		'class'=>'fa fa-users',
                		'item'=>array(
                			array('text'=>'部门管理','href'=>Yii::app()->createUrl('/admin/deptment'),'action'=>array('deptment')),
                			array('text'=>'岗位管理','href'=>Yii::app()->createUrl('/admin/workplace'),'action'=>array('workplace')),
                            array('text'=>'员工管理','href'=>Yii::app()->createUrl('/admin/user'),'action'=>array('user')),
                            array('text'=>'积分统计','href'=>Yii::app()->createUrl('/admin/point'),'action'=>array('point')),
                            array('text'=>'最新动态','href'=>Yii::app()->createUrl('/admin/syslog'),'action'=>array('syslog')),
                            array('text'=>'人事绩效加分','href'=>Yii::app()->createUrl('/admin/addpoint'),'action'=>array('addpoint')),
                            array('text'=>'人事绩效减分','href'=>Yii::app()->createUrl('/admin/subtractpoint'),'action'=>array('subtractpoint')),
                		),
                	),
                    'purviewadmin'=>array(
                        'text'=>'权限中心',
                        'href'=>'#',
                        'class'=>'fa fa-cogs',
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
                			array('text'=>'发布任务','href'=>Yii::app()->createUrl('/task/add'),'action'=>array('add')),
                            array('text'=>'我发布的任务','href'=>Yii::app()->createUrl('/task/mypublishtask'),'action'=>array('mypublishtask')),
                            array('text'=>'我处理的任务','href'=>Yii::app()->createUrl('/task/myhandletask'),'action'=>array('myhandletask')),
                            array('text'=>'所有任务','href'=>Yii::app()->createUrl('/task/list'),'action'=>array('list')),
                		),
                	),
                	'user'=>array(
                		'text'=>'个人中心',
                		'href'=>'#',
                		'class'=>'glyphicon glyphicon-user',
                		'item'=>array(
                            array('text'=>'个人消息','href'=>Yii::app()->createUrl('/user/message'),'action'=>array('message')),
                			array('text'=>'个人积分','href'=>Yii::app()->createUrl('/user/point'),'action'=>array('point')),
                			array('text'=>'修改密码','href'=>Yii::app()->createUrl('/user/passwdedit'),'action'=>array('passwdedit')),
                		),
                	),
                    'gift'=>array(
                        'text'=>'兑换中心',
                        'href'=>'#',
                        'class'=>'fa fa-exchange',
                        'item'=>array(
                            array('text'=>'兑换操作','href'=>Yii::app()->createUrl('/gift/gift'),'action'=>array('gift')),
                            array('text'=>'个人兑换记录','href'=>Yii::app()->createUrl('/gift/exchange'),'action'=>array('exchange')),
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
                			array('text'=>'我处理的任务','href'=>Yii::app()->createUrl('/task/myhandletask'),'action'=>array('myhandletask')),
                            array('text'=>'所有任务','href'=>Yii::app()->createUrl('/task/list'),'action'=>array('list')),
                		),
                	),
                	'user'=>array(
                		'text'=>'个人中心',
                		'href'=>'#',
                		'class'=>'glyphicon glyphicon-user',
                		'item'=>array(
                            array('text'=>'个人提醒','href'=>Yii::app()->createUrl('/user/message'),'action'=>array('message')),
                			array('text'=>'个人消息','href'=>Yii::app()->createUrl('/user/profile'),'action'=>array('profile')),
                            array('text'=>'个人积分','href'=>Yii::app()->createUrl('/user/point'),'action'=>array('point')),
                			array('text'=>'修改密码','href'=>Yii::app()->createUrl('/user/passwdedit'),'action'=>array('passwdedit')),
                		),
                	),
                    'gift'=>array(
                        'text'=>'兑换中心',
                        'href'=>'#',
                        'class'=>'fa fa-exchange',
                        'item'=>array(
                            array('text'=>'兑换操作','href'=>Yii::app()->createUrl('/gift/gift'),'action'=>array('gift')),
                            array('text'=>'个人兑换记录','href'=>Yii::app()->createUrl('/gift/exchange'),'action'=>array('exchange')),
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
        if($ob->deadline_type == 1){
            if($ob->deadline >= date('Y-m-d',strtotime($ob->finishedDate)))
            {
                $point = $ob->point;
            }else{
                $daynum = (strtotime($ob->deadline)+86400 - strtotime($ob->estStarted))/86400;
                $average = round($ob->point/$daynum,2);

                $overdaynum = ceil((strtotime(date('Y-m-d',strtotime($ob->finishedDate))) - strtotime($ob->deadline))/86400);

                $point = $ob->point - ($average*$overdaynum);
                $point = round($point,2);
            }
        }elseif($ob->deadline_type == 2){
            $realdeadline = self::realdeadline($ob);

            if($realdeadline >= date('Y-m-d H:i:s',time()))
            {
                $point = $ob->point;
            }else{
                $average = round($ob->point/$ob->deadline,2);
                //用ceil将除出来的结果往上进一位
                $overhournum = ceil((strtotime($ob->finishedDate) - strtotime($realdeadline))/86400);

                $point = $ob->point - ($average*$overhournum);
                $point = round($point,2);
            }
        }


        $user = User::model()->findByPk($ob->finishedId);
        $user->point = $user->point+$point;
        $user->save();

        $log = new PointLog();
        $log->userId = $ob->finishedId;
        $log->log_type = 1;
        $log->log_point = $point;
        $log->log_desc = "完成任务 [".$ob->name."] 获取积分，任务号：".$ob->code;
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
        $queryString = urldecode(Yii::app()->getRequest()->queryString);
        if(!empty($queryString))
        {
            $tmparr = explode('&',$queryString);
            $arr = array();
            foreach($tmparr as $key => $value)
            {
                $tmp = explode('=',$value);
                $arr[$tmp[0]]=trim($tmp[1]);
            }
            return $arr;
        }
        else
            return array();

    }

    //utf8 截取字符
    public static function substrUtf8($str, $cutLength, $etc = '...') {
        $result = '';
        $i = 0;
        $n = 0.0;
        $strLength = strlen($str); //字符串的字节数

        while ($n < $cutLength && $i < $strLength) {

            $tempStr = substr($str, $i, 1);
            $ascnum = ord($tempStr); //得到字符串中第$i位字符的ASCII码

            if ($ascnum >= 252) {

                //如果ASCII位高于252
                $result = $result . substr($str, $i, 6); //根据UTF-8编码规范，将6个连续的字符计为单个字符
                $i = $i + 6; //实际Byte计为6
                $n ++; //字串长度计1

            } elseif ($ascnum >= 248) {

                //如果ASCII位高于248
                $result = $result . substr($str, $i, 5); //根据UTF-8编码规范，将5个连续的字符计为单个字符
                $i = $i + 5; //实际Byte计为5
                $n ++; //字串长度计1

            } elseif ($ascnum >= 240) {

                //如果ASCII位高于240
                $result = $result . substr($str, $i, 4); //根据UTF-8编码规范，将4个连续的字符计为单个字符
                $i = $i + 4; //实际Byte计为4
                $n ++; //字串长度计1

            } elseif ($ascnum >= 224) {

                //如果ASCII位高于224
                $result = $result . substr($str, $i, 3); //根据UTF-8编码规范，将3个连续的字符计为单个字符
                $i = $i + 3 ; //实际Byte计为3
                $n ++; //字串长度计1

            } elseif ($ascnum >= 192) {

                //如果ASCII位高于192
                $result = $result . substr($str, $i, 2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
                $i = $i + 2; //实际Byte计为2
                $n ++; //字串长度计1

            } elseif ($ascnum >= 65 && $ascnum <= 90 && $ascnum != 73) {

                //如果是大写字母 I除外
                $result = $result . substr($str, $i, 1);
                $i = $i + 1; //实际的Byte数仍计1个
                $n ++; //但考虑整体美观，大写字母计成一个高位字符

            } elseif (!(array_search($ascnum, array(37, 38, 64, 109 ,119)) === FALSE)) {

                //%,&,@,m,w 字符按１个字符宽
                $result = $result . substr($str, $i, 1);
                $i = $i + 1; //实际的Byte数仍计1个
                $n ++; //但考虑整体美观，这些字条计成一个高位字符

            } else {

                //其他情况下，包括小写字母和半角标点符号
                $result = $result . substr($str, $i, 1);
                $i = $i + 1; //实际的Byte数计1个
                $n = $n + 0.5; //其余的小写字母和半角标点等于半个高位字符宽...
            }
        }

        if ($i < $strLength) {
            $result = $result . $etc; //超过长度时在尾处加上省略号
        }

        return $result;
    }

    //获取任务的正式deadline $obj 为task 任务对象
    public static function realdeadline($obj){
        if($obj->deadline_type == 1)
        {
            return date('Y-m-d H:i:s',strtotime($obj->deadline)+86399);
        }elseif($obj->deadline_type == 2){
            return date('Y-m-d H:i:s',strtotime($obj->openedDate)+3600*$obj->deadline);
        }
    }

}
