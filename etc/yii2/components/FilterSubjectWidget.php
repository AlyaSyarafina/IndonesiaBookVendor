<?php
namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\Subject;

class FilterSubjectWidget extends Widget{
	public function init(){
		parent::init();
	}
	
	public function run(){
		$subjects = Subject::find()->orderBy('id')->all();
		
		//read keyword on url
		$keyword = Yii::$app->request->get('keyword');
		$keyword = ($keyword == null) ? '' : $keyword;
		
		//read single subject_id form url
		$subject_id = Yii::$app->request->get('id');
		$subject_id = ($subject_id == null) ? '' : $subject_id;
		
		//read subject_ids from url
		$subject_ids = Yii::$app->request->get('subject_ids');
		$subject_ids = ($subject_ids == null) ? [] : $subject_ids;
		
		//add subject_id from url to subject_ids
		if(!empty($subject_id)){
			$subject_ids[] = $subject_id;
		}
		
		return $this->render('filtersubjectwidget-view', [
			'subjects' => $subjects,
			'keyword' => $keyword,
			'subject_ids' => $subject_ids,
		]);
	}
}
?>