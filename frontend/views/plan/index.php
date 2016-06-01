<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;


$this->title = '我的计划';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-index">

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('发布我的计划', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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
            'title',
            'content:ntext',
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
