<?php
namespace app\controllers;

use Yii;
use yii\data\Pagination;
use yii\web\Cookie;
use app\controllers\FrontEndController;
use app\models\Book;
use app\models\Subject;

class BrowseController extends FrontEndController{
	public $orderByList = [
		'title' => 'title',
		'author' => 'author',
		'publisher' => 'publisher',
		'year' => 'year',
		'price' => 'price',
	];
	public $defaultOrderBy = 'title';
	public $defaultOrderTypeBy = 'ASC';
	public $layout = 'search';
	public $defaultAction = 'subject';

	public function actionSubject(){
		$id = Yii::$app->request->get('id');
		$orderBy = Yii::$app->request->get('sort');
		$orderBy = ($orderBy == null || empty($orderBy)) ? $this->defaultOrderBy : $orderBy; //set default order by if empty
		$orderBy = isset($this->orderByList[$orderBy]) ? $orderBy : $this->defaultOrderBy; //check if order by not in list

		$orderTypeBy = Yii::$app->request->get('order');
		$orderTypeBy = ($orderTypeBy == null || empty($orderTypeBy)) ? $this->defaultOrderTypeBy : $orderTypeBy; //set default order by if empty
		$orderTypeBy = ($orderTypeBy != 'ASC' && $orderTypeBy != 'DESC') ? $this->defaultOrderTypeBy : $orderTypeBy; //check if order by not in list

		$browseView = Yii::$app->request->cookies->get('browse-view');
		$browseView = ($browseView == null || empty($browseView)) ? 'list' : $browseView;
		$subject = null;

		if($id == null || empty($id)){
			//for multiple subject
			$keyword = Yii::$app->request->get('keyword');
			$keyword = ($keyword == null) ? '' : $keyword;
			$subject_ids = Yii::$app->request->get('subject_ids');
			$subject_ids = ($subject_ids == null) ? [] : $subject_ids;
			$subject_ids = (is_array($subject_ids)) ? array_values($subject_ids) : [];

			//set condition
			$condition = [];
			if(count($subject_ids) > 0){
				$condition[] = 'and';
				$condition[] = ['subject_id' => $subject_ids];
			}

			if(!empty($keyword)){
				$subcondition = [
					'or',
					['like', 'title', $keyword],
					['like', 'isbn', $keyword],
					['like', 'publisher', $keyword],
					['like', 'author', $keyword],
					['like', 'description', $keyword],
				];
				if(count($subject_ids) > 0){
					$condition[] = $subcondition;
				}else{
					$condition = $subcondition;
				}
			}

			$books = Book::find()->where($condition)->orderBy($orderBy . " " . $orderTypeBy);

			$booksCount = clone $books;

			$pagination = new Pagination([
				'totalCount' => $books->count(),
				'pageSize' => 15,
			]);

			$books = $books->offset($pagination->offset)->limit($pagination->limit)->all();

			return $this->render('subjects', [
				'books' => $books,
				'pagination' => $pagination,
				'browseView' => $browseView,
				'sort' => $orderBy,
				'keyword' => $keyword,
				'subject_ids' => $subject_ids,
				'order' => $orderTypeBy,
			]);
		}else{
			//for single subject
			$subject = Subject::findOne($id);
			$books = Book::find()->where(['subject_id' => $id])->orderBy($orderBy . " " . $orderTypeBy);
			$booksCount = clone $books;

			$pagination = new Pagination([
				'totalCount' => $books->count(),
				'pageSize' => 15,
			]);

			$books = $books->offset($pagination->offset)->limit($pagination->limit)->all();

			return $this->render('subject', [
				'subject' => $subject,
				'books' => $books,
				'pagination' => $pagination,
				'browseView' => $browseView,
				'sort' => $orderBy,
				'order' => $orderTypeBy,
			]);
		}
	}

	public function actionPublisher(){
		$publisher = Yii::$app->request->get('publisher');
		$publisher = (empty($publisher)) ? null : $publisher;
		$orderBy = Yii::$app->request->get('sort');
		$orderBy = ($orderBy == null || empty($orderBy)) ? $this->defaultOrderBy : $orderBy; //set default order by if empty
		$orderBy = isset($this->orderByList[$orderBy]) ? $orderBy : $this->defaultOrderBy; //check if order by not in list

		$orderTypeBy = Yii::$app->request->get('order');
		$orderTypeBy = ($orderTypeBy == null || empty($orderTypeBy)) ? $this->defaultOrderTypeBy : $orderTypeBy; //set default order by if empty
		$orderTypeBy = ($orderTypeBy != 'ASC' && $orderTypeBy != 'DESC') ? $this->defaultOrderTypeBy : $orderTypeBy; //check if order by not in list

		$browseView = Yii::$app->request->cookies->get('browse-view');
		$browseView = ($browseView == null || empty($browseView)) ? 'list' : $browseView;

		//get keyword
		$keyword = Yii::$app->request->get('keyword');
		$keyword = ($keyword == null) ? '' : $keyword;

		//set condition
		$condition = [];
		if($publisher != null){
			$condition[] = 'and';
			$condition[] = ['publisher' => $publisher];
		}

		if(!empty($keyword)){
			$subcondition = [
				'or',
				['like', 'title', $keyword],
				['like', 'isbn', $keyword],
				['like', 'author', $keyword],
				['like', 'description', $keyword],
			];
			if($publisher != null){
				$condition[] = $subcondition;
			}else{
				$condition = $subcondition;
			}
		}

		//search by publisher
		$books = Book::find()->where($condition)->orderBy($orderBy . " " . $orderTypeBy);

		$booksCount = clone $books;

		$pagination = new Pagination([
			'totalCount' => $books->count(),
			'pageSize' => 15,
		]);

		$books = $books->offset($pagination->offset)->limit($pagination->limit)->all();

		return $this->render('publisher', [
			'publisher' => $publisher,
			'keyword' => $keyword,
			'books' => $books,
			'pagination' => $pagination,
			'browseView' => $browseView,
			'sort' => $orderBy,
			'order' => $orderTypeBy,
		]);
	}

	public function actionAuthor(){
		$author = Yii::$app->request->get('author');
		$author = (empty($author)) ? null : $author;
		$orderBy = Yii::$app->request->get('sort');
		$orderBy = ($orderBy == null || empty($orderBy)) ? $this->defaultOrderBy : $orderBy; //set default order by if empty
		$orderBy = isset($this->orderByList[$orderBy]) ? $orderBy : $this->defaultOrderBy; //check if order by not in list
		
		$orderTypeBy = Yii::$app->request->get('order');
		$orderTypeBy = ($orderTypeBy == null || empty($orderTypeBy)) ? $this->defaultOrderTypeBy : $orderTypeBy; //set default order by if empty
		$orderTypeBy = ($orderTypeBy != 'ASC' && $orderTypeBy != 'DESC') ? $this->defaultOrderTypeBy : $orderTypeBy; //check if order by not in list

		$browseView = Yii::$app->request->cookies->get('browse-view');
		$browseView = ($browseView == null || empty($browseView)) ? 'list' : $browseView;

		//get keyword
		$keyword = Yii::$app->request->get('keyword');
		$keyword = ($keyword == null) ? '' : $keyword;

		//set condition
		$condition = [];
		if($author != null){
			$condition[] = 'and';
			$condition[] = ['author' => $author];
		}

		if(!empty($keyword)){
			$subcondition = [
				'or',
				['like', 'title', $keyword],
				['like', 'isbn', $keyword],
				['like', 'publisher', $keyword],
				['like', 'description', $keyword],
			];
			if($author != null){
				$condition[] = $subcondition;
			}else{
				$condition = $subcondition;
			}
		}

		//search by author
		$books = Book::find()->where($condition)->orderBy($orderBy . " " . $orderTypeBy);

		$booksCount = clone $books;

		$pagination = new Pagination([
			'totalCount' => $books->count(),
			'pageSize' => 15,
		]);

		$books = $books->offset($pagination->offset)->limit($pagination->limit)->all();

		return $this->render('author', [
			'author' => $author,
			'keyword' => $keyword,
			'books' => $books,
			'pagination' => $pagination,
			'browseView' => $browseView,
			'sort' => $orderBy,
			'order' => $orderTypeBy,
		]);
	}

	public function actionChangeView(){
		$type = Yii::$app->request->get('type');
		if($type != 'grid' && $type != 'list'){
			$type = 'list';
		}
		Yii::$app->response->cookies->add(new Cookie([
			'name' => 'browse-view',
			'value' => $type,
		]));
	}
}
?>
