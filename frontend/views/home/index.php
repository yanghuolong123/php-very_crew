<?php
use app\models\extend\MetaData;
use app\models\extend\Distrinct;
use app\models\extend\User;
use yii\helpers\Url;

$this->title = '非常剧组';
?>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php $bannerCount = count($banners); ?>
        <?php for ($i = 0; $i < $bannerCount; $i++): ?>
            <li data-target="#carousel-example-generic" data-slide-to="<?= $i ?>" <?php if ($i == 0): ?>class="active"<?php endif; ?>></li>
        <?php endfor; ?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php foreach ($banners as $key => $banner): ?>
            <div class="item <?php if ($key == 0): ?>active<?php endif; ?>">
                <img src="<?= $banner['url'] ?>" alt="<?= $banner['name'] ?>">
                <div class="carousel-caption">

                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="row">
    <div class="container"><h3>作品推荐</h3></div>
    <?php foreach ($recomVideos as $video): ?>
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

<div class="row">
    <div class="container"><h3>最新计划</h3></div>
    <?php foreach ($latestPlans as $plan): ?>
    <div class="col-sm-6 col-md-4">
      <div class="thumbnail">
        
        <div class="caption">
            <h3><a href="<?= Url::to(['plan/view', 'id'=>$plan->id]) ?>"><?= $plan->title ?></a></h3>
          <p><?= MetaData::getVal($plan->type) ?>  - <?= implode(', ',MetaData::getArrVal(explode(',', trim($plan->tag)))) ?></p>  
          <p>拍摄地区：<?= implode(' ',Distrinct::getArrDistrict([$plan->province, $plan->city, $plan->county])) ?></p>
          <p>所需角色：<?= implode(', ',MetaData::getArrVal(explode(',', trim($plan->plan_role)))) ?></p>
          <p>所需演技：<?= implode(', ',MetaData::getArrVal(explode(',', trim($plan->plan_skill)))) ?></p>
          <p>剧情简介：<?= $plan->content ?></p>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="container"><h3>排档推荐</h3></div>
    <?php foreach ($recomUsers as $user): ?>
    <div class="col-sm-5 col-md-3">
      <div class="thumbnail">
          <a href="<?= Url::to(['user-profile/view', 'uid'=>$user->id]) ?>"><img style="height:250px; width:250px;" src="<?= User::getInfo($user->id)->avatar ?>" alt="<?= User::getInfo($user->id)->nickname ?>"></a>
        <div class="caption">
          <h3><a href="<?= Url::to(['user-profile/view', 'uid'=>$user->id]) ?>"><?= User::getInfo($user->id)->nickname ?></a></h3>
          <p><?= implode(' ',Distrinct::getArrDistrict([$user->profile['province'], $user->profile['city'], $user->profile['county'], $user->profile['country']])) ?></p>              
        </div>
      </div>
    </div>
    <?php endforeach; ?>
</div>