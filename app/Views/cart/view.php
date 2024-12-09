<?php
use app\helpers\Html;
use yii\helpers\Url;

/* var $this yii\web\View */
/* var $lines array */
?>

<h1>Shopping Cart</h1>

<?php
if(count($lines) == 0){
	echo "<h3>Your shopping cart is empty.</h3><br><br>";
}else{
	?>

	<?= Html::beginForm(['update']) ?>
	<table class="table table-striped">
	    <thead>
	        <tr>
				<th>Image</th>
	            <th>Book Title</th>
	            <th width="120px">ISBN</th>
	            <th>Qty</th>
	            <th>Subtotal</th>
				<th class='10px'></th>
	        </tr>                                    
	    </thead>
	    <tbody>
	        <?php 
			$total = 0;
	        foreach($lines as $key => $line){
				$subtotal = $line['book']->price * $line['qty'];
				$total += $subtotal;
	            ?>
	            <tr>
	                <td><?= Html::showImage($line['book']->image_path, ['width' => '50px']) ?></td>
	                <td>
						<strong><?= $line['book']->title ?></strong><br>
						by <?= $line['book']->author ?><br>
						Publisher <?= $line['book']->publisher ?><br>
						Price <?= Yii::$app->formatter->asCurrency($line['book']->price, 'USD') ?>
					</td>
	                <td><?= $line['book']->isbn ?></td>
	                <td><?= Html::input('text', "qty[{$line['book']->id}]", $line['qty'], ['style' => 'text-align:right; max-width:50px', 'width' => '50px']) ?></td>
	                <td align="right"><?= Yii::$app->formatter->asCurrency($subtotal, 'USD') ?></td>
					<td><?= Html::a("<span class='fa fa-times'></span>", ['cart/remove', 'book_id' => $line['book']->id]) ?></td>
	            </tr>
	            <?php 
	        }
	        ?>
			<tr>
				<td colspan="4" align="right">Total</td>
				<td align="right"><?= Yii::$app->formatter->asCurrency($total, 'USD'); ?></td>
				<td></td>
			</tr>
	    </tbody>
	</table>

	<div class='col-lg-offset-9 col-lg-3'>
		<p class='pull-right'>
			<?= Html::submitButton("<span class='fa fa-save'></span> Update", ['class' => 'btn btn-primary']) ?> 
			<?= Html::button("<span class='fa fa-shopping-cart'></span> Check out", [
				'class' => 'btn btn-danger', 
				'onclick' => "javascript:window.location='".Url::toRoute('cart/check-out', true)."'",
			]) ?>
		</p>
	</div>
	<?= Html::endForm() ?>
<?php
}
?>