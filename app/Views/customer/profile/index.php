<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = 'My Profile';
$this->params['breadcrumbs'][] = 'My Profile';
?>
<div class="customer-update">
    <?php 
    if(Yii::$app->session->hasFlash('success')){
        ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
        <?php
    }
    ?>
    <?= $this->render('../../backend/customer/_form', [
        'model' => $model,
    ]) ?>

</div>
