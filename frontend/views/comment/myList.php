<?php

use app\util\CommonUtil;
use yii\helpers\Url;
use yii\widgets\Menu;
use app\models\extend\User;
use app\models\extend\Comment;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '我的'.Comment::getTypeArr(false, $type);
$this->params['breadcrumbs'][] = '消息中心';//['label' => '消息中心', 'url' => ['']];
$this->params['breadcrumbs'][] = $this->title;

app\components\comment\CommentAsset::register($this);
$model = new Comment();
?>
<style>
    .reply_bt{
        height: 26px;
    }
    .reply_form {
        display: none;
    }
</style>

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
                            <a href="<?= Url::to(['user/view', 'id'=>$list['uid']]) ?>">
                                <img class="media-object thumbnail" src="<?= CommonUtil::cropImgLink(User::getInfo($list['uid'])->avatar, 50,50) ?>" alt="<?= User::getInfo($list['uid'])->nickname ?>">
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
                                <?php if($type !=4): ?>
                                <div class="reply">
                                    <a href="javascript:;" class="reply_btn_msg">回复</a>
                                    <?php $form = ActiveForm::begin([
                                            'action' => ['/comment/create'],
                                            'options' => ['class' => 'form-horizontal reply_form clearfix'],
                                            'fieldConfig' => [
                                                'template' => "{input} {error}",
                                            ],
                                        ]); ?>                                    
                                                <?= $form->field($model, 'content',[
                                                    'template' => "{input} <button name=\"reply-button\" class=\"btn btn-info reply_bt col-sm-1 btn-sm\" type=\"submit\">回复</button> <div class=\"col-sm-2\">{error}</div>",
                                                ])->textInput(['class'=>'col-sm-offset-1 col-sm-6 reply_content', 'id'=>'reply_'.$list['id'],'placeholder'=>'回复'.User::getInfo($list['uid'])->nickname]) ?>
                                                
                                                <?= Html::activeHiddenInput($model, 'vid',['value'=>$list['uid']]) ?>
                                                <?= Html::activeHiddenInput($model, 'uid',['value'=>Yii::$app->user->id]) ?>
                                                <?= Html::activeHiddenInput($model, 'type', ['value'=>$type]) ?>
                                                <?= Html::activeHiddenInput($model, 'parent_id',['value'=>$list['id']]) ?>
                                              
                                        <?php ActiveForm::end(); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul> 
            <?php else: ?>
            <div class="alert alert-info">
                <h3>暂时没有 <?= $this->title ?> 信息...</h3>
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
<?php $this->beginBlock('replyCommentJs') ?>
$(function() {
        $('a.reply_btn_msg').on('click', function() {
            var reply = $(this).next('.reply_form');
            if (reply.is(":visible")) {
                reply.hide();
            } else {
                reply.show();
            }
        });
        
    // 回复
    $('form.reply_form').on('beforeSubmit', function(e) {
        var $form = $(this);
        if ($form.find("input[name='Comment[uid]']").val() == 0) {
            alerting({msg: '请先登陆'});
            return false;
        }

        if ($.trim($form.find('.reply_content').val()) === '') {
            alerting({msg: '回复内容不能为空'});
            return false;
        }        

        $.ajax({
            url: $form.attr('action'),
            type: 'post',
            data: $form.serialize(),
            success: function(obj) {
                // do something
                $('#comment-content').val('');
                var data = obj.data;
                var str = '<li class="media">';
                str += '<div class="media-left">';
                str += '   <a href="#">';
                str += '  <img alt="' + data['nickname'] + '" src="' + data['avatar'] + '" class="media-object">';
                str += '   </a>';
                str += '</div>';
                str += '<div class="media-body">';
                str += '<h4 class="media-heading">' + data['nickname'] + ' <span>' + data['createtime'] + '</span></h4>';
                str += '<div>';
                if(data['parent']) {
                    str += '<div class="quote"><blockquote>';
                    str += '<font size="2"><a href=""><font color="#999999">'+data['parent_nickname']+' 发表于 '+data['parent']['createtime']+'</font></a></font>';
                    str += '<p>'+data['parent']['content']+'</p>',
                    str += '</blockquote></div>';
                }
                str += data['content'] + '                     </div>';
                str += '</div>';
                str += '</li>';

                $('.comment_list ul').prepend(str);
            }
        });
    }).on('submit', function(e) {
        e.preventDefault();
    })
    
});
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['replyCommentJs'], \yii\web\View::POS_END); ?>
