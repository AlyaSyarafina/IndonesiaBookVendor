<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
use app\helpers\Html;

/* var $this yii\web\View */
/* var $books app\models\Book */
/* var $pagination yii\data\Pagination */
/* var $browseView string */
/* var $sort string */
/* var $keyword string */
/* var $subject_ids array */
/* var $sortLink array */
?>

<?php
if($pagination->totalCount == 0){
	echo "<h3>No book found for this search.</h3>";
}else{
?>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
			<p style="margin-top: 10px">Showing <?= $pagination->offset+1 ?>-<?= (($pagination->offset+$pagination->pageSize) > $pagination->totalCount) ? $pagination->totalCount : ($pagination->offset+$pagination->pageSize)  ?> of <?= $pagination->totalCount ?> result(s) </p>
		</div>

		<div class="col-xs-8 col-sm-8 col-md-3 col-lg-3">
			<select class="form-control" id="sort" onchange="javascript:window.location=this.value; display:inline">
				<option value="<?= Url::to(ArrayHelper::merge($sortLink, ['sort' => 'title'])) ?>" <?= ($sort == 'title') ? 'selected' : '' ?>>Sort by Title</option>
				<option value="<?= Url::to(ArrayHelper::merge($sortLink, ['sort' => 'author'])) ?>" <?= ($sort == 'author') ? 'selected' : '' ?>>Sort by Author</option>
				<option value="<?= Url::to(ArrayHelper::merge($sortLink, ['sort' => 'publisher'])) ?>" <?= ($sort == 'publisher') ? 'selected' : '' ?>>Sort by Publisher</option>
				<option value="<?= Url::to(ArrayHelper::merge($sortLink, ['sort' => 'year'])) ?>" <?= ($sort == 'year') ? 'selected' : '' ?>>Sort by Year Release</option>
				<option value="<?= Url::to(ArrayHelper::merge($sortLink, ['sort' => 'price'])) ?>" <?= ($sort == 'price') ? 'selected' : '' ?>>Sort by Price</option>
			</select>
			<?= (isset($order) && $order == 'DESC') ? Html::a('<span class="fa fa-sort-alpha-desc"></span>', ArrayHelper::merge($sortLink, ['sort' => $sort, 'order' => 'ASC']), ['title' => 'Sort Asc', 'alt' => 'Sort Asc']) : Html::a('<span class="fa fa-sort-alpha-asc"></span>', ArrayHelper::merge($sortLink, ['sort' => $sort, 'order' => 'DESC']), ['title' => 'Sort Desc', 'alt' => 'Sort Desc']) ?>
			<br>
		</div>

		<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
			<div class="btn-group btn-group-justified">
				<a href="javascript:;" class="btn btn-default disabled" id="list-view-trigger"><span class="glyphicon glyphicon-th-list"></span></a>
				<a href="javascript:;" class="btn btn-default" id="grid-view-trigger"><span class="glyphicon glyphicon-th-large"></span></a>
			</div>
		</div>
	</div>
	<?php
	foreach($books as $book){
		?>
		<div class="row product product-row">
			<div class="col-xs-4 col-lg-2 thumbnail product-thumbnail">
				<?= Html::a(Html::showImage($book->image_path, [
					'width' => '130px',
					'title' => $book->title,
					'alt' => $book->title,
				]), ['book/detail', 'id' => $book->id, 'title' => $book->title]) ?>
				<button class="btn btn-default price-tag"><?= Yii::$app->formatter->asCurrency($book->price, 'USD') ?></button>
			</div>
			<div class="col-xs-8 col-lg-10 product-description">
				<?= Html::a("<h3>".Html::showTitle($book->title)."</h3>", ['book/detail', 'id' => $book->id, 'title' => $book->title], ['class' => 'thumbnail-title', 'title' => $book->title]) ?>
				<p>
					by <?= Html::a("{$book->author}", ['browse/author', 'author' => $book->author]) ?><br>
					Published by <?= Html::a("{$book->publisher}", ['browse/publisher', 'publisher' => $book->publisher]) ?></a><br>
					Release year <?= $book->year ?><br>
				</p>
				<div class='buttons-browse'>
					<?= Html::button('View Detail', [
						'class' => 'btn btn-primary btn-view-detail-list',
						'onclick' => "javascript:window.location='".Url::to(['book/detail', 'id' => $book->id, 'title' => $book->title])."'",
					]) ?>&nbsp;
					<?= Html::button('<span class="fa fa-shopping-cart"></span> Add to Cart', [
						'class' => 'btn btn-danger btn-add-to-cart-list',
						'onclick' => "javascript:window.location='".Url::to(['cart/add', 'book_id' => $book->id])."'",
					]) ?>
				</div>
			</div>
		</div>
		<?php
	}
	?>
<div class="row pagination-block">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?= LinkPager::widget([
			'pagination' => $pagination,
		]) ?>
	</div>
</div>
<div class="load"></div>
<?php
$js = "";

//call trigger
	if($browseView == 'grid'){
		$js .= 'showGridView($("#grid-view-trigger"));';
	}

	//add javascript
	$js .= '$("#grid-view-trigger").click(function(){$(".load").load("'.Url::to(['change-view', 'type' => 'grid'], false).'")});';
	$js .= '$("#list-view-trigger").click(function(){$(".load").load("'.Url::to(['change-view', 'type' => 'list'], true).'")});';
	$this->registerJs($js);
}
?>
