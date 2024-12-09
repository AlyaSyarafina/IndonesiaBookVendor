<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use app\models\Subject;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
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
<div class="book-index">


    <p>
        <?= Html::a('<span class=\'fa fa-plus\'></span> Create Book', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class=\'fa fa-upload\'></span> Import Book', ['import'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<span class=\'fa fa-trash-o\'></span> Delete Selected Books', '#', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure want to delete all selected books?")', 'id' => 'delete-all-btn']) ?>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filter">
            <span class='fa fa-search'></span> Filter
        </button>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            'title',
            'publisher',
            'author',
            'year',
            [
                'attribute' => 'subject_id',
                'value' => function($data){
                    return $data->subject->name;
                },
                'filter' => ArrayHelper::map(Subject::find()->all(), 'id', 'name'),
            ],
            // 'isbn',
            // 'language',
            // 'numofpages',
            // 'price',
            // 'description:ntext',
            'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn', 'options' => ['width' => '70px']],
        ],
    ]); ?>

</div>


<?php
$js = "
$('#delete-all-btn').click(function(){
  var keys = $('#w1').yiiGridView('getSelectedRows');
  $.post('".Url::to(['backend/book/delete-all'], true)."', {'ids[]': keys})
});

$('div.icheckbox_minimal').click(function(){
  alert('test');
});
";
$this->registerJs($js);
?>
