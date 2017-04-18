<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\GameApplySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Game Applies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-apply-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Game Apply', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
//            'user_id',
//            'game_id',
            'username',
            'amount',
            'summary',
            'join_num',
            // 'len_minute',
            // 'len_second',
            // 'condition',
            // 'ability',
            // 'advantage',
            // 'status',
             'create_time:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>
</div>
