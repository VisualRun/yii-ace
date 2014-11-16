<?php

/**
 * This is the model class for table "{{gift}}".
 *
 * The followings are the available columns in table '{{gift}}':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $addId
 * @property string $addDate
 * @property integer $status
 * @property integer $score
 * @property integer $num
 * @property string $remark
 * @property integer $opAdminId
 * @property string $createdTime
 */
class Gift extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{gift}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('addId, status, score, num, opAdminId', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>32),
			array('name', 'length', 'max'=>64),
			array('remark', 'length', 'max'=>128),
			array('addDate, createdTime', 'safe'),
			array('code, name, addId, addDate, status, score, num, remark, opAdminId, createdTime','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, addId, addDate, status, score, num, remark, opAdminId, createdTime', 'safe', 'on'=>'search'),
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
			'user'=>array(self::BELONGS_TO,'User','addId'),
		);
	}

	public function beforeSave()
	{
		$this->createdTime = date('Y-m-d H:i:s');
		$this->opAdminId = Yii::app()->user->id;
		if ($this->isNewRecord) {
			$this->addDate = date('Y-m-d H:i:s');
			$this->addId = Yii::app()->user->id;
		}
		return true;
	}

    public function afterSave(){
        if ($this->isNewRecord) {
            $this->code = 'G'.str_pad($this->primarykey,4,'0',STR_PAD_LEFT);
            $this->isNewRecord = false;
            $this->saveAttributes(array('code'));
        }
        return true;
    }

    public function searchField()
	{
		$column = array(
			'id' => array('name'=>'id','type'=>'hidden'),
			'name' => array('name'=>'兑换物品','type'=>'text'),
			'status' => array('name'=>'状态','type'=>'select','data'=>Yii::app()->params['status']),
			'addDate' => array('name'=>'选择时间','type'=>'daterange'),
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
        $criteria->compare('t.name',$this->name);

        if(isset($_GET['start'])&&!empty($_GET['start']))
            $criteria->compare('UNIX_TIMESTAMP(t.addDate) >',strtotime($_GET['start']));
        if(isset($_GET['end'])&&!empty($_GET['end']))
            $criteria->compare('UNIX_TIMESTAMP(t.addDate) <',strtotime($_GET['end'])+86400);

        $count = $this->with(array('user'))->count($criteria);
        $pages = new CPagination($count);
        $pages->pageVar = 'page';
        $pages->currentPage = !empty($page)?Yii::app()->request->getParam('page')-1:10;
        $pages->pageSize = !empty($rows)?Yii::app()->request->getParam('rows'):10;
        $pages->applyLimit($criteria);
        $models = $this->with(array('user'))->findAll($criteria);

        $row = array();
        foreach ($models as $key => $value) {
            $row[] = array(
                'id' => $value->id,
				'code' => $value->code,
				'name' => $value->name,
				'addId' => isset($value->user)?$value->user->account:'无',
				'addDate'=> $value->addDate,
				'status' => Yii::app()->params['status'][$value->status],
				'statusid'=>Yii::app()->params['status'][$value->status],
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

	public function searchapplyField()
	{
		$column = array(
			'id' => array('name'=>'id','type'=>'hidden'),
			'name' => array('name'=>'兑换物品','type'=>'text'),
		);
		return $column;
	}

	public function giftapplyresult()
	{
		$userinfo = User::model()->findByPk(Yii::app()->user->id);

		$criteria = new CDbCriteria();

        $criteria->select = '*';
        $criteria->order = "";
        $sidx = Yii::app()->request->getParam('sidx');
        $page = Yii::app()->request->getParam('page');
        $rows = Yii::app()->request->getParam('rows');

        if(!empty($sidx))
        	$criteria->order .= 't.'.Yii::app()->request->getParam('sidx').' '.Yii::app()->request->getParam('sord').",";
        $criteria->order .= 't.createdTime DESC,t.id DESC';

        $criteria->compare('t.name',$this->name);
        $criteria->compare('t.status',1);
        $criteria->compare('t.num',' > 0');
        $criteria->compare('t.score',' < '.$userinfo->point);

        $count = $this->count($criteria);
        $pages = new CPagination($count);
        $pages->pageVar = 'page';
        $pages->currentPage = !empty($page)?Yii::app()->request->getParam('page')-1:10;
        $pages->pageSize = !empty($rows)?Yii::app()->request->getParam('rows'):10;
        $pages->applyLimit($criteria);
        $models = $this->findAll($criteria);

        $row = array();
        foreach ($models as $key => $value) {
            $row[] = array(
                'id' => $value->id,
				'code' => $value->code,
				'name' => $value->name,
				'addId' => isset($value->user)?$value->user->account:'无',
				'addDate'=> $value->addDate,
				'status' => Yii::app()->params['status'][$value->status],
				'statusid'=>Yii::app()->params['status'][$value->status],
				'score' => $value->score,
				'num' => $value->num,
				'remark' => $value->remark,
				'opAdminId' => $value->opAdminId,
				'createdTime' => $value->createdTime,
				'handle'=> '<button onclick=\'apply("'.$value->id.'","'.$value->name.'")\' class="apply btn btn-warning btn-xs" ><i class="ace-icon fa fa-search-plus "></i> 申请兑换</button>',
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
			'code' => '兑换物品编码',
			'name' => '兑换物品名称',
			'addId' => '添加人ID',
			'addDate' => '添加时间',
			'status' => '0=停用 1=启用',
			'score' => '兑换分值',
			'num' => '数量',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('addId',$this->addId);
		$criteria->compare('addDate',$this->addDate,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('score',$this->score);
		$criteria->compare('num',$this->num);
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
	 * @return Gift the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
