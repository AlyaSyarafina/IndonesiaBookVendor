<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <p>
        <?= Html::a('<span class=\'fa fa-list\'></span> List News', ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class=\'fa fa-plus\'></span> Create News', ['create'], ['class' => 'btn btn-info']) ?>
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
        'template' => '<tr><th width="150px">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'id',
            'title',
            'content:html',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
