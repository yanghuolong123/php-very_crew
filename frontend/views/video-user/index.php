<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\extend\User;
use app\util\CommonUtil;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;
use yii\helpers\Url;

$this->title = '关联作品成员';
$this->params['breadcrumbs'][] = ['label' => '作品查看', 'url' => ['video/view', 'id' => $searchModel->video_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-user-index">
    <div class="row">
        <div class="col-md-offset-1 col-md-8"><p class="text-muted">作品已成功上传，您可以在72小时内对作品的视频部分进行更新，可以任何时候在“我的作品"中对其基本信息及作品成员进行编辑，请输入姓名或ID来匹配作品成员并添加进成员列表</p></div>
    </div>

    <?php  echo $this->render('_search_user', ['model' => $searchModel]); ?>

    <h3>作品成员列表</h3>
    <form method="post" action="<?= Url::to(['batch-update'])?> ">
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
                    $content = '<div class="row">';
                    $content .= '<div class="col-md-4">';
                    $content .= Html::a(Html::img(CommonUtil::cropImgLink($user->avatar, 130,130), ['class'=>'thumbnail']), ['user/view', 'id' => $user->id]);
                    $content .= '</div>';
                    $content .= '<div class="col-md-8">';
                    $content .= '<p>'.Html::a($user->nickname,['user/view', 'id' => $user->id]).'</p>' ;
                    $content .= '<p>';
                    $content .= '性别：'.MetaData::getVal($user->profile->gender);
                    $content .= '</p>';
                    $content .= '<p>';
                    $content .= '所在地区：'.implode(' ',Distrinct::getArrDistrict([$user->profile->province, $user->profile->city, $user->profile->county, $user->profile->country]));
                    $content .= '</p>';
                    $content .= '<p>';
                    $content .= '表演特长：'.implode(', ',MetaData::getArrVal(explode(',', trim($user->profile->speciality))));
                    $content .= '</p>';
                    $content .= '</div>';
                    $content .= '</div>';
                   
                    return $content;
                },
                'options' => ['style'=>'width:40%;'],
            ],
            [
                'label' => '角色',
                'attribute' => 'role_name',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::textInput('videoUser['.$data->id.'][role_name]', $data->role_name);//MetaData::getVal($data->role);
                },
            ],
            //'video_id',
            //'role',
            //'is_star',                   
            //'status',
            [
                'label' => '备注',
                'attribute' => 'instruction',
                'options' => ['style'=>'width:40%;'],
                'format' => 'raw',
                'value' => function($data) {
                    return Html::textarea('videoUser['.$data->id.'][instruction]', $data->instruction, ['rows'=>5, 'cols'=>35]);//MetaData::getVal($data->role);
                },
            ],   
            //'instruction',
            // 'createtime:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]);
    ?>
    <div class="row">
        <div class="col-sm-1 col-md-offset-10">
            <?= Html::hiddenInput("video_id", $searchModel->video_id) ?>
            <?php if($dataProvider->count >0): ?>
            <?= Html::submitButton('提交保存', ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </div>
    </div>
    </form>
</div>
