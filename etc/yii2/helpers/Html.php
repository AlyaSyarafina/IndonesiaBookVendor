<?php
namespace app\helpers;

use Yii;

class Html extends \yii\helpers\Html{
	/**
	* show image for book thumbnail
	* @param $image_path string 
	* @param $options string|array 
	* @return string
	*/
	public static function showImage($image_path, $options = []){
		$image = "";
		if($image_path == null || empty($image_path)){
			$image = Yii::$app->params['defaultImage'];
		}else{
			$image = $image_path;
			//if file not found
			if(!file_exists(Yii::getAlias("@webroot/$image"))){
				$image = Yii::$app->params['defaultImage'];
			}
		}
		return parent::img("@web/$image", $options);
	}
	/**
	* Format if title more than 50 chars, hide char 51 to the end and add triple dot ...
	* @param $title string
	* @param $limit integer Default value 50
	* @return string
	*/
	public static function showTitle($title, $limit = 50){
		return strlen($title) > 50 ? (substr($title, 0, 50)."...") : $title;
	}
}
?>