<?php
namespace app\components;

use yii\base\Widget;
use app\models\News;

class NewsWidget extends Widget{
	/**
	* Number of recent news to show
	* The default value is 1
	*/
	public $number = 1;
	
	public function init(){
		parent::init();
	}
	
	public function run(){
		$model = News::find()->orderBy('id DESC')->limit($this->number)->all();
		return $this->render('newswidget-view', ['model' => $model]);
	}
}
	
?>