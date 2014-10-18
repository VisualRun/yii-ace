<?php

class AdminController extends Controller
{

    public function   init()
    {
        parent::init();
    }

	public function actionDeptment()
	{
		$this->pageTitle = '控制台';
    $model = new Deptment;
		$this->render('deptment',array('model'=>$model));
	}

	public function actionWorkplace()
	{
		$this->render('workplace');
	}
}