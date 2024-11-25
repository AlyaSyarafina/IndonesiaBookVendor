<?php
namespace app\controllers\backend;

use Yii;
use app\controllers\backend\BackendController;
use app\models\AdminLoginForm;

class LoginController extends BackendController
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
        if(!Yii::$app->admin->isGuest && Yii::$app->session->get('login_as') == 'admin'){
            $this->redirect(['backend/home']);
        }

    	$model = new AdminLoginForm();
    	if($model->load(Yii::$app->request->post()) && $model->login()){
    		return $this->redirect(['backend/home']);
    	}else{
	    	return $this->render('index', ['model' => $model]);
    	}
    }

    public function actionLogout(){
        //remove session login as
        Yii::$app->session->remove('login_as');
        Yii::$app->admin->logout();
        return $this->redirect(['backend/login']);
    }
}
