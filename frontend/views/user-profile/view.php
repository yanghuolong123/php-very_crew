<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;

$this->title = '查看个人资料';
$this->params['breadcrumbs'][] = ['label' => '个人资料', 'url' => ['view', 'uid' => $model->uid]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-view">
    <div class="container">
        <p>
            <?= Html::a('完善我的资料', ['update', 'uid' => $model->uid], ['class' => 'btn btn-success']) ?>

        </p>

        <div class="body-content">

            <div class="row">
                <div class="col-lg-3">

                    <p>
                        <?= Html::img($userModel->avatar, ['style'=>'wdith:240px;height:240px;']) ?>
                    </p>

                    <p><a class="btn btn-default" href="<?= Url::to(['user-profile/update', 'uid'=>$userModel->id]) ?>">更改头像 &raquo;</a></p>

                </div>
                <div class="col-lg-8">

                    <p>
                        <ul class="list-group">
                            <li class="list-group-item"><label>姓名：</label> <?= $userModel->nickname ?></li>
                            <li class="list-group-item"><label>性别：</label> <?= MetaData::getVal($model->gender) ?></li>
                            <li class="list-group-item"><label>所在地区：</label> <?= implode(' ',Distrinct::getArrDistrict([$model->province, $model->city, $model->county, $model->country])) ?></li>
                            <li class="list-group-item"><label>出生日期：</label> <?= $model->birthday ?></li>
                            <li class="list-group-item"><label>身高：</label> <?= $model->height ?></li>
                            <li class="list-group-item"><label>体重：</label> <?= $model->weight ?></li>
                            <li class="list-group-item"><label>可用于拍摄的时间：</label> <?= MetaData::getVal($model->usingtime) ?></li>
                            <li class="list-group-item"><label>擅长角色：</label> <?= implode(', ',MetaData::getArrVal(explode(',', trim($model->good_at_job)))) ?></li>
                            <li class="list-group-item"><label>表演特长：</label> <?= implode(', ',MetaData::getArrVal(explode(',', trim($model->speciality)))) ?></li>
                            <li class="list-group-item"><label>联系方式：</label> 
                                <ul class="list-group">
                                    <li class="list-group-item"><label>电话：</label> <?= $userModel->mobile ?></li>
                                    <li class="list-group-item"><label>QQ：</label> <?= $model->qq ?></li>
                                    <li class="list-group-item"><label>Email：</label> <?= $userModel->email ?></li>
                                    <li class="list-group-item"><label>微信：</label> <?= $model->weixin ?></li>
                                </ul>
                            </li>
                            <li class="list-group-item"><label>其它个人说明：</label> <?= $model->remark ?></li>
                        </ul>
                    </p>
                </div>

            </div>

        </div>
    </div>

    <?php
//    DetailView::widget([
//        'model' => $model,
//        'attributes' => [
//            'id',
//            'uid',
//            'gender',
//            'birthday',
//            'weixin',
//            'qq',
//            'height',
//            'weight',
//            'province',
//            'city',
//            'county',
//            'country',
//            'good_at_job',
//            'speciality',
//            'usingtime',
//            'remark',
//        ],
//    ]) ?>

</div>
