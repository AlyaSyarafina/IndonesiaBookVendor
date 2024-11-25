<?php
use app\helpers\Html;

/* var $this yii\web\View */
/* var $book app\models\Book */
/* var $recomendedBooks app\models\Book */

$this->title = $book->title;
?>
<div class="row product-detail-info">
	<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2 thumbnail product-thumbnail thumbnail-detail">
		<?php
		echo Html::showImage($book->image_path, ['title' => $book->title, 'width' => '160px']);
		?>
		<button class="btn btn-default price-tag"><b><?= Yii::$app->formatter->asCurrency($book->price, 'USD') ?></b></button>
	</div>
	<div class="col-xs-12 col-sm-9 col-md-10 col-lg-10">
		<?= Html::a("<h2>{$book->title}</h2>", '#', ['class' => 'thumbnail-title']) ?>
		<table border=0 class="info-detail">
			<tr>
				<td>Author</td>
				<td>: </td>
				<td><?= Html::a($book->author, ['browse/author', 'author' => $book->author]) ?></td>
			</tr>
			<tr>
				<td>Publisher</td>
				<td>: </td>
				<td><?= Html::a($book->publisher, ['browse/publisher', 'publisher' => $book->publisher]) ?></td>
			</tr>
			<tr>
				<td>ISBN</td>
				<td>: </td>
				<td><?= Html::encode($book->isbn) ?></td>
			</tr>
			<tr>
				<td>Year</td>
				<td>: </td>
				<td><?= Html::encode($book->year) ?></td>
			</tr>
			<tr>
				<td>Subject</td>
				<td>: </td>
				<td><?= Html::a($book->subject->name, ['browse/subject', 'id' => $book->subject->id, 'name' => $book->subject->name]) ?></td>
			</tr>
			<tr>
				<td>Language</td>
				<td>: </td>
				<td><?= Html::encode($book->language) ?></td>
			</tr>
			<tr>
				<td>Number of Pages</td>
				<td>: </td>
				<td><?= Html::encode($book->numofpages) ?></td>
			</tr>
		</table>
		<br>
		<?= Html::a('<span class="fa fa-shopping-cart"></span> Add to Cart', ['cart/add', 'book_id' => $book->id], ['class' => 'btn btn-danger btn-add-to-cart-list']) ?>
	</div>
</div>
<div class="row product-detail-description">
	<div class="col-lg-12">
		<h3>Additional Description</h3>
		<div>
			<?= $book->description ?>
		</div>
	</div>
</div>
<?php
if($recomendedBooks != null){
?>
<div class="row product-detail-recomended-book">
	<div class="col-lg-12">
		<h3>Recomended Books</h3>
		<div id="product-detail-recomended-book">
				<?php
				foreach($recomendedBooks as $recomendedBook){
					?>
					<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
						<div class="item book-item">
							<?= Html::a(Html::showImage($recomendedBook->image_path, ['title' => $recomendedBook->title, 'width' => '140px']), ['book/detail', 'id' => $recomendedBook->id, 'title' => $recomendedBook->title]) ?>
							<?php $title = Html::showTitle($recomendedBook->title) ?>
							<?= Html::a("<h3>{$title}</h3>", ['book/detail', 'id' => $recomendedBook->id, 'title' => $recomendedBook->title], ['class' => 'thumbnail-title', 'title' => $recomendedBook->title]) ?>
							<p>
								by <?= Html::a($recomendedBook->author, ['browse/author', 'author' => $recomendedBook->author]) ?><br>
								<span class="price-tag-red"><?= Yii::$app->formatter->asCurrency($recomendedBook->price, 'USD') ?></span>
							</p>
						</div>
					</div>
					<?php
				}
				?>
		</div>
	</div>
</div>
<?php
}
?>

<?php
if($previousBooks != null){
?>
<div class="row product-history-book">
	<div class="col-lg-12">
		<h3>Previously Viewed</h3>
		<div id="product-detail-recomended-book">
				<?php
				foreach($previousBooks as $previousBook){
					?>
					<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
						<div class="item book-item">
							<?= Html::a(Html::showImage($previousBook->image_path, ['title' => $previousBook->title, 'width' => '140px']), ['book/detail', 'id' => $previousBook->id, 'title' => $previousBook->title]) ?>
							<?php $title = Html::showTitle($previousBook->title) ?>
							<?= Html::a("<h3>{$title}</h3>", ['book/detail', 'id' => $previousBook->id, 'title' => $previousBook->title], ['class' => 'thumbnail-title', 'title' => $previousBook->title]) ?>
							<p>
								by <?= Html::a($previousBook->author, ['browse/author', 'author' => $previousBook->author]) ?><br>
								<span class="price-tag-red"><?= Yii::$app->formatter->asCurrency($previousBook->price, 'USD') ?></span>
							</p>
						</div>
					</div>
					<?php
				}
				?>
		</div>
	</div>
</div>
<?php
}
?>
