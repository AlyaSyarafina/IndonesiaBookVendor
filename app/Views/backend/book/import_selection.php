<?php
use yii\helpers\Html;
use app\models\Book;

/* var $this yii\web\View */
/* var $model app\models\Book[] */

$this->title = "Import Book Selection";
$this->params['breadcrumbs'][] = ['label' => 'Book', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Import', 'url' => ['import']];
$this->params['breadcrumbs'][] = ['label' => 'Selection'];
?>
<?= Html::beginForm(['save-import']) ?>
<table class="table table-condensed table-stripped table-hover">
	<thead>
		<tr>
			<th width="20px"></th>
			<th>Title</th>
			<th>Publisher</th>
			<th>Author</th>
			<th>Year</th>
			<th>Subject</th>
			<th>ISBN</th>
			<th>Language</th>
			<th>Num of Pages</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach($model as $key => $book){
		?>
			<tr>
				<td><?= Html::checkBox("books[$key]", ['value' => true, 'id' => 'checkbox-'.$key]) ?></td>
				<td><?= $book->title ?></td>
				<td><?= $book->publisher ?></td>
				<td><?= $book->author ?></td>
				<td><?= $book->year ?></td>
				<td><?= $book->subject_id ?></td>
				<td><?= $book->isbn ?></td>
				<td><?= $book->language ?></td>
				<td><?= $book->numofpages ?></td>
				<td><?= $book->description ?></td>
			</tr>
		<?php 
		}	
		?>
	</tbody>
</table>
<?= Html::submitButton('<span class="fa fa-upload"></span> Import Data', ['class' => 'btn btn-primary']) ?>
<?= Html::endForm() ?>