<?php

use yii\helpers\Html;
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

            'id',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
