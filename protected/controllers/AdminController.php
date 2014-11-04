<?php

class AdminController extends Controller
{

    public function init()
    {
        parent::init();
    }

	public function actionDeptment()
	{
        $this->menu_nav = array(
                array(
                    'value'=>'组织中心',
                ),
            );

		$this->pageTitle = '部门管理';
        $model = new Deptment();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
		$this->render('deptment',array('model'=>$model));
	}

	public function actionWorkplace()
	{
		$this->pageTitle = '岗位管理';
        $model = new Workplace();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
		$this->render('workplace',array('model'=>$model));
	}

	public function actionUser()
	{
		$this->pageTitle = '员工管理';
        $model = new User();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
		$this->render('user',array('model'=>$model));
	}
}