<?php

class HomeController extends Controller
{

	public $layout = '//layouts/column1';

    public function   init()
    {
        parent::init();
    }

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionWelcome()
	{
		$this->render('welcome');
	}
}