<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = 'Create Page';
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
   	<p>
        <?= Html::a('<span class=\'fa fa-list\'></span> List Page', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
<div class="page-create">

    Sorry! You cannot add new page.

</div>
