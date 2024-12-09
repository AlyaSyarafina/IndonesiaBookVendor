<?php
namespace app\controllers;

use app\controllers\FrontEndController;
use app\models\News;
use yii\data\Pagination;

class NewsController extends FrontEndController{
	public function actionIndex(){
		$news = News::find()->orderBy('id DESC');
		$countNews = clone $news;
		$pagination = new Pagination([
			'totalCount' => $countNews->count(),
			'pageSize' => 10,
		]);
		
		$news = $news->offset($pagination->offset)->limit($pagination->limit)->all();
		
		return $this->render('index', [
			'news' => $news,
			'pagination' => $pagination,
		]);
	}
}
?>