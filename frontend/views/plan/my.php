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
    <?= GridView::widget([
        //'showHeader' => false,
        'summary' => '',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            //'uid',
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($data){ return Html::a($data->title, ['view','id'=>$data->id]);},
            ],
            //'title',
            //'content:ntext',
            [
                'attribute' => 'type',
                'value' => function($data){ return MetaData::getVal($data->type);},
            ],
            [
                'attribute' => 'tag',
                'value' => function($data){ return implode(', ',MetaData::getArrVal(explode(',', trim($data->tag))));},
            ],
            [
                'label'=>'地点',
                'value' => function($data){ return implode(' ',Distrinct::getArrDistrict([$data->province, $data->city, $data->county])).' '.$data->address;},
            ],
            'content:ntext',
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
    
    <h4>我加入的计划</h4>
    <?= GridView::widget([
        //'showHeader' => false,
        'summary' => '',
        'dataProvider' => $joinDataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id', 
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($data){ return Html::a($data->title, ['view','id'=>$data->id]);},
            ], 
            [
                'attribute' => 'type',
                'value' => function($data){ return MetaData::getVal($data->type);},
            ],
            [
                'attribute' => 'tag',
                'value' => function($data){ return implode(', ',MetaData::getArrVal(explode(',', trim($data->tag))));},
            ],
            [
                'label'=>'地点',
                'value' => function($data){ return implode(' ',Distrinct::getArrDistrict([$data->province, $data->city, $data->county])).' '.$data->address;},
            ],
            'content:ntext',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{remove}',
                'buttons' => [
                    'remove' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', '退出'),
                            'aria-label' => Yii::t('yii', '退出'),
                            'data-confirm' => Yii::t('yii', '您确定要退出此计划吗?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        $url = Url::to(['plan-user/remove','plan_id'=>$model->id,'uid'=>$model->uid]);
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
