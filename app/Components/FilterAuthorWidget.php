<?php
namespace app\components;

use Yii;
use yii\base\Widget;
use yii\db\Query;
use app\models\Book;

class FilterAuthorWidget extends Widget{
	public function init(){
		parent::init();
	}
	
	public function run(){
		$query = new Query;
		$authors_result = $query->select('author')->distinct()->from('book')->orderBy('author')->all();
		$authors = [];
		foreach($authors_result as $author_result){
			$authors[] = $author_result['author'];
		}
		
		//read keyword on url
		$keyword = Yii::$app->request->get('keyword');
		$keyword = ($keyword == null) ? '' : $keyword;
		
		//read author from url
		$author = Yii::$app->request->get('author');
		
		return $this->render('filterauthorwidget-view', [
			'authors' => $authors,
			'keyword' => $keyword,
			'author' => $author,
		]);
	}
}
?>