<?php

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = '我的计划';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-index">

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('发布我的计划', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'uid',
            'title',
            'content:ntext',
            'type',
            'tag',
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
