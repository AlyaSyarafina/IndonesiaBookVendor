<?php

use yii\helpers\Html;

/* var $this yii\web\View */
/* var $news app\models\News */

$this->title = "Welcome," . Yii::$app->customer->identity->username
?>

<div class="row">
	<div class="col-lg-8">
		<h1>Recent News</h1>
		<?php
		foreach($news as $news_list){
			?>
			<div class='news'>
				<h2><?= Html::encode($news_list->title) ?></h2>
				<small><?= Yii::$app->formatter->asDate($news_list->created_at) ?></small>
				<?= $news_list->content ?>
			</div>
			<?php
		}
		?>
	</div>
</div>