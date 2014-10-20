<?php

Yii::import('zii.widgets.CPortlet');

class JqGridlist extends CPortlet
{
	public $pageSize = 10;
	public $model = '';
	public $viewData = [];
	public $caption = '';
	protected function renderContent()
	{
		$this->render('jqgridlist',
			array(
				'model'=>$this->model,
				'pageSize'=>$this->pageSize,
				'viewData'=>$this->viewData,
				'caption'=>$this->caption,
			)
		);
	}
}