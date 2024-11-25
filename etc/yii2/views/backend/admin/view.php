<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-8 admin-view">

    <p>
        <?= Html::a('<span class=\'fa fa-list\'></span> List Admin', ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class=\'fa fa-plus\'></span> Create Admin', ['create'], ['class' => 'btn btn-info']) ?>
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
            'username',
            'name',
            'email:email',
        ],
    ]) ?>

</div>
