<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'name',
            'logo',
            'content:ntext',
            // 'order',
            // 'status',
            // 'begin_time:datetime',
            // 'end_time:datetime',
            // 'number',
            // 'create_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
