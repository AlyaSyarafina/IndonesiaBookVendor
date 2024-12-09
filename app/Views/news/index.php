<?php
use app\helpers\Html;
use yii\widgets\LinkPager;

/* var $this yii\web\View */
/* var $news app\models\News */
/* var $pagination yii\data\Pagination */
?>

<h1>News</h1>
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

<?= 
LinkPager::widget([
	'pagination' => $pagination,
]) 
?>