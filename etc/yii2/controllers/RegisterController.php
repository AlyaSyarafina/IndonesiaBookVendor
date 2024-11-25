<?php
namespace app\controllers;

use Yii;
use app\controllers\FrontEndController;
use app\models\Customer;
use app\models\CustomerLoginForm;

class RegisterController extends FrontEndController{
	public function actions(){
		return [
			'captcha' => [
					'class' => 'yii\captcha\CaptchaAction',
					'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionIndex(){
		$customer = new Customer;
		$customer->scenario = "register";

		if($customer->load(Yii::$app->request->post()) && $customer->save()){
			$subject = Yii::$app->params['mail']['registration']['subject'];
			$body = Yii::$app->params['mail']['registration']['body'];

			//replace the {} with customer data
			$body = preg_replace('/{last_name}/', $customer->last_name, $body);

			//sent email
			Yii::$app->mailer->compose()
				->setTo($customer->email)
				->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['title']])
				->setSubject($subject)
				->setHtmlBody($body)
				->send();

			//login
			$customerLogin = new CustomerLoginForm();
			$customerLogin->username = $customer->username;
			$customerLogin->password = $customer->password;
			$customerLogin->login();

			Yii::$app->session->setFlash('success', 'Your registration success!');

			return $this->refresh();
		}

		return $this->render('index', ['model' => $customer]);
	}
}
?>
