<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\util\CommonUtil;

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
                'value' => function($data){
                    return Html::a(Html::img(CommonUtil::cropImgLink($data->logo, 240,150),['class'=>'thumbnail']))."<p>".Html::a($data->title,['video/view','id'=>$data->id])."</p>";                    
                },
                'options' => ['style'=>'width:20%;'],
            ],
            
            //'title',
            [
                'attribute' => 'content',
                'options' => ['style'=>'width:45%;'],
            ],
            //'content:ntext',
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
