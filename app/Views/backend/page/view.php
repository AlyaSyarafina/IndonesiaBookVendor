<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12 page-view">

    <p>
        <?= Html::a('<span class=\'fa fa-list\'></span> List Page', ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class=\'fa fa-edit\'></span> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'template' => "<tr><th width='150px'>{label}</th><td>{value}</td></tr>",
        'attributes' => [
            'id',
            'title',
            'content:html',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
