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

		$assigned = User::model()->findAll('status = 1 && typeId > 1');
		$assigned_arr = array();
		foreach($assigned as $key => $value)
		{
			$assigned_arr[$value->id] = $value->account;
		}

		$this->render('view',array('model'=>$model,'assigned_arr'=>$assigned_arr));
	}
}