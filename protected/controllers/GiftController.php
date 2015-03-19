<?php

class GiftController extends Controller
{
	public function init(){
		parent::init();
		$this->modelClass = 'Gift';
	}

	public function actionGift()
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		$exchanging = GiftExchange::model()->findAllByAttributes(array('status'=>0,'applyId'=>Yii::app()->user->id));
		$exchanging_score = 0;
		$exchanging_code = '';
		if(!empty($exchanging)){
			foreach($exchanging as $key => $value)
			{
				$exchanging_score += $value->score;
				$exchanging_code .= $value->code."&nbsp;&nbsp;";
			}
		}


		$this->pageTitle = '兑换操作';
		$model = new Gift();
		$model->unsetAttributes();
		if(isset($_GET)&&!empty($_GET))
		    $model->attributes=$_GET;

		$this->render('gift',array('model'=>$model,'user'=>$user,'exchanging'=>$exchanging,'exchanging_score'=>$exchanging_score,'exchanging_code'=>$exchanging_code));
	}

	public function actionExchange()
	{
		$this->pageTitle = '个人兑换记录';
		$model = new GiftExchange();
		$model->unsetAttributes();
		if(isset($_GET)&&!empty($_GET))
		    $model->attributes=$_GET;

		$this->render('exchange',array('model'=>$model));
	}

	public function actionGiftlist()
    {
        $this->pageTitle = '兑换物品管理';
        $model = new Gift();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
        $this->render('giftlist',array('model'=>$model));
    }

    public function actionExchangecheck()
    {
        $this->pageTitle = '兑换记录审核';
        $model = new GiftExchange();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
        $this->render('exchangecheck',array('model'=>$model));
    }

    public function actionApplygift()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$userid = Yii::app()->user->id;
			$user = User::model()->findByPk($userid);
			$giftId = Yii::app()->request->getParam('id');
			$gift = Gift::model()->findByPk($giftId);

			$exchanging = GiftExchange::model()->findAllByAttributes(array('status'=>0,'applyId'=>Yii::app()->user->id));
			$exchanging_score = 0;
			$exchanging_code = '';
			if(!empty($exchanging)){
				foreach($exchanging as $key => $value)
				{
					$exchanging_score += $value->score;
					$exchanging_code .= $value->code."&nbsp;&nbsp;";
				}
			}

			$point = $user->point - $exchanging_score;

		  	if($point >= $gift->score){
		    	if($gift->status == 1){
		      		if($gift->num > 0){
		        		$exchange = new GiftExchange();
		       			$exchange->giftId = $giftId;
		        		$exchange->num = 1;
		        		$exchange->score = $gift->score;
		        		$exchange->save();

		        		Helpers::syslog(7,Yii::app()->user->getState('account')." 申请兑换 [".$gift->name."]",Yii::app()->user->id,$giftId);

		        		//通知物品创建人
		        		$content = Yii::app()->user->getState('account')." 申请兑换你添加的物品 [".$gift->name."] ,请尽快审核！";
		        		Helpers::sendmessage($gift->addId,$content,3,0,$exchange->id);

		        		echo json_encode(array('type'=>'success'));
		        		Yii::app()->end();
		      		}else{
		        		echo json_encode(array('type'=>'error','info'=>'兑换物品数量不够！'));
		        		Yii::app()->end();
		      		}
		    	}else{
		      		echo json_encode(array('type'=>'error','info'=>'兑换物品状态有误！'));
		      		Yii::app()->end();
		    	}

		  	}else{
		    	echo json_encode(array('type'=>'error','info'=>'你预计剩余的积分不够！'));
		    	Yii::app()->end();
		  	}
		}
	}

	public function actionChecknot()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$pk = Yii::app()->request->getParam('id');
			$exchange = GiftExchange::model()->with(array('gift'))->findByPk($pk);

			if($exchange->status == 0)
			{
				$exchange->status = -1;
				$exchange->checkId = Yii::app()->user->id;
				$exchange->checkDate = date('Y-m-d H:i:s');
				$exchange->save();

				Helpers::syslog(7,Yii::app()->user->getState('account')." 不通过 [".$exchange->code."] 中 [".$exchange->gift->name."] 的兑换申请",Yii::app()->user->id,$exchange->id);

		       	//通知申请人
		       	$content = "你的兑换申请 [".$exchange->code."] 中的 [".$exchange->gift->name."] 没有被通过！";
		       	Helpers::sendmessage($exchange->applyId,$content,3,0,$exchange->id);

		       	echo json_encode(array('type'=>'success'));
		       	Yii::app()->end();
			}else{
				echo json_encode(array('type'=>'error','info'=>'兑换申请单的状态有误！'));
		    	Yii::app()->end();
			}
		}
	}

	public function actionCheckok()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$pk = Yii::app()->request->getParam('id');
			$exchange = GiftExchange::model()->with(array('gift'))->findByPk($pk);
			$gift = Gift::model()->findByPk($exchange->giftId);
			$user = User::model()->findByPk($exchange->applyId);

			if($exchange->status == 0)
			{
				if($user->point >= $exchange->score){
					if($gift->status == 1 && $gift->num > 0){

						$transaction= Yii::app()->db->beginTransaction();
						try{
							$gift->num = $gift->num - $exchange->num;
							$gift->save();

							$exchange->status = 1;
							$exchange->checkId = Yii::app()->user->id;
							$exchange->checkDate = date('Y-m-d H:i:s');
							$exchange->save();

				    		$user->point = $user->point-$exchange->score;
				    		$user->save();

				    		$log = new PointLog();
				    		$log->userId = $user->id;
				    		$log->log_type = 2;
				    		$log->log_point = "-".$exchange->score;
				    		$log->log_desc = "兑换物品减去积分";
				    		$log->linkId = $exchange->id;
				    		$log->save();

							Helpers::syslog(7,Yii::app()->user->getState('account')." 通过了 [".$exchange->code."] 中 [".$exchange->gift->name."] 的兑换申请",Yii::app()->user->id,$exchange->id);

				       		//通知申请人
				       		$content = "你的兑换申请 [".$exchange->code."] 中的 [".$exchange->gift->name."] 审核通过！";
				       		Helpers::sendmessage($exchange->applyId,$content,3,0,$exchange->id);

				       		$transaction->commit();

				       		echo json_encode(array('type'=>'success'));
				       		Yii::app()->end();
			       		}
			       		catch (Exception $e) {
                			$transaction->rollback();
                			echo json_encode(array('type'=>'error','info'=>'系统繁忙，请稍后再试！','errorinfo'=>$e));
               				Yii::app()->end();
                		}
					}else{
						echo json_encode(array('type'=>'error','info'=>'兑换的物品状态有问题！'));
		    			Yii::app()->end();
					}
		       	}else{
		       		echo json_encode(array('type'=>'error','info'=>'申请人的积分不够，不能确认审核！'));
		    		Yii::app()->end();
		       	}
			}else{
				echo json_encode(array('type'=>'error','info'=>'兑换申请单的状态有误！'));
		    	Yii::app()->end();
			}
		}
	}

	// 批量审核通过兑换
	public function actionCheckallok(){
		if (Yii::app()->request->isAjaxRequest)
		{
			$pk = Yii::app()->request->getParam('id');
			if(!empty($pk)){

				foreach($pk as $k => $v){
					$exchange = GiftExchange::model()->with(array('gift'))->findByPk($v);
					$gift = Gift::model()->findByPk($exchange->giftId);
					$user = User::model()->findByPk($exchange->applyId);
					if($exchange->status != 0)
					{
						echo json_encode(array('type'=>'error','info'=>'兑换申请单'.$exchange->code.'的状态有误！'));
		    			Yii::app()->end();
					}

					if($user->point < $exchange->score){
						echo json_encode(array('type'=>'error','info'=>$user->account.'的积分不够，'.$exchange->code.'不能审核通过！'));
		    			Yii::app()->end();
					}

					if($gift->status != 1 || $gift->num <= 0){
						echo json_encode(array('type'=>'error','info'=>'兑换申请单'.$exchange->code.'所兑换的物品状态有问题！'));
		    			Yii::app()->end();
					}
				}

				$transaction= Yii::app()->db->beginTransaction();
				try{
					foreach($pk as $k => $v){
						$exchange = GiftExchange::model()->with(array('gift'))->findByPk($v);
						$gift = Gift::model()->findByPk($exchange->giftId);
						$user = User::model()->findByPk($exchange->applyId);

						$gift->num = $gift->num - $exchange->num;
						$gift->save();

						$exchange->status = 1;
						$exchange->checkId = Yii::app()->user->id;
						$exchange->checkDate = date('Y-m-d H:i:s');
						$exchange->save();

			    		$user->point = $user->point-$exchange->score;
			    		$user->save();

			    		$log = new PointLog();
			    		$log->userId = $user->id;
			    		$log->log_type = 2;
			    		$log->log_point = "-".$exchange->score;
			    		$log->log_desc = "兑换物品减去积分";
			    		$log->linkId = $exchange->id;
			    		$log->save();

						Helpers::syslog(7,Yii::app()->user->getState('account')." 通过了 [".$exchange->code."] 中 [".$exchange->gift->name."] 的兑换申请",Yii::app()->user->id,$exchange->id);

			       		//通知申请人
			       		$content = "你的兑换申请 [".$exchange->code."] 中的 [".$exchange->gift->name."] 审核通过！";
			       		Helpers::sendmessage($exchange->applyId,$content,3,0,$exchange->id);

					}

					$transaction->commit();

			       	echo json_encode(array('type'=>'success'));
			       	Yii::app()->end();
	       		}
	       		catch (Exception $e) {
	    			$transaction->rollback();
	    			echo json_encode(array('type'=>'error','info'=>'系统繁忙，请稍后再试！','errorinfo'=>$e));
	   				Yii::app()->end();
	    		}

			}
		}
	}

	// 批量审核不通过兑换
	public function actionCheckallnot()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$pk = Yii::app()->request->getParam('id');
			if(!empty($pk)){
				foreach($pk as $k => $v){
					$exchange = GiftExchange::model()->with(array('gift'))->findByPk($v);
					if($exchange->status != 0)
					{
						echo json_encode(array('type'=>'error','info'=>'兑换申请单'.$exchange->code.'的状态有误！'));
		    			Yii::app()->end();
					}
				}

				$transaction= Yii::app()->db->beginTransaction();
				try{
					foreach($pk as $k => $v){
						$exchange = GiftExchange::model()->with(array('gift'))->findByPk($v);

						$exchange->status = -1;
						$exchange->checkId = Yii::app()->user->id;
						$exchange->checkDate = date('Y-m-d H:i:s');
						$exchange->save();

						Helpers::syslog(7,Yii::app()->user->getState('account')." 不通过 [".$exchange->code."] 中 [".$exchange->gift->name."] 的兑换申请",Yii::app()->user->id,$exchange->id);

				       	//通知申请人
				       	$content = "你的兑换申请 [".$exchange->code."] 中的 [".$exchange->gift->name."] 没有被通过！";
				       	Helpers::sendmessage($exchange->applyId,$content,3,0,$exchange->id);
					}

					$transaction->commit();

			       	echo json_encode(array('type'=>'success'));
			       	Yii::app()->end();
	       		}
	       		catch (Exception $e) {
	    			$transaction->rollback();
	    			echo json_encode(array('type'=>'error','info'=>'系统繁忙，请稍后再试！','errorinfo'=>$e));
	   				Yii::app()->end();
	    		}
			}
		}
	}
}