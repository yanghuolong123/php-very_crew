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
    <div class="btn-group btn-group-justified" style="width: 80%;margin:0 0 20px 80px;" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-danger">第一步、上传基本信息</button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-success">第二步、关联作品成员</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-8"><p class="text-muted">作品已成功上传，您可以在72小时内对作品的视频部分进行更新，可以任何时候在“我的作品"中对其基本信息及作品成员进行编辑，请输入昵称或ID添加成会员</p></div>
    </div>

    <?php  echo $this->render('_search_user', ['model' => $searchModel]); ?>

    <h3>作品成员列表</h3>
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
                'attribute' => 'role_name',
//                'format' => 'raw',
//                'value' => function($data) {
//                    return MetaData::getVal($data->role);
//                },
            ],
            //'video_id',
            //'role',
            //'is_star',                   
            //'status',
            [
                'label' => '备注',
                'attribute' => 'desc',
            ],   
            //'desc',
            // 'createtime:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]);
    ?>
</div>
