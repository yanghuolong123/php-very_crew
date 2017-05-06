<?php
use app\models\extend\Video;
use yii\helpers\Url;
use app\util\CommonUtil;

$this->title = '名次及奖项公布';
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <?php if(!empty($model->result)): ?>
    <div class="col-md-12"><p><?= $model->result ?></p></div>
    
    <?php else: ?>
    <div class="alert alert-info">
        <h3>比赛结果还为揭晓...</h3>
    </div>
    <?php endif; ?>
</div>

<?php if(!empty($prizes)): ?>
<div>
        <?php foreach ($prizes as $prize): ?>
        <?php 
            $videoArr = explode(',', trim($prize->win_ids));
            $prizeVideos = Yii::$app->db->createCommand('SELECT * FROM `tbl_video` WHERE `id` IN ('.trim($prize->win_ids).') ORDER BY FIELD(id, '.trim($prize->win_ids).')')->queryAll(PDO::FETCH_OBJ);            
        ?>
        <div class="row">
            <div class="container"><h3 style="color:#008200;"><?= $prize->name ?></h3></div>
            <?php foreach ($prizeVideos as $video): ?>
            <div class="col-sm-6 col-md-3">
              <div class="thumbnail">
                <a href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><img src="<?= CommonUtil::cropImgLink($video->logo) ?>" alt="<?= $video->title ?>"><div class="duration"><?= $video->duration ?></div></a>
                <div class="caption">
                  <h4><a data-toggle="tooltip" data-placement="bottom" title="<?= $video->title ?>" href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><?= CommonUtil::cutstr($video->title,22) ?></a></h4>
                  
                </div>
              </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>