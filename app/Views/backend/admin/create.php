<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin */

$this->title = 'Create Admin';
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
   	<p>
        <?= Html::a('<span class=\'fa fa-list\'></span> List Admin', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
<div class="admin-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
