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
</style>

<div class="games-view container">     
    <h2 style="color: #00c66b;"><?= $model->name ?></h2>
    <div class="row">
        <div class="col-md-8 game_content">
            <blockquote>
                <p><span class="gamestatus"><?= Games::getStatusArr(false, $model->status) ?>.....</span>, 开始时间: <span class="gametime"><?= date('Y-m-d', $model->begin_time) ?></span> 结束时间: <span class="gametime"><?= date('Y-m-d', $model->end_time) ?></span>, 参与作品数: <span class="gamenum"><?= $model->number ?></span></p>
            </blockquote>
            <p><?= $model->content ?></p>
        </div>
        <div class="col-md-4 game_menu">
            <p class="text-right"><a <?php if($model->status!=0): ?>disabled="disabled"<?php endif; ?> class="btn btn-success btn-small" href="<?php if($model->status==0): ?><?= Url::toRoute(['video/create', 'game_id'=>$model->id]) ?><?php else: ?>javascript:;<?php endif;?>" role="button">上传参赛作品 &raquo;</a></p>
            <p class="text-right"><a <?php if($model->status!=1): ?>disabled="disabled"<?php endif; ?> class="btn btn-success btn-small" href="<?php if($model->status==1): ?>#vote<?php else: ?>javascript:;<?php endif;?>" role="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;群众投票 &raquo;</a></p>
            <p class="text-right"><a <?php if($model->status!=3): ?>disabled="disabled"<?php endif; ?> class="btn btn-success btn-small" href="<?php if($model->status==3): ?><?= Url::toRoute(['game/result', 'id'=>$model->id]) ?><?php else: ?>javascript:;<?php endif;?>" role="button">名次奖项公布 &raquo;</a></p>
        </div>
    </div>
    
    
    <a name="vote"></a>
    <?php if(!empty($dataProvider->models)): ?>
   <div class="row">
        <div class="container"><h3 style="color: #00c66b;">当前参赛作品</h3></div>
        <?php foreach ($dataProvider->models as $gameVideo): ?>
        <?php $video = Video::findOne($gameVideo->video_id)  ?>
        <div class="col-sm-6 col-md-3">
          <div class="thumbnail">
            <a href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><img src="<?= CommonUtil::cropImgLink($video->logo) ?>" alt="<?= $video->title ?>"><div class="duration"><?= $video->duration ?></div></a>
            <div class="caption">
              <h4><a data-toggle="tooltip" data-placement="bottom" title="<?= $video->title ?>" href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><?= CommonUtil::cutstr($video->title,22) ?></a></h4>
              <p>ID：<?= $gameVideo->id ?></p>  
              <p>当前票数：<span id="votes_<?= $gameVideo->id ?>"><?= $gameVideo->votes ?></span></p>
              <p class="text-left"><button <?php if($model->status!=1): ?>disabled="disabled"<?php endif; ?> type="button" onclick="gameVote(<?= $gameVideo->id ?>)" class="btn btn-primary btn-small game_vote">投一票</button></p>
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
    $.post("index.php?r=game/ajax-vote", {id: id}, function(e) {        
        $("#votes_"+id).html(e.data);
    });
}

<?php $this->endBlock() ?> 
<?php $this->registerJs($this->blocks['game-video-vote-Js'], \yii\web\View::POS_END); ?>