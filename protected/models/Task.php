<?php

/**
 * This is the model class for table "{{task}}".
 *
 * The followings are the available columns in table '{{task}}':
 * @property integer $id
 * @property string $code
 * @property integer $typeId
 * @property integer $imtypeId
 * @property string $name
 * @property string $desc
 * @property integer $status
 * @property string $deadline
 * @property integer $openedId
 * @property string $openedDate
 * @property integer $assignedId
 * @property string $assignedDate
 * @property string $estStarted
 * @property string $realStarted
 * @property integer $finishedId
 * @property string $finishedDate
 * @property integer $canceledId
 * @property string $canceledDate
 * @property integer $closedId
 * @property string $closedDate
 * @property string $closedReason
 * @property integer $lastEditedId
 * @property string $lastEditedDate
 * @property string $deleted
 * @property string $remark
 * @property integer $opAdminId
 * @property string $createdTime
 */
class Task extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{task}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typeId, imtypeId, name, desc, deadline', 'required'),
			array('typeId, imtypeId, status, openedId, assignedId, finishedId, canceledId, closedId, lastEditedId, opAdminId', 'numerical', 'integerOnly'=>true),
			array('code, name', 'length', 'max'=>32),
			array('closedReason', 'length', 'max'=>30),
			array('deleted', 'length', 'max'=>1),
			array('remark', 'length', 'max'=>128),
			array('openedDate, assignedDate, estStarted, realStarted, finishedDate, canceledDate, closedDate, lastEditedDate, createdTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, typeId, imtypeId, name, desc, status, deadline, openedId, openedDate, assignedId, assignedDate, estStarted, realStarted, finishedId, finishedDate, canceledId, canceledDate, closedId, closedDate, closedReason, lastEditedId, lastEditedDate, deleted, remark, opAdminId, createdTime', 'safe', 'on'=>'search'),
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
		);
	}

	public function beforeSave()
	{
		if($this->isNewRecord){
			$this->openedId = Yii::app()->user->id;
			$this->openedDate = date('Y-m-d H:i:s');
		}
		$this->lastEditedId = Yii::app()->user->id;
		$this->lastEditedDate = date('Y-m-d H:i:s');
		$this->createdTime = date('Y-m-d H:i:s');
		$this->opAdminId = Yii::app()->user->id;
		return true;
	}

	public function afterSave(){
        if ($this->isNewRecord) {
        	$str = '';
        	if(isset($this->typeId))
        		$str .= 'T'.$this->typeId;
        	if(isset($this->imtypeId))
        		$str .= 'IM'.$this->imtypeId;
            $this->code = $str.str_pad($this->primarykey,8,'0',STR_PAD_LEFT);
            $this->isNewRecord = false;
            $this->saveAttributes(array('code'));
        }
        return true;
    }

	public function createField()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'typeId' => array('type'=>'checkbox','data'=>Yii::app()->params['task_type']),
			'imtypeId' => array('type'=>'checkbox','data'=>Yii::app()->params['task_important_type']),
			'name' => '任务名称',
			'desc' => array('type'=>'textarea'),
			'deadline' => array('type'=>'date'),
			'assignedId' => array('type'=>'checkbox','data'=>array_merge(array(""=>"不指定"),CHtml::listData(User::model()->findAllByAttributes(array('status'=>1)), 'id', 'account'))),
			'opAdminId' => array('name'=>'附件','type'=>'file'),
		);
	}

	public function result($currentPage=0)
	{
		$criteria = new CDbCriteria();

        $criteria->select='*';
        $criteria->order='t.createdTime DESC,t.id DESC';
        	
        $criteria->compare('t.status',$this->status);

        $count=$this->count($criteria);
        $pages=new CPagination($count);
        $pages->pageVar='pageIndex';

        $pages->currentPage =$currentPage;
        $pages->pageSize=10;
        $pages->applyLimit($criteria);
        $models = $this->findAll($criteria);

        $row = array();
        foreach ($models as $key => $value) {
            $row[] = array(
                'id' => $value->id,
				'code' => $value->code,
				'typeId' => Yii::app()->params['task_type'][$value->typeId],
				'imtypeId' => Yii::app()->params['task_important_type'][$value->imtypeId],
				'name' => $value->name,
				'desc' => $value->desc,
				'status' => Yii::app()->params['task_status'][$value->status],
				'deadline' => $value->deadline,
				'openedId' => $value->openedId,
				'openedDate' => $value->openedDate,
				'assignedId' => $value->assignedId,
				'assignedDate' => $value->assignedDate,
				'estStarted' => $value->estStarted,
				'realStarted' => $value->realStarted,
				'finishedId' => $value->finishedId,
				'finishedDate' => $value->finishedDate,
				'canceledId' => $value->canceledId,
				'canceledDate' => $value->canceledDate,
				'closedId' => $value->closedId,
				'closedDate' => $value->closedDate,
				'closedReason' => $value->closedReason,
				'lastEditedId' => $value->lastEditedId,
				'lastEditedDate' => $value->lastEditedDate,
				'deleted' => $value->deleted,
				'remark' => $value->remark,
				'opAdminId' => $value->opAdminId,
				'createdTime' => $value->createdTime,
                );
        }
        return $row;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => '任务编码',
			'typeId' => '主次类别',
			'imtypeId' => '重要类别',
			'name' => '任务名称',
			'desc' => '任务说明',
			'status' => '0=等待 1=激活 2=完成 3=暂停 4=取消 5=关闭',
			'deadline' => '任务最后时限',
			'openedId' => '创建人ID',
			'openedDate' => '创建时间',
			'assignedId' => '指派到人ID',
			'assignedDate' => '指派时间',
			'estStarted' => '预计开始时间',
			'realStarted' => '真实开始时间',
			'finishedId' => '完成人ID',
			'finishedDate' => '完成时间',
			'canceledId' => '取消人ID',
			'canceledDate' => '取消时间',
			'closedId' => '关闭人ID',
			'closedDate' => '关闭时间',
			'closedReason' => '关闭原因',
			'lastEditedId' => '最后操作人ID',
			'lastEditedDate' => '最后操作时间',
			'deleted' => '是否删除',
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
		$criteria->compare('typeId',$this->typeId);
		$criteria->compare('imtypeId',$this->imtypeId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('deadline',$this->deadline,true);
		$criteria->compare('openedId',$this->openedId);
		$criteria->compare('openedDate',$this->openedDate,true);
		$criteria->compare('assignedId',$this->assignedId);
		$criteria->compare('assignedDate',$this->assignedDate,true);
		$criteria->compare('estStarted',$this->estStarted,true);
		$criteria->compare('realStarted',$this->realStarted,true);
		$criteria->compare('finishedId',$this->finishedId);
		$criteria->compare('finishedDate',$this->finishedDate,true);
		$criteria->compare('canceledId',$this->canceledId);
		$criteria->compare('canceledDate',$this->canceledDate,true);
		$criteria->compare('closedId',$this->closedId);
		$criteria->compare('closedDate',$this->closedDate,true);
		$criteria->compare('closedReason',$this->closedReason,true);
		$criteria->compare('lastEditedId',$this->lastEditedId);
		$criteria->compare('lastEditedDate',$this->lastEditedDate,true);
		$criteria->compare('deleted',$this->deleted,true);
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
	 * @return Task the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
