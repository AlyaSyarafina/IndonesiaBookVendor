<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>
<div class="book-view">

    <p>
        <?= Html::a('<span class=\'fa fa-list\'></span> List Book', ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class=\'fa fa-plus\'></span> Create Book', ['create'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<span class=\'fa fa-edit\'></span> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class=\'fa fa-trash-o\'></span> Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'publisher',
            'author',
            'year',
            [
                'label' => $model->getAttributeLabel('subject'),
                'value' => $model->subject->id . " - " . $model->subject->name,
            ],
            'isbn',
            'language',
            'numofpages',
            'price',
            'description:ntext',
            [
                'label' => $model->getAttributeLabel('image_path'),
                'value' => ($model->image_path == null || !is_file($model->image_path)) ? Html::img("@web/".Yii::$app->params['defaultImage'], ['alt' => $model->title]) : Html::img("@web/".$model->image_path, ['alt' => $model->title]),
                'format' => 'html',
            ],
			[
				'attribute' => 'featured',
				'value' => $model->featured ? 'Yes' : 'No', 
			],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
