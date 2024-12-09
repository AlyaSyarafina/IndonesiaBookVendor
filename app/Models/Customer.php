<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $institution
 * @property string $address
 * @property string $country
 * @property string $joined_at
 * @property string $lastlogin_at
 * @property string $auth_key
 * @property string $password_reset_token
 *
 * @property Order[] $orders
 */
class Customer extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password_repeat;
    public $verify_code;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'first_name', 'last_name', 'phone', 'institution', 'address', 'country'], 'required'],
            [['password', 'password_repeat'], 'required', 'on' => 'insert', 'on' => 'register'],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password'],
            [['address'], 'string'],
            [['joined_at', 'lastlogin_at'], 'safe'],
            [['username'], 'string', 'max' => 32],
            [['password'], 'string', 'max' => 128],
            [['email', 'first_name', 'last_name', 'phone', 'institution', 'country'], 'string', 'max' => 64],
            [['username'], 'unique', 'message' => 'The Username has already been taken.'],
            [['email'], 'unique', 'message' => 'The Username has already been taken.'],
            // recaptcha
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator3::className(),
                'threshold' => 0.5,
                'action' => 'register',
                'on' => 'register'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'password_repeat' => 'Password Repeat',
            'email' => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'institution' => 'Institution',
            'address' => 'Address',
            'country' => 'Country',
            'joined_at' => 'Joined At',
            'lastlogin_at' => 'Last login At',
            'reCaptcha' => ''
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['customer_id' => 'id']);
    }

    public function beforeSave($insert){
        //encrypt password in database
        if(!empty($this->password)){
            //$this->password = Yii::$app->security->generatePasswordHash($this->password);
			//use old format
			$this->password = md5($this->username.'-'.$this->password);
        }else{
            unset($this->password);
        }

        //set joined date
        if($this->isNewRecord){
            $this->joined_at = date('Y-m-d H:i:s');
            $this->auth_key = \Yii::$app->security->generateRandomString();
            $this->password_reset_token = "";
        }

        return parent::beforeSave($insert);
    }

    public function validatePassword($password){
		return md5($this->username.'-'.$password) == $this->password;
    }

    public static function findByUsername($username){
        return self::findOne([
            'username' => $username,
        ]);
    }

    public static function findIdentity($id){
        return self::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null){
        return self::findOne(['access_token' => $token]);
    }

    public function getId(){
        return $this->id;
    }

    public function getAuthKey(){
        return $this->auth_key;
    }

    public function validateAuthKey($auth_key){
        return $this->auth_key === $auth_key;
    }
}
