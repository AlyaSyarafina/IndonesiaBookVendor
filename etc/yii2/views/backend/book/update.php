<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = 'Update Book: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<p>
    <?= Html::a('<span class=\'fa fa-list\'></span> List Book', ['index'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('<span class=\'fa fa-plus\'></span> Create Book', ['create'], ['class' => 'btn btn-info']) ?>
</p>
<div class="book-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
