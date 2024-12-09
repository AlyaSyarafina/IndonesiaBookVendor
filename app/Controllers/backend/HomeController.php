<?php
namespace app\controllers\backend;

use Yii;
use app\controllers\backend\BackendController;

class HomeController extends BackendController{
	public function actionIndex(){
		return $this->render('index');
	}
}