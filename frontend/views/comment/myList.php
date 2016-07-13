<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use app\models\extend\User;
use app\models\extend\Comment;

$this->title = '我的留言';
$this->params['breadcrumbs'][] = '消息中心';//['label' => '消息中心', 'url' => ['']];
$this->params['breadcrumbs'][] = $this->title;

app\components\comment\CommentAsset::register($this);
?>

<div class="row">
    <div class="col-md-3">

        <?php
        echo Menu::widget([
            'options' => ['class'=>'nav well well-sm'],
            'items' => [
                ['label' => '我的留言', 'url' => ['comment/my-list', 'type'=>2]],
                ['label' => '我的私信', 'url' => ['comment/my-list', 'type'=>3]],
                ['label' => '我的消息', 'url' => ['comment/my-list', 'type'=>4]],
            ],
        ]);
        ?>

    </div>
    <div class="col-md-9">
        <div class="comment_list">
            <?php if(!empty($commentList)): ?>
            <ul class="media-list">
                <?php foreach ($commentList as $list): ?>
                    <li class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?= User::getInfo($list['uid'])->avatar ?>" alt="<?= User::getInfo($list['uid'])->nickname ?>">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= User::getInfo($list['uid'])->nickname ?> <span><?php echo date('Y-m-d H:i:s', $list['createtime']); ?></span></h4>
                            <div>
                                <?php if (!empty($list['parent_id'])): ?>
                                    <?php $parent = Comment::findOne($list['parent_id']); ?>
                                    <div class="quote">
                                        <blockquote>
                                            <font size="2"><a href=""><font color="#999999"><?= User::getInfo($parent['uid'])->nickname ?> 发表于 <?= date('Y-m-d H:i:s', $parent['createtime']); ?></font></a></font>
                                            <p><?= $parent['content'] ?></p>
                                        </blockquote>
                                    </div>
                                <?php endif; ?>
                                <p class="comment_content"><?= $list['content']; ?></p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul> 
            <?php else: ?>
            <div class="alert alert-info">
                <h3>暂时没有留言...</h3>
            </div>
            <?php endif; ?>
        </div>
        <?php
        echo yii\widgets\LinkPager::widget([
            'pagination' => $pages,
        ]);
        ?>
    </div>
</div>

