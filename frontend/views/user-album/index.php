<?php

use yii\helpers\Html;
use app\util\CommonUtil;

$this->title = '我的照片';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/plugin/zoom/css/zoom.css',['depends'=>['app\assets\AppAsset'], 'media'=>'all']);

$this->registerJsFile('@web/plugin/zoom/js/zoom.js',['depends'=>['app\assets\AppAsset']]);

?>
<div class="user-album-index">
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('上传我的照片', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
     
    <?php if(!empty($dataProvider->models)): ?>
        <div class="row gallery">
            <?php foreach ($dataProvider->models as $album): ?>
            <div class="col-xs-6 col-md-3">
                <div class="thumbnail">
                  <a href="<?= $album->url ?>"><img src="<?= CommonUtil::cropImgLink($album->url,330,220) ?>" alt="<?= $album->title ?>"></a>
                  <div class="caption">
                    <h4><?= $album->title ?></h4>
                    <p style="height: 40px;"><?= $album->desc ?></p>
                  </div>
                </div>
            </div>
            <?php endforeach; ?>    
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <h4>暂时没有我的照片</h4>
        </div>
    <?php endif; ?>
    
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]);
    ?>
    
    <?php 
//    echo GridView::widget([
//        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'id',
//            'uid',
//            'title',
//            'url:url',
//            'desc',
//            // 'status',
//            // 'createtime:datetime',
//
//            ['class' => 'yii\grid\ActionColumn'],
//        ],
//    ]); ?>
</div>
