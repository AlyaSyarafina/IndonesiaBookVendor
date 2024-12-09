<?php
namespace app\Controllers;

// use Yii;
use CodeIgniter;
// use app\Controllers\FrontEndController;
// use app\Models\Book;

use App\Models\Book;
use App\Controllers\BaseController;
use Config\Params;

// class HomeController extends FrontEndController{
// 	public function actionIndex(){
// 		$releaseBooks = Book::find()->orderBy('id DESC')->limit(Yii::$app->params['newReleaseNumber'])->all();
// 		$bestSellerBooks = Book::getBestSeller(Yii::$app->params['bestSellerNumber']);
// 		$featuredBooks = Book::getFeatured(Yii::$app->params['featuredNumber']);
// 		return $this->render('index', [
// 			'releaseBooks' => $releaseBooks,
// 			'bestSellerBooks' => $bestSellerBooks,
// 			'featuredBooks' => $featuredBooks,
// 		]);
// 	}
// }

class HomeController extends BaseController{
	public function actionIndex(){
		// $releaseBooks = Book::find()->orderBy('id DESC')->limit(Yii::$app->params['newReleaseNumber'])->all();
		// $bestSellerBooks = Book::getBestSeller(Yii::$app->params['bestSellerNumber']);
		// $featuredBooks = Book::getFeatured(Yii::$app->params['featuredNumber']);
		// return $this->render('index', [
		// 	'releaseBooks' => $releaseBooks,
		// 	'bestSellerBooks' => $bestSellerBooks,
		// 	'featuredBooks' => $featuredBooks,
		// ]);

		$bookModel = new Book();

		// Load parameters from Config\Params
        $params = new Params();
        $newReleaseNumber = $params->newReleaseNumber;
        $bestSellerNumber = $params->bestSellerNumber;
        $featuredNumber = $params->featuredNumber;

        $releaseBooks = $bookModel->orderBy('id', 'DESC')->findAll($newReleaseNumber);
        $bestSellerBooks = $bookModel->getBestSeller($bestSellerNumber);
        $featuredBooks = $bookModel->getFeatured($featuredNumber);

        return view('home\index', [
            'releaseBooks' => $releaseBooks,
            'bestSellerBooks' => $bestSellerBooks,
            'featuredBooks' => $featuredBooks,
        ]);
	}
}
	
?>