<?php

/**
 * This is the model class for table "{{sys_log}}".
 *
 * The followings are the available columns in table '{{sys_log}}':
 * @property integer $id
 * @property string $code
 * @property integer $typeId
 * @property integer $linkId
 * @property integer $linkId2
 * @property string $content
 * @property integer $valid
 * @property integer $userId
 * @property string $deleted
 * @property integer $opAdminId
 * @property string $createdTime
 */
class SysLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sys_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typeId, linkId, linkId2, valid, opAdminId, userId', 'numerical', 'integerOnly'=>true),
			array('code, content', 'length', 'max'=>32),
			array('deleted', 'length', 'max'=>1),
			array('createdTime', 'safe'),
			array('id, code, typeId, linkId, linkId2, content, valid, deleted, opAdminId, createdTime, userId','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, typeId, linkId, linkId2, content, valid, deleted, opAdminId, createdTime, userId', 'safe', 'on'=>'search'),
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

	public function afterSave(){
        if ($this->isNewRecord) {
        	$str = 'SL'.$this->typeId.'_';
            $this->code = $str.str_pad($this->primarykey,11,'0',STR_PAD_LEFT);
            $this->isNewRecord = false;
            $this->saveAttributes(array('code'));
        }
        return true;
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => '日志编码',
			'typeId' => '日志类别',
			'linkId' => '关联ID',
			'linkId2' => '关联ID2',
			'content' => '日志内容',
			'valid' => '0=无效 1=有效',
			'deleted' => '是否删除',
			'userId' => '关联人ID 0为系统',
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
		$criteria->compare('linkId',$this->linkId);
		$criteria->compare('linkId2',$this->linkId2);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('valid',$this->valid);
		$criteria->compare('deleted',$this->deleted,true);
		$criteria->compare('userId',$this->userId,true);
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
	 * @return SysLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
