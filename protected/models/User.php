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
			// array('password', 'required'),
			array('typeId, deptId, workplaceId, status, handonStaffId, sex, opAdminId, logNum', 'numerical', 'integerOnly'=>true),
			array('code, password, realname, officeEmail', 'length', 'max'=>32),
			array('account', 'length', 'max'=>30),
			array('address, personNumber, personAddress, residence, studyLevel, yearOfWorking, graduationYear, homeAddress, homeTel, homeEmail, reconcactorPerson, reconcactorTel, workYearlimit, remark', 'length', 'max'=>128),
			array('officeTel, mobile', 'length', 'max'=>64),
			array('point', 'length', 'max'=>12),
			array('employTime, unemplyTime, createdTime', 'safe'),
			array('code, account, password, typeId, realname, deptId, workplaceId, status, address, officeTel, mobile, officeEmail, employTime, unemplyTime, handonStaffId, personNumber, personAddress, sex, residence, studyLevel, yearOfWorking, graduationYear, homeAddress, homeTel, homeEmail, reconcactorPerson, reconcactorTel, workYearlimit, remark, opAdminId, createdTime, logNum, point','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, account, password, typeId, realname, deptId, workplaceId, status, address, officeTel, mobile, officeEmail, employTime, unemplyTime, handonStaffId, personNumber, personAddress, sex, residence, studyLevel, yearOfWorking, graduationYear, homeAddress, homeTel, homeEmail, reconcactorPerson, reconcactorTel, workYearlimit, remark, opAdminId, createdTime, logNum, point', 'safe', 'on'=>'search'),
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

	public function afterSave(){
        if ($this->isNewRecord) {
            $this->code = 'U'.str_pad($this->primarykey,4,'0',STR_PAD_LEFT);
            $this->isNewRecord = false;
            $this->saveAttributes(array('code'));
        }
        return true;
    }

    public function searchField()
	{
		$column = array(
			'id' => array('name'=>'id','type'=>'hidden'),
			'account' => array('name'=>'账号','type'=>'text'),
			'typeId' => array('name'=>'类别','type'=>'select','data'=>Yii::app()->params['user_type']),
			'deptId' => array('name'=>'部门','type'=>'select','data'=>CHtml::listData(Deptment::model()->findAllByAttributes(array('status'=>1)), 'id', 'name')),
			'workplaceId' => array('name'=>'岗位','type'=>'select','data'=>CHtml::listData(Workplace::model()->findAllByAttributes(array('status'=>1)), 'id', 'name')),
			'sex' => array('name'=>'性别','type'=>'select','data'=>Yii::app()->params['gender']),
			'status' => array('name'=>'状态','type'=>'select','data'=>Yii::app()->params['status']),
			//'createdTime' => array('name'=>'选择时间','type'=>'daterange'),
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

        $criteria->compare('t.typeId',$this->typeId);
        $criteria->compare('t.status',$this->status);
        $criteria->compare('t.account',$this->account);
       	$criteria->compare('t.deptId',$this->deptId);
        $criteria->compare('t.workplaceId',$this->workplaceId);
        $criteria->compare('t.sex',$this->sex);

        if(isset($_GET['start'])&&!empty($_GET['start']))
        	$criteria->compare('createdTime >',$_GET['start']);
        if(isset($_GET['end'])&&!empty($_GET['end']))
        	$criteria->compare('createdTime <=',$_GET['end']);

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
				'account' => $value->account,
				'password' => '',
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
				'point' => $value->point,
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
			'point' => '积分',
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
