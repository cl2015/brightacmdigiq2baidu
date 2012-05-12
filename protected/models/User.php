<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $name
 * @property string $phone
 * @property string $code
 * @property string $email
 * @property integer $gender
 * @property string $company
 * @property string $post
 * @property string $city
 * @property string $room
 * @property string $size
 * @property integer $status
 * @property integer $has_checked_in
 * @property integer $display
 * @property integer $ipad_num
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class User extends TrackStarActiveRecord 
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gender, status, has_checked_in, ipad_num, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('name, phone, code, email, company, post, city, display,room, size', 'length', 'max'=>128),
			array('created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, phone, code, email, gender, company, post, city, room, size, status, has_checked_in, ipad_num, created_at, created_by, updated_at, updated_by', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'phone' => 'Phone',
			'code' => 'Code',
			'email' => 'Email',
			'gender' => 'Gender',
			'company' => 'Company',
			'post' => 'Post',
			'city' => 'City',
			'room' => 'Room',
			'size' => 'Size',
			'status' => 'Status',
			'has_checked_in' => 'Has Checked In',
			'display' => 'Display',
			'ipad_num' => 'Ipad Num',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'updated_at' => 'Updated At',
			'updated_by' => 'Updated By',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('post',$this->post,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('room',$this->room,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('has_checked_in',$this->has_checked_in);
		$criteria->compare('ipad_num',$this->ipad_num);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function apiQuery(){
	
		$criteria=new CDbCriteria;
		$criteria->compare('name',$this->name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('email',$this->email,true);
		return User::model()->findAll($criteria);

	}
}
