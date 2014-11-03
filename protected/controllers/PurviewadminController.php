<?php

class PurviewadminController extends Controller
{

    public function init()
    {
        parent::init();
    }

	public function actionAllpurview()
	{
		$this->pageTitle = '权限管理';
        $model = new Purview();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
		$this->render('allpurview',array('model'=>$model));
	}

	public function actionUserpurview()
	{
		$this->pageTitle = '用户权限';
        $model = new UserPurview();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
		$this->render('userpurview',array('model'=>$model));
	}
}