<?php
namespace app\models;

use Yii;
use yii\base\Model;

class CustomerLoginForm extends Model{
	public $username;
	public $password;
	public $rememberMe=false;

	private $_customer = false;

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
			Yii::$app->session->set('login_as', 'customer');
			//save recent login
			$customer = $this->getCustomer();
			$customer->lastlogin_at = date('Y-m-d H:i:s');
			return Yii::$app->customer->login($customer, $this->rememberMe ? 3600*24*30 : 0);
		}else{
			return false;
		}
	}

	public function getCustomer(){
		if($this->_customer === false){
			$this->_customer = Customer::findByUsername($this->username);
		}

		return $this->_customer;
	}

	public function validatePassword($attribute, $params){
		if(!$this->hasErrors()){
			$customer = $this->getCustomer();
			if(!$customer || !$customer->validatePassword($this->password)){
				$this->addError($attribute, "Incorect username or password.");
			}
		}
	}
}