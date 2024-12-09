<?php
namespace app\controllers\customer;

use Yii;
use app\controllers\customer\CustomerController;
use app\models\News;

class HomeController extends CustomerController{
	public function actionIndex(){
		$news = News::find()->orderBy('id DESC')->limit(10)->all();
		return $this->render('index', [
			'news' => $news,
		]);
	}
}