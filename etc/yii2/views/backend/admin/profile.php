<?php
use yii\helpers\Html;

/* var $this yii\web\View */
/* var $model app\models\Admin */

$this->title = "Profile";
$this->params['breadcrumbs'] = ['label' => 'Profile'];
?>

<div class='admin-profile'>
<?php 
if(Yii::$app->session->hasFlash('success')){
	?>
	<div class='alert alert-success'>
		<?= Yii::$app->session->getFlash('success') ?>
	</div>
	<?php 
}
?>
<?= $this->render('_form', ['model' => $model]) ?>
</div>