<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\extend\Games;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\GamesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Games';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="games-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Games', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id',
                'options' => ['style'=>'width:5%;'],
            ],
            //'type',
            'name',
            //'logo',
            'content:raw',
            // 'order',
            [
                'attribute' => 'status',
                'filter' => Games::getStatusArr(),
                'value' => function($data){
                    return Games::getStatusArr(false, $data->status);
                },
            ],
            [
                'attribute'=>'begin_time',
                'filter' => false,
                'format' => ['date', 'Y-M-d'],
            ],
            [
                'attribute'=>'end_time',
                'filter' => false,
                'format' => ['date', 'Y-M-d'],
            ],
           'number',
           'result',
            // 'createtime:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'options' => ['style'=>'width:10%;'],
                //'template' => '{view} {update} {delete}',
                'template' => '{game-video} {update} {delete}',
                'buttons' => [
                    'game-video' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', '参赛作品'),
                            'aria-label' => Yii::t('yii', '参赛作品'),
                        ];
                        $url = Url::to(['game-video/index','game_id'=>$model->id]);
                        return Html::a('<span class="glyphicon glyphicon-align-center"></span>', $url, $options);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
