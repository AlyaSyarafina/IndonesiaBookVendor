<?php
namespace app\components;

use yii\base\Widget;
use app\models\Subject;

class BrowseSubjectWidget extends Widget{
	public function init(){
		parent::init();
	}
	
	public function run(){
		$subjects = Subject::find()->orderBy('id')->all();
		return $this->render('browsesubjectwidget-view', ['subjects' => $subjects]);
	}
}
?>