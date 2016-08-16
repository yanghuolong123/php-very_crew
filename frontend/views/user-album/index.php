<?php

use yii\helpers\Html;
use app\util\CommonUtil;
use yii\helpers\Url;

$this->title = '个人的照片';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/plugin/zoom/css/zoom.css',['depends'=>['app\assets\AppAsset'], 'media'=>'all']);

$this->registerJsFile('@web/plugin/zoom/js/zoom.js',['depends'=>['app\assets\AppAsset']]);

?>
<div class="user-album-index">
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if($searchModel->uid == Yii::$app->user->id): ?>
    <p>
        <?= Html::a('上传我的照片', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>
     
    <?php if(!empty($dataProvider->models)): ?>
        <div class="row gallery">
            <?php foreach ($dataProvider->models as $album): ?>
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail">
                  <a class="album-img" href="<?= $album->url ?>"><img src="<?= CommonUtil::cropImgLink($album->url,330,220) ?>" alt="<?= $album->title ?>"></a>
                  <div class="caption">
                      <h5>标题：<?= CommonUtil::cutstr($album->title,20) ?></h5>
                    <p style="height: 60px;">说明：<?= CommonUtil::cutstr($album->desc,65) ?></p>
                    <?php if($searchModel->uid == Yii::$app->user->id): ?>
                    <p>
                        <?= Html::a('编辑', ['user-album/update', 'id' => $album->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('删除', ['user-album/delete', 'id' => $album->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => '您确定要删除此条数据吗?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    <?php endif; ?>
                  </div>
                </div>
            </div>
            <?php endforeach; ?>    
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <h4>暂时没有个人照片</h4>
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
