<?php

class HomeController extends Controller
{

    public function   init()
    {
        parent::init();
    }

	public function actionIndex()
	{
		$this->page_js = array(
			'jquery-ui.custom.min.js',
			'jquery.ui.touch-punch.min.js',
			'jquery.easypiechart.min.js',
			'jquery.sparkline.min.js',
			'flot/jquery.flot.min.js',
			'flot/jquery.flot.pie.min.js',
			'flot/jquery.flot.resize.min.js',
			);

		$this->pageTitle = '控制台';
		$this->render('index');
	}

	public function actionWelcome()
	{
		$this->render('welcome');
	}
}