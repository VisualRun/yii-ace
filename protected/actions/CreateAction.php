<?php

/**
 * crud重用
 */
class CreateAction extends CAction{
	public $renderTo = '/actions/create';
    public $successRedirect = 'index';
    public $modelClass;
    function run(){
        // $saveType = Yii::app()->request->getParam('saveType');
        // $pk = Yii::app()->request->getParam('id');
        // if($saveType=='add'&&empty($pk)){
        //     $model = new $this->modelClass;
        //     $model->scenario = 'new';
        // }else{
        //     $model = CActiveRecord::model($this->modelClass)->findByPk($pk);
        //     if(!$model)
        //         $arr = array('hasError'=>true,'msg'=>'数据提交成功');
        //     $model->scenario = 'update';
        // }

        // if(isset($_GET)&&!isset($arr))
        // {
        //     $model->attributes=$_GET;
        //     $uploadedimage=CUploadedFile::getInstance($model, 'img');
        //     if(is_object($uploadedimage) && get_class($uploadedimage)==='CUploadedFile'){
        //         $uploaddir=Yii::getPathOfAlias('webroot') .'/data/';
        //         $filename = md5(uniqid());
        //         $ext = $uploadedimage->extensionName;
        //         $uploadfile=$uploaddir . $filename . '.' . $ext;
        //         $uploadedimage->saveAs($uploadfile);
        //         $model->img='data/' . $filename . '.' . $ext;
        //     }
        //     if($model->save()){
        //         $arr = array('hasError'=>false,'msg'=>'数据提交成功','model'=>$model->attributes);
        //     }else{

        //         $arr = array('hasError'=>true,'msg'=>'数据提交失败','error'=>$model->getErrors(),'model'=>$model->attributes);
        //     }
        // }
        // echo json_encode($arr);
        // Yii::app()->end();

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