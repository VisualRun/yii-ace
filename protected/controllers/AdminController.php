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

		$this->render('deptment');
	}

	public function actionWorkplace()
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

		$this->pageTitle = '岗位管理';

		$this->render('workplace');
	}

	public function actionUser()
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

		$this->pageTitle = '员工管理';

		$this->render('user');
	}
}