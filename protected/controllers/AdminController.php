<?php

class AdminController extends Controller
{

    public function init()
    {
        parent::init();
    }

	public function actionDeptment()
	{
        $this->menu_nav = array(
                array(
                    'value'=>'组织中心',
                ),
            );

		$this->pageTitle = '部门管理';
        $model = new Deptment();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
		$this->render('deptment',array('model'=>$model));
	}

	public function actionWorkplace()
	{
		$this->pageTitle = '岗位管理';
        $model = new Workplace();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
		$this->render('workplace',array('model'=>$model));
	}

	public function actionUser()
	{
		$this->pageTitle = '员工管理';
        $model = new User();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
		$this->render('user',array('model'=>$model));
	}

    public function actionPoint(){
        $this->page_css = array(
            'jquery-ui.custom.min.css',
            'datepicker.css',
            );

        $this->page_js = array(
            'jquery-ui.custom.min.js',
            'jquery.ui.touch-punch.min.js',
            'date-time/bootstrap-datepicker.min.js',
            'date-time/locales/bootstrap-datepicker.zh-CN.js',
            );
        $this->page_script = <<<EOD
<script type="text/javascript">
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true,
        language: 'zh-CN'
    })
</script>
EOD;



        $this->pageTitle = '积分统计';

        $start = Yii::app()->request->getParam('start');
        $end = Yii::app()->request->getParam('end');
        $type = Yii::app()->request->getParam('type');
        //$monthYear = !empty($getmonth)?$getmonth:date('Y-m');

        $criteria=new CDbCriteria;
        $criteria->select = '*';
        $criteria->addCondition("t.log_type = :log_type");
        $criteria->params[':log_type'] = 1;
        $criteria->addCondition("t.valid = :valid");
        $criteria->params[':valid'] = 1;
        //$criteria->addCondition("FROM_UNIXTIME(UNIX_TIMESTAMP(t.createdTime),'%Y-%m') = :date");
        if(!empty($start) && !empty($end))
        {
            $criteria->compare('UNIX_TIMESTAMP(t.createdTime) >',strtotime($_GET['start']));
            $criteria->compare('UNIX_TIMESTAMP(t.createdTime) <',strtotime($_GET['end'])+86400);
        }

        $model = PointLog::model()->with(array('user'))->findAll($criteria);

        $point_tmp = array();
        foreach($model as $key => $value)
        {
            $point_tmp[$value->user->code][] = $value;
        }

        $point_arr = array();
        foreach($point_tmp as $key => $value)
        {
            $tmp_value = 0;
            $tmp_account = '';
            foreach($value as $key1 => $value1)
            {
                $tmp_value += $value1->log_point;
                $tmp_account = $value1->user->account;
            }
            $point_arr[$key]['account'] = $tmp_account;
            $point_arr[$key]['userId'] = $value[0]->userId;
            $point_arr[$key]['point'] = $tmp_value;
        }

        if($type == 'excel')
        {
            $objectPHPExcel = new PHPExcel();
            $objectPHPExcel->setActiveSheetIndex(0);
            $objectPHPExcel->getActiveSheet()->mergeCells('A1:B1');
            $objectPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objectPHPExcel->getActiveSheet()->setCellValue('A1','统计时间：'.$start.'至'.$end);
            $objectPHPExcel->getActiveSheet()->setCellValue('A2','账户');
            $objectPHPExcel->getActiveSheet()->setCellValue('B2','积分值');
            $i=3;
            foreach($point_arr as $key => $value)
            {
                $objectPHPExcel->getActiveSheet()->setCellValue('A'.$i,$value['account']);
                $objectPHPExcel->getActiveSheet()->setCellValue('B'.$i,$value['point']);
            }
            ob_end_clean();
            ob_start();
            header('Content-Type : application/vnd.ms-excel');
            header('Content-Disposition:attachment;filename="积分统计.xls"');
            $objWriter= PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
            $objWriter->save('php://output');

        }

        $this->render('point',array('point_arr'=>$point_arr,'start'=>$start,'end'=>$end));
    }

    public function actionSyslog()
    {
        $this->pageTitle = '最新动态';
        $model = new SysLog();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
        $this->render('syslog',array('model'=>$model));
    }

    //人事绩效加分
    public function actionAddpoint(){
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
        $this->page_script = <<<EOD
<script type="text/javascript">
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true,
        language: 'zh-CN'
    })
</script>
EOD;

        //$saveType = Yii::app()->request->getParam('saveType');
        $pk = Yii::app()->request->getParam('id');
        if (empty($pk)) {
            $this->pageTitle = '人事绩效加分';
            $model = new Task;
            $model->scenario = 'new';
            $model->unsetAttributes();
        } else {
            $this->pageTitle = '人事绩效加分';
            $model = Task::model()->findByPk($pk);
            if (!$model) {
                $arr = array('hasError' => true, 'msg' => '数据提交失败');
            }

            $model->scenario = 'update';
        }

        if (isset($_POST['Task'])) {
            $old_assignedId = $model->assignedId;
            $task_list = $_POST['Task'];
            $tmp_list = $_POST['Task']['tmpid'];


            foreach ($tmp_list as $k1 => $v1) {
                if (empty($pk)) {
                    $model = new Task;
                    $model->scenario = 'new';
                    $model->unsetAttributes();
                }

                $model->typeId = $task_list['typeId'][$k1];
                $model->imtypeId = $task_list['imtypeId'][$k1];
                $model->name = $task_list['name'][$k1];
                $model->desc = $task_list['desc'][$k1];
                $model->point = $task_list['point'][$k1];
                $model->deadline_type = $task_list['deadline_type'][$k1];

                //$model->attributes = $_POST['Task'];

                if ($model->deadline_type == 1) {
                    $deadline = Yii::app()->request->getParam('deadline_1');
                    $model->deadline = $deadline[$k1];
                } elseif ($model->deadline_type == 2) {
                    $deadline = Yii::app()->request->getParam('deadline_2');
                    $model->deadline = $deadline[$k1];
                }

                //如果文件上传
                $uploaded = CUploadedFile::getInstanceByName('attach' . $v1);
                if (is_object($uploaded) && get_class($uploaded) === 'CUploadedFile') {
                    if ($uploaded->size > 10 * 1024 * 1024) {
                        $model->addError('opAdminId', '文件太大！');
                    }

                    $uploaddir = Yii::getPathOfAlias('webroot') . '/data/file/';

                    $ymd = date("Ymd");
                    $uploaddir .= $ymd . "/";
                    if (!file_exists($uploaddir)) {
                        mkdir($uploaddir);
                    }
                    @chmod($uploaddir, 0755);

                    $filename = md5(uniqid());
                    $ext = $uploaded->extensionName;
                    $old_name = $uploaded->name;
                    $uploadfile = $uploaddir . $filename . '.' . $ext;

                    if ($uploaded->saveAs($uploadfile)) {
                        $file = new File();
                        $file->pathname = Yii::app()->request->baseUrl . '/data/file/' . $ymd . "/" . $filename . '.' . $ext;
                        $file->title = $old_name;
                        $file->extension = $ext;
                        $file->size = $uploaded->size;
                        $file->save();
                    } else {
                        $model->addError('opAdminId', '文件上传失败！');
                    }

                }

                if ($model->hasErrors()) {
                    print_r($model->getErrors());
                    Yii::app()->end();
                }

                if ($model->scenario == 'new') {
                    $model->status = 5;
                }

                if (isset($task_list['assignedId' . $v1]) && is_array($task_list['assignedId' . $v1])) {
                    foreach ($task_list['assignedId' . $v1] as $key => $value) {
                        if($key == 0){
                            $model->assignedId = $value;
                        }else{
                            $new_model = new Task();
                            $new_model->attributes = $model->attributes;
                            $new_model->assignedId = $value;
                            $new_model->assignedDate = date('Y-m-d H:i:s');
                            $model=$new_model;
                        }

                        if ($model->save()) {
                            $id = $model->primarykey;
                            if (isset($file)) {
                                $new_file = new File();
                                $new_file->attributes = $file->attributes;
                                $new_file->taskID = $id;
                                $new_file->save();
                            }

                            Helpers::syslog(2, Yii::app()->user->getState('account') . " 发布了任务 [" . $model->name . "]", Yii::app()->user->id, $id);

                            $model->closedId = Yii::app()->user->id;
                            $model->closedDate = date('Y-m-d H:i:s');
                            $model->finishedId = $model->assignedId;
                            if ($model->save()) {
                                //根据任务完成时间 发送积分
                                $point = Helpers::taskpointlog($model);
                                //并通知完成人
                                $content = "任务 [" . $model->name . "] 已由" . Yii::app()->user->getState('account') . "确认完成，你将得到 " . $model->point . " 的积分";
                                Helpers::sendmessage($model->assignedId, $content, 2, 0, $model->id);
                            }

                        } else {
                            $arr[] = array('hasError' => true, 'msg' => '数据提交失败', 'error' => $model->getErrors(), 'model' => $model->attributes);
                            return false;
                        }
                    }

                } else {
                    if ($model->save()) {
                        $id = $model->primarykey;
                        if (isset($file)) {
                            $file->taskID = $id;
                            $file->save();
                        }
                        if ($model->scenario == 'new') {
                            Helpers::syslog(2, Yii::app()->user->getState('account') . " 发布了任务 [" . $model->name . "]", Yii::app()->user->id, $id);
                            if ($model->assignedId != 0) {
                                $content = Yii::app()->user->getState('account') . " 创建并指派了任务 [" . $model->name . "] 给你，请在规定的时限内完成！";
                                Helpers::sendmessage($model->assignedId, $content, 2, 0, $id);
                            }
                        } elseif ($model->scenario == 'update') {

                            Helpers::syslog(2, Yii::app()->user->getState('account') . " 编辑了任务 [" . $model->name . "]", Yii::app()->user->id, $id);
                            if ($model->assignedId != 0 && $model->assignedId != $old_assignedId) {
                                $content = Yii::app()->user->getState('account') . " 编辑并指派了任务 [" . $model->name . "] 给你，请在规定的时限内完成！";
                                Helpers::sendmessage($model->assignedId, $content, 2, 0, $id);
                            }
                        }
                    } else {
                        $arr[] = array('hasError' => true, 'msg' => '数据提交失败', 'error' => $model->getErrors(), 'model' => $model->attributes);
                        return false;
                    }
                }
            }

            if (empty($arr)) {
                $this->redirect(array('/task/list'));
            } else {
                print_r($arr);
                Yii::app()->end();
            }

        } else {
            $this->render('addpoint', array('model' => $model));
        }

        Yii::app()->end();
    }
}