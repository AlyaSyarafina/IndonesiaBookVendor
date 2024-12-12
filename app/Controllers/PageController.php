<?php
namespace app\controllers;

use App\Controllers\BaseController;

class PageController extends BaseController{
	public function about_us(){
		return view('page/test_aboutUs');
	}
	public function sitemap(){
		return view('page/test_sitemap');
	}
	public function contact(){
		return view('page/test_contact');
	}
	public function faq(){
		return view('page/test_faq');
	}
}

// use Yii;
// use app\controllers\FrontEndController;
// use app\models\ContactForm;
// use app\models\Page;

// class PageController extends FrontEndController{
// 	public function actionIndex(){
// 		return $this->goHome();
// 	}

// 	public function actionAboutUs(){
// 		$page = Page::findOne(1);
// 		return $this->render('index', ['page' => $page]);
// 	}

// 	public function actionSitemap(){
// 		$page = Page::findOne(3);
// 		return $this->render('index', ['page' => $page]);
// 	}

// 	public function actionFaq(){
// 		$page = Page::findOne(2);
// 		return $this->render('index', ['page' => $page]);
// 	}

// 	public function actionContact(){
//         $model = new ContactForm();
//         if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'], Yii::$app->params['senderEmail'])) {
//             Yii::$app->session->setFlash('contactFormSubmitted');

//             return $this->refresh();
//         } else {
//             return $this->render('contact', [
//                 'model' => $model,
//             ]);
//         }
// 	}
// }
?>
