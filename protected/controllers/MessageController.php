<?php

class MessageController extends Controller
{
	public function init(){
		parent::init();
		$this->modelClass = 'Message';
	}

	public function actionCheckout(){
		if (Yii::app()->request->isAjaxRequest)
        {
        	$pk = Yii::app()->request->getParam('id');
			$model = Message::model()->findByPk($pk);

			if($model->checkout == 0)
			{
				$model->checkout = 1;
				$model->save();
			}

			echo json_encode(array('type'=>'success','content'=>$model->content));
        	Yii::app()->end();
        }
	}
}