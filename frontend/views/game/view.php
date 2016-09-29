<?php

use yii\helpers\Url;
use app\models\extend\Video;
use app\util\CommonUtil;
use yii\helpers\Html;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '参与比赛', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="games-view container">     
    <h4 style="color: #00c66b;"><?= $model->name ?></h4>
    <p><?= $model->content ?></p>
    <p><a class="btn btn-success btn-small" href="<?= Url::toRoute(['video/create', 'game_id'=>$model->id]) ?>" role="button">我要参加 &raquo;</a></p>
    
    <?php if(!empty($dataProvider->models)): ?>
   <div class="row">
        <div class="container"><h4 style="color: #00c66b;">当前参赛作品</h4></div>
        <?php foreach ($dataProvider->models as $gameVideo): ?>
        <?php $video = Video::findOne($gameVideo->video_id)  ?>
        <div class="col-sm-6 col-md-3">
          <div class="thumbnail">
            <a href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><img src="<?= CommonUtil::cropImgLink($video->logo) ?>" alt="<?= $video->title ?>"><div class="duration"><?= $video->duration ?></div></a>
            <div class="caption">
              <h4><a data-toggle="tooltip" data-placement="bottom" title="<?= $video->title ?>" href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><?= CommonUtil::cutstr($video->title,22) ?></a></h4>
              <p>ID：<?= $gameVideo->id ?></p>  
              <p>当前票数：<span id="votes_<?= $gameVideo->id ?>"><?= $gameVideo->votes ?></span></p>
              <p class="text-left"><button type="button" onclick="gameVote(<?= $gameVideo->id ?>)" class="btn btn-primary btn-small game_vote">投一票</button></p>
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