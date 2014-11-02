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
		$this->render('allpurview');
	}

	public function actionUserpurview()
	{
		$this->pageTitle = '用户权限';
		$this->render('userpurview');
	}
}