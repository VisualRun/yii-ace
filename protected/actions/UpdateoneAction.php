<?php

/**
 * crud重用
 */
class UpdateoneAction extends CAction{  
    public $modelClass;  
    function run(){  
        if (Yii::app()->request->isAjaxRequest)
        {
            $data = $_POST['data'];
            if(!empty($data)){
                foreach ($data as $key => $value) {
                    if(is_numeric($value['id'])){
                        $pk = $value['id']; 
                        $name = 'status';
                        $value = -1; 
                        if(empty($pk))    
                            throw new CHttpException(404);    
                        $model = CActiveRecord::model($this->modelClass)->findByPk($pk); 
                        if(!$model)    
                            throw new CHttpException(404);   
                        $model->{$name} = $value;
                        $model->save(); 
                    }
                }
            }
            if(isset(Yii::app()->request->isAjaxRequest)) {
                    echo true;
            } else
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    } 
}