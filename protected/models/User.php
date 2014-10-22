<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $code
 * @property string $account
 * @property string $password
 * @property integer $typeId
 * @property string $realname
 * @property integer $deptId
 * @property integer $workplaceId
 * @property integer $status
 * @property string $address
 * @property string $officeTel
 * @property string $mobile
 * @property string $officeEmail
 * @property string $employTime
 * @property string $unemplyTime
 * @property integer $handonStaffId
 * @property string $personNumber
 * @property string $personAddress
 * @property integer $sex
 * @property string $residence
 * @property string $studyLevel
 * @property string $yearOfWorking
 * @property string $graduationYear
 * @property string $homeAddress
 * @property string $homeTel
 * @property string $homeEmail
 * @property string $reconcactorPerson
 * @property string $reconcactorTel
 * @property string $workYearlimit
 * @property string $remark
 * @property integer $opAdminId
 * @property string $createdTime
 * @property integer $logNum
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('password', 'required'),
			array('typeId, deptId, workplaceId, status, handonStaffId, sex, opAdminId, logNum', 'numerical', 'integerOnly'=>true),
			array('code, password, realname, officeEmail', 'length', 'max'=>32),
			array('account', 'length', 'max'=>30),
			array('address, personNumber, personAddress, residence, studyLevel, yearOfWorking, graduationYear, homeAddress, homeTel, homeEmail, reconcactorPerson, reconcactorTel, workYearlimit, remark', 'length', 'max'=>128),
			array('officeTel, mobile', 'length', 'max'=>64),
			array('employTime, unemplyTime, createdTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, account, password, typeId, realname, deptId, workplaceId, status, address, officeTel, mobile, officeEmail, employTime, unemplyTime, handonStaffId, personNumber, personAddress, sex, residence, studyLevel, yearOfWorking, graduationYear, homeAddress, homeTel, homeEmail, reconcactorPerson, reconcactorTel, workYearlimit, remark, opAdminId, createdTime, logNum', 'safe', 'on'=>'search'),
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
			'dept'=>array(self::BELONGS_TO,'Deptment','deptId'),
			'workplace'=>array(self::BELONGS_TO,'Workplace','workplaceId'),
		);
	}

	public function beforeSave()
	{
		$this->createdTime = date('Y-m-d H:i:s');
		$this->opAdminId = Yii::app()->user->id;
		return true;
	}

	public function result($currentPage=0)
	{
		$criteria = new CDbCriteria();

        $criteria->select='*';
        $criteria->order='t.createdTime DESC,t.id DESC';
        if(isset($this->status)){
        	$criteria->compare('t.status',$this->status);
        }else{
        	$criteria->condition = 't.status>=:status';
        	$criteria->params = array(':status'=>0);
        }

        $count=$this->with(array('dept','workplace'))->count($criteria);
        $pages=new CPagination($count);
        $pages->pageVar='pageIndex';

        $pages->currentPage =$currentPage;
        $pages->pageSize=10;
        $pages->applyLimit($criteria);
        $models = $this->with(array('dept','workplace'))->findAll($criteria);

        $row = array();
        foreach ($models as $key => $value) {
            $row[] = array(
                'id' => $value->id,
				'code' => $value->code,
				'account' => $value->account,
				'password' => $value->password,
				'typeId' => Yii::app()->params['user_type'][$value->typeId],
				'type'=> Yii::app()->params['user_type'][$value->typeId],
				'realname' => $value->realname,
				'deptId' => isset($value->dept)?$value->dept->name:'无',
				'workplaceId' => isset($value->workplace)?$value->workplace->name:'无',
				'status' => Yii::app()->params['status'][$value->status],
				'statusid'=> Yii::app()->params['status'][$value->status],
				'address' => $value->address,
				'officeTel' => $value->officeTel,
				'mobile' => $value->mobile,
				'officeEmail' => $value->officeEmail,
				'employTime' => $value->employTime,
				'unemplyTime' =>$value->unemplyTime,
				'handonStaffId' => $value->handonStaffId,
				'personNumber' => $value->personNumber,
				'personAddress' => $value->personAddress,
				'sex' => Yii::app()->params['gender'][$value->sex],
				'residence' => $value->residence,
				'studyLevel' => $value->studyLevel,
				'yearOfWorking' => $value->yearOfWorking,
				'graduationYear' => $value->graduationYear,
				'homeAddress' => $value->homeAddress,
				'homeTel' => $value->homeTel,
				'homeEmail' => $value->homeEmail,
				'reconcactorPerson' => $value->reconcactorPerson,
				'reconcactorTel' => $value->reconcactorTel,
				'workYearlimit' => $value->workYearlimit,
				'remark' => $value->remark,
				'opAdminId' => $value->opAdminId,
				'createdTime' => $value->createdTime,
				'logNum' => $value->logNum,
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
			'code' => '员工编码',
			'account' => '账号',
			'password' => 'Password',
			'typeId' => '类别',
			'realname' => '真实姓名',
			'deptId' => '部门ID',
			'workplaceId' => '岗位ID',
			'status' => '0=停用 1=启用',
			'address' => '家庭地址',
			'officeTel' => '办公电话',
			'mobile' => '手机号',
			'officeEmail' => '办公邮箱',
			'employTime' => '入职时间',
			'unemplyTime' => '离职时间',
			'handonStaffId' => '前任员工ID',
			'personNumber' => '身份证号码',
			'personAddress' => '身份证地址',
			'sex' => '性别',
			'residence' => '户籍',
			'studyLevel' => '学历',
			'yearOfWorking' => '合同期限',
			'graduationYear' => '毕业年份',
			'homeAddress' => '家庭地址',
			'homeTel' => '家庭电话',
			'homeEmail' => '个人Email',
			'reconcactorPerson' => '紧急联系人姓名',
			'reconcactorTel' => '紧急联系人电话',
			'workYearlimit' => '工作年限',
			'remark' => '备注',
			'opAdminId' => '操作员工ID',
			'createdTime' => '生成时间',
			'logNum' => '登陆次数',
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
		$criteria->compare('account',$this->account,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('typeId',$this->typeId);
		$criteria->compare('realname',$this->realname,true);
		$criteria->compare('deptId',$this->deptId);
		$criteria->compare('workplaceId',$this->workplaceId);
		$criteria->compare('status',$this->status);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('officeTel',$this->officeTel,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('officeEmail',$this->officeEmail,true);
		$criteria->compare('employTime',$this->employTime,true);
		$criteria->compare('unemplyTime',$this->unemplyTime,true);
		$criteria->compare('handonStaffId',$this->handonStaffId);
		$criteria->compare('personNumber',$this->personNumber,true);
		$criteria->compare('personAddress',$this->personAddress,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('residence',$this->residence,true);
		$criteria->compare('studyLevel',$this->studyLevel,true);
		$criteria->compare('yearOfWorking',$this->yearOfWorking,true);
		$criteria->compare('graduationYear',$this->graduationYear,true);
		$criteria->compare('homeAddress',$this->homeAddress,true);
		$criteria->compare('homeTel',$this->homeTel,true);
		$criteria->compare('homeEmail',$this->homeEmail,true);
		$criteria->compare('reconcactorPerson',$this->reconcactorPerson,true);
		$criteria->compare('reconcactorTel',$this->reconcactorTel,true);
		$criteria->compare('workYearlimit',$this->workYearlimit,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('opAdminId',$this->opAdminId);
		$criteria->compare('createdTime',$this->createdTime,true);
		$criteria->compare('logNum',$this->logNum);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return md5($password)==$this->password;
	}

	/**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public function hashPassword($password)
	{
		return md5($password);
	}
}
