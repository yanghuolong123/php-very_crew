<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\extend\User;
use app\models\extend\Comment;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">用户评论</h3>
    </div>
    <div class="panel-body">

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
                        <div class="reply">
                        <a href="javascript:;" class="reply_btn">回复</a>
                            <?php $form = ActiveForm::begin([
                                'action' => ['/comment/create'],
                                'options' => ['class' => 'form-horizontal reply_form clearfix'],
                                'fieldConfig' => [
                                    'template' => "{input} {error}",
                                ],
                            ]); ?>                                    
                                    <?= $form->field($model, 'content',['options'=>['class'=>'']])->textInput(['class'=>'col-sm-offset-1 col-sm-8 reply_content', 'id'=>'reply_'.$list['id'],'placeholder'=>'回复'.User::getInfo($list['uid'])->nickname]) ?>
                                    <div class="col-lg-offset-1 col-lg-11">
                                    <?= Html::submitButton('回复', ['class' => 'btn btn-info btn-sm', 'name' => 'reply-button']) ?> 
                                    </div>
                                    <?= $form->field($model, 'vid',['options'=>['class'=>'hid-field']])->hiddenInput() ?>
                                    <?= $form->field($model, 'uid',['options'=>['class'=>'hid-field']])->hiddenInput() ?>
                                    <?= $form->field($model, 'parent_id', ['options'=>['class'=>'hid-field']])->hiddenInput(['value'=>$list['id']]) ?>
                            <?php ActiveForm::end(); ?>
                        </div>
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

        <?php $form = ActiveForm::begin([
            'id' => 'comment-form',
            'action' => ['/comment/create'],
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
            ],
        ]); ?>
        
        <?= $form->field($model, 'content')->textarea(['rows' => 5]) ?>
        <?= $form->field($model, 'vid')->hiddenInput() ?>
        <?= $form->field($model, 'uid')->hiddenInput() ?>
        
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('发布', ['class' => 'btn btn-success', 'name' => 'comment-button']) ?>
            </div>
        </div>
        
        <?php ActiveForm::end(); ?>
    </div>
</div>