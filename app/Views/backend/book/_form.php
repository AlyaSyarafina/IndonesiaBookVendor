<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Subject;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-lg-8 book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>

    <?= (!$model->isNewRecord && $model->image_path != null) ? Html::img("@web/".$model->image_path) : "" ?>

    <?= $form->field($model, 'img')->fileInput(); ?>
    <p>Max. 5MB</p>
    <?= $form->field($model, 'title')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'publisher')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'subject_id')->dropDownList(ArrayHelper::map(Subject::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => 17]) ?>

    <?= $form->field($model, 'language')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'numofpages')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
	
	<?= $form->field($model, 'featured')->dropDownList([1 => 'Yes', 0 => 'No']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class=\'fa fa-plus\'></span> Save' : '<span class=\'fa fa-save\'></span> Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
