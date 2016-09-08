<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\extend\MetaData;

/* @var $this yii\web\View */
/* @var $searchModel app\models\native\MetaDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '数据字典';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Meta Data', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'parent_id',
            //'group_key',
            [
                'attribute' => 'group_key',
                'filter' => MetaData::getGroupKeyArr(),
                'value' => function ($data) {
                    return MetaData::getGroupKeyArr(false, $data->group_key);
                },
            ],
            'key',
            'value',
            'sort',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
