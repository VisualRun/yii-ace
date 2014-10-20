<?php

class AdminController extends Controller
{

    public function init()
    {
        parent::init();
    }

	public function actionDeptment()
	{	
		$this->page_css = array(
			'jquery-ui.min.css',
			'datepicker.css',
			'ui.jqgrid.css',
			);

		$this->page_js = array(
			'date-time/bootstrap-datepicker.min.js',
			'jqGrid/jquery.jqGrid.min.js',
			'jqGrid/i18n/grid.locale-en.js',
			);

		$this->pageTitle = '部门管理';
    	$model = new Deptment;

    	// $res = $model->search()->getData();
    	// print_r($res);

		$this->render('deptment',array('model'=>$model));
	}

	public function actionWorkplace()
	{
		$this->render('workplace');
	}
}