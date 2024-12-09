<!-- Modal -->
<div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Message</h4>
      </div>
      <div class="modal-body">
        <?php
		$isShow = false;
		if(Yii::$app->session->hasFlash('error')){
			$isShow = true;
			echo "<p class='text text-danger'>".Yii::$app->session->getFlash('error')."</p>";
		}elseif(Yii::$app->session->hasFlash('success')){
			$isShow = true;
			echo "<p class='text text-success'>".Yii::$app->session->getFlash('success')."</p>";
		}
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
$js = "$('#message').modal('show');";
if($isShow){
	$this->registerJs($js);
}
?>