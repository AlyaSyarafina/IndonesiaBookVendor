<?php
use yii\helpers\Html;
use app\models\Book;

/* var $this yii\web\View */
/* var $results Array */

$this->title = "Import Book Result";
$this->params['breadcrumbs'][] = ['label' => 'Book', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Import', 'url' => ['import']];
$this->params['breadcrumbs'][] = ['label' => 'Result'];

echo Html::a('<span class=\'fa fa-list\'></span> List Book', ['index'], ['class' => 'btn btn-primary']);

foreach($results as $key => $result){
	if(isset($result['error'])){
		echo "<div class='alert alert-danger'>";
		echo $result['error'];
		echo "</div>";
	}else{
		echo "<div class='alert alert-success'>";
		echo $result['success'];
		echo "</div>";
	}
}