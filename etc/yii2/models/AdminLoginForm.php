<?php
namespace app\models;

use Yii;
use yii\base\Model;

class AdminLoginForm extends Model{
	public $username;
	public $password;
	public $rememberMe=false;

	private $_admin = false;

	public function rules(){
		return [
			[['username', 'password'], 'required'],
			[['rememberMe'], 'boolean'],
			[['password'], 'validatePassword']
		];
	}

	public function login(){
		if($this->validate()){
			//set session login as admin
			Yii::$app->session->set('login_as', 'admin');
			return Yii::$app->admin->login($this->getAdmin(), $this->rememberMe ? 3600*24*30 : 0);
		}else{
			return false;
		}
	}

	public function getAdmin(){
		if($this->_admin === false){
			$this->_admin = Admin::findByUsername($this->username);
		}

		return $this->_admin;
	}

	public function validatePassword($attribute, $params){
		if(!$this->hasErrors()){
			$admin = $this->getAdmin();
			
			if($admin == null || !$admin->validatePassword($this->password)){
				$this->addError($attribute, "Incorect username or password.");
			}
		}
	}
}