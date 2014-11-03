<?php

class HomeController extends Controller
{

    public function   init()
    {
        parent::init();
    }

	public function actionIndex()
	{
		$this->page_js = array(
			'jquery-ui.custom.min.js',
			'jquery.ui.touch-punch.min.js',
			'jquery.easypiechart.min.js',
			'jquery.sparkline.min.js',
			'flot/jquery.flot.min.js',
			'flot/jquery.flot.pie.min.js',
			'flot/jquery.flot.resize.min.js',
			);

		//查询系统日志
		$criteria=new CDbCriteria;
		$criteria->select = '*';
		$criteria->addCondition("valid = :valid");
		$criteria->params[':valid']=1;
		$criteria->order = 'id DESC' ;
		$criteria->limit = 10;
		$syslog = SysLog::model()->findAll($criteria);

		//查询我创建的任务
		$criteria=new CDbCriteria;
		$criteria->select = '*';
		$criteria->addCondition("openedId = :openedId");
		$criteria->params[':openedId']=Yii::app()->user->id;
		$criteria->order = 'createdTime DESC,id DESC' ;
		$criteria->limit = 10;
		$mycreatetask = Task::model()->findAll($criteria);

		//查询自己还未完成的任务
		$criteria=new CDbCriteria;
		$criteria->select = '*';
		$criteria->addCondition("assignedId = :assignedId");
		$criteria->params[':assignedId']=Yii::app()->user->id;
		$criteria->addCondition("status < :status");
		$criteria->params[':status'] = 2;
		$criteria->order = 'imtypeId DESC,createdTime DESC,id DESC' ;
		$criteria->limit = 5;
		$myhandletask = Task::model()->findAll($criteria);

		//查询还未指派的的任务
		$criteria=new CDbCriteria;
		$criteria->select = '*';
		$criteria->addCondition("assignedId = :assignedId");
		$criteria->params[':assignedId'] = 0;
		$criteria->addCondition("status = :status");
		$criteria->params[':status'] = 0;
		$criteria->order = 'imtypeId DESC,createdTime DESC,id DESC' ;
		$criteria->limit = 5;
		$noassigned = Task::model()->findAll($criteria);


		////查询我未读的消息通知
		$criteria=new CDbCriteria;
		$criteria->select = '*';
		$criteria->addCondition("touserId = :touserId");
		$criteria->params[':touserId']=Yii::app()->user->id;
		$criteria->order = 'createdTime DESC,id DESC' ;
		$criteria->limit = 10;
		$mymessage = Message::model()->findAll($criteria);

		//查询个人信息
		$user = User::model()->findByPk(Yii::app()->user->id);

		//查询我的积分记录
		$criteria=new CDbCriteria;
		$criteria->select = '*';
		$criteria->addCondition("userId = :userId");
		$criteria->params[':userId']=Yii::app()->user->id;
		$criteria->order = 'createdTime DESC,id DESC' ;
		$criteria->limit = 10;
		$mypointlog = PointLog::model()->findAll($criteria);

		$this->pageTitle = '控制台';
		$this->render('index1',
			array(
				'syslog'=>$syslog,
				'mycreatetask'=>$mycreatetask,
				'myhandletask'=>$myhandletask,
				'noassigned'=>$noassigned,
				'mymessage'=>$mymessage,
				'mypointlog'=>$mypointlog,
				'user'=>$user,
				)
			);
	}

	public function actionWelcome()
	{
		$this->render('welcome');
	}
}