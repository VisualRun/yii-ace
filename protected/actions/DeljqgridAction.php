<?php

/**
 * crud重用
 */
class DeljqgridAction extends CAction{
	public $renderTo = '/actions/create';
    public $successRedirect = 'index';
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
                    $model->status = -1;
                    if($model->save()){
                        if($this->modelClass == 'Deptment'){
                            Helpers::syslog(5,Yii::app()->user->getState('account')."删除了部门 [".$model->name."]",Yii::app()->user->id,$model->id);
                        }elseif($this->modelClass == 'Workplace'){
                            Helpers::syslog(6,Yii::app()->user->getState('account')."删除了岗位 [".$model->name."]",Yii::app()->user->id,$model->id);
                        }elseif($this->modelClass == 'User'){
                            Helpers::syslog(4,Yii::app()->user->getState('account')."删除了员工 [".$model->account."]",Yii::app()->user->id,$model->id);
                        }elseif($this->modelClass == 'Gift'){
                            Helpers::syslog(7,Yii::app()->user->getState('account')."删除了兑换物品 [".$model->name."]",Yii::app()->user->id,$model->id);
                        }
                        echo true;
                    }else
                        echo json_encode($model->getErrors());
                }
            }
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
}