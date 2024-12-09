<?php
namespace app\assets;
use yii\web\AssetBundle;

class AdminLteAsset extends AssetBundle{
	public $basePath = "@webroot/themes/admin-lte";
	public $baseUrl = "@web/themes/admin-lte";
	public $css = [
		'assets/css/bootstrap.min.css',
		'assets/css/font-awesome.min.css',
		'assets/css/ionicons.min.css',
		'assets/css/AdminLTE.css'
	];
	public $js = [
		//'http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js', //jquery has loaded by yii by default
		'assets/js/bootstrap.min.js',
		'assets/js/AdminLTE/app.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
	];
}