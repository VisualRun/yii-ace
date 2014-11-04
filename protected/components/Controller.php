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

    //每个页面的menu_nav
    public $menu_nav=array();

	//每个页面自有的css
	public $page_css=array();

	//每个页面自有的js
	public $page_js=array();

	public function beforeAction($action){
		//查询权限表
		$purview = Purview::model()->findByAttributes(array('controller'=>strtoupper($this->getId()),'action'=>strtoupper($this->action->id),'valid'=>1));
		if($purview)
		{
			$tmpusertype = Yii::app()->user->getState('type');
			$userpurview = UserPurview::model()->findByAttributes(array('usertypeId'=>$tmpusertype,'purviewId'=>$purview->id,'valid'=>1));
			if(empty($userpurview)){
				echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
				echo "<script>alert('没有权限！')</script>";
				echo "<script>window.location.href='".Yii::app()->createUrl('/home/index')."'</script>";
			}else
				return true;
		}
		else
			return true;
	}

	public function actions(){
        return array(
        	'create'=>array(
                    'class'=>'CreateAction',
                    'modelClass'=>$this->modelClass,
                ),
            'view'=>array(
                    'class'=>'ViewAction',
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