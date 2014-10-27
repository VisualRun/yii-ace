<?php

class TaskController extends Controller
{
	public function init(){
		parent::init();
		$this->modelClass = 'Task';
	}

	public function actionAdd(){
		$model = new Task;
		$this->render('add',$model);
	}
}