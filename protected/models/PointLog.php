<?php

/**
 * This is the model class for table "{{point_log}}".
 *
 * The followings are the available columns in table '{{point_log}}':
 * @property string $id
 * @property integer $userId
 * @property integer $log_type
 * @property integer $log_point
 * @property string $log_desc
 * @property integer $linkId
 * @property integer $valid
 * @property string $deleted
 * @property integer $opAdminId
 * @property string $createdTime
 */
class PointLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{point_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, log_type, log_point, linkId, valid, opAdminId', 'numerical', 'integerOnly'=>true),
			array('log_desc', 'length', 'max'=>128),
			array('deleted', 'length', 'max'=>1),
			array('createdTime', 'safe'),
			array('id, userId, log_type, log_point, log_desc, linkId, valid, deleted, opAdminId, createdTime','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userId, log_type, log_point, log_desc, linkId, valid, deleted, opAdminId, createdTime', 'safe', 'on'=>'search'),
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
		$this->createdTime = date('Y-m-d H:i:s');
		$this->opAdminId = Yii::app()->user->id;
		return true;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userId' => '用户ID',
			'log_type' => '积分类型',
			'log_point' => '积分值',
			'log_desc' => '积分说明',
			'linkId' => '关联ID',
			'valid' => '0=无效 1=有效',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('log_type',$this->log_type);
		$criteria->compare('log_point',$this->log_point);
		$criteria->compare('log_desc',$this->log_desc,true);
		$criteria->compare('linkId',$this->linkId);
		$criteria->compare('valid',$this->valid);
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
	 * @return PointLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
