<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* var $this yii\web\View */

?>
<div class="container-fluid" id="search-block">
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
			<?= Html::beginForm(['browse/subject'], 'get') ?>
				<div class="input-group has-warning">
					<input type="text" name="keyword" placeholder="Search by title, author, publisher, or isbn" class="form-control">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-warning" style="padding-top: 20px; padding-bottom: 15px;">
							<span class="fa fa-search"></span>
						</button>
					</span>
				</div>
			<?= Html::endForm() ?>
		</div>
	</div>
</div>
