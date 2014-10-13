<?php

class HomeController extends Controller
{

	// public function init(){
	// 	parent::init();
	// 	$this->modelClass = 'Pcbbuyer';
	// }

	public function actionIndex()
	{
		echo 1;exit;
		$this->render('index');
	}

	public function actionWelcome()
	{
		$this->render('welcome');
	}
}