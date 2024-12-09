<?php
namespace app\Controllers;

// use Yii;
// use yii\web\Controller;
use CodeIgniter\Controller;

// ini adalah kode dari YII2
// class FrontEndController extends Controller{
// 	public $layout = "main";
	
// 	public function __construct($id, $module, $config = []){
// 		parent::__construct($id, $module, $config);
// 		$this->getView()->theme = Yii::createObject([
// 			"class" => "\yii\base\Theme",
// 			"pathMap" => [
// 				"@app/views" => "@app/themes/ibv"
// 			], 
// 			"baseUrl" => "@web/themes/ibv",
// 		]);
// 	}
// }
class FrontEndController extends Controller
{
	protected $layout = "main";
	protected $themePath = "themes/ibv";
	protected $viewPath = "app\\Views";
	protected $baseURL = "/themes/ibv";

	public function __construct()
	{
		parent::__construct();
		$this->initializeTheme();
	}
}

?>