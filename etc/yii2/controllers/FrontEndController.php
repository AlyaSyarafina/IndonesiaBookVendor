<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class FrontEndController extends Controller{
	public $layout = "main";
	
	public function __construct($id, $module, $config = []){
		parent::__construct($id, $module, $config);
		$this->getView()->theme = Yii::createObject([
			"class" => "\yii\base\Theme",
			"pathMap" => [
				"@app/views" => "@app/themes/ibv"
			], 
			"baseUrl" => "@web/themes/ibv",
		]);
	}
}

?>