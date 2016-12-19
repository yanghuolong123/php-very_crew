<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\extend\User;
use app\models\extend\Comment;
use yii\helpers\Url;
use app\util\CommonUtil;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $title ?></h3>
    </div>
    <div class="panel-body">

        <div class="comment_list">
            <ul class="media-list">
                <?php foreach ($commentList as $list): ?>
                    <li class="media">
                        <div class="media-left">
                            <a href="<?= Url::to(['user/view', 'id'=>$list['uid']]) ?>">
                                <img class="media-object thumbnail" src="<?= CommonUtil::cropImgLink(User::getInfo($list['uid'])->avatar,50,50) ?>" alt="<?= User::getInfo($list['uid'])->nickname ?>">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="<?= Url::to(['user/view', 'id'=>$list['uid']]) ?>"><?= User::getInfo($list['uid'])->nickname ?></a> <span><?php echo date('Y-m-d H:i:s', $list['createtime']); ?></span></h4>
                            <div>
                                <?php if (!empty($list['parent_id'])): ?>
                                    <?php $parent = Comment::findOne($list['parent_id']); ?>
                                    <div class="quote">
                                        <blockquote>
                                            <font size="2"><a href="<?= Url::to(['user/view', 'id'=>$parent['uid']]) ?>"><font color="#999999"><?= User::getInfo($parent['uid'])->nickname ?> 发表于 <?= date('Y-m-d H:i:s', $parent['createtime']); ?></font></a></font>
                                            <p><?= $parent['content'] ?></p>
                                        </blockquote>
                                    </div>
                                <?php endif; ?>
                                <p class="comment_content"><?= $list['content']; ?></p>
                            </div>
                            <div class="reply">                                                                
                                <a href="javascript:comment_ding(<?= $list->id ?>);" id="comment_support_<?= $list->id ?>" class="abtn abtn-digg"><?= $list->support ?></a>
                                <a href="javascript:comment_cai(<?= $list->id ?>);" id="comment_oppose_<?= $list->id ?>" class="abtn abtn-bury"><?= $list->oppose ?></a>
                                <a href="#reply" class="reply_btn abtn">回复</a>
                                <?= Html::hiddenInput("comment_id", $list->id) ?>
                            </div>

                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>  
        </div>

        <a name="reply"></a>
        <?php
        $form = ActiveForm::begin([
                    'id' => 'comment-form',
                    'action' => ['/comment/create'],
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
                    ],
        ]);
        ?>

        <?php if (is_array($model->type)): ?>
            <?php $model->type = 2; ?>
            <?= Html::activeRadioList($model, 'type', [2 => '留言', 3 => '私信']) ?>
        <?php else: ?>
            <?= Html::activeHiddenInput($model, 'type') ?>
        <?php endif; ?>

        <?= $form->field($model, 'content')->textarea(['rows' => 5, 'placeholder' => $model->type == 1 ? '大胆说说你对作品的感觉吧~' : '']) ?>        

        <div class="form-group">
            <div class="col-lg-1">
                <?= Html::activeHiddenInput($model, 'vid') ?>
                <?= Html::activeHiddenInput($model, 'uid') ?>                
                <?= Html::activeHiddenInput($model, 'parent_id', ['value' => 0]) ?>
                <?= Html::submitButton('发布', ['class' => 'btn btn-success', 'name' => 'comment-button']) ?>
            </div>
        </div>        

        <?php ActiveForm::end(); ?>
    </div>
</div>