<?php
namespace app\controllers;

use Yii;
use app\controllers\FrontEndController;
use app\models\Book;

class HomeController extends FrontEndController{
	public function actionIndex(){
		$releaseBooks = Book::find()->orderBy('id DESC')->limit(Yii::$app->params['newReleaseNumber'])->all();
		$bestSellerBooks = Book::getBestSeller(Yii::$app->params['bestSellerNumber']);
		$featuredBooks = Book::getFeatured(Yii::$app->params['featuredNumber']);
		return $this->render('index', [
			'releaseBooks' => $releaseBooks,
			'bestSellerBooks' => $bestSellerBooks,
			'featuredBooks' => $featuredBooks,
		]);
	}
}
	
?>