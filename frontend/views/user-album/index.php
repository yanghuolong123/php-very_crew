<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserAlbumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的照片';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-album-index">
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('上传我的照片', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
     
    <?php if(!empty($dataProvider->models)): ?>
    <div class="row">
        <?php foreach ($dataProvider->models as $album): ?>
        <div class="col-xs-6 col-md-3">
          <div class="thumbnail">
            <img src="<?= $album->url ?>" alt="<?= $album->title ?>">
            <div class="caption">
              <h3><?= $album->title ?></h3>
              <p><?= $album->desc ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <div class="alert alert-info">
            <h3>暂时没有我的照片</h3>
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
