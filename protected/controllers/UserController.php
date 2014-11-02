<?php
class UserController extends Controller
{
    public function init()
    {
        parent::init();
        $this->modelClass = 'User';
    }

	public function actionIndex()
	{
		$this->pageTitle = '个人中心';
		$this->render('index');
	}

	public function actionProfile()
	{
    $user_id = Yii::app()->user->id;
    $model = User::model()->findByPk($user_id);
    if(empty($model))
      Yii::app()->end();

    $this->render('profile',$model);
	}

  public function actionSetting()
  {
    $this->render('setting');
  }

  public function actionPasswdedit()
  {
    $this->page_css = array(
      'jquery-ui.custom.min.css',
      'jquery.gritter.css',
      'select2.css',
      'datepicker.css',
      'bootstrap-editable.css',
      );
    $this->pageTitle = '修改密码';
    $model = new User;
    if(isset($_POST['User'])){
      $data = Yii::app()->request->getParam('User');
      $passwd1 = $data['password'];
      $passwd2 = $data['createdTime'];
      $id = Yii::app()->request->getParam('id');
      if(!empty($passwd1) && !empty($passwd2) && $passwd1 == $passwd2)
      {
        $model1 = User::model()->findByPk($id);
        if($model1)
        {
          $model1->password = md5($passwd1);
          $model1->save();
          Helpers::syslog(4,Yii::app()->user->getState('account')."修改密码",Yii::app()->user->id);
          $this->redirect(array('site/logout'));
        }else{
          $model->addError('createdTime','修改提交出错！请刷新再试！');
        }
      }else{
        $model->addError('createdTime','请正确输入！');
      }
    }

    $this->render('passwdedit',array('model'=>$model));
  }
}
?>