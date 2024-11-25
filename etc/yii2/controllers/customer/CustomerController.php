<?php

namespace app\controllers\customer;

use Yii;
use yii\web\Controller;

class CustomerController extends Controller{
    public $layout = "customer";

	public function __construct($id, $module, $config = []){
		parent::__construct($id, $module, $config);
		$this->getView()->theme = Yii::createObject([
			"class" => "\yii\base\Theme",
			"pathMap" => [
				"@app/views" => "@app/themes/admin-lte"
			], 
			"baseUrl" => "@web/themes/admin-lte",
		]);
	}

	public function behaviors()
    {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'user' => Yii::$app->customer,
                'denyCallback' => function ($rule, $action){
                	$this->redirect(['customer/login']);
                },
                'rules' => [
                    [
                        'allow' => Yii::$app->session->get('login_as') == 'customer',
                        'roles' => ['@'],
                    ]
                ],
            ],

        ];
    }
}