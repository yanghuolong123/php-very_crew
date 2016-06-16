<?php

use yii\helpers\Html;
use app\models\extend\MetaData;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '作品查看', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/plugin/video.js/video-js.min.css',['depends'=>['app\assets\AppAsset']]);
$this->registerJsFile('@web/plugin/video.js/video.min.js',['depends'=>['app\assets\AppAsset']]);
?>
<div class="video-view">

    <div class="container">
        
        <video id="example_video_1" class="video-js vjs-default-skin"
            controls preload="auto" width="1130" height="720"
            poster="<?= $model->logo; ?>"
            data-setup='{}'>           
            <source src="<?= $model->file; ?>" type="video/<?= trim(strrchr($model->file, '.'), '.') ?>" />
           <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
        </video>
        
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
                <li class="list-group-item"><label>标签：</label> <?= implode(', ',MetaData::getArrVal(explode(',', trim($model->tag)))) ?></li>
                <li class="list-group-item"><label>剧情介绍：</label> <?= $model->content ?></li>
            </ul>
        </p>
        <div class="comment">
            <?= app\components\comment\CommentWidget::widget(['type'=>1,'vid' => $model->id, 'title'=>'用户评论']) ?>
        </div>
    </div>


</div>
