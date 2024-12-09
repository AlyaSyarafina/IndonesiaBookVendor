<?php

use Yii;
use yii\helpers\Html;
use app\assets\IbvAsset;
use app\components\BrowseSubjectWidget;
use app\components\NewsWidget;

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

		<!-- Google tag (gtag.js) - Google Marketing Platform -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-4XY513LB7X"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'G-4XY513LB7X');
		</script>

		<?php $this->head() ?>
	</head>
	<body>
		<?php $this->beginBody() ?>

		<?= $this->render('_menu.php') ?>
		<?= $this->render('_searchmain.php') ?>
		<?= $this->render('_modal.php') ?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<?= $content ?>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<?= BrowseSubjectWidget::widget() ?>
					<div class="panel panel-warning">
						<div class="panel-heading"><h3 class="sidebar-header">Latest News</h3></div>
						<div class="panel-body">
							<?= NewsWidget::widget(['number' => 2]) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?= $this->render('_footer') ?>
		<?php $this->endBody() ?>
	</body>
</html>
<?php  $this->endPage() ?>
