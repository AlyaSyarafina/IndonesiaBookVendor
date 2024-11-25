<?php

use Yii;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
use app\assets\AdminLteAsset;

/* @var $this yii\web\View */
/* @var $content string */

AdminLteAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<?= Html::csrfMetaTags() ?>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<title><?= Html::encode($this->title) ?></title>
        <?php $this->head(); ?>
	</head>
	<body class="skin-black">
		<?php $this->beginBody(); ?>

		<header class="header">
			<?= Html::a('Indonesia Book Vendor', ['home/index'], ['class' => 'logo']) ?>
			<nav class="navbar navbar-static-top" role="navigation">
				<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<div class="navbar-right">
					<!-- will be widget in the future -->
					<!-- start -->
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="glyphicon glyphicon-user"></i>
								<span><?= Yii::$app->customer->getIdentity()->username ?><i class="caret"></i></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div class="pull-left">
										<?= Html::a('Profile', ['customer/profile'], ['class' => 'btn btn-default btn-flat']); ?>
									</div>
									<div class="pull-right">
										<?= Html::a('Sign out', ['customer/logout'], ['class' => 'btn btn-default btn-flat']) ?>
									</div>
								</li>
							</ul>
						</li>
					</ul>
					<!-- end -->
				</div>
			</nav>
		</header>

		<div class="wrapper row-offcanvas row-offcanvas-left">
			<!-- left menu start -->
			<aside class="left-side sidebar-offcanvas">
				<section class="sidebar">
					<div class="user-panel">
						<div class="pull-left info">
							<p>Hello, <?= Yii::$app->customer->getIdentity()->username ?></p>
						</div>
					</div>
					<?php 
					echo Menu::widget([
						'items' => [
							['label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>', 'url' => ['customer/home'], 'active' => Yii::$app->controller->id == 'customer/home'],
							['label' => '<i class="fa fa-shopping-cart"></i> <span>History Order</span>', 'url'=> ['customer/order/index'], 'active' => Yii::$app->controller->id == 'customer/order'],
							['label' => '<i class="fa fa-sign-out"></i> <span>Sign Out</span>', 'url'=> ['backend/logout']],
						],
						'encodeLabels' => false,
						'options' => ['class' => 'sidebar-menu']
					]);
					?>
				</section>
			</aside>
			<!-- left menu end -->
			<aside class="right-side"> 
				<section class="content-header">
					<h1><?= Html::encode($this->title) ?></h1>
					<?= Breadcrumbs::widget([
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
					]) ?>
				</section>
				<section class="content">
					<?php echo $content; ?>
				</section>
			</aside>
		</div>

		<?php $this->endBody(); ?>
	</body>
</html>
<?php $this->endPage(); ?>