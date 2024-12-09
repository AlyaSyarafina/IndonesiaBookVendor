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
			<a href="#" class="logo">
				Indonesia Book Vendor
			</a>
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
								<span><?= Yii::$app->admin->getIdentity()->username ?><i class="caret"></i></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div class="pull-left">
										<?= Html::a('Profile', ['backend/admin/profile'], ['class' => 'btn btn-default btn-flat']); ?>
									</div>
									<div class="pull-right">
										<?= Html::a('Sign out', ['backend/logout'], ['class' => 'btn btn-default btn-flat']) ?>
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
							<p>Hello, <?= Yii::$app->admin->getIdentity()->username ?></p>
						</div>
					</div>
					<?php
					echo Menu::widget([
						'items' => [
							['label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>', 'url' => ['backend/home'], 'active' => Yii::$app->controller->id == 'backend/home'],
							['label' => '<i class="fa fa-user"></i> <span>Manage Admin</span>', 'url' => ['backend/admin/index'], 'active' => Yii::$app->controller->id == 'backend/admin'],
							['label' => '<i class="fa fa-users"></i> <span>Manage Customer</span>', 'url'=> ['backend/customer/index'], 'active' => Yii::$app->controller->id == 'backend/customer'],
							['label' => '<i class="fa fa-book"></i> <span>Manage Book</span>', 'url'=> ['backend/book/index'], 'active' => Yii::$app->controller->id == 'backend/book'],
							['label' => '<i class="fa fa-shopping-cart"></i> <span>Manage Order</span>', 'url'=> ['backend/order/index'], 'active' => Yii::$app->controller->id == 'backend/order'],
							['label' => '<i class="fa fa-file-o"></i> <span>Manage News</span>', 'url'=> ['backend/news/index'], 'active' => Yii::$app->controller->id == 'backend/news'],
							['label' => '<i class="fa fa-file"></i> <span>Manage Page</span>', 'url'=> ['backend/page/index'], 'active' => Yii::$app->controller->id == 'backend/page'],
							['label' => '<i class="fa fa-sign-out"></i> <span>Sign Out</span>', 'url'=> ['backend/logout']],
						],
						'encodeLabels' => false,
						'options' => ['class' => 'sidebar-menu']
					]);
					?>
					<!--
					<ul class="sidebar-menu">
						<li class="active">
							<a href="index.html"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
						</li>
						<li class="treeview">
							<a href="#"><i class="fa fa-bar-chart-o"></i> <span>Charts</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li><a href="pages/charts/morris.html"><i class="fa fa-angle-double-right"></i> Morris</a></li>
								<li><a href="pages/charts/morris.html"><i class="fa fa-angle-double-right"></i> Morris</a></li>
							</ul>
						</li>
					</ul>-->
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
