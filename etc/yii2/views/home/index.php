<?php

use app\components\BookSliderWidget;

/* var $this yii\web\View */
/* var $releaseBooks app\models\Book */
/* var $bestSellerBooks app\models\Book */
/* var $featuredBooks app\models\Book */

echo BookSliderWidget::widget([
	'title' => 'New Arrival Books',
	'books' => $releaseBooks,
]);

echo BookSliderWidget::widget([
	'title' => 'Best Seller Books',
	'books' => $bestSellerBooks,
]);

echo BookSliderWidget::widget([
	'title' => 'Featured Books',
	'books' => $featuredBooks,
]);

?>
