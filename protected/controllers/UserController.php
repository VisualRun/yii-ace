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
    $this->render('passwdedit',array('model'=>$model));
  }
}
?>