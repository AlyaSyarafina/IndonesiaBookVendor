<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use app\models\Country;


/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = 'Register';
?>
<h1>Register</h1>
<div class="customer-create">
<?php


/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
/* @var $buttonLabel string */
?>
  <div class="col-lg-8 customer-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => false]); ?>

    <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 128, 'value' => '']) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => 128, 'value' => '']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'institution')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'country')->dropDownList(ArrayHelper::map(Country::find()->all(), 'name', 'name')) ?>

    <?= $form->field($model, 'reCaptcha')->widget(
        \himiklab\yii2\recaptcha\ReCaptcha3::className(),
        [
            'action' => 'register'
        ]
    ) ?>

    <div class="form-group">
        <?php
    if(!isset($buttonLabel) || empty($buttonLabel)){
      $buttonLabel = $model->isNewRecord ? '<span class=\'fa fa-plus\'></span> Save' : '<span class=\'fa fa-save\'></span> Save';
    }
    echo Html::submitButton($buttonLabel, ['class' => 'btn btn-primary']);
    ?>
    </div>

    <?php ActiveForm::end(); ?>

  </div>
</div>
