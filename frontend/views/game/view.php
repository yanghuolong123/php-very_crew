<?php

use yii\helpers\Url;
use app\models\extend\Video;
use app\util\CommonUtil;
use app\models\extend\Games;
use yii\helpers\Html;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '参与比赛', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .game_content{
        min-height: 220px;
    }
    .game_menu{
        padding-right: 150px;
    }
    .game-tips{
        font-size: 14px;
    }
    .gamestatus,.gamenum{
        color:red; 
        font-weight: bold;
        font-style: italic;
        font-family: fantasy;
    }
    .gametime{
        color: #00c66b;
    }
    .title {
        margin-top: 35px; 
        margin-bottom: 20px;
        line-height: 30px;
    }
    .list-titile{
        color: #00c66b; 
        font-weight: bold; 
        font-size: 28px;   
        margin-right: 20px;
    }
    .modal-dialog{
        margin: 130px auto;
    }
</style>

<div class="games-view container">     
    <h2 style="color: #00c66b;"><?= $model->name ?></h2>
    <div class="row">
        <div class="col-md-8 game_content">
            <blockquote>
                <p><span class="gamestatus"><?= Games::getStatusArr(false, $model->status) ?>.....</span></p>
            </blockquote>
            <p><?= $model->content ?></p>
        </div>
        <div class="col-md-4 game_menu">
            <p class="text-right"><a <?php if($model->status!=0): ?>disabled="disabled"<?php endif; ?> class="btn btn-success btn-small" href="<?php if($model->status==0): ?><?= Url::toRoute(['game/apply', 'game_id'=>$model->id]) ?><?php else: ?>javascript:;<?php endif;?>" role="button"> 申请资金资助 &raquo;</a></p>
            <p class="text-right"><a <?php if($model->status!=0): ?>disabled="disabled"<?php endif; ?> class="btn btn-success btn-small" href="<?php if($model->status==0): ?><?= Url::toRoute(['video/create', 'game_id'=>$model->id]) ?><?php else: ?>javascript:;<?php endif;?>" role="button">上传参赛作品 &raquo;</a></p>
            <!--
            <p class="text-right"><a <?php if($model->status!=1): ?>disabled="disabled"<?php endif; ?> class="btn btn-success btn-small" href="<?php if($model->status==1): ?>#vote<?php else: ?>javascript:;<?php endif;?>" role="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;群众投票 &raquo;</a></p>
            -->
            <p class="text-right"><a <?php if($model->status!=3): ?>disabled="disabled"<?php endif; ?> class="btn btn-success btn-small" href="<?php if($model->status==3): ?><?= Url::toRoute(['game/result', 'id'=>$model->id]) ?><?php else: ?>javascript:;<?php endif;?>" role="button">名次奖项公布 &raquo;</a></p>
        </div>
    </div>
    
    
    <a name="vote"></a>
    <?php if(!empty($dataProvider->models)): ?>
   <div class="row">
       <div class="container title"><span class="list-titile">当前参赛作品</span><?= Html::dropDownList('sort', $sort, ['id'=>'按ID排序', 'score'=>'按得分排序', 'votes'=>'按投票排序'], ['id'=>'list-sort', 'class'=>'btn btn-success pull-right']) ?></div>
        <?php foreach ($dataProvider->models as $gameVideo): ?>
        <?php $video = Video::findOne($gameVideo->video_id)  ?>
        <div class="col-sm-6 col-md-3">
          <div class="thumbnail">
            <a href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><img src="<?= CommonUtil::cropImgLink($video->logo) ?>" alt="<?= $video->title ?>"><div class="duration"><?= $video->duration ?></div></a>
            <div class="caption">
              <h4><a data-toggle="tooltip" data-placement="bottom" title="<?= $video->title ?>" href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><?= CommonUtil::cutstr($video->title,22) ?></a></h4>
              <!--
              <p>ID：<?= $gameVideo->id ?></p>               
              <p>评委评分：<span><?= empty($gameVideo->score) ? '--' : $gameVideo->score;  ?></span></p>
              <p>群众投票：<span class="gamenum" id="votes_<?= $gameVideo->id ?>"><?= $gameVideo->votes ?></span></p>
              <p class="text-left"><button <?php if($model->status!=1): ?>disabled="disabled"<?php endif; ?> type="button" onclick="gameVote(<?= $gameVideo->id ?>)" class="btn btn-primary btn-small game_vote">投一票</button></p>
              -->
            </div>
          </div>
        </div>
        <?php endforeach; ?>
   </div>
    <?php else: ?>
        <div class="alert alert-info">
            <h3>暂时没有参赛作品...</h3>
        </div>
    <?php endif; ?>
    
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]);
    ?>
</div>

<?php $this->beginBlock('game-video-vote-Js') ?> 

function gameVote(id) {
    $.post("<?= Url::to(['game/ajax-vote']) ?>", {id: id}, function(e) { 
        if(e.success == false) {
            var msg = "亲，你没有登陆，如果你已有帐号请先登陆进行投票，也可以填写你的邮箱，我们会给你发一个链接进行投票。";
            msg += "\n<br/><br/>";
            msg += '<form method="post" class="form-horizontal">';
            msg += '<div class="form-group">';
            msg += '<label for="vote-email" class="col-lg-2 control-label">投票邮箱</label>';
            msg += '<div class="col-lg-5"><input type="text" placeholder="邮箱" autofocus="" name="vote-email" class="form-control" id="vote-email"></div>';
            msg += '<div class="col-lg-2"><button id="voteMailBnt" name="vote-mail-bnt" class="btn btn-info" type="button">确定</button></div>';
            msg += '</div>';
            msg += '<input type="hidden" name="vote-video" value="'+e.data+'" id="vote-video">';
            msg += '</form>';
            greeting({title:"消息提示",msg:msg});
            return;
        }
        if(e.data>0) {
            $("#votes_"+id).html(e.data);
            greeting({msg:"投票成功，感谢您的参与"});
        } else {
            alerting({msg:"亲，您已对此参赛作品投过票了，感谢您的参与"});
        }
    });
}

$(function(){
    $("#list-sort").change(function(){
        var val = $(this).val();
        var url = "<?= Url::to(['game/view','id'=>$model->id]) ?>&sorting="+val + "#vote";
        location.href = url;
    });
    
    $(document).on('click', '#voteMailBnt', function(){
        var email = $.trim($('#vote-email').val());
        var voteId = $('#vote-video').val();
        if(email.length==0) {
            alerting({msg:"请先填写邮箱"});
            return;
        }
        var reg = /\w+[@]{1}\w+[.]\w+/;
        if(!reg.test(email)){
            alerting({msg:"请填写正确邮箱格式"});
            return;
        }
        
        $.post('<?= Url::to(['game/ajax-vote']) ?>', {email:email,voteId:voteId}, function(e){
            greeting({msg:"请查看您的邮箱，收到邮件后可以点击链接进行投票"});
        });
    });
});

<?php $this->endBlock() ?> 
<?php $this->registerJs($this->blocks['game-video-vote-Js'], \yii\web\View::POS_END); ?>

<?=
$this->render('/inc/_wxshare', [
    'title' => $model->name,
    'content' => strip_tags($model->content),
    'logo' => '/uploads/2016/08/11/147092177573581.jpg',
    'shareUrl' => CURRENTURL,
])
?>