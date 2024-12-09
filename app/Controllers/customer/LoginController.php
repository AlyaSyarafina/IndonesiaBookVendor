<?php
namespace app\controllers\customer;

use Yii;
use app\controllers\customer\CustomerController;
use app\models\CustomerLoginForm;

class LoginController extends CustomerController
{
	public $layout = "login";
    public $defaultAction = "login";

    public function behaviors(){
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                    ]
                ]
            ],
        ];
    }

    public function actionLogin(){
        if(!Yii::$app->customer->isGuest && Yii::$app->session->get('login_as') == 'customer'){
            $this->redirect(['customer/home']);
        }

    	$model = new CustomerLoginForm();
    	if($model->load(Yii::$app->request->post()) && $model->login()){
			//cookie reader
			$read_cookies = Yii::$app->request->cookies;
			$cart_cookie_serialize = $read_cookies->getValue('cart', serialize([])); //read searialize cookie
			$cart_cookie = unserialize($cart_cookie_serialize); //unserialize cookie
			
			if(count($cart_cookie) > 0){
				return $this->redirect(['cart/check-out']);
			}else{
    			return $this->redirect(['customer/home']);
			}
    	}else{
	    	return $this->render('index', ['model' => $model]);
    	}
    }

    public function actionLogout(){
        //remove session login as
        Yii::$app->session->remove('login_as');
        Yii::$app->customer->logout();
        return $this->redirect(['customer/login']);
    }
}
