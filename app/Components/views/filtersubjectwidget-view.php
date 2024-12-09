<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* var $this yii\web\View */
/* var $subjects app\models\Subject */
/* var $keyword */
/* var $subject_ids */

?>
<?= Html::beginForm(['browse/subject'], 'get') ?>
<h2 class="block-title">Filter</h2>
<?= Html::input('text', 'keyword', $keyword, ['class' => 'form-control', 'placeholder' => 'Search by title, author, publisher, or isbn']) ?>
<h2 class="block-title">Subject</h2>
<ul class="search-option">
	<?php
	foreach($subjects as $subject){
	?>
		<li><div class="checkbox"><?= Html::label(Html::input('checkbox', 'subject_ids[]', $subject->id, ['id' => "subject-{$subject->id}", 'checked' => in_array($subject->id, $subject_ids) ? true : false])."  {$subject->name}", "subject-{$subject->id}") ?></div></li>
	<?php
	}
	?>
</ul>
<?= Html::submitButton('<span class="fa fa-search"></span> Refine', ['class' => 'btn btn-primary btn-block']) ?>
<br><br>
<?= Html::endForm() ?>