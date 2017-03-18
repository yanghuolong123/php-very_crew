<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\extend\User;
use app\util\CommonUtil;
use app\models\extend\MetaData;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '论坛', 'url' => ['forum-forum/index']];
$this->params['breadcrumbs'][] = $this->title;

$user = User::getInfo($model->user_id);
?>
<div class="forum-thread-view">

    
    <div class="row">
        <div class="col-md-9">
            <h3 class="title"><?= Html::encode($model->title) ?></h3>
            <div class="media">
                <div class="media-left">
                  <a href="<?= Url::to(['user/view', 'id'=>$model->user_id]) ?>">
                    <img class="media-object thumbnail" src="<?= CommonUtil::cropImgLink($user->avatar,50,50) ?>" alt="<?= $user->nickname ?>">
                  </a>
                </div>
                <div class="media-body">
                  <p class="media-heading text-muted"><a href="<?= Url::to(['user/view', 'id'=>$model->user_id]) ?>"><?= $user->nickname ?></a> <?= implode('|',MetaData::getArrVal(explode(',', trim($user->profile->good_at_job)))) ?></p>
                  <p class="text-success">发帖时间: <?= date('Y-m-d H:i:s', $model->createtime) ?>, 查看数: <span class="number"><?= $model->views ?></span>, 回复数: <span class="number"><?= $model->posts ?></span></p>                  
                </div>
            </div>
            
            <p><?= $model->content ?></p>
            <p>
                <?= app\components\comment\CommentWidget::widget(['type' => 5, 'vid' => $model->id, 'title' => '帖子回复']) ?>
            </p>
        </div>
        <div class="col-md-3">
            <?php if($model->user_id == Yii::$app->user->id): ?>
            <p>
                <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
                <?= Html::a('删除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-warning',
                    'data' => [
                        'confirm' => '你确定要删除此帖子吗?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
            <?php endif; ?>
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
