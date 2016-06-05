<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\extend\MetaData;

$this->title = '作品搜索';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(!empty($dataProvider->models)): ?>
   <div class="row">
        <div class="container"><h3>作品搜索</h3></div>
        <?php foreach ($dataProvider->models as $video): ?>
        <div class="col-sm-6 col-md-4">
          <div class="thumbnail">
              <a href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><img style="height:350px; width:350px;" src="<?= $video->logo ?>" alt="<?= $video->title ?>"></a>
            <div class="caption">
                <h3><a href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><?= $video->title ?></a></h3>
              <p><?= MetaData::getVal($video->type) ?>  - <?= implode(', ',MetaData::getArrVal(explode(',', trim($video->tag)))) ?></p>  
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
