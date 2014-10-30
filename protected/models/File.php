<?php

/**
 * This is the model class for table "{{file}}".
 *
 * The followings are the available columns in table '{{file}}':
 * @property integer $id
 * @property string $pathname
 * @property string $title
 * @property string $extension
 * @property integer $size
 * @property integer $taskID
 * @property integer $addedId
 * @property string $addedDate
 * @property integer $downloads
 * @property string $extra
 * @property string $deleted
 */
class File extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{file}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pathname, title, extension, taskID', 'required'),
			array('size, taskID, addedId, downloads', 'numerical', 'integerOnly'=>true),
			array('pathname', 'length', 'max'=>100),
			array('title', 'length', 'max'=>90),
			array('extension', 'length', 'max'=>30),
			array('extra', 'length', 'max'=>255),
			array('deleted', 'length', 'max'=>1),
			array('addedDate', 'safe'),
			array('pathname, title, extension, size, taskID, addedId, addedDate, downloads, extra, deleted','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pathname, title, extension, size, taskID, addedId, addedDate, downloads, extra, deleted', 'safe', 'on'=>'search'),
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
			$this->addedId = Yii::app()->user->id;
			$this->addedDate = date('Y-m-d H:i:s');
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
			'pathname' => '附件地址',
			'title' => '附件标题',
			'extension' => '附件后缀名',
			'size' => '附件大小',
			'taskID' => '附件ID',
			'addedId' => '添加人ID',
			'addedDate' => '添加时间',
			'downloads' => '下载次数',
			'extra' => '特别',
			'deleted' => '是否删除',
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
		$criteria->compare('pathname',$this->pathname,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('size',$this->size);
		$criteria->compare('taskID',$this->taskID);
		$criteria->compare('addedId',$this->addedId);
		$criteria->compare('addedDate',$this->addedDate,true);
		$criteria->compare('downloads',$this->downloads);
		$criteria->compare('extra',$this->extra,true);
		$criteria->compare('deleted',$this->deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return File the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
