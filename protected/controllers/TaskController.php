<?php

class TaskController extends Controller
{
	public function init(){
		parent::init();
		$this->modelClass = 'Task';
	}

    public function actionAdd(){
        $this->page_css = array(
            'jquery-ui.custom.min.css',
            'chosen.css',
            'datepicker.css',
            'bootstrap-timepicker.css',
            'bootstrap-datetimepicker.css',
            'dropzone.css',
            );

        $this->page_js = array(
            'jquery-ui.custom.min.js',
            'jquery.ui.touch-punch.min.js',
            'chosen.jquery.min.js',
            'fuelux/fuelux.spinner.min.js',
            'date-time/bootstrap-datepicker.min.js',
            'date-time/bootstrap-timepicker.min.js',
            'date-time/moment.min.js',
            'date-time/bootstrap-datetimepicker.min.js',
            'date-time/locales/bootstrap-datepicker.zh-CN.js',
            'jquery.knob.min.js',
            'jquery.autosize.min.js',
            'jquery.inputlimiter.1.3.1.min.js',
            'jquery.maskedinput.min.js',
            'bootstrap-tag.min.js',
            'markdown/markdown.min.js',
            'markdown/bootstrap-markdown.min.js',
            'jquery.hotkeys.min.js',
            'bootstrap-wysiwyg.min.js',
            'dropzone.min.js',
            );

        //$saveType = Yii::app()->request->getParam('saveType');
        $pk = Yii::app()->request->getParam('id');
        if(empty($pk)){
            $this->pageTitle = '发布任务';
            $model = new Task;
            $model->scenario = 'new';
            $model->unsetAttributes();
        }else{
            $this->pageTitle = '编辑任务';
            $model = Task::model()->findByPk($pk);
            if(!$model)
                $arr = array('hasError'=>true,'msg'=>'数据提交失败');
            $model->scenario = 'update';
        }

        if(isset($_POST['Task']))
        {
            $old_assignedId = $model->assignedId;
            $model->attributes=$_POST['Task'];

            //如果文件上传
            $uploaded = CUploadedFile::getInstanceByName('Task[opAdminId]');
            #print_r($uploaded);exit;
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

            if($model->assignedId != 0){
                $model->assignedDate = date('Y-m-d H:i:s');
            }

            if($model->save())
            {
                $id = $model->primarykey;
                if(isset($file)){
                    $file->taskID = $id;
                    $file->save();
                }
                if($model->scenario == 'new')
                {
                    Helpers::syslog(2,Yii::app()->user->getState('account')." 发布了任务 [".$model->name."]",Yii::app()->user->id,$id);
                    if($model->assignedId != 0){
                        $content = Yii::app()->user->getState('account')." 创建并指派了任务 [".$model->name."] 给你，请在规定的时限内完成！";
                        Helpers::sendmessage($model->assignedId,$content,2,0,$id);
                    }
                }elseif($model->scenario == 'update'){

                    Helpers::syslog(2,Yii::app()->user->getState('account')." 编辑了任务 [".$model->name."]",Yii::app()->user->id,$id);
                    if($model->assignedId != 0 && $model->assignedId != $old_assignedId ){
                        $content = Yii::app()->user->getState('account')." 编辑并指派了任务 [".$model->name."] 给你，请在规定的时限内完成！";
                        Helpers::sendmessage($model->assignedId,$content,2,0,$id);
                    }
                }

                $this->redirect(array('view','id'=>$id));
            }else{
                $arr = array('hasError'=>true,'msg'=>'数据提交失败','error'=>$model->getErrors(),'model'=>$model->attributes);
                return false;
            }
        }else{
            $this->render('add',array('model'=>$model));
        }

        Yii::app()->end();
    }

	public function actionList()
	{
		$this->pageTitle = '任务列表';
                $model = new Task();
                $model->unsetAttributes();
                if(isset($_GET)&&!empty($_GET))
                    $model->attributes=$_GET;
		$this->render('list',array('model'=>$model));
	}

	public function actionMyhandletask(){
		$user_id = Yii::app()->user->id;
		$this->pageTitle = '我处理的任务';
                $model = new Task();
                $model->unsetAttributes();
                if(isset($_GET)&&!empty($_GET))
                    $model->attributes=$_GET;
		$this->render('myhandletask',array('model'=>$model));
	}

    public function actionMypublishtask(){
        $user_id = Yii::app()->user->id;
        $this->pageTitle = '我发布的任务';
                $model = new Task();
                $model->unsetAttributes();
                if(isset($_GET)&&!empty($_GET))
                    $model->attributes=$_GET;
        $this->render('mypublishtask',array('model'=>$model));
    }

	public function actionView(){

		$pk = Yii::app()->request->getParam('id');

		$model = Task::model()->findByPk($pk);

		$this->pageTitle = '任务详情页';

		$assigned = User::model()->findAll('status = 1 && typeId > 1 && id != '.Yii::app()->user->id);
		$assigned_arr = array();
		foreach($assigned as $key => $value)
		{
			$assigned_arr[$value->id] = $value->account;
		}

        $remark = TaskRemark::model()->with(array('user'))->findAll("taskId = $pk && valid = 1");

        $log = SysLog::model()->with(array('user'))->findAll("linkId = $pk && valid = 1");

		$this->render('view',array('model'=>$model,'assigned_arr'=>$assigned_arr,'remark'=>$remark,'log'=>$log));
	}

	//任务指派
	public function actionAssigned(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');

			$model = Task::model()->findByPk($pk);
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if($model->openedId == Yii::app()->user->id && $model->status == 0)
        	{
        		$assignedid = Yii::app()->request->getParam('assignedid');
        		$model->assignedId = $assignedid;
        		$model->assignedDate = date('Y-m-d H:i:s');
        		if($model->save())
        		{
                    $assignUser = User::model()->findByPk($assignedid);
                    Helpers::syslog(2,Yii::app()->user->getState('account')." 将 [".$model->name."] 指派任务给 ".$assignUser->account,Yii::app()->user->id,$pk);
                    $content = "你创建的任务 [".$model->name."] 已由".Yii::app()->user->getState('account')."开始处理。";
                    Helpers::sendmessage($model->openedId,$content,2,0,$model->id);

                    $content = Yii::app()->user->getState('account')." 指派了任务 [".$model->name."] 给你，请在规定的时限内完成！";
                    Helpers::sendmessage($model->assignedId,$content,2,0,$pk);
        		}

        		echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}

        }
	}

	//任务取消
	public function actionCacel(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk);
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if($model->openedId == Yii::app()->user->id && $model->status == 0)
        	{
        		$model->status = 4;
        		if($model->save())
        		{
        			Helpers::syslog(2,Yii::app()->user->getState('account')." 将任务 [".$model->name."] 取消",Yii::app()->user->id,$pk);
        		}
        		echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}

        }
	}

	//未分配任务，自己承接
	public function actionUndertake(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk);
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if(empty($model->assignedId) && $model->status == 0 && $model->openedId != Yii::app()->user->id )
        	{
        		$model->status = 1;
        		$model->realStarted = date('Y-m-d H:i:s');
        		$model->assignedId = Yii::app()->user->id;
        		$model->assignedDate = date('Y-m-d H:i:s');
        		if($model->save())
        		{
        			Helpers::syslog(2,Yii::app()->user->getState('account')." 承接任务 [".$model->name."]",Yii::app()->user->id,$pk);
                    $content = "你创建的任务 [".$model->name."] 已由".Yii::app()->user->getState('account')."开始处理。";
                    Helpers::sendmessage($model->openedId,$content,2,0,$model->id);
                }
        		echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}

        }
	}

	//任务开始
	public function actionStart(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk);
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if($model->assignedId == Yii::app()->user->id && $model->status == 0)
        	{
        		$model->status = 1;
        		$model->realStarted = date('Y-m-d H:i:s');
        		if($model->save())
        		{
        			Helpers::syslog(2,Yii::app()->user->getState('account')." 开始了任务 [".$model->name."]",Yii::app()->user->id,$pk);
                    $content = "你创建的任务 [".$model->name."] 已由".Yii::app()->user->getState('account')."开始处理。";
                    Helpers::sendmessage($model->openedId,$content,2,0,$model->id);
                }
        		echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}

        }
	}

	//任务备注
	public function actionRemark(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk);
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if($model->status < 2)
        	{
        	   echo $remark = trim(Yii::app()->request->getParam('remark'));

        		$task_remark = new TaskRemark();
        		$task_remark->remark = $remark;
        		$task_remark->taskId = $pk;
        		if($task_remark->save())
        		{
        			Helpers::syslog(2,Yii::app()->user->getState('account')." 在任务 [".$model->name."] 中添加备注",Yii::app()->user->id,$pk);
        		}
        		echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}
        }
	}

	//任务完成
	public function actionFinished(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk);
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if($model->assignedId == Yii::app()->user->id && $model->status == 1)
        	{
        		$model->status = 2;
        		$model->finishedId = Yii::app()->user->id;
        		$model->finishedDate = date('Y-m-d H:i:s');
        		if($model->save())
        		{
        			Helpers::syslog(2,Yii::app()->user->getState('account')." 完成任务 [".$model->name."]",Yii::app()->user->id,$pk);
                    //任务完成通知 创建人
                    $content = "你创建的任务 [".$model->name."] 已由".Yii::app()->user->getState('account')."完成，请尽快关闭！";
                    Helpers::sendmessage($model->openedId,$content,2,0,$model->id);
        		}

        		echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}

        }
	}

	//任务关闭并评分
	public function actionClosed(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk);
        	if(empty($model))
        	{
        		echo json_encode(array('type'=>'error','info'=>'没有这个任务！'));
        		Yii::app()->end();
        	}

        	if($model->openedId == Yii::app()->user->id && $model->status == 2)
        	{
        		$model->status = 5;
        		$model->closedId = Yii::app()->user->id;
        		$model->closedDate = date('Y-m-d H:i:s');
        		if($model->save())
        		{
        			Helpers::syslog(2,Yii::app()->user->getState('account')." 关闭任务 [".$model->name."]",Yii::app()->user->id,$pk);
                    //根据任务完成时间 发送积分
                    $point = Helpers::taskpointlog($model);
                    //并通知完成人
                    $content = "任务 [".$model->name."] 已由".Yii::app()->user->getState('account')."关闭，你将得到 ".$point." 的积分";
                    Helpers::sendmessage($model->finishedId,$content,2,0,$model->id);
                }

                echo json_encode(array('type'=>'success'));
        		Yii::app()->end();
        	}else{
        		echo json_encode(array('type'=>'error','info'=>'数据错误！'));
        		Yii::app()->end();
        	}

        }
	}
}