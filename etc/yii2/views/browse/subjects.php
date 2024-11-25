<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\helpers\Html;
use app\components\FilterSubjectWidget;

/* var $this yii\web\View */
/* var $books app\models\Book */
/* var $pagination yii\data\Pagination */
/* var $browseView string */
/* var $sort string */
/* var $keyword string */
/* var $subject_ids array */
?>

<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
	<?= FilterSubjectWidget::widget() ?>
</div>
<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
	<h2 class="block-title">Search Result</h2>
	<?= $this->render('_search', [
		'pagination' => $pagination,
		'keyword' => $keyword,
		'subject_ids' => $subject_ids,
		'sort' => $sort,
		'books' => $books,
		'browseView' => $browseView,
		'sortLink' => ['browse/subject', 'keyword' => $keyword, 'subject_ids' => $subject_ids],
		'order' => $order,
	]) ?>
</div>
