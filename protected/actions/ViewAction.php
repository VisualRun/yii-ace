<?php

/**
 * crud重用
 */
class ViewAction extends CAction{  
    public $param = 'id';  
    public $renderTo = '/actions/view';  
    public $modelClass;  
    function run(){  
        $pk = Yii::app()->request->getParam($this->param);  
        if(empty($pk))    
            throw new CHttpException(404);    
        $model = CActiveRecord::model($this->modelClass)->findByPk($pk);  
        if(!$model)    
            throw new CHttpException(404);   
               
        $this->getController()->render($this->renderTo, array('model'=>$model));  
    }  
}