<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = "Order Number #{$model->id}";
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <p class='no-print'>
        <?= Html::a('<span class=\'fa fa-list\'></span> List Order', ['index'], ['class' => 'btn btn-success']) ?>
        <?php 
        //when order not procceed
        if($model->sent_date == null && $model->cancel_date == null){
            echo Html::a('<span class=\'fa fa-shopping-cart\'></span> Sent Order', ['sent', 'id' => $model->id], [
                'class' => 'btn btn-info',
                'data' => [
                    'confirm' => 'Are you sure want to sent this order?',
                    'method' => 'post',
                ],
            ]);
            echo " ";
            echo Html::a('<span class=\'fa fa-warning\'></span> Cancel Order', ['cancel', 'id' => $model->id], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => 'Are you sure want to cancel this order?',
                    'method' => 'post',
                ],
            ]);
        }?>
        <?= Html::a('<span class=\'fa fa-trash-o\'></span> Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <a href="#" class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</a>
    </p>

    <?php 
    //when order was procceed
    if($model->sent_date != null){
        ?>
        <div class='alert alert-success no-print'>
            <?= "This order was sent on ".Yii::$app->formatter->asDate($model->sent_date) ?>
        </div>
        <?php
    }else if($model->cancel_date != null){
        ?>
        <div class='alert alert-danger no-print'>
            <?= "This order was canceled on ".Yii::$app->formatter->asDate($model->cancel_date) ?>
        </div>
        <?php
    } 
    ?>

    <!-- Main content -->
    <section class="content invoice">                    
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <?= Html::img("@web/assets/img/logo.png") ?> <?= Yii::$app->params['title'] ?> 
                </h2>                            
            </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                From
                <address>
                    <strong><?= Yii::$app->params['title'] ?></strong><br>
                    <?= nl2br(Yii::$app->params['address']) ?>
                </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
                To
                <address>
                    <strong><?= "{$model->customer->last_name}, {$model->customer->first_name}" ?></strong><br>
                    <?= nl2br($model->customer->address) ?>
                </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Order Number #<?= $model->id ?></b><br/>
                <b>Order Date:</b> <?= Yii::$app->formatter->asDate(strtotime($model->order_date)) ?><br/>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Qty</th>
                            <th>Book Title</th>
                            <th>ISBN</th>
                            <th>Subtotal</th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php 
                        foreach($model->orderLines as $orderLine){
                            ?>
                            <tr>
                                <td><?= $orderLine->qty ?></td>
                                <td><?= $orderLine->book->title ?></td>
                                <td><?= $orderLine->book->isbn ?></td>
                                <td align="right"><?= Yii::$app->formatter->asCurrency($orderLine->price * $orderLine->qty, 'USD') ?></td>
                            </tr>
                            <?php 
                        }
                        ?>
                    </tbody>
                </table>                            
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    <?= $model->notes ?>
                </p>
            </div><!-- /.col -->
            <div class="col-xs-6">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Total:</th>
                            <td align="right"><?= Yii::$app->formatter->asCurrency($model->total, 'USD') ?></td>
                        </tr>
                    </table>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
