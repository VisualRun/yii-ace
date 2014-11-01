<?php

/**
 * crud重用
 */
class UpdatejqgridAction extends CAction{
    public $modelClass;
    function run(){
        if (Yii::app()->request->isAjaxRequest)
        {
            $data = $_POST;
            if(!empty($data)){
                if(is_numeric($data['id'])){
                    $pk = $data['id'];
                    if(empty($pk))
                        throw new CHttpException(404);
                    $model = CActiveRecord::model($this->modelClass)->findByPk($pk);
                    $model->attributes = $data;
                    if(isset($data['password']))
                        $model->password = md5($model->password);
                    if($model->save())
                        echo true;
                    else
                        echo json_encode($model->getErrors());
                }
            }
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
}