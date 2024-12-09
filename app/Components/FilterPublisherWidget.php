<?php
namespace app\components;

use Yii;
use yii\base\Widget;
use yii\db\Query;
use app\models\Book;

class FilterPublisherWidget extends Widget{
	public function init(){
		parent::init();
	}
	
	public function run(){
		$query = new Query;
		$publishers_result = $query->select('publisher')->distinct()->from('book')->orderBy('publisher')->all();
		$publishers = [];
		foreach($publishers_result as $publisher_result){
			$publishers[] = $publisher_result['publisher'];
		}
		
		//read keyword on url
		$keyword = Yii::$app->request->get('keyword');
		$keyword = ($keyword == null) ? '' : $keyword;
		
		//read publisher from url
		$publisher = Yii::$app->request->get('publisher');
		
		return $this->render('filterpublisherwidget-view', [
			'publishers' => $publishers,
			'keyword' => $keyword,
			'publisher' => $publisher,
		]);
	}
}
?>