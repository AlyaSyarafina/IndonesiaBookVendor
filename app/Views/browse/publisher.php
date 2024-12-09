<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\helpers\Html;
use app\components\FilterPublisherWidget;

/* var $this yii\web\View */
/* var $books app\models\Book */
/* var $publisher string */
/* var $keyword string */
/* var $pagination yii\data\Pagination */
/* var $browseView string */
/* var $sort string */
?>
<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
	<?= FilterPublisherWidget::widget() ?>
</div>
<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
	<h2 class="block-title"><?= (empty($publisher)) ? "Search Result" : "Result for {$publisher}" ?></h2>
	<?= $this->render('_search', [
		'pagination' => $pagination,
		'publisher' => $publisher,
		'keyword' => $keyword,
		'sort' => $sort,
		'books' => $books,
		'browseView' => $browseView,
		'sortLink' => ['browse/publisher', 'publisher' => $publisher, 'keyword' => $keyword],
		'order' => $order,
	]) ?>
</div>
