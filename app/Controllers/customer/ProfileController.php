<?php
namespace app\controllers\customer;

use Yii;
use app\controllers\customer\CustomerController;
use app\models\Customer;

class ProfileController extends CustomerController{
	public function actionIndex(){
		$model = Customer::find()->where(['id' => Yii::$app->customer->identity->id])->one();
		if(null == $model){
			throw new NotFoundHttpException('The requested page does not exist.');
		}else{
			if($model->load(Yii::$app->request->post()) && $model->save()){
				Yii::$app->session->setFlash('success', 'Your profile saved successfully!');
				$this->refresh();
				return;
			}

			return $this->render('index', [
				'model' => $model
			]);
		}
	}
}