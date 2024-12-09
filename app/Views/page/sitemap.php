<?php
use yii\helpers\Html;
/* var $this yii\web\View */
?>

<h1>Sitemap</h1>
<ul>
	<li><?= Html::a('Home/Main', ['home/index']) ?></li>
	<li><?= Html::a('Browse', ['#']) ?>
		<ul>
			<li><?= Html::a('Browse by Subject', ['browse/subject']) ?></li>
			<li><?= Html::a('Browse by Author', ['browse/author']) ?></li>
			<li><?= Html::a('Browse by Publisher', ['browse/publisher']) ?></li>
		</ul>
	</li>
	<li><?= Html::a('About Us', ['page/about-us']) ?>
	<li><?= Html::a('Contact', ['page/contact']) ?>
	<li><?= Html::a('Frequently Asked Questions', ['page/faq']) ?>
	<li><?= Html::a('News', ['news/index']) ?>
	<li><?= Html::a('Shopping Cart', ['cart/view']) ?>
	<li><?= Html::a('Register', ['register/index']) ?>
	<li><?= Html::a('Login', ['customer']) ?>
</ul>