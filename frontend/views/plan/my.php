<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;
use yii\helpers\Url;


$this->title = '我的计划';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-index">

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('发布我的计划', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <h4>我发布的计划</h4>
    <div class="table-responsive">
    <?= GridView::widget([
        //'showHeader' => false,
        'summary' => '',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute'=>'id',
                'options' => ['style'=>'width:2%;'],
            ],
            //'uid',
            [
                'attribute' => 'title',
                'label' => '名称',
                'format' => 'raw',
                'options' => ['style'=>'width:15%;'],
                //'value' => function($data){ return Html::a($data->title, ['view','id'=>$data->id]);},
            ],
            //'title',
            //'content:ntext',
            [
                'attribute' => 'type',
                'label' => '类型',
                'options' => ['style'=>'width:5%;'],
                'value' => function($data){ return MetaData::getVal($data->type);},
            ],
            [
                'attribute' => 'tag',
                'options' => ['style'=>'width:13%;'],
                'value' => function($data){ return implode(', ',MetaData::getArrVal(explode(',', trim($data->tag))));},
            ],
            [
                'label'=>'地点',
                'options' => ['style'=>'width:20%;'],
                'value' => function($data){ return implode(' ',Distrinct::getArrDistrict([$data->province, $data->city, $data->county])).' '.$data->address;},
            ],
            [
                'attribute'=>'content',
                'options' => ['style'=>'width:35%;'],
            ],
            //'content:ntext',
            // 'province',
            // 'city',
            // 'county',
            // 'country',
            // 'address',
            // 'plan_role',
            // 'plan_skill',
            // 'remark',
            // 'status',
            // 'createtime:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
    <h4>我加入的计划</h4>
    <div class="table-responsive">
    <?= GridView::widget([
        //'showHeader' => false,
        'summary' => '',
        'dataProvider' => $joinDataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id',
                'options' => ['style'=>'width:2%;'],
            ], 
            [
                'attribute' => 'title',
                'label' => '名称',
                'format' => 'raw',
                'options' => ['style'=>'width:15%;'],
                //'value' => function($data){ return Html::a($data->title, ['view','id'=>$data->id]);},
            ], 
            [
                'attribute' => 'type',
                'label' => '类型',
                'options' => ['style'=>'width:5%;'],
                'value' => function($data){ return MetaData::getVal($data->type);},
            ],
            [
                'attribute' => 'tag',
                'options' => ['style'=>'width:13%;'],
                'value' => function($data){ return implode(', ',MetaData::getArrVal(explode(',', trim($data->tag))));},
            ],
            [
                'label'=>'地点',
                'options' => ['style'=>'width:20%;'],
                'value' => function($data){ return implode(' ',Distrinct::getArrDistrict([$data->province, $data->city, $data->county])).' '.$data->address;},
            ],
            [
                'attribute'=>'content',
                'options' => ['style'=>'width:35%;'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {remove}',
                //'header' => '操作',
                'buttons' => [
                    'remove' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', '退出'),
                            'aria-label' => Yii::t('yii', '退出'),
                            'data-confirm' => Yii::t('yii', '您确定要退出此计划吗?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        $url = Url::to(['plan-user/remove','plan_id'=>$model->id,'uid'=>Yii::$app->user->id]);
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],
        ],
    ]); ?>
    </div>
</div>
