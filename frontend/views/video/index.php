<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\extend\MetaData;
use app\util\CommonUtil;

$this->title = '作品搜索';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(!empty($dataProvider->models)): ?>
   <div class="row">
        <div class="container"><h3>作品搜索</h3></div>
        <?php foreach ($dataProvider->models as $video): ?>
        <div class="col-sm-6 col-md-3">
          <div class="thumbnail">
            <a href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><img src="<?= CommonUtil::cropImgLink($video->logo) ?>" alt="<?= $video->title ?>"><div class="duration"><?= $video->duration ?></div></a>
            <div class="caption">
              <h4><a data-toggle="tooltip" data-placement="bottom" title="<?= $video->title ?>" href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><?= CommonUtil::cutstr($video->title,22) ?></a></h4>
              <p><?= MetaData::getVal($video->type) ?>  - <?= CommonUtil::cutstr(implode(', ',MetaData::getArrVal(explode(',', trim($video->tag)))), 26) ?></p>  
              <p><?= $video->views ?>人气/ <?= $video->comments ?>点评/ <?= $video->support ?>赞</p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
   </div>
    <?php else: ?>
        <div class="alert alert-info">
            <h3>没有搜索到相关作品...</h3>
        </div>
    <?php endif; ?>
    
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]);
    ?>
</div>
