<?php
use yii\helpers\Html;
/* var $this yii\web\View */
/* var $totalItems integer */
?>
<?php 
if($totalItems == 0){
	$cartStatus = "Empty Cart";
}else if($totalItems == 1){
	$cartStatus = "{$totalItems} Item";
}else{
	$cartStatus = "{$totalItems} Items";
}
echo Html::a("<span class='fa fa-shopping-cart' style='font-size:18px'></span> $cartStatus", ['cart/view']);
?>