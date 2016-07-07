<?php
//use Yii;
use yii\helpers\Html;
use app\models\extend\MetaData;
use app\models\extend\User;

$this->title = '计划成员';

$this->params['breadcrumbs'][] = ['label' => '我的计划', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $planModel->title, 'url' => ['view', 'id' => $planModel->id]];
$this->params['breadcrumbs'][] = '计划成员管理';
?>

<table class="table">
 <caption>申请加入此拍摄计划的人员管理.</caption>
      <thead>
        <tr>
          <th>基本信息</th>
          <th>申请角色</th>
          <th>申请说明</th>
          <th>状态</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($planUsers as $user): ?>
        <tr>
          <td><?= Html::img(User::getInfo($user->uid)->avatar,['style'=>'height:60px;width:60px;'])   ?> <?= User::getInfo($user->uid)->nickname ?></td>
          <td><?= MetaData::getVal($user->role) ?></td>
          <td><?= $user->desc ?></td>
          <td><?php if($user->type): ?> 发起人 <?php elseif($user->status==0): ?> 待审核 <?php elseif($user->status==1): ?> 通过审核 <?php else: ?> 不符合 <?php endif; ?></td>
          <td>
              <?php if($planModel->uid ==Yii::$app->user->id && $user->uid != Yii::$app->user->id): ?>
                <?php
                    echo Html::a('接受', ['audit-user', 'id' => $user->id, 'status'=>1], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => '你确定同意接受此用户加入该拍摄计划组吗?',
                            'method' => 'post',
                        ],
                    ]) 
                ?>
                <?php
                    echo Html::a('不符合', ['audit-user', 'id' => $user->id, 'status'=>-1], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => '你确定这个用户不符合吗?',
                            'method' => 'post',
                        ],
                    ]) 
                ?>
              <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
</table>
