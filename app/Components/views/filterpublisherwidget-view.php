<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;

/* var $this yii\web\View */
/* var $publisher string */
/* var $keyword string */
/* var $publishers array */

?>
<?= Html::beginForm(['browse/publisher'], 'get') ?>
<h2 class="block-title">Filter</h2>
<?= Html::input('text', 'keyword', $keyword, ['class' => 'form-control', 'placeholder' => 'Search by title, author, or isbn']) ?>
<h2 class="block-title">Publisher</h2>
<?= AutoComplete::widget([
	'name' => 'publisher',
	'value' => $publisher,
	'clientOptions' => [
		'source' => array_values($publishers),
	],
	'options' => [
		'class' => 'form-control',
		'placeholder' => 'Type publisher here',
	],
]) ?>
<br>
<?= Html::submitButton('<span class="fa fa-search"></span> Refine', ['class' => 'btn btn-primary btn-block']) ?>
<br><br>
<?= Html::endForm() ?>