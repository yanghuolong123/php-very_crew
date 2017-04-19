<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\extend\Games;

$this->title = '参与比赛';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="join-games">
    <h4 style="color: #00c66b;">大赛列表</h4>
    <?= GridView::widget([
        //'showHeader' => false,
        'summary' => '',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'label' => '大赛名称',
                'format' => 'raw',
                //'options' => ['style'=>'width:15%;'],
                'value' => function($data){ return Html::a($data->name, ['view','id'=>$data->id]);},
            ],
            [
                'attribute' => 'status',
                'value' => function($data) {
                    return Games::getStatusArr(false, $data->status);
                },
            ],
//            [
//                'attribute' => 'number',
//            ],
            [
                'attribute' => 'begin_time',
                'value' => function($data) {
                    return date('Y-m-d', $data->begin_time);
                },
            ],
            [
                'attribute' => 'end_time',
                'value' => function($data) {
                    return date('Y-m-d', $data->end_time);
                },
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
</div>
