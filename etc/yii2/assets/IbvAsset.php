<?php
namespace app\assets;

use yii\web\AssetBundle;

class IbvAsset extends AssetBundle{
	public $basePath = "@webroot/themes/ibv";
	public $baseUrl = "@web/themes/ibv";
	public $css = [
		'assets/css/bootstrap.min.css',
		'assets/css/bootstrap-theme.css',
		'assets/css/font-awesome.min.css',
		'assets/owl-carousel/owl.carousel.css',
		'assets/owl-carousel/owl.theme.css',
		'assets/css/style.css',
	];
	
	public $js = [
		'assets/js/jquery-ui.min.js',
		'assets/js/bootstrap.min.js',
		'assets/owl-carousel/owl.carousel.min.js',
		'assets/js/script.js',
	];
	
	public $depends = [
		'yii\web\YiiAsset',
	];
}
?>