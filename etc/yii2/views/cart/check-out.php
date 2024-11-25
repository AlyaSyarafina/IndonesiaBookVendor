<?php
use app\helpers\Html;
use yii\helpers\Url;

/* var $this yii\web\View */
/* var $lines array */
?>

<h1>Check Out Confirmation</h1>

<?php
if(count($lines) == 0){
	echo "<h3>Your shopping cart is empty.</h3><br><br>";
}else{
	?>

	<?= Html::beginForm() ?>
	<?php
	if(Yii::$app->customer->isGuest || Yii::$app->session->get('login_as') != 'customer'){
		?>
		<div class="alert alert-danger">
			You must login first to check out!
		</div>
		<?php
	}
	?>
	<table class="table table-striped">
	    <thead>
	        <tr>
				<th>Image</th>
	            <th>Book Title</th>
	            <th width="120px">ISBN</th>
	            <th>Qty</th>
	            <th>Subtotal</th>
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
	                <td><?= $line['qty'] ?></td>
	                <td align="right"><?= Yii::$app->formatter->asCurrency($subtotal, 'USD') ?></td>
	            </tr>
	            <?php 
	        }
	        ?>
			<tr>
				<td colspan="4" align="right">Total</td>
				<td align="right"><?= Yii::$app->formatter->asCurrency($total, 'USD'); ?></td>
			</tr>
	    </tbody>
	</table>

	<div class='col-lg-offset-8 col-lg-4'>
		<?= Html::label('Notes') ?>
		<?= Html::textarea('notes', '', [
			'class' => 'form-control',
			'rows' => 3,
		]) ?><br>
		<p class='pull-right'>
			<?= Html::button("<span class='fa fa-arrow-left'></span> Cancel", [
				'class' => 'btn btn-primary', 
				'onclick' => "javascript:window.location='".Url::toRoute('cart/view', true)."'",
			]) ?> 
			<?= Html::submitButton("<span class='fa fa-shopping-cart'></span> Yes, Check Out", [
				'class' => 'btn btn-danger '.((Yii::$app->customer->isGuest || Yii::$app->session->get('login_as') != 'customer') ? 'disabled' : ''),
			]) ?> 
		</p>
	</div>
	
	<?= Html::endForm() ?>
<?php
}
?>