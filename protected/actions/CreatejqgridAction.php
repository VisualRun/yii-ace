<?php

/**
 * crud重用
 */
class CreatejqgirdAction extends CAction{
	public $renderTo = '/actions/create';
    public $successRedirect = 'index';
    public $modelClass;
    function run(){
        if (Yii::app()->request->isAjaxRequest)
        {
            $data = $_POST;
            if(!empty($data)){
                $model = new $this->modelClass;
                $model->attributes = $data;
                if($model->save())
                    echo true;
                else
                    echo json_encode($model->getErrors());
            }
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
}