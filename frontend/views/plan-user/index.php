<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\extend\User;
use app\models\extend\Video;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;

 
$this->title = '计划成员管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Plan User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'type',
            //'uid',
            [
                'attribute' => 'uid',
                'label' => '加入人员',
                'format' => 'raw',
                'value' => function($data) {
                    $user = User::getInfo($data->uid);
                    $content = '<div class="row">';
                    $content .= '<div class="col-md-3">';
                    $content .= Html::a(Html::img($user->avatar.'!150!150', ['style' => 'width:150px;height:150px;']), ['user-profile/view', 'uid' => $user->id]);
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
            //'plan_id',
            'role_name',
//            [
//                'label' => '角色',
//                'attribute' => 'role',
//                'format' => 'raw',
//                'value' => function($data) {
//                    return MetaData::getVal($data->role);
//                },
//            ],
            // 'status',
            [
                'label' => '备注',
                'attribute' => 'desc',
            ],
            //'desc',
            // 'createtime:datetime',
            // 'updatetime:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
