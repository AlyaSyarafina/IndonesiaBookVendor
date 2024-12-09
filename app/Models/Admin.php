<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $email
 */
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'name', 'email'], 'required'],
            [['password', 'password_repeat'], 'required', 'on' => 'insert'],
            [['username'], 'string', 'max' => 32],
            [['password'], 'string', 'max' => 128, 'min' => 4],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password'],
            [['name', 'email'], 'string', 'max' => 64],
            [['username'], 'unique', 'message' => 'The Username has already been taken.'],
            [['email'], 'unique', 'message' => 'The Email has already been taken.']
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
            'name' => 'Name',
            'email' => 'Email',
            'password_repeat' => 'Repeat Password'
        ];
    }

    public function beforeSave($insert){
        if(!empty($this->password)){
            //$this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password); 
			//use old format
			$this->password = md5($this->username.'-'.$this->password);
        }else{
            unset($this->password);
        }

        if($this->isNewRecord){
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

    // Implements \yii\web\IdentityInterface */ 
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
