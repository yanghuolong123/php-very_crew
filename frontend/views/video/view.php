<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\extend\MetaData;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '作品查看', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/main.js', ['depends' => ['app\assets\AppAsset']]);
$this->registerCssFile('http://vjs.zencdn.net/5.4.6/video-js.min.css', ['depends' => ['app\assets\AppAsset']]);
$this->registerJsFile('http://vjs.zencdn.net/5.4.6/video.min.js', ['depends' => ['app\assets\AppAsset']]);
$this->registerCss('#payer {
    /*min-height: 720px;*/
    max-width: 1130px;
    width:100%;     
}');
?>
<div class="video-view">

    <div class="container">
        <?php if ($model->status == 0): ?>
            <?= app\components\skip\SkipWidget::widget(['seconds' => 60, 'skipUrl' => Url::to(['view', 'id' => $model->id]), 'msg' => '视频转码中，请等候...']) ?>
        <?php else: ?>
            <div class="row">                
                <video id="payer" class="video-js vjs-default-skin"
                       controls preload="auto"
                       poster="<?= $model->logo; ?>"
                       data-setup='{"controls": true, "autoplay": false, "preload": "auto"}'>           
                    <source src="<?= $model->file; ?>" type="video/<?= trim(strrchr($model->file, '.'), '.') ?>" />
                    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                </video>      

            </div>

            <p>
                <a href="javascript:video_ding(<?= $model->id ?>);" class="abtn abtn-digg"><?= $model->support ?></a>
                <a href="javascript:video_cai(<?= $model->id ?>);" class="abtn abtn-bury"><?= $model->oppose ?></a>
            </p>
            <p>
            <ul class="list-group">
                <li class="list-group-item"><label>作品名称：</label> <?= $model->title ?></li>
                <li class="list-group-item"><label>浏览量：</label> <?= $model->views ?></li>
                <li class="list-group-item"><label>类型：</label> <?= MetaData::getVal($model->type) ?></li>
                <li class="list-group-item"><label>发布时间：</label> <?= date('Y-m-d H:i:s', $model->createtime) ?></li>
                <li class="list-group-item"><label>标签：</label> <?= implode(', ', MetaData::getArrVal(explode(',', trim($model->tag)))) ?></li>
                <li class="list-group-item"><label>剧情介绍：</label> <?= $model->content ?></li>
            </ul>
            </p>
            <div class="comment">
                <?= app\components\comment\CommentWidget::widget(['type' => 1, 'vid' => $model->id, 'title' => '用户评论']) ?>
            </div>
        <?php endif; ?>
    </div>    

</div>
