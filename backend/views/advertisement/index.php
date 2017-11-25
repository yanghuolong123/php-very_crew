<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\extend\Advertisement;

/* @var $this yii\web\View */
/* @var $searchModel app\models\native\AdvertisementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Advertisements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Advertisement', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            //'position',
            [
                'attribute' => 'position',
                'filter' => Advertisement::getPostionArr(),
                'value' => function($data){
                    return Advertisement::getPostionArr(false, $data->position);
                },
            ],
            'url:url',
            'link:url',
            'sort',
            [
                'attribute' => 'status',
                'filter' => Advertisement::getStatusArr(),
                'value' => function($data){
                    return Advertisement::getStatusArr(false, $data->status);
                },
            ],
            //'status',
            // 'createtime:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
