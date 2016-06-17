<?php

use yii\helpers\Html;
use app\models\extend\MetaData;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '作品查看', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/main.js',['depends'=>['app\assets\AppAsset']]);
?>
<div class="video-view">

    <div class="container">
        <div class="payer" id="CuPlayer">
            <script type="text/javascript" src="/plugin/CuPlayer/images/swfobject.js"></script>
            <script type="text/javascript">
                var so = new SWFObject("/plugin/CuPlayer/CuPlayerMiniV4.swf", "CuPlayerV4", "1130", "720", "9", "#000000");
                so.addParam("allowfullscreen", "true");
                so.addParam("allowscriptaccess", "always");
                so.addParam("wmode", "opaque");
                so.addParam("quality", "high");
                so.addParam("salign", "lt");
                so.addVariable("CuPlayerSetFile", "/plugin/CuPlayer/CuPlayerSetFile.php"); //播放器配置文件地址,例SetFile.xml、SetFile.asp、SetFile.php、SetFile.aspx
                so.addVariable("CuPlayerFile", "<?= $model->file; ?>"); //视频文件地址
                so.addVariable("CuPlayerImage", "<?= $model->logo; ?>");//视频略缩图,本图片文件必须正确
                so.addVariable("CuPlayerWidth", "1130"); //视频宽度
                so.addVariable("CuPlayerHeight", "720"); //视频高度
                so.addVariable("CuPlayerAutoPlay", "yes"); //是否自动播放
                so.addVariable("CuPlayerLogo", "/image/logo.png"); //Logo文件地址
                so.addVariable("CuPlayerPosition", "bottom-right"); //Logo显示的位置
                so.write("CuPlayer");
            </script>
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
                <li class="list-group-item"><label>标签：</label> <?= implode(', ',MetaData::getArrVal(explode(',', trim($model->tag)))) ?></li>
                <li class="list-group-item"><label>剧情介绍：</label> <?= $model->content ?></li>
            </ul>
        </p>
        <div class="comment">
            <?= app\components\comment\CommentWidget::widget(['type'=>1,'vid' => $model->id, 'title'=>'用户评论']) ?>
        </div>
    </div>


</div>
