<?php
namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Cookie;
use app\controllers\FrontEndController;
use app\models\Book;


class BookController extends FrontEndController{
	public $defaultAction = "detail";
	public $layout = "detail";
	
	public function actionDetail(){
		//every user view a book set it to cookie, because the history is needed for previously tag
		//read cookie data
		$cookies = Yii::$app->request->cookies;
		$books_serialize_in_cookie = $cookies->getValue('previously_books', serialize([])); //get serialize data in cookie
		$books_in_cookie = unserialize($books_serialize_in_cookie); //unserialize the data
		
		$id = Yii::$app->request->get('id');
		$book = Book::find()->where(['id' => $id])->one();
		$recomendedBooks = Book::getRecommended($book);
		$previousBooks = Book::find()->where(['id' => $books_in_cookie])->all();
		
		if($book == null){
			throw new NotFoundHttpException("Book not found.");
		}else{
			//delete array if the book already been in cookie
			if(($key=array_search($book->id, $books_in_cookie)) !== false){
				unset($books_in_cookie[$key]);
			} 
			//if books in cookie is 6
			if(count($books_in_cookie) == 6){
				array_shift($books_in_cookie); //shift the first data
			}
			array_push($books_in_cookie, $book->id); //push the book id to cookie
			
			//set cookie response
			$cookies = Yii::$app->response->cookies;
			//set data to cookie
			$cookies->add(new Cookie([
				'name' => 'previously_books',
				'value' => serialize($books_in_cookie),
			]));
			
			return $this->render("detail", [
				'book' => $book,
				'recomendedBooks' => $recomendedBooks,
				'previousBooks' => $previousBooks,
			]);
		}
	}
}
?>