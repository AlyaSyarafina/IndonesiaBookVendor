<?php

use App\Components\BookSliderWidget;

/* var $this yii\web\View */
/* var $releaseBooks app\models\Book */
/* var $bestSellerBooks app\models\Book */
/* var $featuredBooks app\models\Book */

// echo BookSliderWidget::widget([
// 	'title' => 'New Arrival Books',
// 	'books' => $releaseBooks,
// ]);

// echo BookSliderWidget::widget([
// 	'title' => 'Best Seller Books',
// 	'books' => $bestSellerBooks,
// ]);

// echo BookSliderWidget::widget([
// 	'title' => 'Featured Books',
// 	'books' => $featuredBooks,
// ]);

// Render the 'New Arrival Books' slider
$newArrivalWidget = new BookSliderWidget('New Arrival Books', $releaseBooks);
echo $newArrivalWidget->render();

// Render the 'Best Seller Books' slider
$bestSellerWidget = new BookSliderWidget('Best Seller Books', $bestSellerBooks);
echo $bestSellerWidget->render();

// Render the 'Featured Books' slider
$featuredWidget = new BookSliderWidget('Featured Books', $featuredBooks);
echo $featuredWidget->render();


?>
