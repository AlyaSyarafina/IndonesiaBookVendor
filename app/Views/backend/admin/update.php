<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */

$this->title = 'Update Admin: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<p>
    <?= Html::a('<span class=\'fa fa-list\'></span> List Admin', ['index'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('<span class=\'fa fa-plus\'></span> Create Admin', ['create'], ['class' => 'btn btn-info']) ?>
</p>
<div class="admin-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
