<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use app\models\extend\User;
use app\models\extend\Comment;

$this->title = '我的私信';
$this->params['breadcrumbs'][] = ['label' => '消息中心', 'url' => ['']];
$this->params['breadcrumbs'][] = $this->title;

app\components\comment\CommentAsset::register($this);
?>

<div class="row">
    <div class="col-md-3">

        <?php
        echo Menu::widget([
            'options' => ['class'=>'nav well well-sm'],
            'items' => [
                ['label' => '我的留言', 'url' => ['comment/my-msg']],
                ['label' => '我的私信', 'url' => ['comment/my-private-msg']],
            ],
        ]);
        ?>

    </div>
    <div class="col-md-9">
        <div class="comment_list">
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
                            <div><?= $list['content']; ?></div>

                            <div class="to_reply">
                                <?php $childrenCommentList = Comment::getChildren($list['id']); ?>   
                                <?php foreach ($childrenCommentList as $child): ?>
                                    <div class="media child-media">
                                        <a class="pull-left" href="#">
                                            <img class="media-object" src="<?= User::getInfo($child['uid'])->avatar ?>" alt="<?= User::getInfo($child['uid'])->nickname ?>">
                                        </a>
                                        <div class="media-body">
                                            <h4 class="media-heading"><?= User::getInfo($child['uid'])->nickname ?> <span><?php echo date('Y-m-d H:i:s', $child['createtime']); ?></span></h4>
                                            <?= $child['content'] ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>                        
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul> 
        </div>
        <?php
        echo yii\widgets\LinkPager::widget([
            'pagination' => $pages,
        ]);
        ?>
    </div>
</div>

