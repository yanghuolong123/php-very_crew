<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\extend\ForumForum;
use app\models\extend\User;
use app\models\extend\ForumThread;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ForumThreadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Forum Threads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-thread-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //= Html::a('Create Forum Thread', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'fid',
                'filter' => ArrayHelper::map(ArrayHelper::toArray(ForumForum::find()->where(['status'=>0])->all()), 'id', 'name'),
                'value' => function($data){
                    return ForumForum::findOne($data->fid)['name'];
                },
            ],
            //'fid',
            'title',
            //'content:ntext',
            [
                'attribute' => 'user_id',
                'filter' => false,
                'value' => function($data){
                    return User::findOne($data->user_id)['nickname'];
                },
            ],
            //'user_id',
            // 'views',
            // 'posts',
            [
                'attribute' => 'recommand',
                'filter' => ForumThread::getRecommandArr(),
                'value' => function($data){
                    return ForumThread::getRecommandArr(false, $data->recommand);
                },
            ],
            //'recommand',
            // 'status',
            // 'lastpost',
            // 'lastposter',
            // 'create_time:datetime',
            // 'update_time:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{recommand}',
                'buttons' => [
                    'recommand' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'recommand'),
                        'data-confirm' => $model->recommand ? '你确定要取消推荐此帖子吗?' : Yii::t('yii', '你确定要推荐此帖子吗?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                        'title' => $model->recommand ? '取消推荐': '推荐',
                    ];
                        $text = $model->recommand ? '<span class="glyphicon glyphicon-thumbs-down"></span>': '<span class="glyphicon glyphicon-thumbs-up"></span>';
                        return Html::a($text, $url, $options );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
