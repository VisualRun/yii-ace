<?php

/**
 * crud重用
 */
class CreateAction extends CAction{
	public $renderTo = '/actions/create';
    public $successRedirect = 'view';
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
            'markdown/markdown.min.js',
            'markdown/bootstrap-markdown.min.js',
            'jquery.hotkeys.min.js',
            'bootstrap-wysiwyg.min.js',
            );

        //$saveType = Yii::app()->request->getParam('saveType');
        $pk = Yii::app()->request->getParam('id');
        if(empty($pk)){
            $this->getController()->pageTitle = '新增';
            $model = new $this->modelClass;
            $model->scenario = 'new';
        }else{
            $this->getController()->pageTitle = '编辑';
            $model = CActiveRecord::model($this->modelClass)->findByPk($pk);
            if(!$model)
                $arr = array('hasError'=>true,'msg'=>'数据提交失败');
                $model->scenario = 'update';
        }

        if(isset($_POST[$this->modelClass]))
        {
            $model->attributes=$_POST[$this->modelClass];

            //如果文件上传
            $uploaded = CUploadedFile::getInstance($model,'opAdminId');
            print_r($model);exit;
            if(is_object($uploaded) && get_class($uploaded)==='CUploadedFile'){
                if($uploaded->size > 8*1024*1024){
                    $model->addError('opAdminId','文件太大！');
                }

                $uploaddir=Yii::getPathOfAlias('webroot') .'/data/file/';

                $ymd = date("Ymd");
                $uploaddir .= $ymd . "/";
                if (!file_exists($uploaddir)) {
                    mkdir($uploaddir);
                }
                @chmod($uploaddir, 0755);

                $filename = md5(uniqid());
                $ext = $uploaded->extensionName;
                $old_name = $uploaded->name;
                $uploadfile=$uploaddir . $filename . '.' . $ext;

                if($uploaded->saveAs($uploadfile))
                {
                    $file = new File();
                    $file->path = $uploadfile;
                    $file->title = $old_name;
                    $file->extension = $ext;
                    $file->extension = $uploaded->size;
                    $file->save();
                }
                else
                    $model->addError('opAdminId','文件上传失败！');

            }
            if($model->hasErrors())
                Yii::app()->end();

            if($model->save())
            {
                $id = $model->{$model->tableSchema->primaryKey};
                if($file){
                    $file->taskID = $id;
                    $file->save();
                }
                //$arr = array('hasError'=>false,'msg'=>'数据提交成功','model'=>$model->attributes);
                $this->getController()->redirect( array($this->successRedirect, 'id'=>$id) );
            }else{
                $arr = array('hasError'=>true,'msg'=>'数据提交失败','error'=>$model->getErrors(),'model'=>$model->attributes);
                //throw new CHttpException(400,$arr);
                return false;
            }
            //echo json_encode($arr);
        }else{
            $this->getController()->render($this->renderTo,array('model'=>$model));
        }

        Yii::app()->end();
    }
}