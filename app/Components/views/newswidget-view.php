<?php
use yii\helpers\Html;

/* var $this yii\web\View */
/* var $model app\models\News */

?>

<div class="news">
	<?php
	foreach($model as $news){
	?>
		<h3 class="news-header"><?= Html::encode($news->title) ?></h3>
		<small><?= Yii::$app->formatter->asDate($news->created_at) ?></small>
		<?= $news->content ?>
		<p><?= Html::a('More news...', ['news/index']) ?></p>
	<?php
	}
	?>
</div>
