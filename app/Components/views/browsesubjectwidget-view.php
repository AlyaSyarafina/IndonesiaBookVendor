<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* var $this yii\web\View */
/* var $subjects app\models\Subject */

?>

<div class="panel panel-warning">
	<div class="panel-heading"><h3 class="sidebar-header">Browse by Subject</h3></div>
	<div class="panel-body">
		<ul>
			<?php
			foreach($subjects as $subject){
			?>
				<li><?= Html::a($subject->name, Url::toRoute(['browse/subject', 'id' => $subject->id, 'name' => $subject->name])) ?></li>
			<?php
			}
			?>
		</ul>
	</div>
</div>