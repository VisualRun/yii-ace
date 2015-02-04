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

    public function actionSetallread(){
        if (Yii::app()->request->isAjaxRequest)
        {
            $user_id = Yii::app()->user->id;
            $res = Message::model()->updateAll(array('checkout'=>1),'checkout=:checkout and touserId=:touserId',array(':checkout'=>'0',':touserId'=>$user_id));
            if($res){
                echo json_encode(array('type'=>'success'));
            }else{
                echo json_encode(array('type'=>'error','info'=>'系统繁忙，稍后再试！'));
            }
        }
    }
}