<?php

class TaskController extends Controller {
	public function init() {
		parent::init();
		$this->modelClass = 'Task';
	}

	//之后的要改成一个页面循环添加
	public function actionAdd() {
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
			$this->pageTitle = '发布任务';
			$model = new Task;
			$model->scenario = 'new';
			$model->unsetAttributes();
		} else {
			$this->pageTitle = '编辑任务';
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
				//print_r($model);exit;

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
					$model->status = 0;
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
							if ($model->assignedId != 0) {
								$content = Yii::app()->user->getState('account') . " 创建并指派了任务 [" . $model->name . "] 给你，请在规定的时限内完成！";
								Helpers::sendmessage($model->assignedId, $content, 2, 0, $id);
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
				$this->redirect(array('list'));
			} else {
				print_r($arr);
				Yii::app()->end();
			}

		} else {
			$this->render('add', array('model' => $model));
		}

		Yii::app()->end();
	}

	public function actionList() {
		$this->pageTitle = '任务列表';
		$model = new Task();
		$model->unsetAttributes();
		if (isset($_GET) && !empty($_GET)) {
			$model->attributes = $_GET;
		}

		$this->render('list', array('model' => $model));
	}

	public function actionMyhandletask() {
		$user_id = Yii::app()->user->id;
		$this->pageTitle = '我处理的任务';
		$model = new Task();
		$model->unsetAttributes();
		if (isset($_GET) && !empty($_GET)) {
			$model->attributes = $_GET;
		}

		$this->render('myhandletask', array('model' => $model));
	}

	public function actionMypublishtask() {
		$user_id = Yii::app()->user->id;
		$this->pageTitle = '我发布的任务';
		$model = new Task();
		$model->unsetAttributes();
		if (isset($_GET) && !empty($_GET)) {
			$model->attributes = $_GET;
		}

		$this->render('mypublishtask', array('model' => $model));
	}

	public function actionView() {

		$pk = Yii::app()->request->getParam('id');

		$model = Task::model()->findByPk($pk);

		$this->pageTitle = '任务详情页';

		$assigned = User::model()->findAll('status = 1 && typeId > 1 && id != ' . Yii::app()->user->id);
		$assigned_arr = array();
		foreach ($assigned as $key => $value) {
			$assigned_arr[$value->id] = $value->account;
		}

		$file = File::model()->findAll("taskId = $pk");

		$criteria = new CDbCriteria;
		$criteria->select = '*';
		$criteria->addCondition("t.taskId = :taskId");
		$criteria->params[':taskId'] = $pk;
		$criteria->addCondition("t.valid = :valid");
		$criteria->params[':valid'] = 1;
		$criteria->order = "t.id ASC";
		$remark = TaskRemark::model()->with(array('user'))->findAll($criteria);

		$criteria = new CDbCriteria;
		$criteria->select = '*';
		$criteria->addCondition("t.linkId = :linkId");
		$criteria->params[':linkId'] = $pk;
		$criteria->addCondition("t.valid = :valid");
		$criteria->params[':valid'] = 1;
		$criteria->order = "t.id ASC";
		$log = SysLog::model()->with(array('user'))->findAll($criteria);

		$this->render('view', array('model' => $model, 'assigned_arr' => $assigned_arr, 'remark' => $remark, 'log' => $log, 'file' => $file));
	}

	//任务指派
	public function actionAssigned() {
		if (Yii::app()->request->isAjaxRequest) {
			$pk = Yii::app()->request->getParam('id');

			$model = Task::model()->findByPk($pk);
			if (empty($model)) {
				echo json_encode(array('type' => 'error', 'info' => '没有这个任务！'));
				Yii::app()->end();
			}

			if ($model->openedId == Yii::app()->user->id && $model->status == 0) {
				$assignedid = Yii::app()->request->getParam('assignedid');
				$model->assignedId = $assignedid;
				$model->assignedDate = date('Y-m-d H:i:s');
				if ($model->save()) {
					$assignUser = User::model()->findByPk($assignedid);
					Helpers::syslog(2, Yii::app()->user->getState('account') . " 将 [" . $model->name . "] 指派任务给 " . $assignUser->account, Yii::app()->user->id, $pk);
					$content = "你创建的任务 [" . $model->name . "] 已由" . Yii::app()->user->getState('account') . "开始处理。";
					Helpers::sendmessage($model->openedId, $content, 2, 0, $model->id);

					$content = Yii::app()->user->getState('account') . " 指派了任务 [" . $model->name . "] 给你，请在规定的时限内完成！";
					Helpers::sendmessage($model->assignedId, $content, 2, 0, $pk);
				}

				echo json_encode(array('type' => 'success'));
				Yii::app()->end();
			} else {
				echo json_encode(array('type' => 'error', 'info' => '数据错误！'));
				Yii::app()->end();
			}

		}
	}

	//任务取消
	public function actionCacel() {
		if (Yii::app()->request->isAjaxRequest) {
			$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk);
			if (empty($model)) {
				echo json_encode(array('type' => 'error', 'info' => '没有这个任务！'));
				Yii::app()->end();
			}

			if ($model->openedId == Yii::app()->user->id && $model->status == 0) {
				$model->status = 4;
				if ($model->save()) {
					Helpers::syslog(2, Yii::app()->user->getState('account') . " 将任务 [" . $model->name . "] 取消", Yii::app()->user->id, $pk);
				}
				echo json_encode(array('type' => 'success'));
				Yii::app()->end();
			} else {
				echo json_encode(array('type' => 'error', 'info' => '数据错误！'));
				Yii::app()->end();
			}

		}
	}

	//未分配任务，自己承接
	public function actionUndertake() {
		if (Yii::app()->request->isAjaxRequest) {
			$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk);
			if (empty($model)) {
				echo json_encode(array('type' => 'error', 'info' => '没有这个任务！'));
				Yii::app()->end();
			}

			if (empty($model->assignedId) && $model->status == 0 && $model->openedId != Yii::app()->user->id) {
				$model->status = 1;
				$model->realStarted = date('Y-m-d H:i:s');
				$model->assignedId = Yii::app()->user->id;
				$model->assignedDate = date('Y-m-d H:i:s');
				if ($model->save()) {
					Helpers::syslog(2, Yii::app()->user->getState('account') . " 承接任务 [" . $model->name . "]", Yii::app()->user->id, $pk);
					$content = "你创建的任务 [" . $model->name . "] 已由" . Yii::app()->user->getState('account') . "开始处理。";
					Helpers::sendmessage($model->openedId, $content, 2, 0, $model->id);
				}
				echo json_encode(array('type' => 'success'));
				Yii::app()->end();
			} else {
				echo json_encode(array('type' => 'error', 'info' => '数据错误！'));
				Yii::app()->end();
			}

		}
	}

	//任务开始
	public function actionStart() {
		if (Yii::app()->request->isAjaxRequest) {
			$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk);
			if (empty($model)) {
				echo json_encode(array('type' => 'error', 'info' => '没有这个任务！'));
				Yii::app()->end();
			}

			if ($model->assignedId == Yii::app()->user->id && $model->status == 0) {
				$model->status = 1;
				$model->realStarted = date('Y-m-d H:i:s');
				if ($model->save()) {
					Helpers::syslog(2, Yii::app()->user->getState('account') . " 开始了任务 [" . $model->name . "]", Yii::app()->user->id, $pk);
					$content = "你创建的任务 [" . $model->name . "] 已由" . Yii::app()->user->getState('account') . "开始处理。";
					Helpers::sendmessage($model->openedId, $content, 2, 0, $model->id);
				}
				echo json_encode(array('type' => 'success'));
				Yii::app()->end();
			} else {
				echo json_encode(array('type' => 'error', 'info' => '数据错误！'));
				Yii::app()->end();
			}

		}
	}

	//任务备注
	public function actionRemark() {
		if (Yii::app()->request->isAjaxRequest) {
			$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk);
			if (empty($model)) {
				echo json_encode(array('type' => 'error', 'info' => '没有这个任务！'));
				Yii::app()->end();
			}

			if ($model->status < 2) {
				$remark = trim(Yii::app()->request->getParam('remark'));

				$task_remark = new TaskRemark();
				$task_remark->remark = $remark;
				$task_remark->taskId = $pk;
				if ($task_remark->save()) {
					Helpers::syslog(2, Yii::app()->user->getState('account') . " 在任务 [" . $model->name . "] 中添加备注", Yii::app()->user->id, $pk);
				}
				echo json_encode(array('type' => 'success'));
				Yii::app()->end();
			} else {
				echo json_encode(array('type' => 'error', 'info' => '数据错误！'));
				Yii::app()->end();
			}
		}
	}

	//任务完成
	public function actionFinished() {
		if (Yii::app()->request->isAjaxRequest) {
			$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk);
			if (empty($model)) {
				echo json_encode(array('type' => 'error', 'info' => '没有这个任务！'));
				Yii::app()->end();
			}

			if ($model->assignedId == Yii::app()->user->id && $model->status == 1) {
				$model->status = 2;
				$model->finishedId = Yii::app()->user->id;
				$model->finishedDate = date('Y-m-d H:i:s');
				if ($model->save()) {
					Helpers::syslog(2, Yii::app()->user->getState('account') . " 完成任务 [" . $model->name . "]", Yii::app()->user->id, $pk);
					//任务完成通知 创建人
					$content = "你创建的任务 [" . $model->name . "] 已由" . Yii::app()->user->getState('account') . "完成，请尽快关闭！";
					Helpers::sendmessage($model->openedId, $content, 2, 0, $model->id);
				}

				echo json_encode(array('type' => 'success'));
				Yii::app()->end();
			} else {
				echo json_encode(array('type' => 'error', 'info' => '数据错误！'));
				Yii::app()->end();
			}

		}
	}

	//任务确认完成并评分
	public function actionClosed() {
		if (Yii::app()->request->isAjaxRequest) {
			$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk);
			if (empty($model)) {
				echo json_encode(array('type' => 'error', 'info' => '没有这个任务！'));
				Yii::app()->end();
			}

			if ($model->openedId == Yii::app()->user->id && $model->status == 2) {
				$model->status = 5;
				$model->closedId = Yii::app()->user->id;
				$model->closedDate = date('Y-m-d H:i:s');
				if ($model->save()) {
					Helpers::syslog(2, Yii::app()->user->getState('account') . " 确认了任务 [" . $model->name . "] 的完成", Yii::app()->user->id, $pk);
					//根据任务完成时间 发送积分
					$point = Helpers::taskpointlog($model);
					//并通知完成人
					$content = "任务 [" . $model->name . "] 已由" . Yii::app()->user->getState('account') . "确认完成，你将得到 " . $point . " 的积分";
					Helpers::sendmessage($model->finishedId, $content, 2, 0, $model->id);
				}

				echo json_encode(array('type' => 'success'));
				Yii::app()->end();
			} else {
				echo json_encode(array('type' => 'error', 'info' => '数据错误！'));
				Yii::app()->end();
			}

		}
	}

	//任务确认完成并评分
	public function actionReturn() {
		if (Yii::app()->request->isAjaxRequest) {
			$pk = Yii::app()->request->getParam('id');
			$model = Task::model()->findByPk($pk);
			if (empty($model)) {
				echo json_encode(array('type' => 'error', 'info' => '没有这个任务！'));
				Yii::app()->end();
			}

			if ($model->openedId == Yii::app()->user->id && $model->status == 2) {
				$model->status = 1;
				$model->finishedId = '';
				$model->finishedDate = '0000-00-00 00:00:00';

				$reason = trim(Yii::app()->request->getParam('reason'));
				if ($reason == '') {
					echo json_encode(array('type' => 'error', 'info' => '请填写退回处理人原因！'));
					Yii::app()->end();
				}

				$delay = Yii::app()->request->getParam('delay');
				$delay_value = Yii::app()->request->getParam('delay_value');

				$old_deadline_type = $model->deadline_type;
				$old_deadline = $model->deadline;
				$old_realdeadline = Helpers::realdeadline($model);

				if ($delay == 'day') {
					if ($old_deadline_type == 1) {
						$model->deadline = date('Y-m-d', strtotime($old_deadline) + 86400 * $delay_value);
					} elseif ($old_deadline_type == 2) {
						$model->deadline = $old_deadline + $delay_value * 24;
					}
				} elseif ($delay == 'hour') {
					//如果延期的时间是小于24个小时，而之前的时限类别是按天的话，换算比较麻烦，直接将时限类型换成按小时

					if ($old_deadline_type == 1) {
						$model->deadline = ceil(((strtotime($old_deadline) + 86400 + $delay_value * 3600) - strtotime($model->openedDate)) / 3600);
					} elseif ($old_deadline_type == 2) {
						$model->deadline = $old_deadline + $delay_value;
					}

					$model->deadline_type = 2;
				}

				if ($model->save()) {
					$new_realdeadline = Helpers::realdeadline($model);

					$assigned = User::model()->findByPk($model->assignedId);

					Helpers::syslog(2, Yii::app()->user->getState('account') . " 将任务 [" . $model->name . "] 退回给了 " . $assigned->account, Yii::app()->user->id, $pk);
					//通知处理人
					$content = Yii::app()->user->getState('account') . " 将任务 [" . $model->name . "] 退回给了你，原因是 [<span style='color:red'>" . $reason . "</span>] ;";
					if ($delay == 'day') {

						$content .= " 同时将最后期限延长了 " . $delay_value . "天;";

						Helpers::syslog(2, Yii::app()->user->getState('account') . " 将任务最后期限从 [" . $old_realdeadline . "] 延长到 [" . $new_realdeadline . "]", Yii::app()->user->id, $pk);

					} elseif ($delay == 'hour') {

						$content .= " 同时将最后期限延长了 " . $delay_value . "小时;";

						Helpers::syslog(2, Yii::app()->user->getState('account') . " 将任务最后期限从 [" . $old_realdeadline . "] 延长到 [" . $new_realdeadline . "]", Yii::app()->user->id, $pk);

					}
					Helpers::sendmessage($model->assignedId, $content, 2, 0, $model->id);

				}

				echo json_encode(array('type' => 'success'));
				Yii::app()->end();
			} else {
				echo json_encode(array('type' => 'error', 'info' => '数据错误！'));
				Yii::app()->end();
			}

		}
	}

	// 批量查看任务
	public function actionAllcheck() {
		$this->pageTitle = '批量查看任务';

		$ids = Yii::app()->request->getParam('ids');

		if (!empty($ids)) {
			$ids = explode(",", $ids);
			$criteria = new CDbCriteria();
			$criteria->addInCondition('id', $ids);

			$model = Task::model()->findAll($criteria);

			$this->render('allcheck', array('model' => $model));
		}
	}
}
