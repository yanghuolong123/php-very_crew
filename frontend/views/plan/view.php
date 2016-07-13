<?php

use yii\helpers\Html;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;
use app\models\extend\User;

$this->title = $model->title;
//$this->params['breadcrumbs'][] = ['label' => '我的计划', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-view">

    <div class="container">
        <p>       
           
            <?= Html::a('加入拍摄计划', ['join', 'plan_id' => $model->id], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
    
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
        <?php foreach ($planUsers as $user): ?>
        <div class="col-sm-5 col-md-3">
          <div class="thumbnail">
            <img style="height:250px; width:250px;" src="<?= User::getInfo($user->uid)->avatar ?>" alt="<?= User::getInfo($user->uid)->nickname ?>">
            <div class="caption">
              <h3><?= User::getInfo($user->uid)->nickname ?></h3>
              <p>角色：<?php if($user->type): ?>发起人, <?php endif; ?><?= MetaData::getVal($user->role) ?></p>              
            </div>
          </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>
