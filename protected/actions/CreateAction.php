<?php

/**
 * crud重用
 */
class CreateAction extends CAction{
	public $renderTo = '/actions/create';
    public $successRedirect = 'index';
    public $modelClass;
    
    function run(){

        $this->getController()->page_css = array(
            'jquery-ui.custom.min.css',
            'chosen.css',
            'datepicker.css',
            'bootstrap-timepicker.css',
            'daterangepicker.css',
            'bootstrap-datetimepicker.css',
            'colorpicker.css',
            );

        $this->getController()->page_js = array(
            'jquery-ui.custom.min.js',
            'jquery.ui.touch-punch.min.js',
            'chosen.jquery.min.js',
            'fuelux/fuelux.spinner.min.js',
            'date-time/bootstrap-datepicker.min.js',
            'date-time/bootstrap-timepicker.min.js',
            'date-time/moment.min.js',
            'date-time/daterangepicker.min.js',
            'date-time/bootstrap-datetimepicker.min.js',
            'bootstrap-colorpicker.min.js',
            'jquery.knob.min.js',
            'jquery.autosize.min.js',
            'jquery.inputlimiter.1.3.1.min.js',
            'jquery.maskedinput.min.js',
            'bootstrap-tag.min.js',
            );

        // $saveType = Yii::app()->request->getParam('saveType');
        // $pk = Yii::app()->request->getParam('id');
        // if($saveType=='add'&&empty($pk)){
        $model = new $this->modelClass;
        $model->scenario = 'new';
        // }else{
        //     $model = CActiveRecord::model($this->modelClass)->findByPk($pk);
        //     if(!$model)
        //         $arr = array('hasError'=>true,'msg'=>'数据提交失败');
        //     $model->scenario = 'update';
        // }

        if(isset($_POST[$this->modelClass]))
        {
            $model->attributes=$_POST[$this->modelClass];
            $uploaded=CUploadedFile::getInstance($model, 'opAdminId');
            if(is_object($uploaded) && get_class($uploaded)==='CUploadedFile'){
                $uploaddir=Yii::getPathOfAlias('webroot') .'/data/';
                $filename = md5(uniqid());
                $ext = $uploadedimage->extensionName;
                $uploadfile=$uploaddir . $filename . '.' . $ext;
                $uploadedimage->saveAs($uploadfile);
                $model->img='data/' . $filename . '.' . $ext;
            }
            if($model->save()){
                $arr = array('hasError'=>false,'msg'=>'数据提交成功','model'=>$model->attributes);
            }else{
                $arr = array('hasError'=>true,'msg'=>'数据提交失败','error'=>$model->getErrors(),'model'=>$model->attributes);
            }
            echo json_encode($arr);
        }else{
            $this->getController()->render($this->renderTo,array('model'=>$model));
        }

        Yii::app()->end();
    }
}