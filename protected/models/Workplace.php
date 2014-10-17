<?php

/**
 * This is the model class for table "{{workplace}}".
 *
 * The followings are the available columns in table '{{workplace}}':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $status
 * @property string $remark
 * @property integer $opAdminId
 * @property string $createdTime
 */
class Workplace extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{workplace}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, status, opAdminId', 'numerical', 'integerOnly'=>true),
			array('code, name', 'length', 'max'=>32),
			array('remark', 'length', 'max'=>128),
			array('createdTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, status, remark, opAdminId, createdTime', 'safe', 'on'=>'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => '岗位编码',
			'name' => '岗位名称',
			'status' => '0=停用 1=启用',
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
		$criteria->compare('status',$this->status);
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
	 * @return Workplace the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
