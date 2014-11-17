<?php

/**
 * This is the model class for table "{{gift_exchange}}".
 *
 * The followings are the available columns in table '{{gift_exchange}}':
 * @property integer $id
 * @property string $code
 * @property string $giftId
 * @property integer $applyId
 * @property string $applyDate
 * @property integer $checkId
 * @property string $checkDate
 * @property integer $status
 * @property integer $num
 * @property integer $score
 * @property string $remark
 * @property integer $opAdminId
 * @property string $createdTime
 */
class GiftExchange extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{gift_exchange}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('applyId, checkId, status, num, score, opAdminId', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>32),
			array('giftId', 'length', 'max'=>64),
			array('remark', 'length', 'max'=>128),
			array('applyDate, checkDate, createdTime', 'safe'),
			array('code, giftId, applyId, applyDate, checkId, checkDate, status, num, score, remark, opAdminId, createdTime','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, giftId, applyId, applyDate, checkId, checkDate, status, num, score, remark, opAdminId, createdTime', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'gift'=>array(self::BELONGS_TO,'Gift','giftId'),
			'apply'=>array(self::BELONGS_TO,'User','applyId'),
			'check'=>array(self::BELONGS_TO,'User','checkId'),
		);
	}

	public function beforeSave()
	{
		$this->createdTime = date('Y-m-d H:i:s');
		$this->opAdminId = Yii::app()->user->id;
		if ($this->isNewRecord) {
			$this->applyDate = date('Y-m-d H:i:s');
			$this->applyId = Yii::app()->user->id;
		}
		return true;
	}

    public function afterSave(){
        if ($this->isNewRecord) {
            $this->code = 'GEX'.str_pad($this->primarykey,6,'0',STR_PAD_LEFT);
            $this->isNewRecord = false;
            $this->saveAttributes(array('code'));
        }
        return true;
    }

    public function searchField()
	{
		$column = array(
			'id' => array('name'=>'id','type'=>'hidden'),
			'giftId' => array('name'=>'兑换物品','type'=>'text'),
			'status' => array('name'=>'状态','type'=>'select','data'=>Yii::app()->params['exchange_status']),
			'applyDate' => array('name'=>'申请时间','type'=>'daterange'),
		);
		return $column;
	}

	public function result()
	{
		$criteria = new CDbCriteria();

        $criteria->select = '*';
        $criteria->order = "";
        $sidx = Yii::app()->request->getParam('sidx');
        $page = Yii::app()->request->getParam('page');
        $rows = Yii::app()->request->getParam('rows');

        if(!empty($sidx))
        	$criteria->order .= 't.'.Yii::app()->request->getParam('sidx').' '.Yii::app()->request->getParam('sord').",";
        $criteria->order .= 't.createdTime DESC,t.id DESC';

        $criteria->compare('t.status',$this->status);

        if(isset($this->giftId))
        {
        	$criteria->compare('gift.name',$this->giftId);
        }

        if($_GET['id']){
            $criteria->compare('t.id',$_GET['id']);
        }

        $criteria->compare('t.applyId',Yii::app()->user->id);


        if(isset($_GET['start'])&&!empty($_GET['start']))
            $criteria->compare('UNIX_TIMESTAMP(t.applyDate) >',strtotime($_GET['start']));
        if(isset($_GET['end'])&&!empty($_GET['end']))
            $criteria->compare('UNIX_TIMESTAMP(t.applyDate) <',strtotime($_GET['end'])+86400);

        $count = $this->with(array('gift','apply','check'))->count($criteria);
        $pages = new CPagination($count);
        $pages->pageVar = 'page';
        $pages->currentPage = !empty($page)?Yii::app()->request->getParam('page')-1:10;
        $pages->pageSize = !empty($rows)?Yii::app()->request->getParam('rows'):10;
        $pages->applyLimit($criteria);
        $models = $this->with(array('gift','apply','check'))->findAll($criteria);

        $row = array();
        foreach ($models as $key => $value) {
            $row[] = array(
                'id' => $value->id,
				'code' => $value->code,
				'giftId' => isset($value->gift)?$value->gift->name:'无',
				'applyId' => isset($value->apply)?$value->apply->account:'无',
				'applyDate'=> $value->applyDate,
				'checkId' => isset($value->check)?$value->check->account:'无',
				'checkDate'=> $value->checkDate,
				'status' => Yii::app()->params['exchange_status'][$value->status],
				'statusid'=>Yii::app()->params['exchange_status'][$value->status],
				'score' => $value->score,
				'num' => $value->num,
				'remark' => $value->remark,
				'opAdminId' => $value->opAdminId,
				'createdTime' => $value->createdTime,
                );
        }
        $data = array(
                    "totalpages" => $pages->pageCount,
                    "currpage" => $pages->currentPage+1,
                    "totalrecords" =>$count,
                    "griddata" => $row,
                );
        return $data;
	}

	public function exchangecheckField()
	{
		$column = array(
			'id' => array('name'=>'id','type'=>'hidden'),
			'giftId' => array('name'=>'兑换物品','type'=>'text'),
			'code' => array('name'=>'记录编码','type'=>'text'),
			'status' => array('name'=>'状态','type'=>'select','data'=>Yii::app()->params['exchange_status']),
			'applyDate' => array('name'=>'申请时间','type'=>'daterange'),
		);
		return $column;
	}

	public function exchangecheckresult()
	{
		$criteria = new CDbCriteria();

        $criteria->select = '*';
        $criteria->order = "";
        $sidx = Yii::app()->request->getParam('sidx');
        $page = Yii::app()->request->getParam('page');
        $rows = Yii::app()->request->getParam('rows');

        if(!empty($sidx))
        	$criteria->order .= 't.'.Yii::app()->request->getParam('sidx').' '.Yii::app()->request->getParam('sord').",";
        $criteria->order .= 't.createdTime DESC,t.id DESC';

        $criteria->compare('t.status',$this->status);
        $criteria->compare('t.code',$this->code);

        if(isset($this->giftId))
        {
        	$criteria->compare('gift.name',$this->giftId);
        }


        if(isset($_GET['start'])&&!empty($_GET['start']))
            $criteria->compare('UNIX_TIMESTAMP(t.applyDate) >',strtotime($_GET['start']));
        if(isset($_GET['end'])&&!empty($_GET['end']))
            $criteria->compare('UNIX_TIMESTAMP(t.applyDate) <',strtotime($_GET['end'])+86400);

        $count = $this->with(array('gift','apply','check'))->count($criteria);
        $pages = new CPagination($count);
        $pages->pageVar = 'page';
        $pages->currentPage = !empty($page)?Yii::app()->request->getParam('page')-1:10;
        $pages->pageSize = !empty($rows)?Yii::app()->request->getParam('rows'):10;
        $pages->applyLimit($criteria);
        $models = $this->with(array('gift','apply','check'))->findAll($criteria);

        $row = array();
        foreach ($models as $key => $value) {
            $row[] = array(
                'id' => $value->id,
				'code' => $value->code,
				'giftId' => isset($value->gift)?$value->gift->name:'无',
				'applyId' => isset($value->apply)?$value->apply->account:'无',
				'applyDate'=> $value->applyDate,
				'checkId' => isset($value->check)?$value->check->account:'无',
				'checkDate'=> $value->checkDate,
				'status' => Yii::app()->params['exchange_status'][$value->status],
				'statusid'=>Yii::app()->params['exchange_status'][$value->status],
				'score' => $value->score,
				'num' => $value->num,
				'remark' => $value->remark,
				'opAdminId' => $value->opAdminId,
				'createdTime' => $value->createdTime,
				'handle'=> ($value->status == 0)?'<button onclick=\'checkok("'.$value->id.'","'.$value->gift->name.'","'.$value->code.'")\' class="btn btn-white btn-default btn-round" ><i class="ace-icon fa fa-check-square-o"></i> 通过</button>&nbsp;<button onclick=\'checknot("'.$value->id.'","'.$value->gift->name.'","'.$value->code.'")\' class="btn btn-white btn-warning btn-round" ><i class="ace-icon fa fa-exclamation-triangle "></i> 不通过</button>':'',
                );
        }
        $data = array(
                    "totalpages" => $pages->pageCount,
                    "currpage" => $pages->currentPage+1,
                    "totalrecords" =>$count,
                    "griddata" => $row,
                );
        return $data;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => '兑换编码',
			'giftId' => '礼品ID',
			'applyId' => '申请人ID',
			'applyDate' => '申请时间',
			'checkId' => '审核人ID',
			'checkDate' => '审核时间',
			'status' => '-1=审核不过 0=新申请 1=兑换成功',
			'num' => '数量',
			'score' => '兑换分值',
			'remark' => '备注',
			'opAdminId' => '操作人ID',
			'createdTime' => '生成时间',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('giftId',$this->giftId,true);
		$criteria->compare('applyId',$this->applyId);
		$criteria->compare('applyDate',$this->applyDate,true);
		$criteria->compare('checkId',$this->checkId);
		$criteria->compare('checkDate',$this->checkDate,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('num',$this->num);
		$criteria->compare('score',$this->score);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('opAdminId',$this->opAdminId);
		$criteria->compare('createdTime',$this->createdTime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GiftExchange the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
