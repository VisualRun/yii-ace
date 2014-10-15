<?php
class UserController extends Controller
{

	public $layout = '//layouts/column1';

    public function   init()
    {
        parent::init();
    }

	public function actionIndex()
	{
		$this->pageTitle = '个人中心';
		$this->render('index');
	}

	public function actionWelcome()
	{
	}
}	
?>