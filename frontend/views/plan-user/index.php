<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\extend\User;
use app\util\CommonUtil;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;
use yii\helpers\Url;

 
$this->title = '计划成员管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Plan User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <form method="post" action="<?= Url::to(['batch-update'])?> ">
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
                'label' => '计划成员及备选入人员',
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
            //'plan_id',
            //'role_name',
            [
                'label' => '角色',
                'attribute' => 'role_name',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::textInput('planUser['.$data->id.'][role_name]', $data->role_name);//MetaData::getVal($data->role);
                },
            ],
            // 'status',
            [
                'label' => '备注',
                'attribute' => 'instruction',
                'options' => ['style'=>'width:40%'],
                'format' => 'raw',
                'value' => function($data) {
                    return Html::textarea('planUser['.$data->id.'][instruction]', $data->instruction, ['rows'=>5, 'cols'=>35]);//MetaData::getVal($data->role);
                },
            ],
            //'instruction',
            // 'createtime:datetime',
            // 'updatetime:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
    <div class="row">
        <div class="col-sm-1 col-md-offset-10">
            <?= Html::hiddenInput("plan_id", $searchModel->plan_id) ?>
            <?php if($dataProvider->count >0): ?>
            <?= Html::submitButton('提交保存', ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </div>
    </div>
    </form>
</div>
