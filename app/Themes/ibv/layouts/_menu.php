<?php
use yii\helpers\Html;
use app\components\CartWidget;
?>

<nav class="navbar navbar-default navbar-fixed-top navbar-default-transparent" id="header-menu">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-menu-collapse">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?= Html::a(Html::img('@web/themes/ibv/assets/img/logo.png'), ['home/index'], ['class' => 'navbar-brand', 'alt' => Yii::$app->params['title'], 'title' => Yii::$app->params['title']]) ?>
		</div>

		<div class="collapse navbar-collapse" id="header-menu-collapse">
			<ul class="nav navbar-nav">
				<li class="<?= Yii::$app->controller->id == 'home' ? 'active' : ''; ?>"><?= Html::a('Home', ['home/index']) ?></li>
				<li class="dropdown <?= Yii::$app->controller->id == 'browse' ? 'active' : ''; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Browse <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><?= Html::a('Browse by Subject', ['browse/subject']) ?></li>
						<li><?= Html::a('Browse by Author', ['browse/author']) ?></li>
						<li><?= Html::a('Browse by Publishser', ['browse/publisher']) ?></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">About <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><?= Html::a('About Us', ['page/about-us']) ?></li>
						<li><?= Html::a('Sitemap', ['page/sitemap']) ?></li>
					</ul>
				</li>
				<li><?= Html::a('Contact', ['page/contact']) ?></li>
				<li><?= Html::a('FAQ', ['page/faq']) ?></li>
				<?php
				//only for guest visitor
				if(Yii::$app->customer->isGuest || (Yii::$app->session->has('login_as') && Yii::$app->session->get('login_as') != 'customer')){
					?>
					<li><?= Html::a('Register', ['register/index']) ?></li>
					<li><?= Html::a('Login', ['customer/login']) ?></li>
					<?php
				}
				?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<?php
					if(!Yii::$app->customer->isGuest && Yii::$app->session->has('login_as') && Yii::$app->session->get('login_as') == 'customer'){
						echo Html::a('Hello, '.Yii::$app->customer->identity->username.'!', ['#'], [
							'class' => 'dropdown-toggle',
							'data-toggle' => 'dropdown',
							'role' => 'button',
							'aria-expanded' => 'false',
						]);
					}
					?>
					<ul class="dropdown-menu" role="menu">
						<li><?= Html::a('Go to Customer Area', ['customer/home']) ?></li>
						<li><?= Html::a('Logout', ['customer/login/logout']) ?></li>
					</ul>
				</li>
				<li>
					<?= CartWidget::widget(); ?>
				</li>
			</ul>
		</div>
	</div>
</nav>
