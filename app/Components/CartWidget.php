<?php
namespace app\components;

use Yii;
use yii\base\Widget;	

class CartWidget extends Widget{
	public function init(){
		parent::init();
	}
	
	public function run(){
		//cookie reader
		$read_cookies = Yii::$app->request->cookies;
		$cart_cookie_serialize = $read_cookies->getValue('cart', serialize([])); //read searialize cookie
		$cart_cookie = unserialize($cart_cookie_serialize); //unserialize cookie
		$totalItems = count($cart_cookie); //count total items
				
		return $this->render('cartwidget-view', ['totalItems' => $totalItems]);
	}
}

?>