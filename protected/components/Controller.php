<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public $modelClass = '';
	
	//每个页面自有的css
	public $page_css=array();

	//每个页面自有的js
	public $page_js=array();

	public function actions(){  
        return array(
        	'create'=>array(  
                    'class'=>'CreateAction',  
                    'modelClass'=>$this->modelClass,
                ),
        	'createjqgrid'=>array(  
                    'class'=>'CreatejqgridAction',  
                    'modelClass'=>$this->modelClass,  
                ),
        	'deljqgrid'=>array(  
                    'class'=>'DeljqgridAction',  
                    'modelClass'=>$this->modelClass,  
                ),
        	'updatejqgrid'=>array(  
                    'class'=>'UpdatejqgridAction',  
                    'modelClass'=>$this->modelClass,  
                ),
        	'requestjqgrid'=>array(  
                    'class'=>'RequestjqgridAction',  
                    'modelClass'=>$this->modelClass,  
                ),
        	);  
    }


	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
}