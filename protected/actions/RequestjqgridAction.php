<?php

/**
 * crud重用
 */
class RequestjqgridAction extends CAction{
	public $modelClass = '';
    public function run(){


    	$obj = $this->modelClass;
        $model=new $obj();
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;

        $currentPage = Yii::app()->request->getParam('pageIndex');
        $resultType = Yii::app()->request->getParam('resultType');
        $data = $model->$resultType($currentPage);
        echo json_encode($data, YII_DEBUG ? JSON_PRETTY_PRINT : 0);
        Yii::app()->end();
    }
}