<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;

/* var $this yii\web\View */
/* var $author string */
/* var $keyword string */
/* var $authors array */

?>
<?= Html::beginForm(['browse/author'], 'get') ?>
<h2 class="block-title">Filter</h2>
<?= Html::input('text', 'keyword', $keyword, ['class' => 'form-control', 'placeholder' => 'Search by title, publisher, or isbn']) ?>
<h2 class="block-title">Author</h2>
<?= AutoComplete::widget([
	'name' => 'author',
	'value' => $author,
	'clientOptions' => [
		'source' => array_values($authors),
	],
	'options' => [
		'class' => 'form-control',
		'placeholder' => 'Type author here',
	],
]) ?>
<br>
<?= Html::submitButton('<span class="fa fa-search"></span> Refine', ['class' => 'btn btn-primary btn-block']) ?>
<br><br>
<?= Html::endForm() ?>