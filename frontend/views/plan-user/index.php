<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\extend\User;
use app\models\extend\Video;
use app\models\extend\MetaData;

 
$this->title = '计划成员管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Plan User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'type',
            'uid',
            //'plan_id',
            //'role',
            [
                'label' => '角色',
                'attribute' => 'role',
                'format' => 'raw',
                'value' => function($data) {
                    return MetaData::getVal($data->role);
                },
            ],
            // 'status',
            'desc',
            // 'createtime:datetime',
            // 'updatetime:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
