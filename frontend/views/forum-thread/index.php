<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\extend\User;

$this->title = $forum->name;
$this->params['breadcrumbs'][] = ['label' => '论坛', 'url' => ['forum-forum/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-thread-index">    
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="title"><?= Html::encode($forum->name) ?></h3>
                    <blockquote>
                        <p class="text-success">帖子数: <span class="number"><?= $forum->threads; ?></span></p>
                        <p class="text-muted"><?= $forum->desc; ?></p>
                    </blockquote>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-success pull-right" href="<?= Url::to(['forum-thread/create', 'fid'=>$forum->id]) ?>" role="button">+发帖</a>
                </div>
            </div>
            <div class="table-container"> 
            <a class="" href="<?= Url::to(['forum-thread/index', 'fid'=>$forum->id, 'sort'=>'-create_time']) ?>">最新</a> / <a class="" href="<?= Url::to(['forum-thread/index', 'fid'=>$forum->id, 'sort'=>'-posts']) ?>">最热</a>  
            <?= GridView::widget([
                'summary' => '',
                'tableOptions' => ['class' => 'table'],
                'dataProvider' => $dataProvider,
                'columns' => [
                    //'id',
                    //'fid',
                    [
                        //'attribute'=>'title',
                        'label' => '标题',
                        'format' => 'raw',
                        'value' => function($data) {
                            return Html::a($data->title,['forum-thread/view', 'id' => $data->id]);
                        },
                    ],
                    //'title',
                    //'content:ntext',
                    [
                        'attribute' => 'user_id',
                        'label' => '作者',
                        'format' => 'raw',
                        'value' => function($data) {
                            $user = User::getInfo($data->user_id);
                            return Html::a($user->nickname,['user/view', 'id' => $user->id]);
                        },
                    ],
                    [
                        'label' => '回复/查看',
                        'value' => function($data) {
                            return $data->posts.'/'.$data->views;
                        },
                    ],
                    //'user_id',
                    // 'views',
                    // 'posts',
                    // 'recommand',
                    // 'status',
                    //'create_time:datetime',
                    [
                        'label' => '发表时间',
                        'value' => function($data) {
                            return date('Y-m-d H:i:s', $data->createtime);
                        },
                    ],
                    // 'update_time:datetime',

                    //['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">版块</h3>
                </div>
                <div class="list-group">
                    <?php foreach ($forums as $forum): ?>
                    <a href="<?= Url::to(['forum-thread/index', 'fid'=>$forum->id]) ?>" title="<?= $forum->desc ?>" data-toggle="tooltip" data-placement="top" class="list-group-item"><?= $forum->name ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
</div>
