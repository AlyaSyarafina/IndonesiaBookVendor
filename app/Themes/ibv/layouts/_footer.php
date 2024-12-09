<?php
use yii\helpers\Html;
use app\components\NewsWidget;
?>
<div id="footer">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<h2 class="block-title">Link</h2>
				<ul id="footer-sitelink">
					<li><?= Html::a('Home', ['home/index']) ?></li>
					<li><?= Html::a('Browse by Subject', ['browse/subject']) ?></li>
					<li><?= Html::a('Browse by Author', ['browse/author']) ?></li>
					<li><?= Html::a('Browse by Publisher', ['browse/publisher']) ?></li>
					<li><?= Html::a('About Us', ['page/about-us']) ?></li>
					<li><?= Html::a('Sitemap', ['page/sitemap']) ?></li>
					<li><?= Html::a('Contact Us', ['page/contact']) ?></li>
					<li><?= Html::a('News', ['news/index']) ?></li>
					<li><?= Html::a('FAQ', ['page/faq']) ?></li>
					<li><?= Html::a('Register', ['register/index']) ?></li>
					<li><?= Html::a('Login', ['customer/login']) ?></li>
				</ul>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<h2 class="block-title">Contact Us</h2>
				<div class="row contact">
					<div class="col-lg-6">
						<b><?= Yii::$app->params['title'] ?></b><br>
						<?= Yii::$app->params['adminEmail'] ?><br>
						<?= Yii::$app->params['address'] ?><br>
						<?= Yii::$app->params['phone'] ?><br>
					</div>
					<div class="col-lg-6">
						<?= Html::a(Html::img('@web/themes/ibv/assets/img/facebook_48x48.png', ['width' => '40px']), 'https://www.facebook.com/IBVendor', ['target' => '_blank']) ?>&nbsp;
						<?= Html::a(Html::img('@web/themes/ibv/assets/img/googleplus_48x48.png', ['width' => '40px']), 'https://plus.google.com/112739325026587100172/about', ['target' => '_blank']) ?>&nbsp;
						<?= Html::a(Html::img('@web/themes/ibv/assets/img/linkedin_48x48.png', ['width' => '40px']), 'https://www.linkedin.com/company/indonesia-book-vendor', ['target' => '_blank']) ?>&nbsp;
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="copyright">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				&copy Copyright 2015 - Indonesia Book Vendor
			</div>
		</div>
	</div>
</div>
