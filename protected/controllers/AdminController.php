<?php

class AdminController extends Controller
{

    public function init()
    {
        parent::init();
    }

	public function actionDeptment()
	{
		$this->pageTitle = '部门管理';
		$this->render('deptment');
	}

	public function actionWorkplace()
	{
		$this->pageTitle = '岗位管理';
		$this->render('workplace');
	}

	public function actionUser()
	{
		$this->pageTitle = '员工管理';
		$this->render('user');
	}
}