<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;
use app\util\CommonUtil;

$this->title = '查看个人主页';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/plugin/flexslider/flexslider.css');
$this->registerCss('.flex-direction-nav a {background: rgba(0, 0, 0, 0) url("../image/arr.png") no-repeat scroll 0 0}');
$this->registerJsFile('@web/plugin/flexslider/jquery.flexslider-min.js',['depends'=>['app\assets\AppAsset']]);
$this->registerJsFile('@web/js/upload.js',['depends'=>['app\assets\AppAsset']]);
?>
<div class="user-profile-view">
    <div class="container">
        

        <div class="body-content">

            <div class="row">
                <div class="col-lg-3">
                    <?php if($model->id == Yii::$app->user->id): ?>
                    <p><?= Html::a('完善我的资料', ['user-profile/update', 'uid' => $model->id], ['class' => 'btn btn-success']) ?></p>
                    <?php endif; ?>
                    <p class="thumbnail"><?= Html::img(CommonUtil::cropImgLink($model->avatar,260, 250)) ?></p>
                    
                    <ul class="list-group">
                        <li class="list-group-item"><label>电话：</label> <?= $model->mobile ?></li>
                        <li class="list-group-item"><label>QQ：</label> <?= $profile->qq ?></li>
                        <li class="list-group-item"><label>Email：</label> <?= $model->email ?></li>
                        <li class="list-group-item"><label>微信：</label> <?= $profile->weixin ?></li>
                    </ul>
                </div>
                <div class="col-lg-8"> 
                        <ul class="list-group">
                            <li class="list-group-item"><label>ID：</label> <?= $model->id ?></li>
                            <li class="list-group-item"><label>姓名：</label> <?= $model->nickname ?></li>
                            <li class="list-group-item"><label>性别：</label> <?= MetaData::getVal($profile->gender) ?></li>
                            <li class="list-group-item"><label>所在地区：</label> <?= implode(' ',Distrinct::getArrDistrict([$profile->province, $profile->city, $profile->county, $profile->country])) ?></li>
                            <li class="list-group-item"><label>出生日期：</label> <?= $profile->birthday ?></li>
                            <li class="list-group-item"><label>身高：</label> <?= $profile->height ?></li>
                            <li class="list-group-item"><label>体重：</label> <?= $profile->weight ?></li>
                            <li class="list-group-item"><label>可用于拍摄的时间：</label> <?= MetaData::getVal($profile->usingtime) ?></li>
                            <li class="list-group-item"><label>擅长角色：</label> <?= implode(', ',MetaData::getArrVal(explode(',', trim($profile->good_at_job)))) ?></li>
                            <li class="list-group-item"><label>表演特长：</label> <?= implode(', ',MetaData::getArrVal(explode(',', trim($profile->speciality)))) ?></li>                            
                            <li class="list-group-item"><label>其它个人说明：</label> <?= $profile->remark ?></li>
                        </ul>
                </div>

            </div>

        </div>
                
        <div class="row container">
            
                <h3>个人照片</h3>
                <?php if($model->id == Yii::$app->user->id): ?>
                <p>
                    <?= Html::a('上传我的照片', ['user-album/index'], ['class' => 'btn btn-success']) ?>
                </p>
                <?php endif; ?>
                
                <div class="flexslider carousel">
                    <?php if(!empty($albums)): ?>
                    <ul class="slides">
                      <?php foreach ($albums as $album): ?>
                      <li><img src="<?= $album->url ?>" /></li>
                      <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <p class="text-info">还没有上传照片哦！</p>
                    <?php endif; ?>
                </div>
                
                                     
        </div>        
        
        <?php if(!empty($perVideo)): ?>
        <div class="row">
            <div class="container"><h3>个人作品</h3></div>
            <?php foreach ($perVideo as $video): ?>
            <div class="col-sm-6 col-md-3">
              <div class="thumbnail">
                  <a href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><img src="<?= CommonUtil::cropImgLink($video->logo) ?>" alt="<?= $video->title ?>"></a>
                <div class="caption">
                    <h4><a data-toggle="tooltip" data-placement="bottom" title="<?= $video->title ?>" href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><?= CommonUtil::cutstr($video->title,22) ?></a></h4>
                  <p><?= MetaData::getVal($video->type) ?>  - <?= implode(', ',MetaData::getArrVal(explode(',', trim($video->tag)))) ?></p>  
                  <p><?= $video->views ?>人气/ <?= $video->comments ?>点评/ <?= $video->support ?>赞</p>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <?= app\components\comment\CommentWidget::widget(['type'=>[2,3],'vid' => $model->id, 'title'=>'留言']) ?>
    </div>

</div>

<?php $this->beginBlock('flexslider_Js') ?> 
$(function() {
    $(".flexslider").flexslider({
        animation: "slide",
        //animationLoop: false,
        itemWidth: 210,
        itemMargin: 5,
        minItems: 2,
        maxItems: 4
                // pausePlay: true
    });
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['flexslider_Js'], \yii\web\View::POS_END); ?> 