<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\util\CommonUtil;
use app\models\extend\Video;
use app\models\extend\User;
use app\models\extend\Games;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\GameVideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '参赛作品';
$this->params['breadcrumbs'][] = ['label' => '大赛管理', 'url' => ['games/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-video-index">

    <h1>大赛:<?= Games::findOne($_GET['game_id'])->name.' '. Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Game Video', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => '作品',
                'format' => 'raw',
                'value' => function($data){
                    $video = Video::findOne($data->video_id);
                    $user = User::findOne($data->user_id);
                    $return = Html::a(Html::img(CommonUtil::cropImgLink($video->logo, 240,150,1,false),['class'=>'thumbnail']),['video/view','id'=>$video->id]);
                    $return .= "<p>作品名称：".Html::a($video->title,Yii::$app->params['frontendHost'].'/index.php?r=video/view&id='.$video->id, ['target'=>'_blank'])."</p>";
                    $return .= "<p>参与人：".Html::a($user->nickname,Yii::$app->params['frontendHost'].'/index.php?r=user/view&id='.$user->id, ['target'=>'_blank'])."</p>";
                    return $return;                     
                },
                'options' => ['style'=>'width:20%;'],
            ],
            //'game_id',
            //'video_id',
            //'user_id',
            'votes',
            'score',
            [
                'attribute' => 'remark',
                'options' => ['style'=>'width:25%;'],
            ],
            //'remark',
            [
                'attribute' => 'createtime',
                'label' => '参赛时间',
                'value' => function($data) {
                    return date('Y-m-d H:i:s', $data->createtime);
                }
            ],
            //'createtime:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{review}',
                'buttons' => [
                    'review' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', '评委点评'),
                            'aria-label' => Yii::t('yii', '评委点评'),
                        ];
                        $url = Url::to(['game-video/update','id'=>$model->id]);
                        return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, $options);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
