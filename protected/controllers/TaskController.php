<?php

class TaskController extends Controller
{
	public function init(){
		parent::init();
		$this->modelClass = 'Task';
	}

	public function actionAdd(){
		$this->page_css = array(
			'jquery-ui.custom.min.css',
			'chosen.css',
			'datepicker.css',
			'bootstrap-timepicker.css',
			'daterangepicker.css',
			'bootstrap-datetimepicker.css',
			'colorpicker.css',
			);

		$this->page_js = array(
			'jquery-ui.custom.min.js',
			'jquery.ui.touch-punch.min.js',
			'chosen.jquery.min.js',
			'fuelux/fuelux.spinner.min.js',
			'date-time/bootstrap-datepicker.min.js',
			'date-time/bootstrap-timepicker.min.js',
			'date-time/moment.min.js',
			'date-time/daterangepicker.min.js',
			'date-time/bootstrap-datetimepicker.min.js',
			'date-time/locales/bootstrap-datepicker.zh-CN.js',
			'bootstrap-colorpicker.min.js',
			'jquery.knob.min.js',
			'jquery.autosize.min.js',
			'jquery.inputlimiter.1.3.1.min.js',
			'jquery.maskedinput.min.js',
			'bootstrap-tag.min.js',
			);

		$model = new Task;

		$this->render('add',array('model'=>$model));
	}

	public function actionList()
	{
		$this->pageTitle = '任务列表';
		$this->render('list');
	}

	public function actionMytask(){
		$user_id = Yii::app()->user->id;
		$this->pageTitle = '我的任务';
		$this->render('mytask');
	}

	public function actionView(){
		$this->page_css = array(
			'jquery-ui.min.css',
			);
		$this->page_js = array(
			'jquery-ui.min.js',
			'jquery.ui.touch-punch.min.js',
			);

		$pk = Yii::app()->request->getParam('id');

		$model = Task::model()->findByPk($pk);

		$this->pageTitle = '任务详情页';

		$assigned = User::model()->findAll('status = 1 && typeId > 1 && id != '.Yii::app()->user->id);
		$assigned_arr = array();
		foreach($assigned as $key => $value)
		{
			$assigned_arr[$value->id] = $value->account;
		}

		$this->render('view',array('model'=>$model,'assigned_arr'=>$assigned_arr));
	}

	//任务指派
	public function actionAssigned(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');

			$model = Task::model()->findByPk($pk); 	
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if($model->openedId == Yii::app()->user->id && $model->status == 0)
        	{	
        		$assignedid = Yii::app()->request->getParam('assignedid');
        		$model->assignedId = $assignedid;
        		$model->assignedDate = date('Y-m-d H:i:s');
        		$model->save();
        		echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}		

        }
	}

	//任务取消
	public function actionCacel(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk); 	
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if($model->openedId == Yii::app()->user->id && $model->status == 0)
        	{	
        		$model->status = 4;
        		$model->save();
        		echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}		

        }
	}

	//未分配任务，自己承接
	public function actionUndertake(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk); 	
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if(empty($model->assignedId) && $model->status == 0 && $model->openedId != Yii::app()->user->id )
        	{	
        		$model->status = 1;
        		$model->realStarted = date('Y-m-d H:i:s');
        		$model->assignedId = Yii::app()->user->id;
        		$model->assignedDate = date('Y-m-d H:i:s');
        		$model->save();
        		echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}		

        }
	}

	//任务开始
	public function actionStart(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk); 	
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if($model->assignedId == Yii::app()->user->id && $model->status == 0)
        	{	
        		$model->status = 1;
        		$model->realStarted = date('Y-m-d H:i:s');
        		$model->save();
        		echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}		

        }
	}

	//任务备注
	public function actionRemark(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk); 	
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if($model->status < 2)
        	{	
        		$remark = trim(Yii::app()->request->getParam('remark'));

        		$task_remark = new TaskRemark();
        		$task_remark->remark = $remark;
        		$task_remark->taskId = $pk;
        		$task_remark->save();
        		echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}
        }
	}

	//任务完成
	public function actionFinished(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk); 	
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if($model->assignedId == Yii::app()->user->id && $model->status == 1)
        	{	
        		$model->status = 2;
        		$model->finishedId = Yii::app()->user->id;
        		$model->finishedDate = date('Y-m-d H:i:s');
        		$model->save();

        		//任务完成通知 创建人

        		echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}		

        }
	}

	//任务关闭并评分
	public function actionClosed(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk); 	
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if($model->openedId == Yii::app()->user->id && $model->status == 2)
        	{	
        		$model->status = 5;
        		$model->closedId = Yii::app()->user->id;
        		$model->closedDate = date('Y-m-d H:i:s');
        		$model->save();

        		//根据任务完成时间 发送积分 并通知完成人

        		echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}		

        }
	}
}