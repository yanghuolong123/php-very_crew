<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\extend\User;
use app\models\extend\Video;
use app\models\extend\MetaData;

$this->title = '关联作品成员';
//$this->params['breadcrumbs'][] = ['label' => '作品修改', 'url' => ['video/update', 'id' => $searchModel->video_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'uid',
                'format' => 'raw',
                'value' => function($data) {
                    $user = User::getInfo($data->uid);
                    return Html::a(Html::img($user->avatar, ['style' => 'width:150px;height:150px;']), ['user-profile/view', 'uid' => $user->id]) . "<p>  " . $user->nickname . "</p>";
                },
            ],
            [
                'label' => '角色',
                'attribute' => 'role',
                'format' => 'raw',
                'value' => function($data) {
                    return MetaData::getVal($data->role);
                },
            ],
            //'video_id',
            //'role',
            [
                'attribute' => 'is_star',
                'format' => 'raw',
                'value' => function($data) {return $data->is_star ? '是' : '否';}
            ],
            //'is_star',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($data) {return $data->status ? '已确定' : '待确定';}
            ],       
            //'status',
            // 'desc',
            // 'createtime:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
