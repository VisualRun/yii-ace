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
		$this->pageTitle = '控制台';
		$this->render('index');
	}

	public function actionWelcome()
	{
		$this->render('welcome');
	}
}