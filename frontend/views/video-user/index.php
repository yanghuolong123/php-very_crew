<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\extend\User;
use app\util\CommonUtil;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;

$this->title = '关联作品成员';
//$this->params['breadcrumbs'][] = ['label' => '作品修改', 'url' => ['video/update', 'id' => $searchModel->video_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-user-index">
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
                    $content = '<div class="row">';
                    $content .= '<div class="col-md-3">';
                    $content .= Html::a(Html::img(CommonUtil::cropImgLink($user->avatar, 150, 150), ['style' => 'width:150px;height:150px;']), ['user-profile/view', 'uid' => $user->id]);
                    $content .= '</div>';
                    $content .= '<div class="col-md-6">';
                    $content .= '<p>'.Html::a($user->nickname,['user-profile/view', 'uid' => $user->id]).'</p>' ;
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
