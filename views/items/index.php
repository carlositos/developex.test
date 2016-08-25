<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;
use yii\helpers\Url;
use karnbrockgmbh\modal\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div>
        <?php
        Modal::begin([
            'id' => 'createItem',
            'url' => Url::to(['/items/create']), // Ajax view with form to load
            'ajaxSubmit' => true,
        ]);
        Modal::end();
        ?>
        <a href="#" id="createItemLink" class="btn btn-success">Create Items</a>

    </div>
<?php Pjax::begin(['id' => 'item-grid', 'enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($model){
                    return Html::textInput('', $model->title, [
                        'class'=>'form-control item-name',
                        'data-id' => $model->id
                    ]);
                },
                'filter' => false
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'contentOptions' => ['class' => 'action-column'],
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'data-pjax' => '#model-grid',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

<?php
$this->registerJs("
    
    var editing = false;
    
    $(document).ready(function(){
    	
    	$('#createItemLink').on('click', function(e){
    	    e.preventDefault();
            $('#createItem').modal({show:true});
        });
        
        $('#createItem').on('kbModalShow', function(event, data, status, xhr) {
            $('.modal-body').html(data);
        });
        
        $('#createItem').on('kbModalSubmit', function(event, data, status, xhr) {
            $('#createItem').modal('hide');
            $.pjax.reload({container: '#item-grid'});     
        });
        
        setInterval(function(){ 
            console.log(editing);
            if(!editing){
                $.pjax.reload({container: '#item-grid'});
            }
        }, 1000);
   	
 	});
    
 	$(document).on('blur', '.item-name', function(){
        editing = false;
         
        var id = $(this).data('id');
        var title = $(this).val();
        
        $.ajax({
          type: 'POST',
          url: '".Url::to(['/items/update'])."',
          data: {id: id, title: title}
        });
    });
    
    $(document).on('focus', '.item-name', function(){
        editing = true;
    });
    
",
    View::POS_END, 'my-options');
?>