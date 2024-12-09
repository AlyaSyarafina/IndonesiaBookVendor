<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = 'Update Customer: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<p>
    <?= Html::a('<span class=\'fa fa-list\'></span> List Customer', ['index'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('<span class=\'fa fa-plus\'></span> Create Customer', ['create'], ['class' => 'btn btn-info']) ?>
</p>
<div class="customer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
