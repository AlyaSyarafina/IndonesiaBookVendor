<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\helpers\Html;
use app\components\FilterSubjectWidget;

/* var $this yii\web\View */
/* var $books app\models\Book */
/* var $subject app\models\Subject */
/* var $pagination yii\data\Pagination */
/* var $browseView string */
/* var $sort string */
?>
<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
	<?= FilterSubjectWidget::widget() ?>
</div>
<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
	<h2 class="block-title">Result for <?= $subject->name ?></h2>
	<?= $this->render('_search', [
		'pagination' => $pagination,
		'subject' => $subject,
		'sort' => $sort,
		'books' => $books,
		'browseView' => $browseView,
		'sortLink' => ['browse/subject', 'id' => $subject->id, 'name' => $subject->name],
		'order' => $order,
	]) ?>
</div>
