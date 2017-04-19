<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\extend\ForumForum;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ForumForumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Forum Forums';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-forum-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Forum Forum', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'name',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->name, ['forum-thread/index', 'fid'=>$data->id]);
                },
            ],
            'instruction',
            'sort',
            //'status',
            [
                'attribute' => 'status',
                'filter' => ForumForum::getStatusArr(),
                'value' => function($data){
                    return ForumForum::getStatusArr(false, $data->status);
                },
            ],           
            
            //'create_time:datetime',
            // 'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
