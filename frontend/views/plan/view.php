<?php

use yii\helpers\Html;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;
use app\models\extend\User;
use yii\helpers\Url;
use app\util\CommonUtil;

$this->title = $model->title;
//$this->params['breadcrumbs'][] = ['label' => '我的计划', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//$plan = Plan::findOne($model->id);
?>
<div class="plan-view">

    <?php if($model->uid != Yii::$app->user->id): ?>
    <div class="container">
        <p>           
            <?= Html::a('加入拍摄计划', ['join', 'plan_id' => $model->id], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
    <?php endif; ?>
    
    <p>        
        <ul class="list-group">
          <li class="list-group-item"><label>拍摄计划名称：</label> <?= $model->title ?></li>
          <li class="list-group-item"><label>拍摄类型：</label> <?= MetaData::getVal($model->type) ?></li>
          <li class="list-group-item"><label>拍摄地区：</label> <?= implode(' ',Distrinct::getArrDistrict([$model->province, $model->city, $model->county])) ?></li>
          <li class="list-group-item"><label>具体地点：</label> <?= $model->address ?></li>
          <li class="list-group-item"><label>发布时间：</label> <?= date('Y-m-d H:i:s', $model->createtime) ?></li>
          <li class="list-group-item"><label>剧情说明：</label> <?= $model->content ?></li>
          <li class="list-group-item"><label>所需角色：</label> <?= implode(', ',MetaData::getArrVal(explode(',', trim($model->plan_role)))) ?></li>
          <li class="list-group-item"><label>所需表演技能：</label> <?= implode(', ',MetaData::getArrVal(explode(',', trim($model->plan_skill)))) ?></li>
          <li class="list-group-item"><label>备注说明：</label> <?= $model->remark ?></li>
        </ul>
    </p>

    <div class="row">
        <div class="container"><h3>参与成员</h3></div>
        <?php if(!empty($planUsers)): ?>
        <?php foreach ($planUsers as $user): ?>
        <div class="col-sm-6 col-md-2">
          <div class="thumbnail">
            <a href="<?= Url::to(['user/view', 'id'=>$user->uid]) ?>"><img src="<?= CommonUtil::cropImgLink(User::getInfo($user->uid)->avatar, 320, 320) ?>" alt="<?= User::getInfo($user->uid)->nickname ?>"></a>
            <div class="caption">
              <h4><a href="<?= Url::to(['user/view', 'id'=>$user->uid]) ?>"><?= User::getInfo($user->uid)->nickname ?></a></h4>
              <p style="height: 30px;">角色：<?php if(empty($user->type)): ?>发起人 <?php endif; ?><?= CommonUtil::cutstr($user->role_name, 30) ?></p>              
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info" style="margin-left:15px; margin-right:15px;">
                <p class="text-info">暂无加入成员 ...</p>
            </div>
        <?php endif; ?>
    </div>

</div>
