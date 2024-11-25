<?php
namespace app\components;

use yii\base\Widget;
use app\models\Book;
use yii\base\InvalidParamException;

class BookSliderWidget extends Widget{	
	/**
	* Header title of the widget
	*/
	public $title;
	
	/**
	* Model of book to show
	*/
	public $books;
	
	public function init(){
		parent::init();
	}
	
	public function run(){		
		return $this->render('bookslider-view', [
			'books' => $this->books,
			'title' => $this->title,
		]);
	}
}
?>