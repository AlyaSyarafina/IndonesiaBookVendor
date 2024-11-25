<?php
use app\helpers\Html;

/* var $this yii\web\view */
/* var $books app\models\Book */
/* var $title string */
?>

<?php
if($books !== null && count($books) > 0){
	?>
	<!-- NEW RELEASE -->
	<h2 class="block-title"><span><?= Html::encode($title) ?></span></h2>
	<div id="new-release-carousel" class="owl-carousel owl-theme">
		<?php
		foreach($books as $book){
			?>
			<div class="item book-item">
				<?php
				echo Html::a(Html::showImage($book->image_path, ['class' => 'thumbnail-small', 'alt' => $book->title, 'title' => $book->title]), ['book/detail', 'id' => $book->id, 'title' => $book->title], ['title' => $book->title]);
				?>
				<?php
				//if title more than 50 chars, hide char 51 to the end and add triple dot ...
				$title = Html::showTitle($book->title);
				echo Html::a("<h3>$title</h3>", ['book/detail', 'id' => $book->id, 'title' => $book->title], ['title' => $book->title])
				?>
				<p>by <?= Html::a("$book->author", ['browse/author', 'author' => $book->author], ['title' => $book->author]) ?></p>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}
?>
