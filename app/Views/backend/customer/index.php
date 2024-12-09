<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Filter</h4>
            </div>

            <div class="modal-body">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="customer-index">


    <p>
        <?= Html::a('<span class=\'fa fa-plus\'></span> Create Customer', ['create'], ['class' => 'btn btn-success']) ?>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filter">
            <span class='fa fa-search'></span> Filter
        </button>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'email:email',
            'first_name',
            'last_name',
            // 'phone',
            // 'institution',
            // 'address:ntext',
            // 'country',
            'joined_at',
            // 'lastlogin_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
