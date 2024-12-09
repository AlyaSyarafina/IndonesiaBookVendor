<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-lg-8 news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 125]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6])
    		->widget(letyii\tinymce\Tinymce::className(), Yii::$app->params['tinyMceWidgetConf']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class=\'fa fa-plus\'></span> Save' : '<span class=\'fa fa-save\'></span> Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
