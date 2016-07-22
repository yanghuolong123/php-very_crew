<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\extend\MetaData;
use app\util\CommonUtil;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '作品查看', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('http://vjs.zencdn.net/5.4.6/video-js.min.css', ['depends' => ['app\assets\AppAsset']]);
$this->registerJsFile('http://vjs.zencdn.net/5.4.6/video.min.js', ['depends' => ['app\assets\AppAsset']]);
$this->registerCss('#payer {
    max-width: 1130px;
    width:100%;     
}');
if (!CommonUtil::isMobile()) {
    $this->registerCss('#payer {
    min-height: 720px;
}');
}
?>
<div class="video-view">


    <?php if ($model->status == 0): ?>
        <?= app\components\skip\SkipWidget::widget(['seconds' => 60, 'skipUrl' => Url::to(['view', 'id' => $model->id]), 'msg' => '视频转码中，请等候...']) ?>
    <?php else: ?>
        <div class="container">
                            
                <video id="payer" class="video-js vjs-default-skin"
                       controls preload="auto"
                       poster="<?= $model->logo; ?>"
                       data-setup='{"controls": true, "autoplay": false, "preload": "auto"}'>           
                    <source src="<?= $model->file; ?>" type="video/<?= trim(strrchr($model->file, '.'), '.') ?>" />
                    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                </video>      

             

            <p>
                <a href="javascript:video_ding(<?= $model->id ?>);" id="video_ding_<?= $model->id ?>" class="abtn abtn-digg"><?= $model->support ?></a>
                <a href="javascript:video_cai(<?= $model->id ?>);" id="video_cai_<?= $model->id ?>" class="abtn abtn-bury"><?= $model->oppose ?></a>
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
                <?= app\components\comment\CommentWidget::widget(['type' => 1, 'vid' => $model->id, 'title' => '作品大家聊']) ?>
            </div>
        </div> 
    <?php endif; ?>


</div>

<?php $this->beginBlock('video-ding-cai-Js') ?> 

function video_ding(id) {
    var obj = $("#video_ding_"+id);
    $.post("index.php?r=video/ding&id=" + id, function(e) {
        obj.addClass("selected");
        obj.html(e.data);
        obj.on('click', function(evt) {
            evt.preventDefault();
        });
    });
}

function video_cai(id) {
    var obj = $("#video_cai_"+id);
    $.post("index.php?r=video/cai", {id: id}, function(e) {
        obj.addClass("selected");
        obj.html(e.data);
        obj.on('click', function(evt) {
            evt.preventDefault();
        });
    });
}

<?php $this->endBlock() ?> 
<?php $this->registerJs($this->blocks['video-ding-cai-Js'], \yii\web\View::POS_END); ?>