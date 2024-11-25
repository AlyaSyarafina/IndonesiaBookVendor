<?php

use Yii;
use yii\helpers\Html;
use app\assets\IbvAsset;
use app\components\FilterSubjectWidget;

/* @var $this yii\web\View */
/* @var $content string */

IbvAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE HTML>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<title><?= isset($this->title) ? Html::encode($this->title) : Yii::$app->params['title'] ?></title>
		<?= Html::csrfMetaTags() ?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="<?= Yii::$app->charset ?>">
		<link rel="shortcut icon" href="<?= Yii::getAlias('@web').'/favicon.ico' ?>" type="image/x-icon">
		<link rel="icon" href="<?= Yii::getAlias('@web').'/favicon.ico' ?>" type="image/x-icon">
		<?php $this->head() ?>
	</head>
	<body>
		<?php $this->beginBody() ?>

		<?= $this->render('_menu.php') ?>
		<?= $this->render('_searchmain.php') ?>
		<?= $this->render('_modal.php') ?>
		<div class="container">
			<div class="row">
				<?= $content ?>
			</div>
		</div>
		<?= $this->render('_footer') ?>
		<?php $this->endBody() ?>
	</body>
</html>
<?php  $this->endPage() ?>
