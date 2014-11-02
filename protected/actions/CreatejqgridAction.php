<?php

/**
 * crud重用
 */
class CreatejqgridAction extends CAction{
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
                if(isset($data['password']))
                    $model->password = md5($model->password);
                if($model->save()){
                    if($this->modelClass == 'Deptment'){
                        Helpers::syslog(5,Yii::app()->user->getState('account')."添加了部门 [".$model->name."]",Yii::app()->user->id,$model->id);
                    }elseif($this->modelClass == 'Workplace'){
                        Helpers::syslog(6,Yii::app()->user->getState('account')."添加了岗位 [".$model->name."]",Yii::app()->user->id,$model->id);
                    }elseif($this->modelClass == 'User'){
                        Helpers::syslog(4,Yii::app()->user->getState('account')."添加了员工 [".$model->account."]",Yii::app()->user->id,$model->id);
                    }
                    echo true;
                }else
                    echo json_encode($model->getErrors());
            }
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
}