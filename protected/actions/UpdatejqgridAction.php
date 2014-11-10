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

                    if(isset($model->password)){
                        $old_password = $model->password;
                        $model->attributes = $data;
                        if(isset($data['password']) && !empty($data['password']))
                            $model->password = md5($model->password);
                        else
                            $model->password = $old_password;
                    }else{
                        $model->attributes = $data;
                    }

                    if($model->save()){
                        if($this->modelClass == 'Deptment'){
                            Helpers::syslog(5,Yii::app()->user->getState('account')."更新了部门 [".$model->name."] 信息",Yii::app()->user->id,$model->id);
                        }elseif($this->modelClass == 'Workplace'){
                            Helpers::syslog(6,Yii::app()->user->getState('account')."更新了岗位 [".$model->name."] 信息",Yii::app()->user->id,$model->id);
                        }elseif($this->modelClass == 'User'){
                            Helpers::syslog(4,Yii::app()->user->getState('account')."更新了员工 [".$model->account."] 信息",Yii::app()->user->id,$model->id);
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