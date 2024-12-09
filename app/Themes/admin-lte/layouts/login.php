<?php
use yii\helpers\Html;
use app\assets\AdminLteAsset;

/* var $this \yii\web\View */
/* var $content string */

AdminLteAsset::register($this);

$this->beginPage();
?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<?= Html::csrfMetaTags() ?>
    	<title><?= Html::encode($this->title) ?></title>
		<?php $this->head(); ?>
	</head>
	<body class="bg-black">
		<?php $this->beginBody() ?>
		<div class="form-box" id="login-box">
            <div class="header"><?= Html::encode($this->title) ?></div>
            <?= $content ?>
        </div>
		<?php $this->endBody() ?>
	</body>
</html>

<?php 
$this->endPage();
?>