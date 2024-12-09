<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\AdminLoginForm */
?>

<?php 
$this->title = "Login to Customer Area";
$form = ActiveForm::begin();
?>
    <div class="body bg-gray">
        <div class="form-group">
            <?= $form->field($model, "username") ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, "password")->passwordInput() ?>
        </div>          
        <div class="form-group">
        	<?= $form->field($model, 'rememberMe')->checkbox() ?>
        </div>
    </div>
    <div class="footer">                                                               
        <?= Html::submitButton('Sign me in', ['class' => 'btn bg-olive btn-block']) ?>
                
    </div>
<?php 
ActiveForm::end();
?>
