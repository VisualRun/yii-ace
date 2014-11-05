<?php

/**
 * This is the model class for table "{{message}}".
 *
 * The followings are the available columns in table '{{message}}':
 * @property integer $id
 * @property string $code
 * @property integer $typeId
 * @property integer $userId
 * @property integer $touserId
 * @property integer $linkId
 * @property integer $linkId2
 * @property string $content
 * @property integer $checkout
 * @property string $deleted
 * @property integer $opAdminId
 * @property string $createdTime
 */
class Message extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{message}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typeId, userId, touserId, linkId, linkId2, checkout, opAdminId', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>256),
			array('deleted', 'length', 'max'=>1),
			array('createdTime', 'safe'),
			array('typeId, userId, touserId, linkId, linkId2, content, checkout, deleted, opAdminId, createdTime','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, typeId, userId, touserId, linkId, linkId2, content, checkout, deleted, opAdminId, createdTime', 'safe', 'on'=>'search'),
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
			'user'=>array(self::BELONGS_TO,'User','userId'),
		);
	}

	public function beforeSave()
	{
		$this->createdTime = date('Y-m-d H:i:s');
		$this->opAdminId = Yii::app()->user->id;
		return true;
	}

	public function searchmyField()
	{
		$column = array(
			'id' => array('name'=>'id','type'=>'hidden'),
			'typeId' => array('name'=>'消息类别','type'=>'select','data'=>Yii::app()->params['message_type']),
			'userId' => array('name'=>'发送人','type'=>'select','data'=>CHtml::listData(User::model()->findAllByAttributes(array('status'=>1)), 'id', 'account')),
			'checkout' => array('name'=>'状态','type'=>'select','data'=>Yii::app()->params['status']),
            'createdTime' => array('name'=>'选择时间','type'=>'daterange'),
		);
		return $column;
	}

	public function myresult()
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

        $criteria->compare('t.typeId',$this->typeId);
        $criteria->compare('t.userId',$this->userId);
        $criteria->compare('t.checkout',$this->checkout);
       	$criteria->compare('t.touserId',Yii::app()->user->id);

        if(isset($_GET['start'])&&!empty($_GET['start']))
            $criteria->compare('UNIX_TIMESTAMP(t.createdTime) >',strtotime($_GET['start']));
        if(isset($_GET['end'])&&!empty($_GET['end']))
            $criteria->compare('UNIX_TIMESTAMP(t.createdTime) <',strtotime($_GET['end'])+86400);

        $count = $this->count($criteria);
        $pages = new CPagination($count);
        $pages->pageVar = 'page';
        $pages->currentPage = !empty($page)?Yii::app()->request->getParam('page')-1:10;
        $pages->pageSize = !empty($rows)?Yii::app()->request->getParam('rows'):10;
        $pages->applyLimit($criteria);
        $models = $this->findAll($criteria);

        $row = array();
        foreach ($models as $key => $value) {

            $tmp = array(
                'id' => $value->id,
                'typeId' => Yii::app()->params['message_type'][$value->typeId],
                'userId' => isset($value->user)?$value->user->account:'系统',
                'touserId' => Yii::app()->user->getState('account'),
                'linkId' => $value->linkId,
                'linkId2' => $value->linkId2,
                'content' => Helpers::substrUtf8($value->content,20),
                'checkout' => Yii::app()->params['checkout'][$value->checkout],
                'deleted' => Yii::app()->params['is_ync'][$value->deleted],
                'opAdminId' => $value->opAdminId,
                'createdTime' => $value->createdTime,
                'hand'=> '<button onclick=\'checkmessage("'.$value->id.'","1","")\' class="checkmessage btn btn-warning btn-xs" ><i class="ace-icon fa fa-search-plus "></i> 查看</button>',
                );
            if($value->typeId == 2)
            {
                $tmp['linkstr'] = '<a onclick=\'checkmessage("'.$value->id.'","2","'.Yii::app()->createUrl('task/view',array('id'=>$value->linkId)).'")\' href="javascript:;">关联任务</a>';
            }else{
                $tmp['linkstr'] = '暂无';
            }
            $row[] = $tmp;
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
			'typeId' => '消息类别',
			'userId' => '发送人用户ID 0为系统',
			'touserId' => '接收人用户ID 0为系统',
			'linkId' => '关联ID',
			'linkId2' => '关联ID2',
			'content' => '消息内容',
			'checkout' => '0=未看 1=已看',
			'deleted' => '是否删除',
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
		$criteria->compare('typeId',$this->typeId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('touserId',$this->touserId);
		$criteria->compare('linkId',$this->linkId);
		$criteria->compare('linkId2',$this->linkId2);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('checkout',$this->checkout);
		$criteria->compare('deleted',$this->deleted,true);
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
	 * @return Message the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
