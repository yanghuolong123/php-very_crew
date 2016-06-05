<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\extend\MetaData;
use yii\grid\GridView;

$this->title = '搭档搜索';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        //'showHeader' => false,
        'summary' => '',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nickname',
            'profile.gender',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
</div>
