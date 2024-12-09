<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Subject;

/* @var $this yii\web\View */
/* @var $model app\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?php echo $form->field($model, 'featured')->dropDownList([1 => 'Yes', 0 => 'No']) ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'publisher') ?>

    <?= $form->field($model, 'author') ?>

    <?= $form->field($model, 'year') ?>

    <?php echo $form->field($model, 'subject_id')->dropDownList(ArrayHelper::merge(['' => ''], ArrayHelper::map(Subject::find()->all(), 'id', 'name'))) ?>

    <?php echo $form->field($model, 'isbn') ?>

    <?php echo $form->field($model, 'language') ?>

    <?php echo $form->field($model, 'numofpages') ?>

    <?php echo $form->field($model, 'price') ?>

    <?php echo $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
