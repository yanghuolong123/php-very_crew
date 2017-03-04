<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\extend\User;
use app\models\extend\ForumForum;

$this->title = '论坛';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .title {
        font-size: 24px;
        color: #4cae4c;
        font-family: cursive;
        //font-style: italic;
    }
    .forum-link {
        font-size: 12px;
        color: #4cae4c;
    }
</style>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">版块</h3>
            </div>
            <div class="list-group">
                <?php foreach ($forums as $forum): ?>
                <a href="<?= Url::to(['forum-thread/index', 'fid'=>$forum->id]) ?>" class="list-group-item"><?= $forum->name ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-info">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <span class="title">推荐</span>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-success pull-right" href="<?= Url::to(['forum-thread/create']) ?>" role="button">+发帖</a>
                    </div>
                </div>
                <div class="table-container"> 
                    <?= GridView::widget([
                        'layout' => "\n{items}\n",
                        //'summary' => '',
                        'tableOptions' => ['class' => 'table'],
                        'dataProvider' => $dataProvider, 
                        'columns' => [
                            [
                                //'attribute'=>'title',
                                'label' => '标题',
                                'format' => 'raw',
                                'value' => function($data) {
                                    $forum = ForumForum::findOne($data->fid);
                                    return '['.Html::a($forum->name, ['forum-thread/index', 'fid'=>$forum->id], ['class'=>'forum-link']).'] '.Html::a($data->title,['forum-thread/view', 'id' => $data->id]);
                                },
                            ],
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
                            [
                                'label' => '发表时间',
                                'value' => function($data) {
                                    return date('Y-m-d H:i:s', $data->createtime);
                                },
                            ],
                            //'fid',
                            //'title',
                            //'content:ntext',
                            //'user_id',
                            // 'views',
                            // 'posts',
                            // 'recommand',
                            // 'status',
                            // 'create_time:datetime',
                            // 'update_time:datetime',

                             
                        ],
                    ]); ?>
                </div> 
            </div>
        </div>
    </div>
</div>