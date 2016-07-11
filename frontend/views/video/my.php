<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = '我的作品';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('上传我的作品', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'layout' => "{items}\n{pager}",
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'label' => '作品',
                'format' => 'raw',
                'value' => function($data){return Html::a(Html::img($data->logo,['style'=>'width:150px;height:150px;']), ['view','id'=>$data->id])."<p>  ".$data->title."</p>";},
            ],
            
            //'title',
            'content:ntext',
            //'logo',
            //'file',
            // 'type',
             'views',
             'comments',
            // 'support',
            // 'oppose',
            // 'status',
            //'createtime:datetime',
            [
                'attribute'=>'createtime',
                'format' => ['date', 'Y-M-d H:i:s'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
